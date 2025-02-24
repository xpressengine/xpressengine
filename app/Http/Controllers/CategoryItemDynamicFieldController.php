<?php

namespace App\Http\Controllers;

use App\Http\Sections\DynamicFieldSection;
use Illuminate\Support\Collection;
use Xpressengine\Category\CategoryHandler;
use Xpressengine\Category\CategoryItemHandler;
use Xpressengine\Category\Values\DynamicGroupKey;
use Xpressengine\Http\Request;
use Xpressengine\Presenter\Presentable;

/**
 * Class CategoryItemDynamicFieldController
 *
 * @package App\Http\Controllers
 */
final class CategoryItemDynamicFieldController extends Controller
{
    /**
     * @var CategoryItemHandler
     */
    private $categoryHandler;

    /**
     * CategoryItemDynamicFieldController 생성자
     *
     * @param CategoryHandler $categoryHandler
     */
    public function __construct(CategoryHandler $categoryHandler)
    {
        $this->categoryHandler = $categoryHandler;
    }

    /**
     * @param string $id
     *
     * @return Presentable
     */
    public function settings(string $id): Presentable
    {
        // @phpstan-ignore-next-lin
        $category = $this->categoryHandler->cates()->findOrFail($id);

        $dynamicFieldSection = new DynamicFieldSection(
            (string)DynamicGroupKey::fromId($category->getKey()),
            \XeDB::connection(),
            false
        );

        return \XePresenter::make('category.dynamicField', [
            'dynamicFieldSection' => $dynamicFieldSection
        ]);
    }

    /**
     * @param int $categoryId
     * @param Request $request
     *
     * @return Presentable
     *
     * @throws \Throwable
     */
    public function form(int $categoryId, Request $request): Presentable
    {
        $this->validate($request, [
            'id' => 'sometimes|integer'
        ]);

        // @phpstan-ignore-next-line
        $categoryItem = $this->categoryHandler
            ->items()
            ->useDynamic(true)
            ->useProxy(true)
            ->setProxyOption(DynamicGroupKey::fromId($categoryId)->toProxyOption())
            ->find($request->get('id'));
        
        return api_render('category.dynamicForm', [
            'categoryItem' => $categoryItem,
            'types' => $this->resolveDynamicTypes($categoryId),
        ]);
    }

    /**
     * @param int $categoryId
     *
     * @return Collection
     */
    private function resolveDynamicTypes(int $categoryId): Collection
    {
        $dynamicGroupKey = DynamicGroupKey::fromId($categoryId);

        $dynamicField = app('xe.dynamicField');

        return collect($dynamicField->gets((string)$dynamicGroupKey))
            ->filter(function ($field) {
                return $field->isEnabled();
            });
    }
}
