<?php

/*
 *
 * (c) Maurizio Brioschi <maurizio.brioschi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ridesoft\AIML;

class Category
{
    /** @var string */
    protected $pattern;
    /** @var string */
    protected $template;
    /** @var bool */
    protected $isTemplateSrai;
    /** @var */
    protected $stars = [];

    public function __construct(string $pattern, string $template)
    {
        $this->pattern = $pattern;
        $this->template = $template;
    }

    /**
     * @return string
     */
    public function getPattern()
    {
        return $this->pattern;
    }

    /**
     * Return the template element
     * If the template is type srai, return the original template
     * If the template is not srai, return the template filled with the correct stars
     *
     * @param array $stars
     * @return string
     */
    public function getTemplate(array $stars = []): ?string
    {
        if (count($stars) === 0) {
            return $this->template;
        }
        if (!empty($stars)) {
            $this->stars = array_merge([], $stars);
        }
        $content = $this->getContentFilledWithStars($this->template);
        if ($this->isTemplateSrai()) {
            $content = str_replace('<srai>', '', str_replace('</srai>', '', $content));
        }
        return $content;
    }


    /**
     * Check if the template has the tag srai
     * If it is strai, set the pattern with the content of srai
     * @return bool
     */
    public function isTemplateSrai(): bool
    {
        $this->isTemplateSrai = false;
        $found = preg_match('/<srai>(.*?)<\/srai>/', $this->template, $output);
        if ($found) {
            $this->isTemplateSrai = true;
            $this->template = $output[1];
        }
        return $this->isTemplateSrai;
    }

    /**
     * @param array $stars
     * @return $this
     */
    public function setStars(array $stars): self
    {
        $this->stars = $stars;
        return $this;
    }

    /**
     * @param string $content
     * @return string
     */
    protected function getContentFilledWithStars(string $content): string
    {
        if (count($this->stars) === 1) {
            $content = str_replace("<star/>", $this->stars[0], $content);
        } elseif (count($this->stars) > 1) {
            foreach ($this->stars as $key => $star) {
                $index = $key + 1;
                $content = str_replace("<star index=\"" . $index . "\"/>", $star, $content);
            }
        }
        return $content;
    }
}
