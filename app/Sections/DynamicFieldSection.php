<?php
/**
 *
 */
namespace App\Sections;

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
class DynamicFieldSection
{
    const CACHE_SESSION_NAME = 'DF_CACHE';
    const STEP_SESSION_NAME = 'DF_STEP';
    const UPDATE_FLAG_SESSION_NAME = 'DF_UPDATE_FLAG';

    /**
     * @var string
     */
    protected $group;

    /**
     * create instance
     *
     * @param string $group config group name
     */
    public function __construct($group)
    {
        $this->group = $group;
    }

    /**
     * setting
     *
     * @param VirtualConnectionInterface $conn     database connection
     * @param bool               $revision 리비전 처리
     * @return \Illuminate\View\View
     */
    public function setting(VirtualConnectionInterface $conn, $revision = false)
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

        XeFrontend::rule('dynamicFieldSection', $this->getRules());

        // 다국어 입력 필드
        XeFrontend::js('/assets/vendor/jqueryui/jquery-ui.js')->appendTo('head')->load();
        XeFrontend::css('/assets/vendor/jqueryui/jquery-ui.css')->load();
        XeFrontend::js('/assets/vendor/expanding/expanding.js')->appendTo('head')->load();
        XeFrontend::js('/assets/vendor/lang/LangEditorBox.js')->type('text/jsx')->appendTo('head')->load();
        XeFrontend::css('/assets/vendor/lang/LangEditorBox.css')->load();
        XeFrontend::css('/assets/vendor/lang/flag.css')->load();

        return View::make('dynamicField.setting', [
            'databaseName' => $conn->getName(),
            'group' => $this->group,
            'configs' => $configs,
            'fieldTypes' => $fieldTypes,
            'revision' => $revision,
        ]);
    }

    /**
     * form validation rules
     *
     * @return array
     */
    public function getRules()
    {
        return [
            'typeId' => 'Required',
            'skinId' => 'Required',
            'id' => 'Required|AlphaNum|Between:4,20',
            //'label' => 'Required|Min:4',
        ];
    }
}
