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
use Mailery\Activity\Log\Mapper\LoggableMapper;
use Cycle\Annotated\Annotation\Inheritance\DiscriminatorColumn;
use Cycle\ORM\Entity\Behavior;

/**
* This doc block required for STI/JTI
*/
#[Entity(
    table: 'templates',
    repository: TemplateRepository::class,
    mapper: LoggableMapper::class,
)]
#[Behavior\CreatedAt(
    field: 'createdAt',
    column: 'created_at',
)]
#[Behavior\UpdatedAt(
    field: 'updatedAt',
    column: 'updated_at',
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

    #[Column(type: 'text', nullable: true)]
    protected ?string $description = null;

    #[Column(type: 'string(255)')]
    protected string $type;

    #[Column(type: 'datetime')]
    protected \DateTimeImmutable $createdAt;

    #[Column(type: 'datetime', nullable: true)]
    protected ?\DateTimeImmutable $updatedAt = null;

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
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
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

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return self
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
