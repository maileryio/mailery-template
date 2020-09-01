<?php

namespace Mailery\Template\Provider;

use Psr\Container\ContainerInterface;
use Mailery\Template\Provider\TemplateTypeConfigs;
use Mailery\Template\Model\TemplateTypeList;
use Mailery\Template\TemplateTypeInterface;
use Mailery\Brand\Entity\Brand;

final class TemplateTypeProvider
{
    /**
     * @var Brand
     */
    private Brand $brand;

    /**
     * @var ContainerInterface
     */
    private ContainerInterface $container;

    /**
     * @var TemplateTypeConfigs
     */
    private TemplateTypeConfigs $typeConfigs;

    /**
     * @param ContainerInterface $container
     * @param TemplateTypeConfigs $typeConfigs
     */
    public function __construct(ContainerInterface $container, TemplateTypeConfigs $typeConfigs)
    {
        $this->container = $container;
        $this->typeConfigs = $typeConfigs;
    }

    /**
     * @param Brand $brand
     * @return self
     */
    public function withBrand(Brand $brand): self
    {
        $new = clone $this;
        $new->brand = $brand;

        return $new;
    }

    /**
     * @return TemplateTypeList
     */
    public function getTypes(): TemplateTypeList
    {
        $types = array_map(
            function (string $type): TemplateTypeInterface {
                return $this->container->get($type);
            },
            array_keys($this->typeConfigs->getConfigs())
        );

        return new TemplateTypeList($types);
    }
}
