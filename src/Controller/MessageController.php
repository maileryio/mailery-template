<?php

declare(strict_types=1);

namespace Mailery\Template\Controller;

use Mailery\Template\Entity\Template;
use Mailery\Template\Form\TemplateForm;
use Mailery\Template\Repository\TemplateRepository;
use Mailery\Template\Search\TemplateSearchBy;
use Mailery\Template\Service\TemplateService;
use Mailery\Template\WebController;
use Mailery\Widget\Dataview\Paginator\OffsetPaginator;
use Mailery\Widget\Search\Data\Reader\Search;
use Mailery\Widget\Search\Form\SearchForm;
use Mailery\Widget\Search\Model\SearchByList;
use Psr\Http\Template\ResponseInterface as Response;
use Psr\Http\Template\ServerRequestInterface as Request;
use Yiisoft\Data\Reader\Sort;
use Yiisoft\Http\Method;
use Yiisoft\Router\UrlGeneratorInterface as UrlGenerator;
use Mailery\Template\Provider\TemplateTypeProvider;

class TemplateController extends WebController
{
    private const PAGINATION_INDEX = 10;

    /**
     * @param Request $request
     * @param SearchForm $searchForm
     * @param TemplateTypeProvider $typeProvider
     * @return Response
     */
    public function index(Request $request, SearchForm $searchForm, TemplateTypeProvider $typeProvider): Response
    {
        $searchForm = $searchForm->withSearchByList(new SearchByList([
            new TemplateSearchBy(),
        ]));

        $queryParams = $request->getQueryParams();
        $pageNum = (int) ($queryParams['page'] ?? 1);

        $dataReader = $this->getTemplateRepository()
            ->getDataReader()
            ->withSearch((new Search())->withSearchPhrase($searchForm->getSearchPhrase())->withSearchBy($searchForm->getSearchBy()))
            ->withSort((new Sort([]))->withOrderString('name'));

        $paginator = (new OffsetPaginator($dataReader))
            ->withPageSize(self::PAGINATION_INDEX)
            ->withCurrentPage($pageNum);

        $templateTypes = $typeProvider
            ->withBrand($this->getBrandLocator()->getBrand())
            ->getTypes();

        return $this->render('index', compact('searchForm', 'paginator', 'templateTypes'));
    }

    /**
     * @param Request $request
     * @param SearchForm $searchForm
     * @return Response
     */
    public function view(Request $request, SearchForm $searchForm): Response
    {
        ;
    }

    /**
     * @param Request $request
     * @param TemplateForm $campaignForm
     * @param UrlGenerator $urlGenerator
     * @return Response
     */
    public function create(Request $request, TemplateForm $campaignForm, UrlGenerator $urlGenerator): Response
    {
        ;
    }

    /**
     * @param Request $request
     * @param TemplateForm $campaignForm
     * @param UrlGenerator $urlGenerator
     * @return Response
     */
    public function edit(Request $request, TemplateForm $campaignForm, UrlGenerator $urlGenerator): Response
    {
        ;
    }

    /**
     * @param Request $request
     * @param TemplateService $campaignService
     * @param UrlGenerator $urlGenerator
     * @return Response
     */
    public function delete(Request $request, TemplateService $campaignService, UrlGenerator $urlGenerator): Response
    {
        ;
    }

    /**
     * @return TemplateRepository
     */
    private function getTemplateRepository(): TemplateRepository
    {
        return $this->getOrm()
            ->getRepository(Template::class)
            ->withBrand($this->getBrandLocator()->getBrand());
    }
}
