<?php
/**
 * SkinHandler class. This file is part of the Xpressengine package.
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

use Closure;
use Xpressengine\Plugin\PluginRegister;
use Xpressengine\Skin\Exceptions\SkinNotFoundException;

/**
 * SkinHandler는 XpressEngine에 등록된 스킨들을 관리하는 역할을 합니다. SkinHandler는 XE에서 `XeSkin` 파사드를 할당받습니다.
 *
 * @category    Skin
 * @package     Xpressengine\Skin
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class SkinHandler
{

    /**
     * 타겟에 대한 스킨정보를 저장할 때 사용하는 Key의 구분자.
     */
    const INSTANCE_DELIMITER = ':';

    /**
     * @var PluginRegister Container. 등록된 스킨 목록을 가지고 있다.
     */
    protected $register;

    /**
     * @var SkinInstanceStore 스킨 지정 정보 저장소. 지정된 스킨 정보를 저장하고 있는 저장소.
     */
    protected $store;

    /**
     * @var string[] 기본 스킨 목록. 각 타겟에 기본으로 사용할 스킨의 아이디 목록을 저장한다.
     */
    protected $defaultSkins;
    /**
     * @var string[] 기본 설정스킨 목록. 각 타겟에 기본으로 사용할 설정스킨의 아이디 목록을 저장한다.
     */
    protected $defaultSettingsSkins;

    /**
     * @var Closure 현재 요청이 모바일 버전인지 조회할 때 사용되는 resolver.
     */
    protected $mobileResolver;


    /**
     * 생성자.
     *
     * @param PluginRegister    $register             Container. 등록된 스킨 목록을 가지고 있다.
     * @param SkinInstanceStore $store                스킨 지정 정보 저장소
     * @param array             $defaultSkins         기본 스킨 목록
     * @param array             $defaultSettingsSkins 기본 설정 스킨 목록
     */
    public function __construct(
        PluginRegister $register,
        SkinInstanceStore $store,
        array $defaultSkins,
        array $defaultSettingsSkins
    ) {
        $this->register = $register;
        $this->store = $store;
        $this->defaultSkins = $defaultSkins;
        $this->defaultSettingsSkins = $defaultSettingsSkins;
    }

    /**
     * 스킨 지정 정보 저장소를 설정한다.
     *
     * @param SkinInstanceStore $store 스킨 지정 정보 저장소
     *
     * @return void
     */
    public function setStore(SkinInstanceStore $store)
    {
        $this->store = $store;
    }

    /**
     * 스킨 지정 정보 저장소를 반환한다.
     *
     * @return SkinInstanceStore 스킨 지정 정보 저장소
     */
    public function getStore()
    {
        return $this->store;
    }


    /**
     * 현재 요청이 모바일 버전인지 조회할 때 사용되는 resolver를 지정한다.
     *
     * @param Closure $callback resolver
     *
     * @return void
     */
    public function setMobileResolver(Closure $callback)
    {
        $this->mobileResolver = $callback;
    }

    /**
     * 현재 요청이 모바일 버전인지 조회할 때 사용되는 resolver를 조회한다.
     *
     * @return Closure
     */
    public function getMobileResolver()
    {
        return $this->mobileResolver ?: function () {
        };
    }

    /**
     * 주어진 id로 등록된 스킨을 반환한다.
     *
     * @param string $id     반환할 스킨의 id
     * @param array  $config 스킨의 설정정보
     *
     * @return SkinEntity
     */
    public function get($id, array $config = null)
    {
        $className = $this->register->get($id);

        if ($className === null) {
            return null;
        }

        if (class_exists($className) === false) {
            throw new SkinNotFoundException();
        }

        return new SkinEntity($id, $className, $config);
    }

    /**
     * 해당 id의 스킨이 등록돼 있는지 검사
     *
     * @param string $id skin id
     *
     * @return bool
     */
    public function has($id)
    {
        $className = $this->register->get($id);
        if ($className === null) {
            return false;
        }
        if (class_exists($className) === false) {
            return false;
        }
        return true;
    }

    /**
     * 주어진 타겟에 등록된 스킨의 목록을 조회하여 반환한다.
     *
     * @param string|string[] $target     조회할 스킨 target
     * @param bool            $isSettings 설정스킨 여부. true일 경우 설정스킨 목록을 반환한다.
     *
     * @return SkinEntity[]
     */
    public function getList($target, $isSettings = false)
    {
        $type = 'skin';
        if ($isSettings === true) {
            $type = 'settingsSkin';
        }
        $list = $this->register->get($target.PluginRegister::KEY_DELIMITER.$type) ?: [];

        foreach ($list as $id => $class) {
            $list[$id] = $this->get($id);
        }
        return $list;
    }

    /**
     * 주어진 타겟에 등록된 모바일 스킨의 목록을 조회하여 반환한다.
     *
     * @param string|string[] $target     조회할 스킨 target
     * @param bool            $isSettings 설정스킨 여부. true일 경우 설정스킨 목록을 반환한다.
     *
     * @return SkinEntity[]
     */
    public function getListSupportingMobile($target, $isSettings = false)
    {
        $skins = $this->getList($target, $isSettings);
        return array_where(
            $skins,
            function ($entity) {
                /** @var SkinEntity $entity */
                return $entity->supportMobile();
            }
        );
    }

    /**
     * 주어진 타겟에 등록된 데스크탑 스킨의 목록을 조회하여 반환한다.
     *
     * @param string|string[] $target     조회할 스킨 target
     * @param bool            $isSettings 설정스킨 여부. true일 경우 설정스킨 목록을 반환한다.
     *
     * @return SkinEntity[]
     */
    public function getListSupportingDesktop($target, $isSettings = false)
    {
        $skins = $this->getList($target, $isSettings);
        return array_where(
            $skins,
            function ($entity) {
                /** @var SkinEntity $entity */
                return $entity->supportDesktop();
            }
        );
    }


    /**
     * 타겟이 지정돼 있는 스킨을 반환한다.
     *
     * @param string|string[] $target 조회할 타겟
     * @param string          $mode   'mobile' or 'desktop'
     *
     * @return SkinEntity
     */
    public function getAssigned($target, $mode = null)
    {
        $storeKey = $this->mergeKey($target);
        if (is_array($target)) {
            $target = reset($target);
        }

        if ($mode === null) {
            $resolver = $this->getMobileResolver();
            $mode = $resolver() === true ? 'mobile' : 'desktop';
        }

        $skinId = $this->store->getSelectedSkin($storeKey, $mode);

        // 지정된 스킨이 없을 경우, 해당 인스턴스를 제외하고 타겟에만 지정된 스킨을 선택한다.
        if ($skinId === null) {
            $skinId = $this->store->getSelectedSkin($target, $mode);
        }

        // 타켓에 지정된 스킨이 없을 경우, 해당 타겟에 지정된 기본 스킨을 선택한다.
        if ($skinId === null || !$this->has($skinId)) {
            $skinId = $target ? array_get($this->defaultSkins, $target) : null;
        }

        // 해당 타겟에 지정된 기본 스킨도 없을 경우, 해당 타겟으로 등록된 첫번째 스킨을 선택한다.
        if ($skinId === null) {
            $skins = array_keys($this->getList($target));
            $skinId = array_shift($skins);
        }

        // 해당 타겟으로 등록된 스킨이 하나도 없을 경우, 예외 처리
        if ($skinId === null) {
            throw new SkinNotFoundException();
        }

        // 선택된 스킨의 config 정보를 얻는다.
        $config = $this->store->getConfigs($storeKey, $skinId);

        $skinEntity = $this->get($skinId, $config);

        // 선택된 스킨이 기본 스킨이 아닐 경우 기본 스킨을 주입해서 반환
        if (isset($this->defaultSkins[$target]) && $skinId !== $this->defaultSkins[$target]) {
            $defaultSkinId = $this->defaultSkins[$target];
            $defaultSkinClass = $this->register->get($defaultSkinId);

            $defaultSkin = new SkinEntity($defaultSkinId, $defaultSkinClass);

            $skinEntity->setDefaultSkin($defaultSkin);
        }

        return $skinEntity;
    }

    /**
     * 타겟이 지정돼 있는 설정스킨을 반환한다.
     * 설정스킨을 모바일|데스크탑을 구분하지 않고, 스킨 정보를 저장소에 저장하는 기능도 제공하지 않는다.
     *
     * @param string|string[] $target 조회할 타겟
     *
     * @return SkinEntity
     */
    public function getAssignedSettings($target)
    {
        // 해당 타겟에 지정된 기본 스킨을 선택한다.
        $skinId = array_get($this->defaultSettingsSkins, $target, null);
        $skin = null;

        // 해당 타겟에 지정된 기본 스킨도 없을 경우, 해당 타겟으로 등록된 첫번째 스킨을 선택한다.
        if ($skinId === null) {
            $skins = $this->getList($target, true);
            $skin = array_shift($skins);
        } else {
            return $this->get($skinId);
        }

        // 해당 타겟으로 등록된 스킨이 하나도 없을 경우, 예외 처리
        if ($skin === null) {
            throw new SkinNotFoundException();
        }

        // 선택된 스킨을 생성하여 반환한다.
        return $skin;
    }

    /**
     * 타겟에 주어진 스킨을 지정한다. 지정된 정보를 저장소에 저장하고, getAssigned() 메소드를 통해 조회할 수 있다.
     *
     * @param string      $target 타겟
     * @param SkinEntity  $skin   스킨
     * @param string|null $mode   'mobile' or 'desktop'
     *
     * @return void
     */
    public function assign($target, SkinEntity $skin, $mode = 'desktop')
    {
        $storeKey = $this->mergeKey($target);

        // set skin id
        $this->store->setSelectedSkin($storeKey, $mode, $skin->getId());
    }

    /**
     * 주어진 타겟에 지정된 스킨의 설정을 저장한다.
     *
     * @param string     $target 타겟
     * @param SkinEntity $skin   지정된 스킨, 스킨은 설정정보를 가지고 있다.
     *
     * @return void
     */
    public function saveConfig($target, SkinEntity $skin)
    {
        $storeKey = $this->mergeKey($target);

        // set config
        $this->store->setConfigs($storeKey, $skin->getId(), $skin->setting());
    }

    public function getConfig($target, $skin)
    {
        $storeKey = $this->mergeKey($target);
        $skinId = $skin instanceof SkinEntity ? $skin->getId() : $skin;

        return $this->store->getConfigs($storeKey, $skinId);
    }

    /**
     * 기본스킨으로 사용할 스킨을 지정한다.
     * 해당 타겟에 사용할 스킨을 찾을 때, 저장소에 지정된 스킨 정보가 없을 경우, 이 메소드를 통해 지정된 기본스킨을 조회한다.
     *
     * @param string $target 타겟
     * @param string $skinId 기본스킨의 아이디
     *
     * @return void
     */
    public function setDefaultSkin($target, $skinId)
    {
        $this->defaultSkins[$target] = $skinId;
    }

    /**
     * 기본스킨으로 사용할 설정스킨을 지정한다.
     * 해당 타겟에 사용할 설정스킨을 찾을 때, 저장소에 지정된 스킨 정보가 없을 경우, 이 메소드를 통해 지정된 스킨을 조회한다.
     *
     * @param string $target 타겟
     * @param string $skinId 기본스킨의 아이디
     *
     * @return void
     */
    public function setDefaultSettingsSkin($target, $skinId)
    {
        $this->defaultSettingsSkins[$target] = $skinId;
    }

    /**
     * 스킨 지정정보를 저장소에 사용하는 키를 조합한다.
     * 보통 타겟과 해당 타겟의 인스턴스 아이디를 전달받는다.
     *
     * @param string|string[] $target     타겟
     * @param string|null     $instanceId 타겟 인스턴스 아이디
     *
     * @return string
     */
    public function mergeKey($target, $instanceId = null)
    {
        if (is_string($target)) {
            $target = [$target];
        }

        if (end($target) === null) {
            array_pop($target);
        }

        if ($instanceId !== null) {
            array_push($target, $instanceId);
        }

        $storeKey = implode(static::INSTANCE_DELIMITER, $target);

        return $storeKey;
    }
}
