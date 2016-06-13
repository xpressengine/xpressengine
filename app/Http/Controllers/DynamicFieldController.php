<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Http\Controllers;

use App;
use XePresenter;
use Validator;
use Hash;
use Auth;
use Xpressengine\Config\ConfigEntity;
use Xpressengine\Http\Request;
use Document;
use App\Http\Sections\DynamicFieldSection;
use XeDB;
use XeLang;
use XeDynamicField;
use Xpressengine\Translation\Translator;

class DynamicFieldController extends Controller
{
    protected $targetName;

    /**
     * create instance
     */
    public function __construct(Request $request)
    {
        $this->targetName = $request->get('targetName');
    }

    /**
     * index
     *
     * @return \Xpressengine\Presenter\RendererInterface
     */
    public function index(Request $request)
    {
        /**
         * @var \Xpressengine\DynamicField\DynamicFieldHandler $dynamicField
         */
        $dynamicField = app('xe.dynamicField');

        $list = [];
        $configs = $dynamicField->getConfigHandler()->gets($request->get('group'));
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
            $info['label'] = xe_trans($info['label']);

            $list[] = $info;
        }

        return XePresenter::makeApi([
            'list' => $list,
        ]);
    }

    /**
     * get skin options
     *
     * @return \Xpressengine\Presenter\RendererInterface
     */
    public function getSkinOption(Request $request)
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
        if (
            $request->get('id') != null &&
            $config = $configHandler->get($request->get('group'), $request->get('id'))
        ) {
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
        foreach ($registerHandler->getSkinsByType($dynamicField, $request->get('typeId')) as $skin) {
            $skins[$skin->getId()] = $skin->name();
        }

        return XePresenter::makeApi([
            'skins' => $skins,
            'skinId' => $skinId,
        ]);
    }

    /**
     * get additional configure
     *
     * @return \Xpressengine\Presenter\RendererInterface
     */
    public function getAdditionalConfigure(Request $request)
    {
        /**
         * @var \Xpressengine\DynamicField\DynamicFieldHandler $dynamicField
         */
        $dynamicField = app('xe.dynamicField');

        $configHandler = $dynamicField->getConfigHandler();

        $config = $configHandler->get($request->get('group'), $request->get('id'));

        $registerHandler = $dynamicField->getRegisterHandler();

        $fieldType = $registerHandler->getType($dynamicField, $request->get('typeId'));
        $fieldSkin = $registerHandler->getSkin($dynamicField, $request->get('skinId'));

        return XePresenter::makeApi([
            'configure' => $fieldType->getSettingsView($config) . $fieldSkin->settings($config),
        ]);
    }

    /**
     * store dynamic field
     *
     * @return \Xpressengine\Presenter\RendererInterface
     */
    public function store(Request $request, Translator $translator)
    {
        /**
         * @var \Xpressengine\DynamicField\DynamicFieldHandler $dynamicField
         */
        $dynamicField = app('xe.dynamicField');

        $inputs = $request->all();
        unset($inputs['databaseName']);

        /**
         * @var \Xpressengine\DynamicField\RegisterHandler $registerHandler
         */
        $registerHandler = $dynamicField->getRegisterHandler();

        $rules = DynamicFieldSection::getRules();
        $fieldType = $registerHandler->getSkin($dynamicField, $inputs['typeId']);
        $fieldSkin = $registerHandler->getSkin($dynamicField, $inputs['skinId']);
        $rules = array_merge($rules, $fieldType->getSettingsRules(), $fieldSkin->getSettingsRules());

        $this->validate($request->instance(), $rules);

        $configHandler = $dynamicField->getConfigHandler();

        $config = $configHandler->getDefault();
        foreach ($inputs as $name => $value) {
            $config->set($name, $value);
        }

        $dynamicField->setConnection(XeDB::connection($request->get('databaseName')));
        $dynamicField->create($config);


        $row = $config->getPureAll();

        $fieldType = $registerHandler->getType($dynamicField, $row['typeId']);
        $fieldSkin = $registerHandler->getSkin($dynamicField, $row['skinId']);
        $row['typeName'] = $fieldType->name();
        $row['skinName'] = $fieldSkin->name();

        $multiLang = $translator->getPreprocessorValues($inputs, session()->get('locale'));
        $row['label'] = $multiLang['label'];

        return XePresenter::makeApi($row);
    }

    /**
     * update dynamic field
     *
     * @return \Xpressengine\Presenter\RendererInterface
     */
    public function update(Request $request, Translator $translator)
    {
        /**
         * @var \Xpressengine\DynamicField\DynamicFieldHandler $dynamicField
         */
        $dynamicField = app('xe.dynamicField');

        $inputs = $request->all();
        unset($inputs['databaseName']);

        /**
         * @var \Xpressengine\DynamicField\RegisterHandler $registerHandler
         */
        $registerHandler = $dynamicField->getRegisterHandler();

        $rules = DynamicFieldSection::getRules();
        $fieldType = $registerHandler->getSkin($dynamicField, $inputs['typeId']);
        $fieldSkin = $registerHandler->getSkin($dynamicField, $inputs['skinId']);
        $rules = array_merge($rules, $fieldType->getSettingsRules(), $fieldSkin->getSettingsRules());

        $this->validate($request->instance(), $rules);

        $configHandler = $dynamicField->getConfigHandler();

        $config = $configHandler->get($inputs['group'], $inputs['id']);
        foreach ($inputs as $name => $value) {
            $config->set($name, $value);
        }

        $dynamicField->setConnection(XeDB::connection($request->get('databaseName')));
        $dynamicField->put($config);

        $row = $config->getPureAll();
        $fieldType = $registerHandler->getType($dynamicField, $row['typeId']);
        $fieldSkin = $registerHandler->getSkin($dynamicField, $row['skinId']);
        $row['typeName'] = $fieldType->name();
        $row['skinName'] = $fieldSkin->name();

        $multiLang = $translator->getPreprocessorValues($inputs, session()->get('locale'));
        $row['label'] = $multiLang['label'];

        return XePresenter::makeApi($row);
    }

    /**
     * get edit information
     *
     * @return \Xpressengine\Presenter\RendererInterface
     */
    public function getEditInfo(Request $request)
    {
        /**
         * @var \Xpressengine\DynamicField\DynamicFieldHandler $dynamicField
         */
        $dynamicField = app('xe.dynamicField');

        /**
         * @var \Xpressengine\DynamicField\ConfigHandler $configHandler
         */
        $configHandler = $dynamicField->getConfigHandler();
        $config = $configHandler->get($request->get('group'), $request->get('id'));

        return XePresenter::makeApi([
            'config' => $config->getPureAll(),
        ]);
    }

    /**
     * destroy
     *
     * @return \Xpressengine\Presenter\RendererInterface
     */
    public function destroy(Request $request)
    {
        /**
         * @var \Xpressengine\DynamicField\DynamicFieldHandler $dynamicField
         */
        $dynamicField = app('xe.dynamicField');

        /**
         * @var \Xpressengine\DynamicField\ConfigHandler $configHandler
         */
        $configHandler = $dynamicField->getConfigHandler();

        $config = $configHandler->get($request->get('group'), $request->get('id'));

        $dynamicField->setConnection(XeDB::connection($request->get('databaseName')));
        $dynamicField->drop($config);

        return XePresenter::makeApi([
            'id' => $request->get('id'),
        ]);
    }
}
