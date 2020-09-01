<?php

namespace Mailery\Template\Service;

use Mailery\Brand\Service\BrandLocator;
use Mailery\Template\Provider\TemplateTypeProvider;
use Mailery\Template\Model\TemplateTypeList;

final class TemplateTypeService
{
    /**
     * @var BrandLocator
     */
    private BrandLocator $brandLocator;

    /**
     * @var TemplateTypeProvider
     */
    private TemplateTypeProvider $typeProvider;

    /**
     * @param BrandLocator $brandLocator
     * @param TemplateTypeProvider $typeProvider
     */
    public function __construct(BrandLocator $brandLocator, TemplateTypeProvider $typeProvider)
    {
        $this->brandLocator = $brandLocator;
        $this->typeProvider = $typeProvider;
    }

    /**
     * @return TemplateTypeList
     */
    public function getTypeList(): TemplateTypeList
    {
        return $this->typeProvider
            ->withBrand($this->brandLocator->getBrand())
            ->getTypes();
    }
}