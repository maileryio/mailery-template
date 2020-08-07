<?php

declare(strict_types=1);

namespace Mailery\Message\Controller;

use Mailery\Message\Entity\Message;
use Mailery\Message\Form\MessageForm;
use Mailery\Message\Repository\MessageRepository;
use Mailery\Message\Search\MessageSearchBy;
use Mailery\Message\Service\MessageService;
use Mailery\Message\WebController;
use Mailery\Widget\Dataview\Paginator\OffsetPaginator;
use Mailery\Widget\Search\Data\Reader\Search;
use Mailery\Widget\Search\Form\SearchForm;
use Mailery\Widget\Search\Model\SearchByList;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Yiisoft\Data\Reader\Sort;
use Yiisoft\Http\Method;
use Yiisoft\Router\UrlGeneratorInterface as UrlGenerator;

class MessageController extends WebController
{
    private const PAGINATION_INDEX = 10;

    /**
     * @param Request $request
     * @param SearchForm $searchForm
     * @return Response
     */
    public function index(Request $request, SearchForm $searchForm): Response
    {
        $searchForm = $searchForm->withSearchByList(new SearchByList([
            new MessageSearchBy(),
        ]));

        $queryParams = $request->getQueryParams();
        $pageNum = (int) ($queryParams['page'] ?? 1);

        $dataReader = $this->getMessageRepository()
            ->getDataReader()
            ->withSearch((new Search())->withSearchPhrase($searchForm->getSearchPhrase())->withSearchBy($searchForm->getSearchBy()))
            ->withSort((new Sort([]))->withOrderString('name'));

        $paginator = (new OffsetPaginator($dataReader))
            ->withPageSize(self::PAGINATION_INDEX)
            ->withCurrentPage($pageNum);

        return $this->render('index', compact('searchForm', 'paginator'));
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
     * @param MessageForm $campaignForm
     * @param UrlGenerator $urlGenerator
     * @return Response
     */
    public function create(Request $request, MessageForm $campaignForm, UrlGenerator $urlGenerator): Response
    {
        ;
    }

    /**
     * @param Request $request
     * @param MessageForm $campaignForm
     * @param UrlGenerator $urlGenerator
     * @return Response
     */
    public function edit(Request $request, MessageForm $campaignForm, UrlGenerator $urlGenerator): Response
    {
        ;
    }

    /**
     * @param Request $request
     * @param MessageService $campaignService
     * @param UrlGenerator $urlGenerator
     * @return Response
     */
    public function delete(Request $request, MessageService $campaignService, UrlGenerator $urlGenerator): Response
    {
        ;
    }

    /**
     * @return MessageRepository
     */
    private function getMessageRepository(): MessageRepository
    {
        return $this->getOrm()
            ->getRepository(Message::class)
            ->withBrand($this->getBrandLocator()->getBrand());
    }
}
