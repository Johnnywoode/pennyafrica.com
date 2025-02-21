<?php

namespace App\Services;

use App\Helpers\Helper;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Exception;

class MtnMomoService
{
    private $baseUrl;
    private $apiKey;
    private $subscriptionKey;
    private $accountId;
    private $environment;
    private $currency;

    public function __construct()
    {
        $this->baseUrl = config('mtn_momo.base_url');
        $this->apiKey = config('mtn_momo.api_key');
        $this->subscriptionKey = config('mtn_momo.subscription_key');
        $this->accountId = config('mtn_momo.account_id');
        $this->environment = config('mtn_momo.environment', 'sandbox');
        $this->currency = config('mtn_momo.currency', 'EUR');
    }

    /**
     * Create API User and store ID in env file
     */
    public function createApiUser()
    {
        $referenceId = Str::uuid()->toString(); // Generate a UUID

        $response = Http::withHeaders([
            'Ocp-Apim-Subscription-Key' => $this->subscriptionKey,
            'X-Reference-Id' => $referenceId,
            'Content-Type' => 'application/json'
        ])->post("{$this->baseUrl}/v1_0/apiuser", [
            'providerCallbackHost' => config('app.url'),
        ]);

        if ($response->failed()) {
            throw new Exception('Failed to create API user: ' . $response->body());
        }

        // Store the API user ID in the .env file
        Helper::storeInEnv('MTN_MOMO_API_USER', $referenceId);

        return ['api_user_id' => $referenceId];
    }


    /**
     * Create API Key and store in env file
     */
    public function createApiKey()
    {
        $apiUserId = config('mtn_momo.api_user');

        if (!$apiUserId) {
            $apiUser = $this->createApiUser();
            $apiUserId = config('mtn_momo.api_user');
        }

        $response = Http::withHeaders([
            'Ocp-Apim-Subscription-Key' => $this->subscriptionKey,
            'Content-Type' => 'application/json'
        ])->post("{$this->baseUrl}/v1_0/apiuser/{$apiUserId}/apikey");

        if ($response->failed()) {
            throw new Exception('Failed to generate API key: ' . $response->body());
        }

        $apiKey = $response->json()['apiKey'];
        Helper::storeInEnv('MTN_MOMO_API_KEY', $apiKey);

        return ['api_key' => $apiKey];
    }

    /**
     * Get Access Token (Cached for Performance)
     */
    public function getAccessToken()
    {
        $apiUserId = config('mtn_momo.api_user');
        $apiKey = config('mtn_momo.api_key');

        if (!$apiUserId || !$apiKey) {
            throw new Exception('API User ID or API Key is missing. Generate them first.');
        }


        return Cache::remember('mtn_momo_token', 3500, function () use ($apiUserId, $apiKey) {
            $response = Http::withHeaders([
                'Authorization' => "Basic " . base64_encode($apiUserId . ":" . $apiKey),
                'Ocp-Apim-Subscription-Key' => $this->subscriptionKey,
            ])->withoutVerifying()->post("{$this->baseUrl}/collection/token/");

            if ($response->failed()) {
                throw new Exception('Failed to retrieve MTN MoMo Access Token: ' . $response->body());
            }

            return $response->json()['access_token'];
        });
    }

    /**
     * Get Basic User Info
     */
    public function getBasicUserInfo($accountHolderId)
    {
        $token = $this->getAccessToken();

        $response = Http::withHeaders([
            'Authorization' => "Bearer $token",
            'Ocp-Apim-Subscription-Key' => $this->subscriptionKey,
            'Cache-Control' => 'no-cache',
            'X-Target-Environment' => $this->environment,
        ])->get("{$this->baseUrl}/collection/v1_0/accountholder/MSISDN/{$accountHolderId}/basicuserinfo");

        if ($response->failed()) {
            throw new Exception('Failed to retrieve user info: ' . $response->body());
        }

        return $response->json();
    }

    /**
     * Request Payment (Collections)
     */
    public function requestPayment($phoneNumber, $amount, $externalId)
    {
        $token = $this->getAccessToken();

        $response = Http::withHeaders([
            'Authorization' => "Bearer $token",
            'Ocp-Apim-Subscription-Key' => $this->subscriptionKey,
            'X-Reference-Id' => $externalId,
            'X-Target-Environment' => $this->environment,
        ])->post("{$this->baseUrl}/collection/v1_0/requesttopay", [
            'amount' => $amount,
            'currency' => $this->currency,
            'externalId' => $externalId,
            'payer' => ['partyIdType' => 'MSISDN', 'partyId' => $phoneNumber],
            'payerMessage' => 'Payment request',
            'payeeNote' => 'Payment to merchant',
        ]);

        if ($response->failed()) {
            throw new Exception('Payment request failed');
        }

        return $response->json();
    }

    /**
     * Get Account Balance
     */
    public function getAccountBalance()
    {
        $token = $this->getAccessToken();

        $response = Http::withHeaders([
            'Authorization' => "Bearer $token",
            'Ocp-Apim-Subscription-Key' => $this->subscriptionKey,
            'X-Target-Environment' => $this->environment,
        ])->get("{$this->baseUrl}/collection/v1_0/account/balance");

        if ($response->failed()) {
            throw new Exception('Failed to retrieve account balance: ' . $response->body());
        }

        return $response->json();
    }
}
