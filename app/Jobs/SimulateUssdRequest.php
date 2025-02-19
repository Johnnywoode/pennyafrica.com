<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use App\Events\UssdResponseReceived;
use Illuminate\Support\Facades\Auth;

class SimulateUssdRequest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $user = Auth::user();
        $response = Http::post(route('api.handle-ussd'), [
            'sessionID' => uniqid(),
            'userID' => rand(1000, 9999),
            'newSession' => true,
            'msisdn' => $user->phone,
            'userData' => $user->id,
            'network' => $user->network
        ]);

        broadcast(new UssdResponseReceived($response->json()))->toOthers();
    }
}
