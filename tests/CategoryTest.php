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
use Ridesoft\AIML\Category;

class CategoryTest extends TestCase
{
    public function testGetPattern()
    {
        $category = new Category('pattern', 'template');
        $this->assertEquals('pattern', $category->getPattern());
    }

    public function testGetTemplate()
    {
        $category = new Category('pattern', 'template');
        $this->assertEquals('template', $category->getTemplate());

        $category = new Category(
            '* is a *.',
            "<star index=\"1\"/> is a <star index=\"2\"/>?"
        );
        $this->assertEquals(
            'Mauri is a rock star?',
            $category->getTemplate('Mauri', 'rock star')
        );

        $category = new Category(
            'I love *',
            "I love <star/>"
        );
        $this->assertEquals(
            'I love pussy',
            $category->getTemplate('pussy')
        );
    }

    public function testGetStars()
    {
        $category = new Category(
            'A * is a *.',
            "When a <star index=\"1\"/>is not a<star index=\"2\"/>?"
        );
        $stars = $category->getStars('Mauri', 'snowboarder');
        $this->assertEquals(2, count($stars));
        $this->assertEquals('Mauri', $stars[1]);
        $this->assertEquals('snowboarder', $stars[2]);

        $category = new Category(
            'I love *',
            "I love <star/>"
        );
        $stars = $category->getStars('Pussy');
        $this->assertEquals(1, count($stars));
        $this->assertEquals('Pussy', $stars[1]);
    }

    public function testSrai()
    {
        $category = new Category(
            'DO YOU KNOW WHO * IS?',
            "<srai>WHO IS <star/>?</srai>"
        );
        $this->assertEquals(
            'WHO IS *?',
            $category->getPattern()
        );

        $category = new Category(
            'BYE *',
            "<srai>BYE</srai>"
        );
        $this->assertEquals(
            'BYE',
            $category->getPattern()
        );

        $category = new Category(
            'I like * and *',
            "<srai>I like <star index=\"1\"/>,<star index=\"2\"/></srai>"
        );
        $this->assertEquals(
            'I like *,*',
            $category->getPattern()
        );

        $category = new Category(
            'My family is done by *,* and *',
            "<srai>My family has three elements: <star index=\"1\"/>, <star index=\"2\"/> and <star index=\"3\"/></srai>"
        );
        $this->assertEquals(
            'My family has three elements: *, * and *',
            $category->getPattern()
        );
        $this->assertEquals(
            'My family has three elements: *, * and *',
            $category->getTemplate()
        );


    }
}
