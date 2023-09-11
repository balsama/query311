<?php

$originalGeo = json_decode(file_get_contents(__DIR__ . "/../data/ZIP_Codes.geojson"));
$absolutelyEverything = json_decode(file_get_contents(__DIR__ . "/../data/absolutelyEverything.json"));
$newFeatures = [];

$i = 0;
foreach ($originalGeo->features as $feature) {
    $zip = (string) $feature->properties->ZIP5;
    foreach ($absolutelyEverything as $aeYear) {
        if (property_exists($aeYear, $zip)) {
            //...
            $foo = 21;
        }
        else {
            $foo = 21;
        }
        $values[$aeYear->$zip->year] = [
            'per_population' => $aeYear->$zip->per_capita,
            'per_area' => $aeYear->$zip->per_area,
            'per_area_normalized' => $aeYear->$zip->normalized_per_area,
            'per_population_normalized' => $aeYear->$zip->normalized_per_population,
            'raw_count' => $aeYear->$zip->count,
            'raw_count_normalized' => $aeYear->$zip->normalized_count,
            'population_density' => $aeYear->$zip->density,
            'population_density_normalized' => $aeYear->$zip->normalized_density,
        ];
    }
    $foo = 21;
    $originalGeo->features[$i]->properties->trashComplaintsPerAcreByYear = $values;
    $i++;
}

$foo = 21;
file_put_contents(__DIR__ . "/../data/zt.geojson", json_encode($originalGeo, JSON_PRETTY_PRINT));

$foo = 21;
