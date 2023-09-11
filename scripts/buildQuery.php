<?php

include_once __DIR__ . "/../vendor/autoload.php";

use Latitude\QueryBuilder\Engine\CommonEngine;
use Latitude\QueryBuilder\Engine\BasicEngine;
use Latitude\QueryBuilder\Engine\SqlServerEngine;
use Latitude\QueryBuilder\QueryFactory;

use function Latitude\QueryBuilder\field;
use function Latitude\QueryBuilder\search;
use function Latitude\QueryBuilder\func;


$year = 'e6013a93-1321-4f2a-bf91-8d8a02f1e62f';
$zipCodes = ['02109', '02113'];
$caseTitleContains = 'Trash';
$after = '2023-09';
$before = '2023-10';

$factory = new QueryFactory(new CommonEngine());
if ($count) {
    $factory->select(func('COUNT', $year . '.case_title'));
}
else {
    $factory->select($year . '.case_title');
}
$query = $factory
    ->from($year)
    ->where(search('case_title')->contains($caseTitleContains))
    ->andWhere(field('location_zipcode')->in(implode("','", $zipCodes)))
    ->andWhere(field('open_dt')->gte($after))
    ->andWhere(field('open_dt')->lte($before))
    ->compile();

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

print $url;

$foo =21;