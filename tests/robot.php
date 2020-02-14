<?php
/*
 *
 * (c) Maurizio Brioschi <maurizio.brioschi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require 'vendor/autoload.php';

$file = new \Ridesoft\AIML\File();

echo "Hello Aiml\n";
echo $file->setAimlFile(__DIR__ . '/files/simple.aiml')
        ->getCategory('Hello Aiml')
        ->getTemplate() . "\n";

$file2 = new \Ridesoft\AIML\File();
$category = $file2->setAimlFile(__DIR__ . '/files/srai.aiml')
    ->getCategory('Who Mauri is?');

echo "Who Mauri is? \n";
if ($category->isTemplateSrai()) {
    echo $file2->getCategory($category->getTemplate($category->getStars()))
        ->getTemplate(). "\n";
}

