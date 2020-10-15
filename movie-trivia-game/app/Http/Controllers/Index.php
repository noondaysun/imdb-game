<?php

namespace App\Http\Controllers;

use App\Models\GameRounds;
use App\Models\GameSessions;
use App\Models\ImdbData;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class Index extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  Request $request
     * @return RedirectResponse|View
     */
    public function __invoke(Request $request)
    {
        $sessionId = Session::getId();
        $movieCount = ImdbData::count();

        if (!$movieCount) {
            $request->session()->flash('info', 'Please wait while we collect random movie data');

            Artisan::call('imdb:collect');
        }

        // Check if this session already stored in game sessions/ add as challenger
        $gameSession = GameSessions::where('session_id_initiator', $sessionId)
            ->orWhere('session_id_challenger', $sessionId)
            ->orWhereNull('session_id_challenger')
            ->first();

        if (!isset($gameSession->id)) {
            $request->session()->flash('status', 'Waiting on challenger');
            $gameSession = new GameSessions();
            $gameSession->session_id_initiator = $sessionId;
            $gameSession->save();
        } elseif (
            $gameSession->session_id_initiator !== $sessionId &&
            $gameSession->session_id_challenger === null
        ) {
            $gameSession->session_id_challenger = $sessionId;
            $gameSession->save();
        }

        $gameRoundsInitiator = GameRounds::where('session_id', $gameSession->session_id_initiator)
            ->count();
        $gameRoundsChallenger = GameRounds::where('session_id', $gameSession->session_id_challenger)
            ->count();

        if ($gameRoundsInitiator === 8) {
            $this->addLockedToSession($request);
        }

        if ($gameRoundsChallenger === 8) {
            $this->addLockedToSession($request);
        }

        if ($gameRoundsChallenger === 8 && $gameRoundsInitiator === 8) {
            return redirect('/results');
        }

        $imdbData = ImdbData::inRandomOrder()->first();

        return view(
            'index',
            [
                'imdb' => $imdbData,
                'initiator_rounds' => $gameRoundsInitiator,
                'challenger_rounds' => $gameRoundsChallenger,
            ]
        );
    }

    private function addLockedToSession(Request $request): void
    {
        $request->session()->put('game_locked', true);
    }
}
