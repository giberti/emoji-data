<?php
declare(strict_types=1);

namespace Giberti\EmojiDataBuilder;

class Emoji
{
    private $codePoints;
    private $cldrName;
    private $version;
    private $status;
    private $emoji;
    private $group;
    private $subgroup;

    public function __construct(
        array $codePoints,
        string $cldrName,
        string $version,
        string $status,
        string $emoji,
        ?string $group,
        ?string $subgroup
    ) {
        $this->codePoints = $codePoints;
        $this->cldrName = $cldrName;
        $this->version = $version;
        $this->status = $this->validateStatus($status);
        $this->emoji = $emoji;
        $this->group = $group;
        $this->subgroup = $subgroup;
    }

    public function getCodePoints(): array
    {
        return $this->codePoints;
    }

    public function getCldrName(): string
    {
        return $this->cldrName;
    }

    public function getEmoji(): string
    {
        return $this->emoji;
    }

    public function getGroup(): string
    {
        return $this->group;
    }

    public function getSubgroup(): string
    {
        return $this->subgroup;
    }

    public function getVersion(): float
    {
        return $this->version;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    private function validateStatus(string $status): string
    {
        $valid = [
            'component',
            'fully-qualified',
            'minimally-qualified',
            'unqualified',
        ];
        if (!in_array($status, $valid)) {
            throw new \InvalidArgumentException('Invalid status');
        }

        return $status;
    }
}