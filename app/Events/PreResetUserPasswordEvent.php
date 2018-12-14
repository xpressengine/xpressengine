<?php
/**
 * PreResetUserPasswordEvent.php
 *
 * PHP version 7
 *
 * @category    Events
 * @package     App\Events
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace App\Events;

/**
 * Class PreResetUserPasswordEvent
 *
 * @category    Events
 * @package     App\Events
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class PreResetUserPasswordEvent
{
    public $credentials;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($credentials)
    {
        $this->credentials = $credentials;
    }
}
