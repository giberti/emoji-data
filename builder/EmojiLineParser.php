<?php
declare(strict_types=1);

namespace Giberti\EmojiDataBuilder;

/**
 * Class EmojiLineParser
 * @package Giberti\Builder
 *
 * Format: code points; status # emoji name
 *     Code points — list of one or more hex code points, separated by spaces
 *     Status
 *       component           — an Emoji_Component,
 *                             excluding Regional_Indicators, ASCII, and non-Emoji.
 *       fully-qualified     — a fully-qualified emoji (see ED-18 in UTS #51),
 *                             excluding Emoji_Component
 *       minimally-qualified — a minimally-qualified emoji (see ED-18a in UTS #51)
 *       unqualified         — a unqualified emoji (See ED-19 in UTS #51)
 */
class EmojiLineParser
{
    /**
     * @var array|string[] $codePoints
     */
    private $codePoints;

    /**
     * @var string $status
     */
    private $status;

    /**
     * @var EmojiLineCommentParser $comment
     */
    private $comment;

    public function __construct(string $line)
    {
        [$codePoints, $statusAndComment] = explode(';', $line);
        $components = explode('#', $statusAndComment);
        $status = array_shift($components);
        $comment = implode('#', $components);
        $this->codePoints = explode(' ', trim($codePoints));
        $this->status = trim($status);
        $this->comment = new EmojiLineCommentParser($comment);
    }

    public function getCodePoints(): array
    {
        return $this->codePoints;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getCldrName(): string
    {
        return $this->comment->getCldrName();
    }

    public function getVersion(): string
    {
        return $this->comment->getVersion();
    }

    public function getEmoji(): string
    {
        return $this->comment->getEmoji();
    }
}