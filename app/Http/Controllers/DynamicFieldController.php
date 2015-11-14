<?php
namespace App\Http\Controllers;

use App;
use Input;
use Presenter;
use Validator;
use Hash;
use Auth;
use Xpressengine\Config\ConfigEntity;
use Xpressengine\Permission\Action;
use Xpressengine\Support\Exceptions\HttpXpressengineException;
use Document;
use App\Sections\DynamicFieldSection;
use XeDB;
use DynamicField;
use Cfg;
use Category;

class DynamicFieldController extends Controller
{

    protected $section;

    protected $targetName;

    /**
     * create instance
     */
    public function __construct()
    {
        $this->targetName = Input::get('targetName');
        $this->section = new DynamicFieldSection($this->targetName);
    }

    /**
     * index
     *
     * @return \Xpressengine\Presenter\RendererInterface
     */
    public function index()
    {
        /**
         * @var \Xpressengine\DynamicField\DynamicFieldHandler $dynamicField
         */
        $dynamicField = app('xe.dynamicField');

        $list = [];
        $configs = $dynamicField->getConfigHandler()->gets(Input::get('group'));
        /**
         * @var ConfigEntity $config
         */
        foreach ($configs as $config) {
            $info = $config->getPureAll();
            /**
             * @var \Xpressengine\DynamicField\TypeInterface $fieldType
             */
            $fieldType = $dynamicField->get($config->get('group'), $config->get('id'));
            $info['typeName'] = $fieldType->name();
            $info['skinName'] = $fieldType->getSkin()->name();

            $list[] = $info;
        }

        return Presenter::makeApi([
            'list' => $list,
        ]);
    }

    /**
     * get skin options
     *
     * @return \Xpressengine\Presenter\RendererInterface
     */
    public function getSkinOption()
    {
        /**
         * @var \Xpressengine\DynamicField\DynamicFieldHandler $dynamicField
         */
        $dynamicField = app('xe.dynamicField');

        /**
         * @var \Xpressengine\DynamicField\ConfigHandler $configHandler
         */
        $configHandler = $dynamicField->getConfigHandler();
        $skinId = '';
        if (Input::get('id') != null && $config = $configHandler->get(Input::get('group'), Input::get('id'))) {
            $skinId = $config->skinId;
        }

        /**
         * @var \Xpressengine\DynamicField\RegisterHandler $registerHandler
         */
        $registerHandler = $dynamicField->getRegisterHandler();

        // fieldType 에 따른 Skin 리스트
        /**
         * @var \Generator $skins
         */
        $skins = [];
        foreach ($registerHandler->getSkinsByType($dynamicField, Input::get('typeId')) as $skin) {
            $skins[$skin->getId()] = $skin->name();
        }

        return Presenter::makeApi([
            'skins' => $skins,
            'skinId' => $skinId,
        ]);
    }

    /**
     * get additional configure
     *
     * @return \Xpressengine\Presenter\RendererInterface
     */
    public function getAdditionalConfigure()
    {
        /**
         * @var \Xpressengine\DynamicField\DynamicFieldHandler $dynamicField
         */
        $dynamicField = app('xe.dynamicField');

        $configHandler = $dynamicField->getConfigHandler();

        $config = $configHandler->get(Input::get('group'), Input::get('id'));

        $registerHandler = $dynamicField->getRegisterHandler();

        $fieldType = $registerHandler->getType($dynamicField, Input::get('typeId'));
        $fieldSkin = $registerHandler->getSkin($dynamicField, Input::get('skinId'));

        return Presenter::makeApi([
            'configure' => $fieldType->getSettingsView($config) . $fieldSkin->settings($config),
        ]);
    }

