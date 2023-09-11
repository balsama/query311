<?php
$absolutelyEverything = json_decode(file_get_contents(__DIR__ . "/../data/absolutelyEverything.json"));
$year = 2022;

$t22 = $absolutelyEverything->$year;

$reportCountTotal = 0;
$perAreaTotal = 0;
$perPersonTotal = 0;
$population_total = 0;
$area_total = 0;
foreach ($t22 as $zip) {
    $reportCountTotal = $reportCountTotal + $zip->count;
    $perAreaTotal = $perAreaTotal + $zip->per_area;
    $perPersonTotal = $perPersonTotal + $zip->per_capita;
    $population_total = $population_total + $zip->zip_population;
    $area_total = $area_total + $zip->zip_area;
}

$perAreaAvg = $perAreaTotal / 36;
$perPersonAvg = $perPersonTotal / 36;
$perPersonAvg2 = $population_total / $reportCountTotal;
$perAreaAvg2 = $reportCountTotal / $area_total;

$foo = 21;