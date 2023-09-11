<?php

include_once __DIR__ . "/../../vendor/autoload.php";

use Latitude\QueryBuilder\Engine\CommonEngine;
use Latitude\QueryBuilder\Engine\BasicEngine;
use Latitude\QueryBuilder\Engine\SqlServerEngine;
use Latitude\QueryBuilder\QueryFactory;

use function Latitude\QueryBuilder\field;
use function Latitude\QueryBuilder\search;
use function Latitude\QueryBuilder\func;

use Balsama\Fetch;

$submittedParams = $_POST;

$factory = new QueryFactory(new CommonEngine());
$count = false;
if (array_key_exists('count', $submittedParams)) $count = true;

if (array_key_exists('search', $submittedParams)) {
    $year = $submittedParams['table'];
    $zipCode = $submittedParams['zip-code'];
    $caseTitleContains = $submittedParams['case-title-contains'];
    $after = $submittedParams['date-after'];
    $before = $submittedParams['date-before'];

    if ($count) {
        $query = $factory->select(func('COUNT', $year . '.case_title'))
            ->from($year)
            ->where(search('case_title')->contains($caseTitleContains))
            ->andWhere(field('location_zipcode')->eq($zipCode))
            ->andWhere(field('open_dt')->gte($after))
            ->andWhere(field('open_dt')->lte($before))
            ->compile();
    } else {
        $query = $factory->select($year . '.*')
            ->from($year)
            ->where(search('case_title')->contains($caseTitleContains))
            ->andWhere(field('location_zipcode')->eq($zipCode))
            ->andWhere(field('open_dt')->gte($after))
            ->andWhere(field('open_dt')->lte($before))
            ->compile();
    }
}
elseif (array_key_exists('by-address', $submittedParams)) {
    $year = $submittedParams['table'];
    $location = $submittedParams['address-contains'];

    if ($count) {
        $query = $factory->select(func('COUNT', $year . '.case_title'))
            ->from($year)
            ->where(search('location')->contains($location))
            ->compile();
    }
    else {
        $query = $factory->select($year . '.*')
            ->from($year)
            ->where(search('location')->contains($location))
            ->compile();
    }
}

$sqlQuery = $query->sql();
$sqlParams = $query->params();
$replaceStr = '?';

foreach ($sqlParams as $sqlParam) {
    $pos = strpos($sqlQuery, $replaceStr);
    if ($pos !== false) {
        $sqlQuery = substr_replace($sqlQuery, "'" . $sqlParam . "'", $pos, strlen($replaceStr));
    }
}

$url = "https://data.boston.gov/api/3/action/datastore_search_sql?sql=" . $sqlQuery;

$result = Fetch::fetch($url);


if ($result->success) {
    header('Content-Type: application/json; charset=utf-8');
    header('Content-Disposition: inline; filename="boston-311-' . time() . '.json"');

    print json_encode($result->result->records, JSON_PRETTY_PRINT);
    exit(0);
}

print $url;

$foo = 21;