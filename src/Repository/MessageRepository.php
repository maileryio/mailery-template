<?php

declare(strict_types=1);

namespace Mailery\Template\Repository;

use Cycle\ORM\Select\QueryBuilder;
use Cycle\ORM\Select\Repository;
use Mailery\Brand\Entity\Brand;
use Mailery\Template\Entity\Template;
use Mailery\Widget\Search\Data\Reader\SelectDataReader;

class TemplateRepository extends Repository
{
    /**
     * @param array $scope
     * @param array $orderBy
     * @return SelectDataReader
     */
    public function getDataReader(array $scope = [], array $orderBy = []): SelectDataReader
    {
        return new SelectDataReader($this->select()->where($scope)->orderBy($orderBy));
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
     * @param string $subject
     * @param Template|null $exclude
     * @return Template|null
     */
    public function findBySubject(string $subject, ?Template $exclude = null): ?Template
    {
        return $this
            ->select()
            ->where(function (QueryBuilder $select) use ($subject, $exclude) {
                $select->where('subject', $subject);

                if ($exclude !== null) {
                    $select->where('id', '<>', $exclude->getId());
                }
            })
            ->fetchOne();
    }
}
