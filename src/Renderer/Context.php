<?php

namespace Mailery\Template\Renderer;

use Mailery\Campaign\Entity\Campaign;
use Mailery\Campaign\Entity\Recipient;

class Context implements ContextInterface
{

    public function __construct(
        private Campaign $campaign,
        private Recipient $recipient
    ) {}

}
