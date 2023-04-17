<?php
declare(strict_types=1);

namespace Giberti\EmojiDataBuilder;

class EmojiLineCommentParser
{
    private $version;
    private $cldrName;
    private $emoji;

    public function __construct(string $testComment)
    {
        $commentElements = explode(' ', trim($testComment));
        $this->emoji = array_shift($commentElements);
        $this->version = substr(
            array_shift($commentElements),
            1 // drop the leading `E` from the version number
        );
        $this->cldrName = trim(implode(' ', $commentElements));
    }

    public function getCldrName(): string
    {
        return $this->cldrName;
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function getEmoji(): string
    {
        return $this->emoji;
    }
}
