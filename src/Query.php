<?php

namespace Balsama\Query311\Query311;

use Latitude\QueryBuilder\Engine\CommonEngine;
use Latitude\QueryBuilder\QueryFactory;
use Latitude\QueryBuilder\Query as LatitudeQuery;
use function Latitude\QueryBuilder\field;

class Query
{
    public LatitudeQuery $query;
    public string $table;

    public function __construct(
        string $table
    )
    {
        $this->table = $table;
        $factory = new QueryFactory(new CommonEngine());
        $this->query = $factory
            ->select('case_title', 'case_enquiry_id')
            ->from($this->table)
            ->compile();
    }

    public function getQuery(): string
    {
        return $this->query->sql();
    }

}