<?php
/**
 * TermsRepository.php
 *
 * PHP version 7
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
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
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
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
        return $this->query()->where('site_key',\XeSite::getCurrentSiteKey())->orderByDesc('is_enabled')->orderBy('order')->get();
    }

    /**
     * Return number of last order
     *
     * @return mixed
     */
    public function lastOrder()
    {
        return $this->query()->where('site_key',\XeSite::getCurrentSiteKey())->where('is_enabled', true)->max('order');
    }

    /**
     * Return number of last disabled order
     *
     * @return mixed
     */
    public function lastDisabledOrder()
    {
        return $this->query()->where('site_key',\XeSite::getCurrentSiteKey())->where('is_enabled', false)->max('order');
    }

    /**
     * Return enabled terms item
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function fetchEnabled()
    {
        return $this->query()->where('site_key',\XeSite::getCurrentSiteKey())->where('is_enabled', true)->orderBy('order')->get();
    }

    /**
     * Return enabled and requrie terms item
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function fetchRequireEnabled()
    {
        return $this->query()->where('site_key',\XeSite::getCurrentSiteKey())->where([['is_enabled', true], ['is_require', true]])->orderBy('order')->get();
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
