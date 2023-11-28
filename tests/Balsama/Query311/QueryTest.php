<?php

namespace Balsama\Query311\Query311;

use Balsama\Query311\Query311Builder;

class QueryTest extends \PHPUnit\Framework\TestCase
{
    private Query311Builder $query;

    protected function setUp(): void
    {
        parent::setUp();
        $post = [
            'table' => 'e6013a93-1321-4f2a-bf91-8d8a02f1e62f',
            'by-address' => null,
            'address-contains' => '36 Hull',
            'address-search-type' => null,
        ];
        $this->query = new Query311Builder($post);
    }

    public function testGetQuery()
    {
        $foo = $this->query->getQuery();
        $url = 'https://data.boston.gov/api/3/action/datastore_search_sql?sql=' . $foo;
    }

}