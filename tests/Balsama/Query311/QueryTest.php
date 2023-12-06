<?php

namespace Balsama\Query311\Query311;

use Balsama\Query311\Query311Builder;
use Balsama\Query311\QueryParameters;
use PHPUnit\Framework\TestCase;

class QueryTest extends TestCase
{
    private Query311Builder $query;
    private QueryParameters $queryParameters;

    public static array $zipAndCategoryFormData = [
        'table' => '2023',
        'zip-code' => '02113',
        'case-title-contains' => 'Bicycle',
        'address-contains' => '',
        'date-after' => '2023-01-01',
        'date-before' => '2023-12-31',
    ];

    public static array $addressStartsWithFormData = [
        'table' => '2023',
        'zip-code' => '',
        'case-title-contains' => '0',
        'address-contains' => '36 Hull',
        'date-after' => '2023-01-01',
        'date-before' => '2023-12-31',
    ];

    public static array $addressContainsFormData = [
        'table' => '2023',
        'zip-code' => '',
        'case-title-contains' => '0',
        'address-contains' => '36 Hull',
        'address-search-type' => 'on',
        'date-after' => '2023-01-01',
        'date-before' => '2023-12-31',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->queryParameters = $this->getSampleQueryParameters();
        $this->query = new Query311Builder($this->queryParameters);
    }

    public function testGetQuery()
    {
        $sql = $this->query->getQuery();
        $url = 'https://data.boston.gov/api/3/action/datastore_search_sql?sql=' . $sql;
        $this->assertTrue(true);
    }

    public function testZipAndCategoryForm()
    {
        $queryParameters = new QueryParameters(self::$zipAndCategoryFormData);
        $query = new Query311Builder($queryParameters);
        $sql = $query->getQuery();
        $expected = <<<EOD
SELECT "e6013a93-1321-4f2a-bf91-8d8a02f1e62f".* FROM "e6013a93-1321-4f2a-bf91-8d8a02f1e62f" WHERE "case_title" LIKE '%Bicycle%' AND "location_zipcode" = '02113' AND "open_dt" >= '2023-01-01T00:00:00-05:00' AND "open_dt" <= '2023-12-31T00:00:00-05:00'
EOD;

        $this->assertEquals(
            $expected,
            $sql
        );
    }

    public function testAddressStartsWithForm()
    {
        $queryParameters = new QueryParameters(self::$addressStartsWithFormData);
        $query = new Query311Builder($queryParameters);
        $sql = $query->getQuery();
        $expected = <<<EOD
SELECT "e6013a93-1321-4f2a-bf91-8d8a02f1e62f".* FROM "e6013a93-1321-4f2a-bf91-8d8a02f1e62f" WHERE "location" LIKE '36 Hull%' AND "open_dt" >= '2023-01-01T00:00:00-05:00' AND "open_dt" <= '2023-12-31T00:00:00-05:00'
EOD;

        $this->assertEquals(
            $expected,
            $sql
        );
    }

    public function testAddressContainsForm()
    {
        $queryParameters = new QueryParameters(self::$addressContainsFormData);
        $query = new Query311Builder($queryParameters);
        $sql = $query->getQuery();
        $expected = <<<EOD
SELECT "e6013a93-1321-4f2a-bf91-8d8a02f1e62f".* FROM "e6013a93-1321-4f2a-bf91-8d8a02f1e62f" WHERE "location" LIKE '%36 Hull%' AND "open_dt" >= '2023-01-01T00:00:00-05:00' AND "open_dt" <= '2023-12-31T00:00:00-05:00'
EOD;

        $this->assertEquals(
            $expected,
            $sql
        );
    }

    public static function getSampleQueryParameters(): QueryParameters
    {
        $formData = array (
            'table' => '2023',
            'zip-code' => '02113',
            'case-title-contains' => 'Bicycle',
            'address-contains' => '',
            'date-after' => '2023-01-01',
            'date-before' => '2023-12-31',
            'XDEBUG_SESSION_START' => 'annares',
        );
        return new QueryParameters($formData);
    }
}