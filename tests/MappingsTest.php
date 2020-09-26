<?php
declare(strict_types=1);

use Giberti\EmojiData\Emoji;
use Giberti\EmojiData\Mappings;
use PHPUnit\Framework\TestCase;

class MappingsTest extends TestCase
{
    /**
     * @dataProvider provideCldrNameAndEmoji
     * @param string $name
     * @param string|null $emoji
     */
    public function test_cldrNameToEmoji(string $name, ?string $emoji)
    {
        $this->assertEquals($emoji, Mappings::getEmojiFromCldrName($name));
    }

    /**
     * Provides test data for test_cldrNameToEmoji()
     *
     * @return array[]
     */
    public function provideCldrNameAndEmoji(): array
    {
        return [
            'invalid' => ['this-is-an-invalid-emoji-cldr-name', null],
            'avocado' => ['avocado', Emoji::AVOCADO],
            'jack-o-lantern' => ['jack-o-lantern', Emoji::JACK_O_LANTERN],
            'piñata' => ['piñata', Emoji::PINATA],
            'flag: St. Kitts & Nevis' => ['flag: St. Kitts & Nevis', Emoji::FLAG_ST_KITTS_AND_NEVIS],
        ];
    }

    /**
     * @dataProvider provideMarkdownAndEmoji
     * @param string $markdown
     * @param string|null $emoji
     */
    public function test_markdownToEmoji(string $markdown, ?string $emoji)
    {
        $this->assertEquals($emoji, Mappings::getEmojiFromMarkdown($markdown));
    }

    /**
     * Provides test data for test_markdownToEmoji()
     *
     * @return array[]
     */
    public function provideMarkdownAndEmoji(): array
    {
        return [
            'invalid' => [':this_is_an_invalid_emoji_markdown_name:', null],
            'avocado' => [':avocado:', Emoji::AVOCADO],
            'jack-o-lantern' => [':jack_o_lantern:', Emoji::JACK_O_LANTERN],
            'piñata' => [':pinata:', Emoji::PINATA],
            'flag: St. Kitts & Nevis' => [':flag_st_kitts_and_nevis:', Emoji::FLAG_ST_KITTS_AND_NEVIS],
        ];
    }

}