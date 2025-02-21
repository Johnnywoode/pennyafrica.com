<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Http\Requests\USSDRequest;
use App\Models\User;
use App\Models\Withdrawal;
use App\Services\MtnMomoService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class UssdController extends Controller
{
    protected $momoService;

    public function __construct(MtnMomoService $momoService)
    {
        $this->momoService = $momoService;
    }

    public function handleUssd(USSDRequest $request)
    {
        // $apiUser = $this->momoService->createApiUser();
        // $apiKey = $this->momoService->createApiKey();
        // $accessToken = $this->momoService->getAccessToken();
        // $accessToken = $this->momoService->getBasicUserInfo('0241076474');
        $accessToken = $this->momoService->getAccountBalance();

        return response()->json($accessToken);
        $sessionID = $request->input('sessionID');
        $userID = $request->input('userID');
        $newSession = $request->input('newSession');
        $msisdn = $request->input('msisdn');
        $userData = $request->input('userData');
        $network = $request->input('network');

        if ($newSession) {
            $message = "Welcome to Arkesel Voting Portal. Please vote for your favourite service from Arkesel<br>" .
                "1. SMS<br>" .
                "2. Voice<br>" .
                "3. Email<br>" .
                "4. USSD<br>" .
                "5. Payments<br>";
            $continueSession = true;

            // Keep track of the USSD state of the user and their session
            $currentState = [
                'sessionID' => $sessionID,
                'msisdn' => $msisdn,
                'userData' => $userData,
                'network'   => $network,
                'newSession' => $newSession,
                'message' => $message,
                'level' => 1,
                'page' => 1,
            ];

            $userResponseTracker = Cache::get($sessionID);

            !$userResponseTracker
                ? $userResponseTracker = [$currentState]
                : $userResponseTracker[] = $currentState;

            Cache::put($sessionID, $userResponseTracker, 120);

            return response()->json([
                'sessionID' => $sessionID,
                'msisdn' => $msisdn,
                'userID' => $userID,
                'continueSession' => $continueSession,
                'message' => $message,
            ]);
        }

        $userResponseTracker = Cache::get($sessionID) ?? [];

        if (!(count($userResponseTracker) > 0)) {
            return response()->json([
                'sessionID' => $sessionID,
                'msisdn' => $msisdn,
                'userID' => $userID,
                'continueSession' => false,
                'message' => 'Error! Please dial code again!',
            ]);
        }

        $lastResponse = $userResponseTracker[count($userResponseTracker) - 1];

        $message = "Bad Option";
        $continueSession = false;

        if ($lastResponse['level'] === 1) {
            if (in_array($userData, ["2", "3", "4", "5"])) {

                $message = "Thank you for voting!";
                $continueSession = false;
            } else if ($userData === '1') {
                $message = "For SMS which of the features do you like best?" .
                    "<br>1. From File" .
                    "<br>2. Quick SMS" .
                    "<br><br> #. Next Page";

                $continueSession = true;

                $currentState = [
                    'sessionID' => $sessionID,
                    'msisdn' => $msisdn,
                    'userData' => $userData,
                    'network'   => $network,
                    'newSession' => $newSession,
                    'message' => $message,
                    'level' => 2,
                    'page' => 1,
                ];

                $userResponseTracker[] = $currentState;
                Cache::put($sessionID, $userResponseTracker, 120);
            }
        } else if ($lastResponse['level'] === 2) {
            if ($lastResponse['page'] === 1 && $userData === '#') {
                $message = "For SMS which of the features do you like best?" .
                    "<br>3. Bulk SMS" .
                    "<br><br>*. Go Back" .
                    "<br>#. Next Page";

                $continueSession = true;

                $currentState = [
                    'sessionID' => $sessionID,
                    'msisdn' => $msisdn,
                    'userData' => $userData,
                    'network'   => $network,
                    'newSession' => $newSession,
                    'message' => $message,
                    'level' => 2,
                    'page' => 2,
                ];

                $userResponseTracker[] = $currentState;
                Cache::put($sessionID, $userResponseTracker, 120);
            } else if ($lastResponse['page'] === 2 && $userData === '#') {
                // Useful Resources
                $message = "For SMS which of the features do you like best?" .
                    "<br>4. SMS To Contacts" .
                    "<br><br>*. Go Back";

                $continueSession = true;

                $currentState = [
                    'sessionID' => $sessionID,
                    'msisdn' => $msisdn,
                    'userData' => $userData,
                    'network'   => $network,
                    'newSession' => $newSession,
                    'message' => $message,
                    'level' => 2,
                    'page' => 3,
                ];

                $userResponseTracker[] = $currentState;
                Cache::put($sessionID, $userResponseTracker, 120);
            } else if ($lastResponse['page'] === 3 && $userData === '*') {
                $message = "For SMS which of the features do you like best?" .
                    "<br>3. Bulk SMS" .
                    "<br><br>*. Go Back" .
                    "<br>#. Next Page";

                $continueSession = true;

                $currentState = [
                    'sessionID' => $sessionID,
                    'msisdn' => $msisdn,
                    'userData' => $userData,
                    'network'   => $network,
                    'newSession' => $newSession,
                    'message' => $message,
                    'level' => 2,
                    'page' => 2,
                ];

                $userResponseTracker[] = $currentState;
                Cache::put($sessionID, $userResponseTracker, 120);
            } else if ($lastResponse['page'] === 2 && $userData === '*') {
                $message = "For SMS which of the features do you like best?" .
                    "<br>1. From File" .
                    "<br>2. Quick SMS" .
                    "<br><br> #. Next Page";

                $continueSession = true;
                $currentState = [
                    'sessionID' => $sessionID,
                    'msisdn' => $msisdn,
                    'userData' => $userData,
                    'network'   => $network,
                    'newSession' => $newSession,
                    'message' => $message,
                    'level' => 2,
                    'page' => 1,
                ];

                $userResponseTracker[] = $currentState;
                Cache::put($sessionID, $userResponseTracker, 120);
            } else if (in_array($userData, ["1", "2", "3", "4"])) {
                $message = "Thank you for voting!";
                $continueSession = false;
            } else {
                $message = "Bad choice!";
                $continueSession = false;
            }
        }

        $response = [
            'sessionID' => $sessionID,
            'msisdn' => $msisdn,
            'userID' => $userID,
            'continueSession' => $continueSession,
            'message' => $message,
        ];

        // Broadcast the response in real-time
        broadcast(new MessageSent($response))->toOthers();

        return response()->json($response);
    }


    public function register(USSDRequest $request)
    {
        $sessionID = $request->input('sessionID');
        $userID = $request->input('userID');
        $newSession = $request->input('newSession');
        $msisdn = $request->input('msisdn');
        $userData = trim($request->input('userData'));
        $network = $request->input('network');

        $user = User::where('phone', $msisdn)->first();
        // dd($request->all(), $newSession, $newSession == true, $newSession === "true", (bool)$newSession);
        if ($newSession === "true") {
            $message = "Welcome to Penny Africa.<br>" .
                "1. Register<br>" .
                "2. Check Balance<br>" .
                "3. Withdraw<br>" .
                "4. Cancel Subscription";

            $currentState = [
                'sessionID' => $sessionID,
                'msisdn' => $msisdn,
                'userData' => $userData,
                'network' => $network,
                'newSession' => $newSession,
                'message' => $message,
                'level' => 1
            ];

            Cache::put($sessionID, [$currentState], 120);

            return response()->json([
                'sessionID' => $sessionID,
                'msisdn' => $msisdn,
                'userID' => $userID,
                'continueSession' => true,
                'message' => $message,
            ]);
        }

        $userResponseTracker = Cache::get($sessionID) ?? [];

        if (empty($userResponseTracker)) {
            return response()->json([
                'sessionID' => $sessionID,
                'msisdn' => $msisdn,
                'userID' => $userID,
                'continueSession' => false,
                'message' => 'Session expired. Please dial again.',
            ]);
        }

        $lastResponse = end($userResponseTracker);
        $continueSession = false;
        $message = "Invalid choice!";
        // dd($lastResponse);

        if ($lastResponse['level'] === 1) {
            switch ($userData) {
                case '1':
                    if ($user) {
                        $message = "You are already registered.";
                    } else {
                        $userInfo = $this->momoService->getBasicUserInfo($msisdn);
                        // TODO: Check for if userinfo doesn't not exist
                        $newUser =  User::create([
                            'phone' => $msisdn,
                            'network' => $network,
                            'status' => true,
                        ])->details()->create([
                            'name' => $userInfo['given_name'] . ' ' . $userInfo['family_name'],
                            'dob' => $userInfo['birthdate'],
                            'gender' => $userInfo['gender'],
                        ])->user->account()->create();

                        $message = "congratulations {$newUser->user->details->name}.<br>You have successfully registered to Penny Africa";
                    }
                    break;
                case '2':
                    if (!$user) {
                        $message = "You need to register first.";
                    } else {
                        $balance = $user->account->pennies ?? 0;
                        $message = "Your current balance is: GH₵ " . number_format($balance, 2);
                    }
                    break;
                case '3':
                    if (!$user) {
                        $message = "You need to register first.";
                    } else {
                        $message = "Enter the amount to withdraw:<br>Note: Amount should be less than {$user->account->pennies}";
                        $continueSession = true;
                        $newState = ['level' => 2];
                    }
                    break;
                case '4':
                    if (!$user) {
                        $message = "You are not registered.";
                    } else {
                        $user->delete();
                        $message = "Your subscription has been canceled.";
                    }
                    break;
            }
        } elseif ($lastResponse['level'] === 2) {
            if (!$user || !is_numeric($userData) || $userData < 0) {
                $message = "Invalid amount. Try again later.";
            } else {

                if ($user->account->pennies >= $userData) {
                    // Create withdrawal record
                    $withdrawal = Withdrawal::create([
                        'user_id' => $user->id,
                        'amount' => $userData,
                        'transaction_id' => Str::uuid(),
                        'status' => Withdrawal::STATUS_PENDING,
                    ]);

                    // Deduct from account balance
                    $user->account->pennies -= $userData;
                    $user->account->save();

                    $message = "Withdrawal request of GH₵ " . number_format($userData, 2) . " has been initiated. Transaction ID: {$withdrawal->transaction_id}";
                } else {
                    $message = "Insufficient balance.";
                }
            }
        }

        if ($continueSession) {
            $newState = array_merge($lastResponse, ['userData' => $userData], $newState);
            $userResponseTracker[] = $newState;
            Cache::put($sessionID, $userResponseTracker, 120);
        }

        return response()->json([
            'sessionID' => $sessionID,
            'msisdn' => $msisdn,
            'userID' => $userID,
            'continueSession' => $continueSession,
            'message' => $message,
        ]);
    }
}
