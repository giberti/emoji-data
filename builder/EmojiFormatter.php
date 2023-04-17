<?php
declare(strict_types=1);
namespace Giberti\EmojiDataBuilder;
class EmojiFormatter
{
    private $emoji;

    public function __construct(Emoji $emoji)
    {
        $this->emoji = $emoji;
    }

    public function constantValue(): string
    {
        return '\u{' . implode('}\u{', $this->emoji->getCodePoints()) . '}';
    }

    public function cldrName(): string
    {
        return $this->emoji->getCldrName();
    }

    public function emoji(): string
    {
        return $this->emoji->getEmoji();
    }

    public function cldrAsMarkdown(): string
    {
        return strtolower($this->constName());
    }

    public function constName(): string
    {
        $replaceMap = [
            ':' => '',
            '.' => '',
            ',' => '',
            '!' => '',
            '(' => '',
            ')' => '',
            '*' => 'ASTERISK',
            '&' => 'AND',
            '#' => 'HASH',
            ' ' => '_',
            '-' => '_',
            '1st' => 'FIRST',
            '2nd' => 'SECOND',
            '3rd' => 'THIRD',

            // "smart quotes"
            '“' => '',
            '”' => '',
            '’' => '',

            // non-ascii characters
            'Å' => 'A',
            'ã' => 'a',
            'ç' => 'c',
            'é' => 'e',
            'í' => 'i',
            'ñ' => 'n',
            'ô' => 'o',
        ];

        $constant = str_replace(
            array_keys($replaceMap),
            array_values($replaceMap),
            $this->emoji->getCldrName()
        );

//        $constant = mb_convert_encoding($constant, 'ASCII');
        iconv('UTF-8', 'ASCII', $constant);

        return strtoupper($constant);
    }
}