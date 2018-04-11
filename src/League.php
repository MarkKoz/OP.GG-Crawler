<?php

class League {
    public $tier;
    public $division;
    public $lp;
    public $wins;
    public $losses;
    public $ratio;
    private $rank;

    public function __construct($stats) {
        list($this->rank, $this->lp, $this->wins, $this->losses, $this->ratio) =
            $stats;

        $this->getRank();
        $this->getStat($this->lp, '/(\d+) LP/');
        $this->getStat($this->wins, '/(\d+)W/');
        $this->getStat($this->losses, '/(\d+)L/');
        $this->getStat($this->ratio, '/(\d+)%/');
    }

    public function getJSON() {
        return json_encode(
            array(
                "tier" => $this->tier,
                "division" => $this->division,
                "lp" => $this->lp,
                "wins" => $this->wins,
                "losses" => $this->losses,
                "ratio" => $this->ratio,
            ));
    }

    private function getRank() {
        if (preg_match('/(\w+) (\d)/', $this->rank, $matches)) {
            $this->tier = $matches[1];
            $this->division = $this->romanise($matches[2]);
        } else {
            $this->tier = $this->rank;
        }
    }

    private function getStat(&$stat, $pattern) {
        if (!empty($stat)) {
            preg_match($pattern, $stat, $matches);
            $stat = intval($matches[1]);
        }
    }

    private function romanise($i) {
        switch($i) {
            case "1":
                return "I";
            case "2":
                return "II";
            case "3":
                return "III";
            case "4":
                return "IV";
            case "5":
                return "V";
            default:
                return $i;
        }
    }
}
