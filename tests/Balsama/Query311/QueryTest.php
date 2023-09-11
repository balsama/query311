<?php

namespace Balsama\Query311\Query311;

class QueryTest extends \PHPUnit\Framework\TestCase
{
    private Query $query;

    protected function setUp(): void
    {
        parent::setUp();
        $this->query = new Query('123');
    }

    public function testGetQuery()
    {
        $foo = $this->query->getQuery();
        $bar = 21;
    }

}