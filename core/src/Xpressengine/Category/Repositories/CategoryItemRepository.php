<?php
/**
 * CategoryItemRepository.php
 *
 * PHP version 5
 *
 * @category    Category
 * @package     Xpressengine\Category
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Category\Repositories;

use Xpressengine\Support\EloquentRepositoryTrait;

/**
 * Class CategoryItemRepository
 *
 * @category    Category
 * @package     Xpressengine\Category
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class CategoryItemRepository
{
    use EloquentRepositoryTrait;

    /**
     * Category model class provider
     *
     * @var callable
     */
    protected static $provider;

    /**
     * The name of Category model class
     *
     * @return string
     */
    public static function getModel()
    {
        $categoryModel = static::provideCategoryModel();

        return $categoryModel::getItemModel();
    }

    /**
     * Set the name of Category model
     *
     * @param string $model model class
     * @return void
     */
    public static function setModel($model)
    {
        $categoryModel = static::provideCategoryModel();
        $categoryModel::setItemModel($model);

        static::setAggregator($categoryModel);
    }

    /**
     * Set aggregator to model
     *
     * @param string $aggregator aggregator class
     * @return void
     */
    protected static function setAggregator($aggregator)
    {
        $model = static::getModel();
        $model::setAggregatorModel($aggregator);
    }

    /**
     * Set category model class provider
     *
     * @param callable $provider callable
     * @return void
     */
    public static function setCategoryModelProvider(callable $provider)
    {
        static::$provider = $provider;
    }

    /**
     * Provide category model class
     *
     * @return string
     */
    public static function provideCategoryModel()
    {
        return call_user_func(static::$provider);
    }
}
