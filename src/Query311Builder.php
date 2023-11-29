<?php

namespace Balsama\Query311;

use Latitude\QueryBuilder\Engine\CommonEngine;
use Latitude\QueryBuilder\QueryFactory;
use function Latitude\QueryBuilder\field;
use function Latitude\QueryBuilder\search;
use function Latitude\QueryBuilder\func;

class Query311Builder
{
    private array $submittedParams;
    private bool $isCount;
    private string $type;
    private QueryFactory $factory;

    public function __construct(array $post)
    {
        $this->submittedParams = $post;
        $this->type = $this->getType();
        $this->isCount = $this->getIsCount();
        $this->factory = new QueryFactory(new CommonEngine());
    }

    public function getQuery(): string
    {

        if ($this->type === 'search') {
            $year = $this->submittedParams['table'];
            $zipCode = $this->submittedParams['zip-code'];
            $caseTitleContains = $this->submittedParams['case-title-contains'];
            $after = $this->submittedParams['date-after'];
            $before = $this->submittedParams['date-before'];

            $query = $this->factory->select($year . '.*')
                ->from($year)
                ->where(search('case_title')->contains($caseTitleContains))
                ->andWhere(field('location_zipcode')->eq($zipCode))
                ->andWhere(field('open_dt')->gte($after))
                ->andWhere(field('open_dt')->lte($before))
                ->compile();

        }
        elseif ($this->type === 'by-address') {
            $year = $this->submittedParams['table'];
            $location = $this->submittedParams['address-contains'];

            $searchType = 'begins';
            if (array_key_exists('address-search-type', $this->submittedParams)) {
                $searchType = 'contains';
            }

            if ($this->isCount) {
                $query = $this->factory->select(func('COUNT', $year . '.case_title'))
                    ->from($year)
                    ->where(search('location')->$searchType($location))
                    ->compile();
            }
            else {
                $query = $this->factory->select($year . '.*')
                    ->from($year)
                    ->where(search('location')->$searchType($location))
                    ->compile();
            }
        }
        else {
            throw new \Exception('Unrecognized form type');
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

    private function getType(): ?string
    {
        if (array_key_exists('search', $this->submittedParams)) {
            return 'search';
        }
        if (array_key_exists('by-address', $this->submittedParams)) {
            return 'by-address';
        }
        return null;
    }

    private function getIsCount(): bool
    {
        if (array_key_exists('count', $this->submittedParams)) {
            return true;
        }
        return false;
    }

}