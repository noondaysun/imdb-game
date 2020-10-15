<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="text-gray-900 antialiased leading-tight">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Movie Trivia</title>

        <!-- Links -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="manifest" href="/manifest.webmanifest">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <!-- Scripts -->
        <script async src="{{ asset('js/app.js') }}"></script>
    </head>
    <body class="min-h-screen from-yellow-300 to-white">
    <div class="max-w-md mx-auto flex p-6 bg-white rounded-lg shadow-xl">
    <div class="flex-shrink-0">
        <img class="h-20 w-20" src="{{ asset('images/logo.svg') }}" alt="Movie Trivia Logo">
    </div>
    <div class="ml-6 pt-1">
        <h4 class="text-xl text-gray-900 leading-tight">Movie Trivia</h4>
        @if (session('status'))
            <div id="statusAlert" class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3" role="alert">
                <p class="font-bold">{{ session('status') }}</p>
            </div>
        @endif
        <div class="text-base text-gray-600 leading-normal">
            <h5 class="text-xl text-gray-900 leading-tight">Guess the year</h5>
            <div>
                {{ $imdb->title }}
                <img alt="{{ $imdb->title }}" src="{{ asset("/storage/$imdb->poster") }}" /> <br />
                Rating: {{ $imdb->rating }}
                <form id="ratingForm" method="post" action="/round">
                    @csrf
                    <input class="shadow appearance-none border rounded w py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="number" min="1800" max="{{ date('Y') }}" name="guess" placeholder="eg. 1999" {{ Session::has('game_locked') ? 'disabled="disabled"' : '' }} />
                    <input type="hidden" name="imdb_data_id" value="{{ $imdb->id }}" />
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" onclick="document.getElementById('ratingForm').submit();" type="button">
                        Save
                    </button>
                </form>
                @if (in_array(8, [$initiator_rounds, $challenger_rounds]))
                    <a href="/results">View Results</a>
                @endif
            </div>
        </div>
    </div>
    </div>
    </body>
</html>
