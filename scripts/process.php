<?php

include_once __DIR__ . "/../vendor/autoload.php";

$results = json_decode(file_get_contents(__DIR__ . "/../data/total-count-by-zip.json"));

$csvFile = file(__DIR__ . "/../data/populationByZip.csv");
$data = [];
foreach ($csvFile as $line) {
    $parts = str_getcsv($line);
    $zipsByPopulation[strval("0$parts[0]")] = $parts[1];
}

$zipsGeo = json_decode(file_get_contents(__DIR__ . "/../data/ZIP_Codes.geojson"));
$zipsGeo = $zipsGeo->features;

$absolutelyEverything = [];
foreach ($results as $yearstring => $yearResults) {
    $yearlyCounts = [];
    foreach ($yearResults as $zip => $yearZipResults) {
        $population = (int) str_replace(',', '', $zipsByPopulation[$zip]);
        $area = \Balsama\Query311\Helpers::areaFromZip($zip, $zipsGeo);
        if ($area == 0) {
            throw new Exception('Area zero');
        }

        $yearCountInt = (int) str_replace(',', '', $yearZipResults);
        $yearlyCounts[$zip] = [
            'year' => $yearstring,
            'zip' => "$zip",
            'count' => $yearZipResults,
            'zip_population' => $population,
            'zip_area' => $area,
            'per_capita' => $yearCountInt / (float) $population,
            'per_area' => $yearCountInt / (float) $area,
            'density' => (float) $population / (float) $area,
        ];
    }
    // Normalize
    $maxPerArea = 0;
    $maxPerPopulation = 0;
    $maxCount = 0;
    $maxDensity = 0;
    foreach ($yearlyCounts as $yearlyZip) {
        if ($yearlyZip['per_area'] > $maxPerArea) {
            $maxPerArea = $yearlyZip['per_area'];
        }
        if ($yearlyZip['per_capita'] > $maxPerPopulation) {
            $maxPerPopulation = $yearlyZip['per_capita'];
        }
        if ($yearlyZip['count'] > $maxCount) {
            $maxCount = $yearlyZip['count'];
        }
        if ($yearlyZip['density'] > $maxDensity) {
            $maxDensity = $yearlyZip['density'];
        }
    }
    foreach ($yearlyCounts as $yearlyZip) {
        $yearlyCounts[$yearlyZip['zip']]['normalized_per_area'] = $yearlyCounts[$yearlyZip['zip']]['per_area'] / $maxPerArea;
        $yearlyCounts[$yearlyZip['zip']]['normalized_per_population'] = $yearlyCounts[$yearlyZip['zip']]['per_capita'] / $maxPerPopulation;
        $yearlyCounts[$yearlyZip['zip']]['normalized_count'] = $yearlyCounts[$yearlyZip['zip']]['count'] / $maxCount;
        $yearlyCounts[$yearlyZip['zip']]['normalized_density'] = $yearlyCounts[$yearlyZip['zip']]['density'] / $maxDensity;
    }

    \Balsama\Query311\Helpers::csv(['year', 'zip', 'count', 'zip_population', 'zip_area', 'per_capita', 'per_area', 'normalized_per_area', 'normalized_per_population', 'normalized_count', 'density', 'normalized_density'], $yearlyCounts, "$yearstring--counts.csv", false, __DIR__ . "/../data/");
    $absolutelyEverything[$yearstring] = $yearlyCounts;
}
file_put_contents(__DIR__ . "/../data/absolutelyEverything.json", json_encode($absolutelyEverything, JSON_PRETTY_PRINT));
