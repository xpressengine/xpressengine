<?php
/**
 * TermsHandler.php
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
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
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
        if (is_iterable($terms)) {
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
        $terms = is_iterable($terms) ? $terms : [$terms];
        foreach ($terms as $idx => $term) {
            $this->repo->update($term, ['is_enabled' => false, 'order' => $idx]);
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
