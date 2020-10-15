<?php

namespace Tests\Unit\Console\Commands;

use App\Console\Commands\ImdbDataCollector;
use DomDocument;
use Goutte\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Symfony\Component\DomCrawler\Crawler;
use Tests\TestCase;
use Weidner\Goutte\GoutteFacade as Goutte;

class ImdbDataCollecterTest extends TestCase
{
    /** @var */
    private $imdbDataCollector;

    protected function setUp(): void
    {
        parent::setUp();

        $this->imdbDataCollector = new ImdbDataCollector();
    }

    public function testHandle()
    {
        $crawler = new Crawler(
            $this->getImdbBasicHtml(),
            ImdbDataCollector::URI
        );

        $this->instance(Client::class, Mockery::mock(Client::class, function ($mock) use ($crawler) {
            $mock->shouldReceive('request')
                ->once()
                ->with('GET', ImdbDataCollector::URI)
                ->andReturn($crawler);
        }));

        $this->assertDatabaseHas('imdb_data', [
            'title' => 'Test one',
        ]);
    }

    private function getImdbBasicHtml(): DOMDocument
    {
        $doc = new DOMDocument();
        $doc->loadHTML("
            <html>
                <body>
                    <div class=\"lister\">
                        <table class=\"chart full-width\" data-caller-name=\"chart-top250movie\">
                            <tbody class=\"lister-list\">
                                <tr>
                                    <td class=\"posterColumn\">
                                        <a href=\"\">
                                            <img src=\"https://phpstan.org/logo.d8929f3a.png\" />
                                        </a>
                                    </td>
                                    <td class=\"titleColumn\">
                                        <a href=\"\">Test one</a>
                                        <span class=\"secondaryInfo\">2001</span>
                                    </td>
                                    <td class=\"ratingColumn imdbRating\">8.9</td>
                                    <td class=\"ratingColumn\"></td>
                                    <td class=\"watchListColumn\"></td>
                                <tr>
                                <tr>
                                    <td class=\"posterColumn\">
                                        <a href=\"\">
                                            <img src=\"https://phpstan.org/logo.d8929f3a.png\" />
                                        </a>
                                    </td>
                                    <td class=\"titleColumn\">
                                        <a href=\"\">Test two</a>
                                        <span class=\"secondaryInfo\">1999</span>
                                    </td>
                                    <td class=\"ratingColumn imdbRating\">7.5</td>
                                    <td class=\"ratingColumn\"></td>
                                    <td class=\"watchListColumn\"></td>
                                <tr>
                                <tr>
                                    <td class=\"posterColumn\">
                                        <a href=\"\">
                                            <img src=\"https://phpstan.org/logo.d8929f3a.png\" />
                                        </a>
                                    </td>
                                    <td class=\"titleColumn\">
                                        <a href=\"\">Test three</a>
                                        <span class=\"secondaryInfo\">2016</span>
                                    </td>
                                    <td class=\"ratingColumn imdbRating\">6.7</td>
                                    <td class=\"ratingColumn\"></td>
                                    <td class=\"watchListColumn\"></td>
                                <tr>
                                <tr>
                                    <td class=\"posterColumn\">
                                        <a href=\"\">
                                            <img src=\"https://phpstan.org/logo.d8929f3a.png\" />
                                        </a>
                                    </td>
                                    <td class=\"titleColumn\">
                                        <a href=\"\">Test four</a>
                                        <span class=\"secondaryInfo\">1974</span>
                                    </td>
                                    <td class=\"ratingColumn imdbRating\">5.5</td>
                                    <td class=\"ratingColumn\"></td>
                                    <td class=\"watchListColumn\"></td>
                                <tr>
                            </tbody>
                        </table>
                    </div>
                </body>
            </html>
        ");

        return $doc;
    }
}
