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
use Ridesoft\AIML\Exception\InvalidCategoryException;
use Ridesoft\AIML\Exception\InvalidSearchedPatternException;
use Ridesoft\AIML\File;

class FileTest extends TestCase
{
    /** @var File */
    protected $file;

    protected function setUp(): void
    {
        $this->file = new File();
    }

    /**
     * @param $file
     * @param $numberOfCategories
     * @dataProvider fileProvider
     */
    public function testSetGetAimlFile($file, $numberOfCategories)
    {
        $this->file->setAimlFile($file);
        $this->assertEquals($file, $this->file->getAimlFile());
    }

    /**
     * @param $file
     * @param $numberOfCategories
     * @param array $categories
     * @param array $args
     * @throws \Exception
     * @dataProvider fileProvider
     */
    public function testGetCategories($file, $numberOfCategories, $categories)
    {
        $this->file->setAimlFile($file);
        $this->assertEquals($numberOfCategories, count($this->file->getCategories()));
        $index = 0;
        foreach ($categories as $key => $category) {
            $this->assertEquals($category[0], $this->file->getCategories()[$key]->getPattern());
            $this->assertEquals($category[1], $this->file->getCategories()[$key]->getTemplate($category[2]));
            $index++;
        }
    }

    public function testNoAimlFileSet()
    {
        $this->expectException(\Exception::class);
        $this->file->getCategories();
    }

    public function testInvalidCategoryExceptionNoPattern()
    {
        $this->expectException(InvalidCategoryException::class);
        $this->file->setAimlFile(__DIR__ . '/files/noPattern.aiml');
        $this->file->getCategories();
    }

    public function testInvalidCategoryExceptionNoTemplate()
    {
        $this->expectException(InvalidCategoryException::class);
        $this->file->setAimlFile(__DIR__ . '/files/noTemplate.aiml');
        $this->file->getCategories();
    }

    /**
     * @dataProvider getCategoryMatchProvider
     * @param $file
     * @param $pattern
     * @param $category
     */
    public function testGetCategory($file, $pattern, $category)
    {
        $this->file->setAimlFile($file);
        $categoryFound = $this->file->getCategory($pattern);
        $this->assertNotNull($categoryFound);
        $this->isInstanceOf(Category::class, $categoryFound);
        $this->assertEquals($category, $categoryFound);
    }

    public function testInvalidSearchedPatternException()
    {
        $this->expectException(InvalidSearchedPatternException::class);
        $this->file->setAimlFile(__DIR__ . '/files/simple.aiml')
            ->getCategory('Hello Mauri');
    }


    public function testInvalidSearchedPatternExceptionStar()
    {
        $this->expectException(InvalidSearchedPatternException::class);
        $this->file->setAimlFile(__DIR__ . '/files/star.aiml')
            ->getCategory('A Mauri Brioschi.');
    }

    public function testInvalidSearchedPatternExceptionSrai()
    {
        $this->expectException(InvalidSearchedPatternException::class);
        $this->file->setAimlFile(__DIR__ . '/files/srai.aiml')
            ->getCategory('Who Mauri Brioschi is?');
    }

    public function fileProvider()
    {
        return [
            [
                __DIR__ . '/files/simple.aiml',
                2,
                [
                    ['HELLO Aiml', 'Hello User', []],
                    ['How are u?', "I'm fine", []]
                ]
            ],
            [
                __DIR__ . '/files/star.aiml',
                2,
                [
                    ['A * is a *.', "When <star index=\"1\"/> is a <star index=\"2\"/>.", []],
                    ['A *.', "When <star/>.", []]
                ]
            ],
            [
                __DIR__ . '/files/star.aiml',
                2,
                [
                    ['A * is a *.', "When ciao is a rock.", ['ciao', 'rock']],
                    ['A *.', "When rain.", ['rain']]
                ]
            ],
            [
                __DIR__ . '/files/srai.aiml',
                3,
                [
                    ['Who is Mauri?', "Mauri is a tech lead", []],
                    ['Who is Mayla?', "Mayla is mauri wife", []],
                    ['Who * is?', 'Who is Mauri?', ['Mauri']],
                ]
            ],
        ];
    }

    public function getCategoryMatchProvider()
    {
        $starMatch = new Category('A *.', 'When <star/>.');
        $starMatch->setStars(['Mauri']);
        return [
            [
                __DIR__ . '/files/simple.aiml', 'HELLO Aiml', new Category('HELLO Aiml', 'Hello User')
            ],
            [
                __DIR__ . '/files/simple.aiml', 'hello aIml', new Category('HELLO Aiml', 'Hello User')
            ],
            [
                __DIR__ . '/files/star.aiml', 'A Mauri', $starMatch
            ],
            [
                __DIR__ . '/files/srai.aiml', 'Who is Mayla?', new Category('Who is Mayla?', 'Mayla is mauri wife')
            ],
            [
                __DIR__ . '/files/srai.aiml', 'Who * is?', new Category('Who * is?', '<srai>Who is <star/>?</srai>')
            ],
        ];
    }
}
