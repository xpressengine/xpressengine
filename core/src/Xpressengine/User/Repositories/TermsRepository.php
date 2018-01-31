<?php
/**
 * TermsRepository.php
 *
 * PHP version 5
 *
 * @category
 * @package
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\User\Repositories;

use Xpressengine\Support\EloquentRepositoryTrait;

class TermsRepository
{
    use EloquentRepositoryTrait;

    public function all()
    {
        return $this->query()->orderBy('order')->get();
    }

    public function lastOrder()
    {
        return $this->query()->where('is_enabled', true)->max('order');
    }

    public function fetchEnabled()
    {
        return $this->query()->where('is_enabled', true)->orderBy('order')->get();
    }

    public function create($attributes)
    {
        return $this->query()->create($attributes);
    }
}
