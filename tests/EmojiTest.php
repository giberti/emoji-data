<?php

use PHPUnit\Framework\TestCase;

use Giberti\EmojiData\Emoji;

class EmojiTest extends TestCase
{
    /**
     * Spot check a few emoji
     */
    public function test_emoji()
    {
        $this->assertEquals('🥑', Emoji::AVOCADO, 'Avocado');
        $this->assertEquals('🏴‍☠️', Emoji::PIRATE_FLAG, 'pirate flag');
        $this->assertEquals('🇨🇼', Emoji::FLAG_CURACAO, 'flag: Curaçao');
    }
}