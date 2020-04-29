<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 7
 *
 * @category    Support
 * @package     Xpressengine\Support
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Support;

/**
 * Interface Migration
 *
 * @category    Support
 * @package     Xpressengine\Support
 * @property string id
 * @property string title
 * @property string parentId
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
abstract class Migration
{
    /**
     * 서비스에 필요한 자체 환경(타 서비스와 연관이 없는 환경)을 구축한다.
     * 서비스의 db table 생성과 같은 migration 코드를 작성한다.
     *
     * @return mixed
     */
    public function install()
    {
    }

    /**
     * 서비스에 필요한 환경(타 서비스와 연관된 환경)을 구축한다.
     * db seeding과 같은 코드를 작성한다.
     * @return void
     */
    public function installed()
    {
    }

    /**
     * 서비스가 구동된 이후에 실행되므로 다양한 서비스를 사용하여 코드를 작성할 수 있다.
     *
     * @return void
     */
    public function init()
    {
    }

    /**
     * 서비스가 구동되는데에 직접적인 연관은 없으나, XE 설치후 기본적인 메뉴구성이나 컨텐츠를 구성하는 코드를 작성한다.
     *
     * @return void
     */
    public function initialized()
    {
    }

    /**
     * 서비스가 업데이트되었을 경우, update()메소드를 실행해야 하는지의 여부를 체크한다.
     * update()메소드를 실행해야 한다면 false를 반환한다.
     *
     * @param string $installedVersion current version
     *
     * @return bool
     */
    public function checkUpdated($installedVersion = null)
    {
        return true;
    }

    /**
     * update 코드를 실행한다.
     *
     * @param string $installedVersion current version
     *
     * @return mixed
     */
    public function update($installedVersion = null)
    {
    }
}
