<?php

namespace Balsama\Query311;

use PHPUnit\Framework\TestCase;

class QueryParametersTest extends TestCase
{
    public static QueryParameters $queryParameters;

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
        $formData = array (
            'table' => '2023',
            'zip-code' => '02113',
            'case-title-contains' => 'Bicycle',
            'address-contains' => '',
            'date-after' => '2023-01-01',
            'date-before' => '2023-12-31',
            'XDEBUG_SESSION_START' => 'annares',
        );
        $this->queryParameters = new QueryParameters($formData);
    }

    public function testFoo()
    {
        $this->assertTrue(true);
    }

    public function testFormFlavor()
    {
        $queryParameters = new QueryParameters(self::$addressStartsWithFormData);
        $this->assertEquals('ADDRESS', $queryParameters->formFlavor);

        $queryParameters = new QueryParameters(self::$addressContainsFormData);
        $this->assertEquals('ADDRESS', $queryParameters->formFlavor);

        $queryParameters = new QueryParameters(self::$zipAndCategoryFormData);
        $this->assertEquals('ZIP_PLUS_CATEGORY', $queryParameters->formFlavor);
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
