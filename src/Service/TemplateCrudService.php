<?php

namespace Mailery\Template\Service;

use Cycle\ORM\ORMInterface;
use Cycle\ORM\Transaction;
use Mailery\Template\Entity\Template;

class TemplateCrudService
{
    /**
     * @var ORMInterface
     */
    private ORMInterface $orm;

    /**
     * @param ORMInterface $orm
     */
    public function __construct(ORMInterface $orm)
    {
        $this->orm = $orm;
    }

    /**
     * @param Template $template
     * @return bool
     */
    public function delete(Template $template): bool
    {
        $tr = new Transaction($this->orm);
        $tr->delete($template);
        $tr->run();

        return true;
    }
}
