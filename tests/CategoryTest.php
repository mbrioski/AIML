<?php

namespace Rideaoft\AIML\Tests;

use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{
    /** @var \Ridesoft\AIML\Category */
    protected $category;

    protected function setUp(): void
    {
        $this->category = new \Ridesoft\AIML\Category('pattern', 'template');
    }

    public function testGetPattern()
    {
        $this->assertEquals('pattern', $this->category->getPattern());
    }

    public function testGetTemplate()
    {
        $this->assertEquals('template', $this->category->getTemplate());
    }
}
