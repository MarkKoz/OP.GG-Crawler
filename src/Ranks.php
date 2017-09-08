<?php

spl_autoload_register(function ($class) {
    include $class . '.php';
});

header("content-type:application/json");

/*try {
    $crawler = new RankCrawler($_POST['summoner'], $_POST['region']);
} catch (RuntimeException $e) {
    header('HTTP/1.1 400 '. $e->getMessage());
    exit();
}

switch ($_POST['league']) {
    case 'Solo/Duo':
        $league = new League($crawler->getSolo());
        break;
    case 'Flex 3v3':
        $league = new League($crawler->getThree());
        break;
    case 'Flex 5v5':
        $league = new League($crawler->getFive());
        break;
}

echo $league->getJSON();
exit();*/

try {
    $crawler = new RankCrawler('Brizi', 'na');
} catch (RuntimeException $e) {
    header('HTTP/1.1 400 '. $e->getMessage());
    exit();
}

$league = new League($crawler->getThree());
echo $league->getJSON();

/*foreach ($league as $stat) {
    if (!empty($stat)) {
        print $stat . "\n";
    }
}*/
