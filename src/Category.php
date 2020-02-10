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
        if ($this->isTemplateSrai()) {
            $this->pattern = str_replace(
                '<srai>',
                '',
                str_replace(
                    '</srai>',
                    '',
                    $this->pattern
                )
            );
            $this->pattern = str_replace("<star/>", '*', $this->pattern);
            preg_match_all('/<star index="\d"\/>/', $this->pattern, $output);
            foreach ($output as $value) {
                $this->pattern = str_replace($value, '*', $this->pattern);
            }
        }
        return $this->pattern;
    }

    /**
     * Return the template element or the patter when the category is a srai
     *
     * @param string ...$stars
     * @return string
     */
    public function getTemplate(string ...$stars): string
    {
        if ($this->isTemplateSrai()) {
            return $this->getPattern();
        }
        $matches = preg_match_all('/\*/m', $this->getPattern(), $arguments);
        if ($matches > 0 && count($stars) == $matches) {
            for ($i = 0; $i < $matches; $i++) {
                $this->stars[$i + 1] = $stars[$i];
            }
        }
        if ($matches === 1) {
            $this->template = str_replace("<star/>", $this->stars[1], $this->template);
        } elseif ($matches > 1) {
            foreach ($this->stars as $key => $star) {
                $this->template = str_replace("<star index=\"" . $key . "\"/>", $star, $this->template);
            }
        }
        return $this->template;
    }

    /**
     * @param array $stars
     * @return array
     */
    public function getStars(...$stars): array
    {
        $matches = preg_match_all('/\*/m', $this->pattern, $arguments);
        if ($matches > 0 && count($stars) == $matches) {
            for ($i = 0; $i < $matches; $i++) {
                $this->stars[$i + 1] = $stars[$i];
            }
        }
        return $this->stars;
    }

    protected function isTemplateSrai(): bool
    {
        $this->isTemplateSrai = false;
        $found = preg_match('/<srai>(.*?)<\/srai>/', $this->template, $output);
        if ($found) {
            $this->isTemplateSrai = true;
            $this->pattern = $output[1];
        }
        return $this->isTemplateSrai;
    }
}
