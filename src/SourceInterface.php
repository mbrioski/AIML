<?php


namespace Ridesoft\AIML;

interface SourceInterface
{
    /**
     * @return array
     */
    public function getCategories(): array;

    /**
     * Get the category matching the category pattern with the contentToMatch
     *
     * @param string $contentToMatch
     * @return Category
     */
    public function getCategory(string $contentToMatch): Category;
}
