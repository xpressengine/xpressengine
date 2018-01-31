<?php
/**
 * TermsRepository.php
 *
 * PHP version 5
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\User\Repositories;

use Xpressengine\Support\EloquentRepositoryTrait;

/**
 * Class TermsRepository
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class TermsRepository
{
    use EloquentRepositoryTrait;

    /**
     * Return all terms
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return $this->query()->orderBy('order')->get();
    }

    /**
     * Return number of last order
     *
     * @return mixed
     */
    public function lastOrder()
    {
        return $this->query()->where('is_enabled', true)->max('order');
    }

    /**
     * Return enabled terms item
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function fetchEnabled()
    {
        return $this->query()->where('is_enabled', true)->orderBy('order')->get();
    }

    /**
     * Create new item
     *
     * @param array $attributes attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create($attributes)
    {
        return $this->query()->create($attributes);
    }
}
