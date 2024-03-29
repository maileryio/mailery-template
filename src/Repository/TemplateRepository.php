<?php

declare(strict_types=1);

namespace Mailery\Template\Repository;

use Cycle\ORM\Select\QueryBuilder;
use Cycle\ORM\Select\Repository;
use Mailery\Brand\Entity\Brand;
use Mailery\Template\Entity\Template;
use Mailery\Template\Filter\TemplateFilter;
use Yiisoft\Data\Paginator\OffsetPaginator;
use Yiisoft\Data\Paginator\PaginatorInterface;
use Yiisoft\Data\Reader\Sort;
use Yiisoft\Data\Reader\DataReaderInterface;
use Yiisoft\Yii\Cycle\Data\Reader\EntityReader;

final class TemplateRepository extends Repository
{
    /**
     * @param array $scope
     * @param array $orderBy
     * @return DataReaderInterface
     */
    public function getDataReader(array $scope = [], array $orderBy = []): DataReaderInterface
    {
        return new EntityReader($this->select()->where($scope)->orderBy($orderBy));
    }

    /**
     * @param TemplateFilter $filter
     * @return PaginatorInterface
     */
    public function getFullPaginator(TemplateFilter $filter): PaginatorInterface
    {
        $dataReader = $this->getDataReader();

        if (!$filter->isEmpty()) {
            $dataReader = $dataReader->withFilter($filter);
        }

        return new OffsetPaginator(
            $dataReader->withSort(
                Sort::only(['id'])->withOrder(['id' => 'desc'])
            )
        );
    }

    /**
     * @param Brand $brand
     * @return self
     */
    public function withBrand(Brand $brand): self
    {
        $repo = clone $this;
        $repo->select
            ->andWhere([
                'brand_id' => $brand->getId(),
            ]);

        return $repo;
    }

    /**
     * @param Template $template
     * @return self
     */
    public function withSameType(Template $template): self
    {
        $repo = clone $this;
        $repo->select
            ->andWhere([
                'type' => $template->getType(),
            ]);

        return $repo;
    }

    /**
     * @param string $name
     * @param Template|null $exclude
     * @return Template|null
     */
    public function findByName(string $name, ?Template $exclude = null): ?Template
    {
        return $this
            ->select()
            ->where(function (QueryBuilder $select) use ($name, $exclude) {
                $select->where('name', $name);

                if ($exclude !== null) {
                    $select->where('id', '<>', $exclude->getId());
                }
            })
            ->fetchOne();
    }
}
