<?php

namespace Mailery\Template\Model;

use Mailery\Template\Entity\Template;

interface TemplateTypeInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getLabel(): string;

    /**
     * @return string
     */
    public function getCreateLabel(): string;

    /**
     * @return string|null
     */
    public function getCreateRouteName(): ?string;

    /**
     * @return array
     */
    public function getCreateRouteParams(): array;

    /**
     * @param Template $entity
     * @return bool
     */
    public function isEntitySameType(Template $entity): bool;
}
