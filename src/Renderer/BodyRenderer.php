<?php

namespace Mailery\Template\Renderer;

use Symfony\Component\Mime\Message;

class BodyRenderer implements BodyRendererInterface
{

    /**
     * @var Context
     */
    private Context $context;

    /**
     * @inheritdoc
     */
    public function render(Message $message): void
    {
//        var_dump(1111);exit;
    }

    /**
     * @inheritdoc
     */
    public function withContext(ContextInterface $context): self
    {
        $new = clone $this;
        $new->context = $context;

        return $new;
    }

}