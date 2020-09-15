<?php

namespace Mailery\Template\Service;

use Mailery\Template\Repository\TemplateRepository;
use Mailery\Brand\Service\BrandLocator;
use Mailery\Widget\Search\Form\SearchForm;
use Mailery\Widget\Search\Model\SearchByList;
use Mailery\Template\Search\TemplateSearchBy;
use Yiisoft\Data\Paginator\PaginatorInterface;
use Yiisoft\Data\Reader\Sort;
use Yiisoft\Data\Paginator\OffsetPaginator;
use Mailery\Template\Provider\TemplateTypeProvider;
use Mailery\Template\Model\TemplateTypeList;
use Yiisoft\Data\Reader\Filter\FilterInterface;

final class TemplateService
{
    /**
     * @var BrandLocator
     */
    private BrandLocator $brandLocator;

    /**
     * @var TemplateRepository
     */
    private TemplateRepository $templateRepo;

    /**
     * @var TemplateTypeProvider
     */
    private TemplateTypeProvider $templateTypeProvider;

    /**
     * @param BrandLocator $brandLocator
     * @param TemplateRepository $templateRepo
     * @param TemplateTypeProvider $templateTypeProvider
     */
    public function __construct(BrandLocator $brandLocator, TemplateRepository $templateRepo, TemplateTypeProvider $templateTypeProvider)
    {
        $this->brandLocator = $brandLocator;
        $this->templateRepo = $templateRepo;
        $this->templateTypeProvider = $templateTypeProvider;
    }

    /**
     * @return TemplateTypeList
     */
    public function getTemplateTypes(): TemplateTypeList
    {
        return $this->templateTypeProvider
            ->withBrand($this->brandLocator->getBrand())
            ->getTypes();
    }

    /**
     * @return SearchForm
     */
    public function getSearchForm(): SearchForm
    {
        return (new SearchForm())
            ->withSearchByList(new SearchByList([
                new TemplateSearchBy(),
            ]));
    }

    /**
     * @param FilterInterface|null $filter
     * @return PaginatorInterface
     */
    public function getFullPaginator(?FilterInterface $filter = null): PaginatorInterface
    {
        $dataReader = $this->templateRepo
            ->withBrand($this->brandLocator->getBrand())
            ->getDataReader();

        if ($filter !== null) {
            $dataReader = $dataReader->withFilter($filter);
        }

        return new OffsetPaginator(
            $dataReader->withSort(
                (new Sort([]))->withOrder(['id' => 'DESC'])
            )
        );
    }
}
