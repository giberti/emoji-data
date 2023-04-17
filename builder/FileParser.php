<?php
declare(strict_types=1);

namespace Giberti\EmojiDataBuilder;

use Giberti\EmojiDataBuilder\Visitors\EmojiVisitor;
use Tree\Node\Node;
use Tree\Node\NodeInterface;

class FileParser
{
    /**
     * @var Node $tree
     */
    private $tree;

    public function __construct(string $content)
    {
        $this->tree = new Node();

        $lines = explode("\n", $content);
        $currentGroup = null;
        $currentSubgroup = null;
        foreach ($lines as $line) {
            if ($this->isBlank($line)) {
                continue;
            }

            if ($this->isComment($line)) {

                if ($this->isGroupHeading($line)) {
                    $currentSubgroup = null;
                    $currentGroup = new Node($this->getGroupCldr($line));
                    $this->tree->addChild($currentGroup);
                }

                if ($this->isSubgroupHeading($line)) {
                    $currentSubgroup = new Node($this->getSubgroupCldr($line));
                    $currentGroup->addChild($currentSubgroup);
                }

                continue;
            }

            $emojiLine = new EmojiLineParser($line);
            $emoji = new Emoji(
                $emojiLine->getCodePoints(),
                $emojiLine->getCldrName(),
                $emojiLine->getVersion(),
                $emojiLine->getStatus(),
                $emojiLine->getEmoji(),
                $currentGroup->getValue(),
                $currentSubgroup->getValue()
            );

            $currentSubgroup->addChild(new Node($emoji));
        }
    }

    /**
     * Get the list of groups
     *
     * @return string[]
     */
    public function getGroups(): array
    {
        $groups = [];
        foreach ($this->tree->getChildren() as $group) {
            $groups[] = $group->getValue();
        }

        return $groups;
    }

    /**
     * Get the group Node for the provided name
     *
     * @param string $name The group name to find
     * @return NodeInterface|null
     */
    private function getGroup(string $name): ?NodeInterface
    {
        foreach ($this->tree->getChildren() as $group) {
            if ($group->getValue() === $name) {
                return $group;
            }
        }

        return null;
    }

    /**
     * Get a list of subgroups for this group
     *
     * @param string $group
     * @return string[]|null
     */
    public function getSubgroups(string $group): ?array
    {
        $group = $this->getGroup($group);
        if (!$group) {
            return null;
        }

        $subgroups = [];
        foreach ($group->getChildren() as $subgroup) {
            $subgroups[] = $subgroup->getValue();
        }

        return $subgroups;
    }

    /**
     * Get all the emoji
     *
     * @return Emoji[]
     */
    public function getAllEmoji(): array
    {
        $visitor = new EmojiVisitor();

        return $this->tree->accept($visitor);
    }

    private function isGroupHeading(string $line): bool
    {
        return strpos($line, '# group: ') === 0;
    }

    private function getGroupCldr(string $line): string
    {
        return trim(str_replace('# group: ', '', $line));
    }

    private function isSubgroupHeading(string $line): bool
    {
        return strpos($line, '# subgroup: ') === 0;
    }

    private function getSubgroupCldr(string $line): string
    {
        return trim(str_replace('# subgroup: ', '', $line));
    }

    private function isComment(string $line): bool
    {
        return substr($line, 0, 1) === '#';
    }

    private function isBlank(string $line): bool
    {
        return trim($line) === '';
    }
}