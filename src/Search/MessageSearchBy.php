<?php

declare(strict_types=1);

namespace Mailery\Template\Search;

use Cycle\ORM\Select;
use Cycle\ORM\Select\QueryBuilder;
use Mailery\Widget\Search\Model\SearchBy;

class TemplateSearchBy extends SearchBy
{
    /**
     * {@inheritdoc}
     */
    protected function buildQueryInternal(Select $query, string $searchPhrase): Select
    {
        $newQuery = clone $query;

        $newQuery->andWhere(function (QueryBuilder $select) use ($searchPhrase) {
            return $select
                ->andWhere(['name' => ['like' => '%' . $searchPhrase . '%']]);
        });

        return $newQuery;
    }
}