    /**
     * store dynamic field
     *
     * @return \Xpressengine\Presenter\RendererInterface
     */
    public function store()
    {
        /**
         * @var \Xpressengine\DynamicField\DynamicFieldHandler $dynamicField
         */
        $dynamicField = app('xe.dynamicField');

        $inputs = Input::all();
        unset($inputs['databaseName']);

        /**
         * @var \Xpressengine\DynamicField\RegisterHandler $registerHandler
         */
        $registerHandler = $dynamicField->getRegisterHandler();

        $rules = $this->section->getRules();
        $fieldType = $registerHandler->getSkin($dynamicField, $inputs['typeId']);
        $fieldSkin = $registerHandler->getSkin($dynamicField, $inputs['skinId']);
        $rules = array_merge($rules, $fieldType->getSettingsRules(), $fieldSkin->getSettingRules());

        $this->validate(Input::instance(), $rules);

        $configHandler = $dynamicField->getConfigHandler();

        $config = $configHandler->getDefault();
        foreach ($inputs as $name => $value) {
            $config->set($name, $value);
        }

        $dynamicField->setConnection(XeDB::connection(Input::get('databaseName')));
        $dynamicField->create($config);


        $row = $config->getPureAll();
        $fieldType = $registerHandler->getType($dynamicField, $row['typeId']);
        $fieldSkin = $registerHandler->getSkin($dynamicField, $row['skinId']);
        $row['typeName'] = $fieldType->name();
        $row['skinName'] = $fieldSkin->name();

        return Presenter::makeApi($row);
    }

    /**
     * update dynamic field
     *
     * @return \Xpressengine\Presenter\RendererInterface
     */
    public function update()
    {
        /**
         * @var \Xpressengine\DynamicField\DynamicFieldHandler $dynamicField
         */
        $dynamicField = app('xe.dynamicField');

        $inputs = Input::all();
        unset($inputs['databaseName']);

        /**
         * @var \Xpressengine\DynamicField\RegisterHandler $registerHandler
         */
        $registerHandler = $dynamicField->getRegisterHandler();

        $rules = $this->section->getRules();
        $fieldType = $registerHandler->getSkin($dynamicField, $inputs['typeId']);
        $fieldSkin = $registerHandler->getSkin($dynamicField, $inputs['skinId']);
        $rules = array_merge($rules, $fieldType->getRules(), $fieldSkin->getRules());

        $configHandler = $dynamicField->getConfigHandler();

        $config = $configHandler->getDefault();
        foreach ($inputs as $name => $value) {
            $config->set($name, $value);
        }

        $dynamicField->setConnection(XeDB::connection(Input::get('databaseName')));
        $dynamicField->put($config);

        $row = $config->getPureAll();
        $fieldType = $registerHandler->getType($dynamicField, $row['typeId']);
        $fieldSkin = $registerHandler->getSkin($dynamicField, $row['skinId']);
        $row['typeName'] = $fieldType->name();
        $row['skinName'] = $fieldSkin->name();

        return Presenter::makeApi($row);
    }

    /**
     * get edit information
     *
     * @return \Xpressengine\Presenter\RendererInterface
     */
    public function getEditInfo()
    {
        /**
         * @var \Xpressengine\DynamicField\DynamicFieldHandler $dynamicField
         */
        $dynamicField = app('xe.dynamicField');

        /**
         * @var \Xpressengine\DynamicField\ConfigHandler $configHandler
         */
        $configHandler = $dynamicField->getConfigHandler();
        $config = $configHandler->get(Input::get('group'), Input::get('id'));

        return Presenter::makeApi([
            'config' => $config->getPureAll(),
        ]);
    }

    /**
     * destroy
     *
     * @return \Xpressengine\Presenter\RendererInterface
     */
    public function destroy()
    {
        /**
         * @var \Xpressengine\DynamicField\DynamicFieldHandler $dynamicField
         */
        $dynamicField = app('xe.dynamicField');

        /**
         * @var \Xpressengine\DynamicField\ConfigHandler $configHandler
         */
        $configHandler = $dynamicField->getConfigHandler();

        $config = $configHandler->get(Input::get('group'), Input::get('id'));

        $dynamicField->setConnection(XeDB::connection(Input::get('databaseName')));
        $dynamicField->drop($config);

        return Presenter::makeApi([
            'id' => Input::get('id'),
        ]);
    }
}
