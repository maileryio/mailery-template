<?php

declare(strict_types=1);

namespace Mailery\Template\Search;

use Mailery\Widget\Search\Model\SearchBy;

final class TemplateSearchBy extends SearchBy
{
    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        return [self::getOperator(), 'name', $this->getSearchPhrase()];
    }

    /**
     * @inheritdoc
     */
    public static function getOperator(): string
    {
        return 'like';
    }
}
