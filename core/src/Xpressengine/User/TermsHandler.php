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
use Xpressengine\User\Models\Term;
use Xpressengine\User\Repositories\TermsRepository;

/**
 * Class TermsHandler
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class TermsHandler
{
    /**
     * Repository instance
     *
     * @var TermsRepository
     */
    protected $repo;

    /**
     * TermsHandler constructor.
     *
     * @param TermsRepository $repo repository instance
     */
    public function __construct(TermsRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Set item to enable
     *
     * @param Term|Term[] $terms terms
     * @param int         $order order number
     * @return void
     */
    public function enable($terms, $order = 0)
    {
        if (is_array($terms) || $terms instanceof Collection) {
            foreach ($terms as $idx => $term) {
                $this->repo->update($term, ['is_enabled' => true, 'order' => $idx]);
            }
        } else {
            $this->repo->update($terms, ['is_enabled' => true, 'order' => $order]);
        }
    }

    /**
     * Set item to disable
     *
     * @param Term|Term[] $terms terms
     * @return void
     */
    public function disable($terms)
    {
        $terms = is_array($terms) || $terms instanceof Collection ? $terms : [$terms];

        foreach ($terms as $term) {
            $this->repo->update($term, ['is_enabled' => false, 'order' => 999]);
        }
    }

    /**
     * Dynamically call the repository instance
     *
     * @param string $name      method name
     * @param array  $arguments arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->repo, $name], $arguments);
    }
}
