<?php
/*
 *
 * (c) Maurizio Brioschi <maurizio.brioschi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
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
