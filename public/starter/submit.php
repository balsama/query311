<?php

include_once __DIR__ . "/../../vendor/autoload.php";

use Balsama\Fetch;

$query = new \Balsama\Query311\Query311Builder($_POST);

$url = "https://data.boston.gov/api/3/action/datastore_search_sql?sql=" . $query->getQuery();

$result = Fetch::fetch($url);

if ($result->success) {
    header('Content-Type: application/json; charset=utf-8');
    header('Content-Disposition: inline; filename="boston-311-' . time() . '.json"');

    print json_encode($result->result->records, JSON_PRETTY_PRINT);
    exit(0);
}

print $url;

$foo = 21;