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
    <div class="max-w-lg mx-auto flex p-6 bg-white rounded-lg shadow-xl">
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
            Welcome, {{ $name ?? 'guest' }}
            
            <h5 class="text-xl text-gray-900 leading-tight">Guess the year - Results</h5>
            <div>
                <table>
                    <tbody>
                    @foreach ($score_line as $sessionKey => $result)
                        <tr>
                        @if ($sessionKey === $original_session_id))
                            <td class="{{ $result['class'] }}">Yours:</td>
                        @else
                            <td class="{{ $result['class'] }}">Challenger:</td>
                        @endif
                            <td>{{ $result['score'] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <table class="table-fixed">
                    <thead>
                        <tr>
                            <td class="w-1/2 px-4 py-2">Title</td>
                            <td class="w-1/6 px-4 py-2">Year</td>
                            <td class="w-1/6 px-4 py-2">Guess</td>
                            <td class="w-1/6 px-4 py-2">Score</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($records as $rec)
                        <tr class="{{ $score_line[$rec->session_id]['class'] }}">
                            <td class="w-1/2 border px-4 py-2">{{ $rec->title }}</td>
                            <td class="w-1/6 border px-4 py-2">{{ $rec->year }}</td>
                            <td class="w-1/6 border px-4 py-2">{{ $rec->guess }}</td>
                            <td class="w-1/6 border px-4 py-2">{{ $rec->score }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <br />
                <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" href="{{ url('/') }}" alt="Go home">
                    New Game
                </a>
            </div>
        </div>
    </div>
    </div>
    </body>
</html>
