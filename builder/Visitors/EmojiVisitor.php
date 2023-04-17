<?php
declare(strict_types=1);

namespace Giberti\EmojiDataBuilder\Visitors;

use Giberti\EmojiDataBuilder\Emoji;
use Giberti\EmojiDataBuilder\EmojiFormatter;
use Tree\Node\NodeInterface;
use Tree\Visitor\Visitor;

class EmojiVisitor implements Visitor
{
    public function visit(NodeInterface $node)
    {
        $nodes = [];

        foreach ($node->getChildren() as $child) {
            $value = $child->getValue();
            if (
                $value instanceof Emoji
                && $value->getStatus() === 'fully-qualified'
            ) {
                $nodes[] = new EmojiFormatter($value);

                continue;
            }

            $nodes = \array_merge($nodes, $child->accept($this));
        }

        return $nodes;
    }
}
