<?php

/*
 *
 * (c) Maurizio Brioschi <maurizio.brioschi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ridesoft\AIML;

use Ridesoft\AIML\Exception\InvalidCategoryException;
use Ridesoft\AIML\Exception\InvalidSearchedPatternException;

class File implements SourceInterface
{
    /** @var string */
    protected $aimlFile;
    /** @var array|Category */
    protected $categories = [];

    /**
     * @param string $aimlFile
     * @return File
     */
    public function setAimlFile(string $aimlFile): self
    {
        $this->aimlFile = $aimlFile;
        return $this;
    }

    /**
     * @return string
     */
    public function getAimlFile(): ?string
    {
        return $this->aimlFile;
    }

    /**
     * @return array|Category
     * @throws \Exception
     */
    public function getCategories(): array
    {
        if ($this->getAimlFile() === null) {
            throw new \Exception('Aiml file not set');
        }
        if (empty($this->categories)) {
            $this->parse();
        }
        return $this->categories;
    }

    /**
     * @inheritDoc
     */
    public function getCategory(string $contentToMatch): ?Category
    {
        $contentWords = explode(' ', $contentToMatch);
        $stars = [];
        /** @var Category $category */
        foreach ($this->getCategories() as $category) {
            $pattern = $category->getPattern();
            $patternWords = explode(' ', $pattern);
            $foundPattern = false;
            $stars = [];
            for ($i = 0; $i < count($patternWords); $i++) {
                if (count($patternWords) !== count($contentWords)) {
                    continue;
                }
                if (strstr($patternWords[$i], '*') !== false) {
                    $foundPattern = true;
                    array_push($stars, $contentWords[$i]);
                    continue;
                }
                if (strcmp(strtolower($patternWords[$i]), strtolower($contentWords[$i])) === 0) {
                    $foundPattern = true;
                } else {
                    $foundPattern = false;
                    break;
                }
            }
            if ($foundPattern) {
                return $category->setStars($stars);
            }
        }
        throw new InvalidSearchedPatternException(
            'Pattern ' . $contentToMatch . ' not found in file ' . $this->getAimlFile()
        );
    }

    /**
     * @return $this
     */
    protected function parse(): self
    {
        $xmldata = simplexml_load_file($this->getAimlFile(), "SimpleXMLElement", LIBXML_NOCDATA);
        if (!$xmldata) {
            throw new \InvalidArgumentException(
                'File ' . $this->getAimlFile() . ' is not a valid xml(aiml) file'
            );
        }
        for ($i = 0; $i < count($xmldata->category); $i++) {
            if (!property_exists($xmldata->category[$i], 'pattern')) {
                throw new InvalidCategoryException('Pattern not found in file ' . $this->getAimlFile());
            }
            if (!property_exists($xmldata->category[$i], 'template')) {
                throw new InvalidCategoryException('Template not found in file ' . $this->getAimlFile());
            }
            array_push(
                $this->categories,
                new Category(
                    $xmldata->category[$i]->pattern,
                    str_replace(
                        '<template>',
                        '',
                        str_replace(
                            '</template>',
                            '',
                            $xmldata->category[$i]->template->asXML()
                        )
                    )
                )
            );
        }

        return $this;
    }
}
