<?php

namespace Mailery\Template\Model;

use Mailery\Template\Model\TemplateTypeInterface;
use Doctrine\Common\Collections\ArrayCollection;

final class TemplateTypeList extends ArrayCollection
{
    /**
     * @param object $sender
     * @return TemplateTypeInterface|null
     */
    public function findByEntity(object $sender): ?TemplateTypeInterface
    {
        return $this->filter(function (TemplateTypeInterface $senderType) use($sender) {
            return $senderType->isEntitySameType($sender);
        })->first() ?? null;
    }
}
