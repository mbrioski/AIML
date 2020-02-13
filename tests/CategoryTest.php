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
    /**
     * @dataProvider patternProvider
     * @param $pattern
     * @param $template
     * @param $expectedPattern
     */
    public function testGetPattern($pattern, $template, $expectedPattern)
    {
        $category = new Category($pattern, $template);
        $this->assertEquals($expectedPattern, $category->getPattern());
    }

    /**
     * @dataProvider templateProvider
     * @param $pattern
     * @param $template
     * @param $expected
     * @param mixed ...$args
     */
    public function testGetTemplate($pattern, $template, $expected, array $args = [])
    {
        $category = new Category($pattern, $template);
        if (!empty($args)) {
            $this->assertEquals($expected, $category->getTemplate($args));
        }
    }

    public function testIsTemplateSrai()
    {
        $category = new Category('pattern', 'template');
        $this->assertFalse($category->isTemplateSrai());

        $category = new Category(
            'pattern',
            '<srai>My family has three elements: <star index="1"/>, <star index="2"/> and <star index="3"/></srai>'
        );
        $this->assertTrue($category->isTemplateSrai());
    }

    public function patternProvider()
    {
        return [
            [
                'pattern',
                'template',
                'pattern'
            ],
            [
                'DO YOU KNOW WHO * IS?',
                "<srai>WHO IS <star/>?</srai>",
                "DO YOU KNOW WHO * IS?"
            ],
            [
                'BYE *',
                '<srai>BYE</srai>',
                'BYE *'
            ],
            [
                'My family is done by *,* and *',
                '<srai>My family has three elements: <star index="1"/>, <star index="2"/> and <star index="3"/></srai>',
                'My family is done by *,* and *'
            ],
        ];
    }

    public function templateProvider()
    {
        return [
            [
                'pattern',
                'template',
                'template'
            ],
            [
                '* is a *.',
                '<star index="1"/> is a <star index="2"/>?',
                'Mauri is a rock star?',
                ['Mauri', 'rock star']
            ],
            [
                'I love *',
                "I love <star/>",
                'I love pussy',
                ['pussy']
            ]
        ];
    }

}
