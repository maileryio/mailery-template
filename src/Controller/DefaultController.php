<?php

declare(strict_types=1);

namespace Mailery\Template\Controller;

use Mailery\Template\Service\TemplateService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Mailery\Web\ViewRenderer;
use Mailery\Template\Service\TemplateTypeService;

final class DefaultController
{
    private const PAGINATION_INDEX = 10;

    /**
     * @var ViewRenderer
     */
    private ViewRenderer $viewRenderer;

    /**
     * @param ViewRenderer $viewRenderer
     */
    public function __construct(ViewRenderer $viewRenderer)
    {
        $this->viewRenderer = $viewRenderer->withController($this);
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
}
