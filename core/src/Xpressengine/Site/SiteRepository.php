<?php
/**
 * SiteRepository.php
 *
 * PHP version 5
 *
 * @category    Site
 * @package     Xpressengine\Site
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Site;

use Illuminate\Support\Arr;
use Xpressengine\Site\Exceptions\CanNotUseDomainException;
use Xpressengine\Support\EloquentRepositoryTrait;

/**
 * Class SiteRepository
 *
 * @category    Site
 * @package     Xpressengine\Site
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class SiteRepository
{
    use EloquentRepositoryTrait;

    /**
     * Create a new site model object
     *
     * @param array $attributes attributes
     * @return Site
     */
    public function create(array $attributes)
    {
        $host = Arr::get($attributes, 'host');
        if (!$host || $this->query()->where('host', $host)->exists()) {
            throw new CanNotUseDomainException(['host' => $host]);
        }

        return $this->createModel()->create($attributes);
    }

    /**
     * Delete object by host name
     *
     * @param string $host host
     * @return bool|int
     */
    public function deleteByHost($host)
    {
        if ($site = $this->query()->where('host', $host)->first()) {
            return $this->delete($site);
        }

        return false;
    }

    /**
     * Find a object by given column and value
     *
     * @param string $column column name
     * @param string $value  value
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function findBy($column, $value)
    {
        return $this->query()->where($column, $value)->first();
    }
}
