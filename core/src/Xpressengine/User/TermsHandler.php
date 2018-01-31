<?php
/**
 * TermsHandler.php
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

namespace Xpressengine\User;

use Illuminate\Support\Collection;
use Xpressengine\User\Repositories\TermsRepository;

class TermsHandler
{
    protected $repo;

    public function __construct(TermsRepository $repo)
    {
        $this->repo = $repo;
    }

    public function enable($terms, $order = 0)
    {
        if (is_array($terms) || $terms instanceof Collection) {
            foreach ($terms as $idx => $term) {
                $this->repo->update($term, ['is_activate' => true, 'order' => $idx]);
            }
        } else {
            $this->repo->update($terms, ['is_activate' => true, 'order' => $order]);
        }
    }

    public function disable($terms)
    {
        $terms = is_array($terms) || $terms instanceof Collection ? $terms : [$terms];

        foreach ($terms as $term) {
            $this->repo->update($term, ['is_activate' => false, 'order' => 999]);
        }
    }

    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->repo, $name], $arguments);
    }
}
