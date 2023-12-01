<?php

namespace Balsama\Query311\Query311;


use Balsama\Query311\Helpers;
use PHPUnit\Framework\TestCase as TestCaseAlias;

class HelpersTest extends TestCaseAlias
{

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testGetVars()
    {
        $vars = Helpers::getVars();
        $this->assertIsArray($vars);
    }

    public function testGetOptions()
    {
        $options = Helpers::getCategoryOptionsHtml();
        $this->assertIsString($options);;
    }

}