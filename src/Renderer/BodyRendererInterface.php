<?php

namespace Mailery\Template\Renderer;

use Symfony\Component\Mime\Message;
use Twig\NodeVisitor\NodeVisitorInterface;

interface BodyRendererInterface
{

    /**
     * @param Message $message
     * @return void
     */
    public function render(Message $message): void;

    /**
     * @param ContextInterface $context
     * @return self
     */
    public function withContext(ContextInterface $context): self;

    /**
     * @param NodeVisitorInterface $visitor
     * @return self
     */
    public function withNodeVisitor(NodeVisitorInterface $visitor): self;

}
