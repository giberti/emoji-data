<?php

namespace Giberti\EmojiDataBuilder;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require(__DIR__ . '/../vendor/autoload.php');

$url = 'https://unicode.org/Public/emoji/15.1/emoji-test.txt';
$cacheFile = md5($url) . '.cache';

if (file_exists($cacheFile)) {
    $content = file_get_contents($cacheFile);
} else {
    $content = file_get_contents($url);
    file_put_contents($cacheFile, $content);
}

$fileParser = new FileParser($content);
$emoji = $fileParser->getAllEmoji();
$templateData = [
    'emojis' => $emoji,
    'generated' => date('Y-m-d'),
    'source' => $url,
];

$twig = new Environment(
    new FilesystemLoader(__DIR__ . '/Templates'),
    []
);

file_put_contents(
    __DIR__ . '/../src/Emoji.php',
    $twig->load('Emoji.twig')->render($templateData)
);
file_put_contents(
    __DIR__ . '/../src/Mappings.php',
    $twig->load('Mappings.twig')->render($templateData)
);

echo "Done.\n";
