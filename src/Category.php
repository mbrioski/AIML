<?php


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
