<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class UssdController extends Controller
{
  public function handleUssd(Request $request)
  {
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

  public function register(Request $request)
  {
    $sessionID = $request->input('sessionID');
    $userID = $request->input('userID');
    $newSession = $request->input('newSession');
    $msisdn = $request->input('msisdn');
    $userData = trim($request->input('userData'));
    $network = $request->input('network');

    if ($newSession) {
      $message = "Welcome to  PennyAfrica.<br>" .
        "1. Register<br>" .
        "2. Check Pennies<br>" .
        "3. Withdraw";

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

    // Handle Main Menu
    if ($lastResponse['level'] === 1) {
      if ($userData === '1') {
        $message = "Enter your name to register:";
        $continueSession = true;
        $newState = ['level' => 2];
      } elseif ($userData === '2') {
        // Fetch user balance
        $balance = $this->getUserBalance($msisdn, true);
        $message = "Your current pennies balance is: GH₵ " . number_format($balance, 2);
      } elseif ($userData === '3') {
        $message = "Withdraw function coming soon.";
      }
    }
    // Handle Registration
    elseif ($lastResponse['level'] === 2) {
      // Save user details (Example: Store in DB)
      $userDetails = $this->registerUser($msisdn, $userData);
      $message = "Registration successful!<br>" . json_encode($userDetails);
    }

    // Save state if session continues
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

  /**
   * Dummy function to get user's balance
   */
  private function getUserBalance($msisdn, $inSimulation = false)
  {
    return !$inSimulation ? Auth::user()->account->pennies : 10.50;
  }

  /**
   * Dummy function to register user
   */
  private function registerUser($msisdn, $name)
  {
    // Simulate storing user details in a database
    $balance = $this->getUserBalance($msisdn, true); // Example initial balance

    return [
      'name' => $name,
      'msisdn' => $msisdn,
      'balance' => $balance
    ];
  }
}
