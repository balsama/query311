<?php

include_once __DIR__ . "/../vendor/autoload.php";

use Balsama\Query311\FetchFromBalsama311;

$url = 'http://localhost/query311/public/starter/submit.php?XDEBUG_SESSION_START=annares';

$years = [
    '2023' => 'e6013a93-1321-4f2a-bf91-8d8a02f1e62f',
    '2022' => '81a7b022-f8fc-4da5-80e4-b160058ca207',
    '2021' => 'f53ebccd-bc61-49f9-83db-625f209c95f5',
    '2020' => '6ff6a6fd-3141-4440-a880-6f60a37fe789',
    '2019' => 'ea2e4696-4a2d-429c-9807-d02eb92e0222',
    '2018' => '2be28d90-3a90-4af1-a3f6-f28c1e25880a',
    '2017' => '30022137-709d-465e-baae-ca155b51927d',
];

$post = [
    'form_params' => [
        'table' => 'e6013a93-1321-4f2a-bf91-8d8a02f1e62f',
        'case-title-contains' => 'Trash',
        'zip-code' => '02109',
        'date-after' => '2023-01-01',
        'date-before' => '2023-12-31',
        'search' => '',
        'count' => 'on',
    ],
];

$zips = json_decode(file_get_contents(__DIR__ . "/../data/zips.json"));

foreach ($years as $yearstring => $year) {
    $post['form_params']['table'] = $year;
    $post['form_params']['date-after'] = $yearstring . '-01-01';
    $post['form_params']['date-before'] = $yearstring . '-12-31';
    foreach ($zips as $zip) {
        $post['form_params']['zip-code'] = $zip;
        $result = FetchFromBalsama311::fetch($url, $post);
        $results[$yearstring][$zip] = $result[0]->count;
        echo "Done with zip $zip for $yearstring\n";
    }
}
file_put_contents(__DIR__ . '/../data/total-count-by-zip.json', json_encode($results, JSON_PRETTY_PRINT));
$foo = 21;
