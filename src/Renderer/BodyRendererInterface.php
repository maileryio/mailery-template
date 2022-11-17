<?php

namespace Mailery\Template\Renderer;

use Symfony\Component\Mime\Message;

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

}
