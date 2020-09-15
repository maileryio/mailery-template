<?php

declare(strict_types=1);

namespace Mailery\Template\Controller;

use Mailery\Template\Service\TemplateService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Mailery\Web\ViewRenderer;
use Mailery\Template\Service\TemplateTypeService;
use Psr\Http\Message\ResponseFactoryInterface as ResponseFactory;
use Mailery\Template\Service\TemplateCrudService;

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
     * @param ViewRenderer $viewRenderer
     * @param ResponseFactory $responseFactory
     */
    public function __construct(
        ViewRenderer $viewRenderer,
        ResponseFactory $responseFactory
    ) {
        $this->viewRenderer = $viewRenderer
            ->withController($this)
            ->withCsrf();

        $this->responseFactory = $responseFactory;
    }

    /**
     * @param Request $request
     * @param TemplateService $templateService
     * @param TemplateTypeService $templateTypeService
     * @return Response
     */
    public function index(Request $request, TemplateService $templateService, TemplateTypeService $templateTypeService): Response
    {
        $queryParams = $request->getQueryParams();
        $pageNum = (int) ($queryParams['page'] ?? 1);
        $searchBy = $queryParams['searchBy'] ?? null;
        $searchPhrase = $queryParams['search'] ?? null;

        $searchForm = $templateService->getSearchForm()
            ->withSearchBy($searchBy)
            ->withSearchPhrase($searchPhrase);

        $paginator = $templateService->getFullPaginator($searchForm->getSearchBy())
            ->withPageSize(self::PAGINATION_INDEX)
            ->withCurrentPage($pageNum);

        $templateTypes = $templateTypeService->getTypeList();

        return $this->viewRenderer->render('index', compact('searchForm', 'paginator', 'templateTypes'));
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
            ->withHeader('Location', $urlGenerator->generate('/template/template/index'));
    }
}
