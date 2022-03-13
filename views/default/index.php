<?php declare(strict_types=1);

use Mailery\Activity\Log\Widget\ActivityLogLink;
use Mailery\Icon\Icon;
use Mailery\Template\Entity\Template;
use Mailery\Widget\Dataview\Columns\ActionColumn;
use Mailery\Widget\Dataview\Columns\DataColumn;
use Mailery\Widget\Dataview\GridView;
use Mailery\Widget\Dataview\GridView\LinkPager;
use Mailery\Widget\Link\Link;
use Mailery\Widget\Search\Widget\SearchWidget;
use Yiisoft\Html\Html;

/** @var Yiisoft\Yii\WebView $this */
/** @var Mailery\Widget\Search\Form\SearchForm $searchForm */
/** @var Mailery\Template\Model\TemplateTypeList $templateTypeList */
/** @var Yiisoft\Aliases\Aliases $aliases */
/** @var Yiisoft\Router\UrlGeneratorInterface $urlGenerator */
/** @var Yiisoft\Data\Reader\DataReaderInterface $dataReader*/
/** @var Yiisoft\Data\Paginator\PaginatorInterface $paginator */
$this->setTitle('All templates');

?><div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
            <h1 class="h3">All templates</h1>
            <div class="btn-toolbar float-right">
                <?= SearchWidget::widget()->form($searchForm); ?>
                <b-dropdown right size="sm" variant="secondary" class="mb-2">
                    <template v-slot:button-content>
                        <?= Icon::widget()->name('settings'); ?>
                    </template>
                    <?= ActivityLogLink::widget()
                        ->tag('b-dropdown-item')
                        ->label('Activity log')
                        ->group('template'); ?>
                </b-dropdown>
                <b-dropdown right size="sm" variant="primary" class="mx-sm-1 mb-2">
                    <template v-slot:button-content>
                        <?= Icon::widget()->name('plus')->options(['class' => 'mr-1']); ?>
                        Add new template
                    </template>
                    <?php foreach ($templateTypeList as $templateType) {
                        echo Html::tag(
                            'b-dropdown-item',
                            $templateType->getCreateLabel(),
                            [
                                'href' => $urlGenerator->generate($templateType->getCreateRouteName(), $templateType->getCreateRouteParams()),
                            ]
                        );
                    } ?>
                </b-dropdown>
            </div>
        </div>
    </div>
</div>
<div class="mb-2"></div>
<div class="row">
    <div class="col-12">
        <?= GridView::widget()
            ->paginator($paginator)
            ->options([
                'class' => 'table-responsive',
            ])
            ->tableOptions([
                'class' => 'table table-hover',
            ])
            ->emptyText('No data')
            ->emptyTextOptions([
                'class' => 'text-center text-muted mt-4 mb-4',
            ])
            ->columns([
                (new DataColumn())
                    ->header('Name')
                    ->content(function (Template $data, int $index) use ($urlGenerator) {
                        return Html::a(
                            $data->getName(),
                            $urlGenerator->generate($data->getViewRouteName(), $data->getViewRouteParams())
                        );
                    }),
                (new DataColumn())
                    ->header('Type')
                    ->content(function (Template $data, int $index) use ($templateTypeList) {
                        $templateType = $templateTypeList->findByEntity($data);
                        return $templateType ? $templateType->getLabel() : null;
                    }),
                (new ActionColumn())
                    ->contentOptions([
                        'style' => 'width: 80px;',
                    ])
                    ->header('Preview')
                    ->view('')
                    ->update(function (Template $data, int $index) use ($urlGenerator) {
                        return Html::a(
                            Icon::widget()->name('eye')->render(),
                            $urlGenerator->generate($data->getPreviewRouteName(), $data->getPreviewRouteParams()),
                            [
                                'class' => 'text-decoration-none mr-3',
                            ]
                        )
                        ->encode(false);
                    })
                    ->delete(''),
                (new ActionColumn())
                    ->contentOptions([
                        'style' => 'width: 80px;',
                    ])
                    ->header('Edit')
                    ->view('')
                    ->update(function (Template $data, int $index) use ($urlGenerator) {
                        return Html::a(
                            Icon::widget()->name('pencil')->render(),
                            $urlGenerator->generate($data->getEditRouteName(), $data->getEditRouteParams()),
                            [
                                'class' => 'text-decoration-none mr-3',
                            ]
                        )
                        ->encode(false);
                    })
                    ->delete(''),
                (new ActionColumn())
                    ->contentOptions([
                        'style' => 'width: 80px;',
                    ])
                    ->header('Delete')
                    ->view('')
                    ->update('')
                    ->delete(function (Template $data, int $index) use ($urlGenerator) {
                        return Link::widget()
                            ->label(Icon::widget()->name('delete')->options(['class' => 'mr-1'])->render())
                            ->method('delete')
                            ->href($urlGenerator->generate($data->getDeleteRouteName(), $data->getDeleteRouteParams()))
                            ->confirm('Are you sure?')
                            ->options([
                                'class' => 'text-decoration-none text-danger',
                            ])
                            ->encode(false);
                    }),
            ]);
        ?>
    </div>
</div><?php
if ($paginator->getTotalItems() > 0) {
            ?><div class="mb-4"></div>
    <div class="row">
        <div class="col-6">
            <?= GridView\OffsetSummary::widget()
                ->paginator($paginator); ?>
        </div>
        <div class="col-6">
            <?= LinkPager::widget()
                ->paginator($paginator)
                ->options([
                    'class' => 'float-right',
                ])
                ->prevPageLabel('Previous')
                ->nextPageLabel('Next')
                ->urlGenerator(function (int $page) use ($urlGenerator) {
                    $url = $urlGenerator->generate('/template/template/index');
                    if ($page > 1) {
                        $url = $url . '?page=' . $page;
                    }

                    return $url;
                }); ?>
        </div>
    </div><?php
        }
?>
