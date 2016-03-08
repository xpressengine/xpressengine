<?php
/**
 *
 */
namespace App\Sections;

use DynamicField;
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

        \Frontend::rule('dynamicFieldSection', $this->getRules());

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
            'label' => 'Required|Min:4',
        ];
    }
}
