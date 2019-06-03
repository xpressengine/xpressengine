<?php
/**
 * CoreOperation.php
 *
 * PHP version 7
 *
 * @category    Foundation
 * @package     Xpressengine\Foundation
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Foundation\Operations;

/**
 * Class CoreOperation
 *
 * @category    Foundation
 * @package     Xpressengine\Foundation
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

class CoreOperation extends Operation
{
    /**
     * Set the core version.
     *
     * @param string $ver version
     * @return $this
     */
    public function version($ver)
    {
        $this->data['version'] = $ver;

        return $this;
    }

    /**
     * Get the core version.
     *
     * @return string|null
     */
    public function getVersion()
    {
        return $this->data['version'] ?? null;
    }
}
