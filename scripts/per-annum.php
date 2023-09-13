<?php

include_once __DIR__ . "/../vendor/autoload.php";

$absolutelyEverything = json_decode(file_get_contents(__DIR__ . "/../data/absolutelyEverything.json"));

foreach ($absolutelyEverything as $yearResults) {
    foreach ($yearResults as $zipResults) {
        if ($zipResults->zip === "02114") {
            $results[$zipResults->year] = $zipResults->count;
        }
    }
}

$results = \Balsama\Query311\Helpers::includeArrayKeysInArray($results);
\Balsama\Query311\Helpers::csv(['year', 'count'], $results, '02114-resiults-annum-.csv');
$foo = 21;