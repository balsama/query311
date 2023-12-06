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
    private QueryParameters $queryParameters;
    private QueryFactory $factory;

    public function __construct(QueryParameters $queryParameters)
    {
        $this->queryParameters = $queryParameters;
        $this->factory = new QueryFactory(new CommonEngine());
    }

    public function getQuery(): string
    {
        $year = Helpers::getYearUuid($this->queryParameters->year);
        $after = $this->queryParameters->after->format($this->queryParameters->after::ATOM);
        $before = $this->queryParameters->before->format($this->queryParameters->before::ATOM);

        switch ($this->queryParameters->formFlavor) {
            case 'ZIP_PLUS_CATEGORY':
                $zipCode = $this->queryParameters->zip;
                $caseTitleContains = $this->queryParameters->titleSearchString;

                $query = $this->factory->select($year . '.*')
                    ->from($year)
                    ->where(search('case_title')->contains(urlencode($caseTitleContains)))
                    ->andWhere(field('location_zipcode')->eq($zipCode))
                    ->andWhere(field('open_dt')->gte($after))
                    ->andWhere(field('open_dt')->lte($before))
                    ->compile();
                break;
            case 'ADDRESS':
                $location = $this->queryParameters->address;

                $searchType = ($this->queryParameters->searchAddressByContains) ? 'contains' : 'begins';
                $query = $this->factory->select($year . '.*')
                    ->from($year)
                    ->where(search('location')->$searchType($location))
                    ->andWhere(field('open_dt')->gte($after))
                    ->andWhere(field('open_dt')->lte($before))
                    ->compile();
                break;
            default:
                $caseTitleContains = $this->queryParameters->titleSearchString;
                $query = $this->factory->select($year . '.*')
                    ->from($year)
                    ->where(search('case_title')->contains(urlencode($caseTitleContains)))
                    ->andWhere(field('open_dt')->gte($after))
                    ->andWhere(field('open_dt')->lte($before))
                    ->compile();
                throw new \Exception('Unknown form flavor');
        }

        $query = $this->insertParams($query->sql(), $query->params());
        return $query;
    }

    private function insertParams(string $sqlQuery, array $sqlParams, string $replaceStr = '?'): string
    {
        foreach ($sqlParams as $sqlParam) {
            $pos = strpos($sqlQuery, $replaceStr);
            if ($pos !== false) {
                $sqlQuery = substr_replace($sqlQuery, "'" . urlencode($sqlParam) . "'", $pos, strlen($replaceStr));
            }
        }

        return $sqlQuery;
    }

    private function urlEncodeSpecialChars(string $string, array $search = ['%'], array $replace = ['%25']): string
    {

    }
}
