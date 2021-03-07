<?php

declare(strict_types=1);

namespace Mailery\Template\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Yiisoft\Yii\View\ViewRenderer;
use Psr\Http\Message\ResponseFactoryInterface as ResponseFactory;
use Mailery\Template\Service\TemplateCrudService;
use Mailery\Brand\BrandLocatorInterface;
use Mailery\Template\Repository\TemplateRepository;
use Mailery\Widget\Search\Form\SearchForm;
use Mailery\Widget\Search\Model\SearchByList;
use Mailery\Template\Search\TemplateSearchBy;
use Mailery\Template\Filter\TemplateFilter;
use Mailery\Template\Model\TemplateTypeList;
use Yiisoft\Router\UrlGeneratorInterface as UrlGenerator;

final class DefaultController
{
    private const PAGINATION_INDEX = 10;

    /**
     * @var ViewRenderer
     */
    private ViewRenderer $viewRenderer;

    /**
     * @var ResponseFactory
     */
    private ResponseFactory $responseFactory;

    /**
     * @var TemplateRepository
     */
    private TemplateRepository $templateRepo;

    /**
     * @param ViewRenderer $viewRenderer
     * @param ResponseFactory $responseFactory
     * @param BrandLocatorInterface $brandLocator
     * @param TemplateRepository $templateRepo
     */
    public function __construct(
        ViewRenderer $viewRenderer,
        ResponseFactory $responseFactory,
        BrandLocatorInterface $brandLocator,
        TemplateRepository $templateRepo
    ) {
        $this->viewRenderer = $viewRenderer
            ->withController($this)
            ->withViewBasePath(dirname(dirname(__DIR__)) . '/views');

        $this->responseFactory = $responseFactory;
        $this->templateRepo = $templateRepo->withBrand($brandLocator->getBrand());
    }

    /**
     * @param Request $request
     * @param TemplateTypeList $templateTypeList
     * @return Response
     */
    public function index(Request $request, TemplateTypeList $templateTypeList): Response
    {
        $queryParams = $request->getQueryParams();
        $pageNum = (int) ($queryParams['page'] ?? 1);
        $searchBy = $queryParams['searchBy'] ?? null;
        $searchPhrase = $queryParams['search'] ?? null;

        $searchForm = (new SearchForm())
            ->withSearchByList(new SearchByList([
                new TemplateSearchBy(),
            ]))
            ->withSearchBy($searchBy)
            ->withSearchPhrase($searchPhrase);

        $filter = (new TemplateFilter())
            ->withSearchForm($searchForm);

        $paginator = $this->templateRepo->getFullPaginator($filter)
            ->withPageSize(self::PAGINATION_INDEX)
            ->withCurrentPage($pageNum);

        return $this->viewRenderer->render('index', compact('searchForm', 'paginator', 'templateTypeList'));
    }

    /**
     * @param Request $request
     * @param TemplateCrudService $templateCrudService
     * @param UrlGenerator $urlGenerator
     * @return Response
     */
    public function delete(Request $request, TemplateCrudService $templateCrudService, UrlGenerator $urlGenerator): Response
    {
        $templateId = $request->getAttribute('id');
        if (empty($templateId) || ($template = $this->templateRepo->findByPK($templateId)) === null) {
            return $this->responseFactory->createResponse(404);
        }

        $templateCrudService->delete($template);

        return $this->responseFactory
            ->createResponse(302)
            ->withHeader('Location', $urlGenerator->generate('/template/default/index'));
    }
}
