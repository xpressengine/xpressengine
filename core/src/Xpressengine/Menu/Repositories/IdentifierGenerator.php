<?php
/**
 * IdentifierGenerator.php
 *
 * PHP version 7
 *
 * @category    Menu
 * @package     Xpressengine\Menu
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Menu\Repositories;

use Xpressengine\Keygen\Keygen;

/**
 * Class IdentifierGenerator
 *
 * @category    Menu
 * @package     Xpressengine\Menu
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class IdentifierGenerator
{
    /**
     * IdentifierGenerator constructor.
     *
     * @param Keygen $keygen Key generator instance
     */
    public function __construct(Keygen $keygen)
    {
        $this->keygen = $keygen;
    }

    /**
     * Generate new key
     *
     * @return string
     */
    public function generateId()
    {
        $newId = substr($this->keygen->generate(), 0, 8);

        if (!preg_match('/[^0-9]/', $newId)) {
            $newId = $this->generateId();
        }

        return $newId;
    }
}
