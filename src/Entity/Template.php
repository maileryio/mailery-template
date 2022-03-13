<?php

declare(strict_types=1);

/**
 * Template module for Mailery Platform
 * @link      https://github.com/maileryio/mailery-template
 * @package   Mailery\Template
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2020, Mailery (https://mailery.io/)
 */

namespace Mailery\Template\Entity;

use Mailery\Brand\Entity\Brand;
use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Relation\BelongsTo;
use Mailery\Template\Repository\TemplateRepository;
use Mailery\Template\Mapper\DefaultMapper;
use Cycle\Annotated\Annotation\Inheritance\DiscriminatorColumn;

#[Entity(
    table: 'templates',
    repository: TemplateRepository::class,
    mapper: DefaultMapper::class
)]
#[DiscriminatorColumn(name: 'type')]
abstract class Template
{
    #[Column(type: 'primary')]
    protected int $id;

    #[BelongsTo(target: Brand::class)]
    protected Brand $brand;

    #[Column(type: 'string(255)')]
    protected string $name;

    #[Column(type: 'string(255)')]
    protected string $type;

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getName();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return self
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return Brand
     */
    public function getBrand(): Brand
    {
        return $this->brand;
    }

    /**
     * @param Brand $brand
     * @return self
     */
    public function setBrand(Brand $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
