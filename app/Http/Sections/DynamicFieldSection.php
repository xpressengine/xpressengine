<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Http\Sections;

use DynamicField;
use XeFrontend;
use View;
use Xpressengine\Database\VirtualConnectionInterface;
use XeConfig;
use Xpressengine\Config\ConfigEntity;

/**
 * Class DynamicFieldSection
 * @package App\Sections
 */
class DynamicFieldSection extends Section
{
    const CACHE_SESSION_NAME = 'DF_CACHE';
    const STEP_SESSION_NAME = 'DF_STEP';
    const UPDATE_FLAG_SESSION_NAME = 'DF_UPDATE_FLAG';

    /**
     * @var string
     */
    protected $group;

    /**
     * @var VirtualConnectionInterface
     */
    protected $conn;

    /**
     * @var bool
     */
    protected $revision;

    /**
     * create instance
     *
     * @param string                     $group    config group name
     * @param VirtualConnectionInterface $conn     database connection
     * @param bool                       $revision 리비전 처리
     */
    public function __construct($group, VirtualConnectionInterface $conn, $revision = false)
    {
        $this->group = $group;
        $this->conn = $conn;
        $this->revision = $revision;
    }

    /**
     * form validation rules
     *
     * @return array
     */
    public static function getRules()
    {
        return [
            'typeId' => 'Required',
            'skinId' => 'Required',
            'id' => 'Required|AlphaNum|Between:4,20',
            //'label' => 'Required|Min:4',
        ];
    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        /** @var \Xpressengine\DynamicField\DynamicFieldHandler $dynamicField */
        $dynamicField = app('xe.dynamicField');
        $parent = $dynamicField->getConfigHandler()->parent($this->group);

        $configs = [];
        if ($parent !== null) {
            /**
             * @var ConfigEntity $config
             */
            foreach (XeConfig::children($parent) as $config) {
                if ($config->get('use') === true) {
                    $configs[$config->get('id')] = $config;
                }
            }
        }

        /**
         * @var \Xpressengine\DynamicField\RegisterHandler $registerHandler
         */
        $dynamicFieldHandler = app('xe.dynamicField');
        $registerHandler = $dynamicFieldHandler->getRegisterHandler();
        $types = $registerHandler->getTypes($dynamicFieldHandler);
        $fieldTypes = [];
        foreach ($types as $types) {
            $fieldTypes[] = $types;
        }

        XeFrontend::rule('dynamicFieldSection', static::getRules());

        // 다국어 입력 필드
        XeFrontend::js('/assets/vendor/jqueryui/jquery-ui.js')->appendTo('head')->load();
        XeFrontend::css('/assets/vendor/jqueryui/jquery-ui.css')->load();
        XeFrontend::js('/assets/vendor/expanding/expanding.js')->appendTo('head')->load();
//        XeFrontend::js('/assets/vendor/vendor.bundle.js')->appendTo('head')->load();
        XeFrontend::js('/assets/core/lang/langEditorBox.bundle.js')->appendTo('head')->load();
        XeFrontend::css('/assets/core/lang/langEditorBox.css')->load();
        XeFrontend::css('/assets/core/xe-ui-component/xe-ui-component.css')->load();

        return View::make('dynamicField.setting', [
            'databaseName' => $this->conn->getName(),
            'group' => $this->group,
            'configs' => $configs,
            'fieldTypes' => $fieldTypes,
            'revision' => $this->revision,
        ]);
    }
}
