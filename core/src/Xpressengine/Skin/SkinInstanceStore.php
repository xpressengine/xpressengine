<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 7
 *
 * @category    Skin
 * @package     Xpressengine\Skin
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Skin;

use Xpressengine\Config\ConfigManager as ConfigStore;

/**
 * 특정 타겟에 지정된 스킨과 그 스킨의 설정 정보(config data)를 저장하는 저장소이다.
 *
 * @category    Skin
 * @package     Xpressengine\Skin
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class SkinInstanceStore
{
    /**
     * 지정된 스킨정보를 조회할 때 사용하는 key
     */
    const PREFIX_KEY_SELECTED = 'skins.selected';

    /**
     * 스킨의 설정정보를 조회할 때 사용하는 key
     */
    const PREFIX_KEY_CONFIGS = 'skins.configs';

    /**
     * 데스크탑 버전
     */
    const SKIN_MODE_DESKTOP = 'desktop';
    /**
     * 모바일 버전
     */
    const SKIN_MODE_MOBILE = 'mobile';

    /**
     * @var ConfigStore
     */
    private $store;

    /**
     * SkinInstanceStore constructor.
     *
     * @param ConfigStore $store XpressEngine Config를 저장소(persistence storage)로 사용한다.
     */
    public function __construct(ConfigStore $store)
    {
        $this->store = $store;
    }

    /**
     * 저장소(persistence storage)를 지정한다.
     *
     * @param ConfigStore $store config store
     *
     * @return void
     */
    public function setStore(ConfigStore $store)
    {
        $this->store = $store;
    }


    /**
     * 주어진 key에 지정된 스킨을 조회한다.
     *
     * @param string $key  target key
     * @param string $mode 'mobile' or 'desktop'
     *
     * @return array|string
     */
    public function getSelectedSkin($key, $mode = null)
    {
        $key = $this->makeStoreKey(static::PREFIX_KEY_SELECTED, $key);
        if ($mode === null) {
            $config = $this->store->get($key);
            return $config === null ? [] : $config->getPureAll();
        } else {
            return $this->store->getPureVal("$key.$mode");
        }
    }

    /**
     * 주어진 타겟에 주어진 스킨을 지정한다. 두번째 파라메터가 배열일 경우, 두가지 모드의 스킨을 동시에 저장하는 것으로 간주한다.
     * ['mobile' => 'SKIN_ID', 'desktop' => 'SKIN_ID']
     *
     * @param string $key    target key
     * @param string $mode   'mobile' or 'desktop'
     * @param string $skinId skin id
     *
     * @return void
     */
    public function setSelectedSkin($key, $mode, $skinId = null)
    {
        $key = $this->makeStoreKey(static::PREFIX_KEY_SELECTED, $key);

        if ($skinId === null) {
            $skinId = $mode;
            $mode = null;
        } else {
            $skinId = [$mode => $skinId];
        }

        $desktop = array_get($skinId, static::SKIN_MODE_DESKTOP);
        $mobile = array_get($skinId, static::SKIN_MODE_MOBILE);

        if (isset($desktop)) {
            $this->store->setVal("$key.".static::SKIN_MODE_DESKTOP, $desktop);
        }
        if (isset($mobile)) {
            $this->store->setVal("$key.".static::SKIN_MODE_MOBILE, $mobile);
        }
    }

    /**
     * 주어진 타겟과 그 타겟에 지정된 스킨의 설정정보를 가져온다. 주어진 타겟에 한번이라도 지정된 적이 있는 스킨정보를 모두 가져온다.
     * 두번째 파라메터가 있을 경우, 주어진 스킨의 설정정보만 가져온다.
     *
     * @param string $key    target key
     * @param string $skinId skin id
     *
     * @return mixed
     */
    public function getConfigs($key, $skinId = null)
    {
        $key = $this->makeStoreKey(static::PREFIX_KEY_CONFIGS, $key);
        if ($skinId === null) {
            $config = $this->store->get($key);
            return $config->getPureAll();
        } else {
            $config = $this->store->getPureVal("$key.$skinId", []);
            return $config;
        }
    }

    /**
     * 주어진 타겟에 지정된 스킨의 설정을 저장한다.
     *
     * @param string $key    target key
     * @param string $skinId skin id
     * @param array  $config skin config data
     *
     * @return void
     */
    public function setConfigs($key, $skinId, $config = null)
    {
        if ($config === null) {
            $config = $skinId;
            $skinId = null;
        }

        $key = $this->makeStoreKey(static::PREFIX_KEY_CONFIGS, $key);

        if ($skinId === null) {
            $this->store->set($key, $config);
        } else {
            $this->store->setVal("$key.$skinId", $config);
        }
    }

    /**
     * 주어진 키를 조합하여 저장소(persistence storage)에 조회할 키를 생성한다.
     *
     * @param string $type prefix key, PREFIX_KEY_SELECTED이나 PREFIX_KEY_CONFIGS가 전달된다.
     * @param string $key  target key
     *
     * @return string
     */
    private function makeStoreKey($type, $key)
    {
        return "$type.$key";
    }
}
