<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Xpressengine\Category\CategoryHandler;
use Xpressengine\Http\Request;
use Xpressengine\Translation\Translator;

/**
 * Class CategoryItemController
 *
 * @package App\Http\Controllers
 */
class CategoryItemController extends Controller
{
    /**
     * @var \Xpressengine\Category\CategoryHandler
     */
    private $categoryHandler;

    /**
     * CategoryItemController constructor.
     * @param  \Xpressengine\Category\CategoryHandler  $categoryHandler
     */
    public function __construct(CategoryHandler $categoryHandler)
    {
        $this->categoryHandler = $categoryHandler;
    }

    /**
     * Get children of an item.
     *
     * @param  Request  $request  request
     * @param  int  $id  identifier
     * @return \Xpressengine\Presenter\Presentable
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getChildren(Request $request, Translator $translator, int $id)
    {
        $lang = $request->get('lang');

        $item = $this->categoryHandler->items()->findOrFail($id);
        $children = $item->getChildren();

        if (in_array($lang, $translator->getLocales(), true) === true) {
            $translator->setLocale($lang);
        }

        foreach ($children as $child) {
            $child->readableWord = xe_trans($child->word);
            $child->readableDescription = xe_trans($child->description);
        }

        return \XePresenter::makeApi($children->toArray());
    }
}