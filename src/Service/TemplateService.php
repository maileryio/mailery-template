<?php

namespace Mailery\Template\Service;

use Mailery\Template\Repository\TemplateRepository;
use Mailery\Brand\Service\BrandLocator;
use Mailery\Widget\Search\Form\SearchForm;
use Mailery\Widget\Search\Model\SearchByList;
use Mailery\Template\Search\TemplateSearchBy;
use Yiisoft\Data\Paginator\PaginatorInterface;
use Yiisoft\Data\Reader\Sort;
use Mailery\Widget\Search\Data\Reader\Search;
use Mailery\Widget\Dataview\Paginator\OffsetPaginator;
use Mailery\Template\Provider\TemplateTypeProvider;
use Mailery\Template\Model\TemplateTypeList;

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
     * @param SearchForm $searchForm
     * @return PaginatorInterface
     */
    public function getFullPaginator(SearchForm $searchForm): PaginatorInterface
    {
        $dataReader = $this->templateRepo
            ->withBrand($this->brandLocator->getBrand())
            ->getDataReader();

        $search = (new Search())->withSearchPhrase($searchForm->getSearchPhrase())->withSearchBy($searchForm->getSearchBy());
        $sort = (new Sort([]))->withOrder(['created_at' => 'desc']);

        return new OffsetPaginator(
            $dataReader
                ->withSearch($search)
                ->withSort($sort)
        );
    }
}
