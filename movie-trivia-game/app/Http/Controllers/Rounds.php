<?php

namespace App\Http\Controllers;

use App\Models\GameRounds;
use App\Models\GameSessions;
use App\Models\ImdbData;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class Rounds extends Controller
{
    /**
     * @return View
     */
    public function results(Request $request): View
    {
        $sessionId = Session::getId();
        $gameSession = GameSessions::where('session_id_initiator', $sessionId)
            ->orWhere('session_id_challenger', $sessionId)
            ->first();
        $results = GameRounds::join('imdb_data', 'game_rounds.imdb_data_id', 'imdb_data.id')
            ->select(
                'imdb_data.title',
                'imdb_data.year',
                'game_rounds.guess',
                'game_rounds.score',
                'game_rounds.session_id'
            )->whereIn('session_id', [$gameSession->session_id_initiator, $gameSession->session_id_challenger])
            ->get();

        $scoreLine = [
            $gameSession->session_id_initiator => ['score' => 0],
            $gameSession->session_id_challenger => ['score' => 0],
        ];
        foreach ($results as $row) {
            $scoreLine[$gameSession->session_id_initiator]['score'] +=
                $row->session_id === $gameSession->session_id_initiator ? $row->score : 0;
            $scoreLine[$gameSession->session_id_challenger]['score'] +=
                $row->session_id === $gameSession->session_id_challenger ? $row->score : 0;
        }

        // Highest to lowest
        uasort($scoreLine, function ($value1, $value2) {
            return ($value1 <=> $value2) * -1;
        });
        $keys = array_keys($scoreLine);
        $scoreLine[$keys[0]]['class'] = 'bg-green-200';
        $scoreLine[$keys[1]]['class'] = 'bg-red-200';
        
        Session::forget('game_locked');
        Auth::logout();
        Session::regenerate();

        return view('results')
            ->with('original_session_id', $sessionId)
            ->with('score_line', $scoreLine)
            ->with('records', $results);
    }

    /**
     * @return RedirectResponse
     */
    public function round(Request $request): RedirectResponse
    {
        $sessionId = Session::getId();
        $imdbDataId = $request->input('imdb_data_id');
        $guess = $request->input('guess');
        $imdb = ImdbData::where('id', $imdbDataId)
            ->first();

        $gameRound = new GameRounds();
        $gameRound->session_id = $sessionId;
        $gameRound->imdb_data_id = $imdbDataId;
        $gameRound->guess = $guess;
        $gameRound->score = (int) $guess === (int) $imdb->year ? 5 : -3;
        $gameRound->save();

        return redirect('/')->with('status', 'Guess saved.');
    }
}
