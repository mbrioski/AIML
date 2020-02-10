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
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }
}
