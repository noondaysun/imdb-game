<?php

namespace App\Console\Commands;

use App\Models\ImdbData;
use Weidner\Goutte\GoutteFacade as Goutte;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ImdbDataCollector extends Command
{
    const URI = 'http://www.imdb.com/chart/top?ref_=nb_mv_3_chttp';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'imdb:collect';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Collect top 250 data from IMDb';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            DB::table('imdb_data')->truncate();
        } catch (\Exception $exception) {
            Log::error($exception);
        }

        $imdbData = new ImdbData();
        $records = [];

        try {
            $crawler = Goutte::request('GET', self::URI);

            $records = $crawler->filter('tbody.lister-list>tr')->each(function ($row) {
                return $row->filter('td')->each(function ($td, $i) {
                    if ($i === 0) { // poster
                        $title = $td->filter('a>img')->extract(['alt'])[0];
                        $poster = $td->selectImage($title)->image()->getUri();
                        preg_match('/UY/', $poster, $out);
                        $poster = preg_replace(
                            '/U(X|Y)(\d+)/',
                            !empty($out) ? 'UY268' : 'UX182',
                            str_replace('45,67', '182,268', $poster)
                        );
                        Storage::put(
                            $localImage = '/public/' . base64_encode($title) . '.jpg',
                            file_get_contents($poster),
                            'public'
                        );

                        return $localImage;
                    } elseif ($i === 1) { // title/year
                        $text = $td->text();
                        $text = preg_replace('/^[0-9]{1,3}\.\ /', '', $text);
                        $text = explode('(', $text);

                        return [
                            'title' => trim($text[0]),
                            'year' => (int) trim($text[1], ')'),
                        ];
                    } elseif ($i === 2) {
                        return $td->text();
                    }
                });
            });

            array_walk($records, function (&$record) {
                return ImdbData::create([
                    'poster' => str_replace('/public/', '', $record[0]),
                    'title' => $record[1]['title'],
                    'year' => $record[1]['year'],
                    'rating' => $record[2],
                ]);
            });

            return count($records);
        } catch (\Exception $exception) {
            $message = $exception->getMessage();

            $this->error($message);
            Log::error($message);
        }

        return 0;
    }
}
