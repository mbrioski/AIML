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
use Ridesoft\AIML\Exception\InvalidCategoryException;
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
     * @dataProvider fileProvider
     * @throws \Exception
     */
    public function testGetCategories($file, $numberOfCategories)
    {
        $this->file->setAimlFile($file);
        $this->assertEquals($numberOfCategories, count($this->file->getCategories()));
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

    public function fileProvider()
    {
        return [
            [__DIR__ . '/files/simple.aiml', 2]
        ];
    }
}
