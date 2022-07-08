<?php

namespace Mailery\Template\Service;

use Cycle\ORM\EntityManagerInterface;
use Mailery\Template\Entity\Template;
use Yiisoft\Yii\Cycle\Data\Writer\EntityWriter;

class TemplateCrudService
{
    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    /**
     * @param Template $template
     * @return bool
     */
    public function delete(Template $template): bool
    {
        (new EntityWriter($this->entityManager))->delete($template);

        return true;
    }
}
