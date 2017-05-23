<?php
/**
 * MenuRepository.php
 *
 * PHP version 5
 *
 * @category    Menu
 * @package     Xpressengine\Menu
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Menu\Repositories;

use Illuminate\Database\QueryException;
use Xpressengine\Menu\Models\Menu;
use Xpressengine\Support\CacheableEloquentRepositoryTrait;

/**
 * Class MenuRepository
 *
 * @category    Menu
 * @package     Xpressengine\Menu
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class MenuRepository
{
    use CacheableEloquentRepositoryTrait;

    /**
     * Namespace for cache
     *
     * @var string
     */
    protected $namespace = 'xemenu';

    /**
     * IdentifierGenerator instance
     *
     * @var IdentifierGenerator
     */
    protected $generator;

    /**
     * Limit count of retry for ID duplicated
     *
     * @var int
     */
    const DUPLICATE_RETRY_CNT = 2;

    /**
     * MenuRepository constructor.
     *
     * @param IdentifierGenerator $generator IdentifierGenerator instance
     */
    public function __construct(IdentifierGenerator $generator)
    {
        $this->generator = $generator;
    }

    /**
     * Create menu
     *
     * @param array $attributes attributes
     * @return Menu
     */
    public function create(array $attributes = [])
    {
        $model = $this->createModel();
        $model->fill($attributes);

        $cnt = 0;
        while (true) {
            try {
                $model->{$model->getKeyName()} = $this->generator->generateId();
                $model->save();

                $this->clearCache();

                break;
            } catch (QueryException $e) {
                if (++$cnt >= static::DUPLICATE_RETRY_CNT || $e->getCode() != "23000") {
                    throw $e;
                }
            }
        }

        return $model;
    }

    /**
     * Find a menu by its primary key. and with relations
     *
     * @param string       $id   identifier
     * @param string|array $with relation name
     * @return mixed
     */
    public function findWith($id, $with = [])
    {
        return $this->cacheCall(__FUNCTION__, func_get_args(), function () use ($id, $with) {
            return $this->query()->with($with)->find($id);
        });
    }

    /**
     * Get menu list by site keyword. and with relations
     *
     * @param string       $siteKey site key
     * @param string|array $with    relation name
     * @return mixed
     */
    public function fetchBySiteKey($siteKey, $with = [])
    {
        return $this->cacheCall(__FUNCTION__, func_get_args(), function () use ($siteKey, $with) {
            return $this->query()->with($with)->where('siteKey', $siteKey)->get();
        });
    }
}
