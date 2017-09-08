<?php

require_once __DIR__ . '/vendor/autoload.php';
use Goutte\Client;

class RankCrawler {
    public $summoner;
    public $region;
    protected $client;
    protected $crawler;

    // TODO: Validate summoner name.
    public function __construct($summoner, $region) {
        $this->summoner = $summoner;
        $this->region = $region;
        $this->client = new Client();
        $this->crawler = $this->client->request('GET',
                                                'https://' .
                                                $this->region .
                                                '.op.gg/summoner/userName=' .
                                                $this->summoner);
        $this->validateSummoner();
    }

    private function validateSummoner() {
        if ($this->crawler->filter('.SummonerNotFoundLayout')->count()) {
            throw new RuntimeException('Summoner \'' .
                                       $this->summoner .
                                       '\' could not be found.');
        }
    }

    private function getNode($pattern) {
        try {
            return str_replace(',',
                               '',
                               trim($this->crawler->filter($pattern)->text()));
        } catch (InvalidArgumentException $e) {
            return '';
        }
    }

    // TODO: Get series progress.
    public function getSolo() {
        return array(
            $this->getNode('.TierRankInfo .TierRank .tierRank'),
            $this->getNode('.TierRankInfo .TierInfo .LeaguePoints'),
            $this->getNode('.TierRankInfo .WinLose .wins'),
            $this->getNode('.TierRankInfo .WinLose .losses'),
            $this->getNode('.TierRankInfo .WinLose .winratio')
        );
    }

    public function getThree() {
        return array(
            $this->getNode('.TierBox .SummonerRatingLine:nth-child(3) .TierRank .TierRank'),
            $this->getNode('.TierBox .SummonerRatingLine:nth-child(3) .TierRank .leaguePoints'),
            $this->getNode('.TierBox .SummonerRatingLine:nth-child(3) .WinLose .wins'),
            $this->getNode('.TierBox .SummonerRatingLine:nth-child(3) .WinLose .losses'),
            $this->getNode('.TierBox .SummonerRatingLine:nth-child(3) .WinLose .winratio')
        );
    }

    public function getFive() {
        return array(
            $this->getNode('.TierBox .SummonerRatingLine:nth-child(2) .TierRank .TierRank'),
            $this->getNode('.TierBox .SummonerRatingLine:nth-child(2) .TierRank .leaguePoints'),
            $this->getNode('.TierBox .SummonerRatingLine:nth-child(2) .WinLose .wins'),
            $this->getNode('.TierBox .SummonerRatingLine:nth-child(2) .WinLose .losses'),
            $this->getNode('.TierBox .SummonerRatingLine:nth-child(2) .WinLose .winratio')
        );
    }
}
