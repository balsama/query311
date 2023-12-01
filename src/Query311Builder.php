<?php

namespace Balsama\Query311;

use Latitude\QueryBuilder\Engine\CommonEngine;
use Latitude\QueryBuilder\QueryFactory;
use PhpParser\Node\Param;
use function Latitude\QueryBuilder\field;
use function Latitude\QueryBuilder\search;
use function Latitude\QueryBuilder\func;

class Query311Builder
{
    private array $submittedParams;
    private QueryFactory $factory;

    public function __construct(array $post)
    {
        $this->submittedParams = $post;
        $this->factory = new QueryFactory(new CommonEngine());
    }

    public function getQuery(): string
    {
        $year = Helpers::getYearUuid($this->submittedParams['table']);
        $after = $this->submittedParams['date-after'];
        $before = $this->submittedParams['date-before'];

        // Option 1
        $zipCode = $this->submittedParams['zip-code'];
        $caseTitleContains = $this->submittedParams['case-title-contains'];

        // Option 2
        $location = $this->submittedParams['address-contains'];

        if ($zipCode) {
        $query = $this->factory->select($year . '.*')
            ->from($year)
            ->where(search('case_title')->contains(urlencode($caseTitleContains)))
            ->andWhere(field('location_zipcode')->eq($zipCode))
            ->andWhere(field('open_dt')->gte($after))
            ->andWhere(field('open_dt')->lte($before))
            ->compile();
        }
        elseif ($location) {
            $searchType = array_key_exists('address-search-type', $this->submittedParams) ? 'contains' : 'begins';
            $query = $this->factory->select($year . '.*')
                ->from($year)
                ->where(search('location')->$searchType($location))
                ->andWhere(field('open_dt')->gte($after))
                ->andWhere(field('open_dt')->lte($before))
                ->compile();
        }
        else {
            $query = $this->factory->select($year . '.*')
                ->from($year)
                ->where(search('case_title')->contains(urlencode($caseTitleContains)))
                ->andWhere(field('open_dt')->gte($after))
                ->andWhere(field('open_dt')->lte($before))
                ->compile();
        }

        $query = $this->insertParams($query->sql(), $query->params());
        return $query;
    }

    private function insertParams(string $sqlQuery, array $sqlParams, string $replaceStr = '?'): string
    {
        foreach ($sqlParams as $sqlParam) {
            $pos = strpos($sqlQuery, $replaceStr);
            if ($pos !== false) {
                $sqlQuery = substr_replace($sqlQuery, "'" . $sqlParam . "'", $pos, strlen($replaceStr));
            }
        }

        return $sqlQuery;
    }

}