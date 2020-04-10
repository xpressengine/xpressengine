<?php
/**
 * DynamicFieldController.php
 *
 * PHP version 7
 *
 * @category    Controllers
 * @package     App\Http\Controllers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\Http\Controllers;

use App;
use XePresenter;
use Xpressengine\Config\ConfigEntity;
use Xpressengine\Http\Request;
use App\Http\Sections\DynamicFieldSection;
use XeDB;
use XeFrontend;
use Xpressengine\Translation\Translator;
use function Matrix\add;

/**
 * Class DynamicFieldController
 *
 * @category    Controllers
 * @package     App\Http\Controllers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class DynamicFieldController extends Controller
{
    /**
     * Show list of dynamic field.
     *
     * @param Request $request request
     * @return \Xpressengine\Presenter\Presentable
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
     * Get skin options.
     *
     * @param Request $request request
     * @return \Xpressengine\Presenter\Presentable
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
        if ($request->get('id') != null &&
            $config = $configHandler->get($request->get('group'), $request->get('id'))
        ) {
            $skinId = $config->get('skinId');
        }

        /**
         * @var \Xpressengine\DynamicField\RegisterHandler $registerHandler
         */
        $registerHandler = $dynamicField->getRegisterHandler();

        // fieldType 에 따른 Skin 리스트
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
     * Get additional configure.
     *
     * @param Request $request request
     * @return \Xpressengine\Presenter\Presentable
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

        $rules = array_merge($fieldType->getSettingsRules(), $fieldSkin->getSettingsRules());

        XeFrontend::rule('dynamicFieldSection', $rules);

        return XePresenter::makeApi([
            'result' => $fieldType->getSettingsView($config) . $fieldSkin->settings($config),
        ]);
    }

    /**
     * Store dynamic field
     *
     * @param Request    $request    request
     * @param Translator $translator Translator instance
     * @return \Xpressengine\Presenter\Presentable
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

        $fieldCreateRules = DynamicFieldSection::getCreateRules();
        $this->validate($request->instance(), $fieldCreateRules);

        $additionalRules = [];
        $fieldType = $registerHandler->getSkin($dynamicField, $inputs['typeId']);
        $fieldSkin = $registerHandler->getSkin($dynamicField, $inputs['skinId']);
        $additionalRules = array_merge(
            $additionalRules,
            $fieldType->getSettingsRules(),
            $fieldSkin->getSettingsRules()
        );
        $this->validate($request->instance(), $additionalRules);

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
     * Update dynamic field.
     *
     * @param Request    $request    request
     * @param Translator $translator Translator instance
     * @return \Xpressengine\Presenter\Presentable
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

        $fieldUpdateRules = DynamicFieldSection::getUpdateRules();
        $this->validate($request->instance(), $fieldUpdateRules);

        $additionalRules = [];
        $fieldType = $registerHandler->getSkin($dynamicField, $inputs['typeId']);
        $fieldSkin = $registerHandler->getSkin($dynamicField, $inputs['skinId']);
        $additionalRules = array_merge(
            $additionalRules,
            $fieldType->getSettingsRules(),
            $fieldSkin->getSettingsRules()
        );
        $this->validate($request->instance(), $additionalRules);

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

        if (isset($inputs['label']) === true) {
            $multiLang = $translator->getPreprocessorValues($inputs, session()->get('locale'));
            $row['label'] = $multiLang['label'];
        } else {
            $row['label'] = xe_trans($row['label']);
        }

        return XePresenter::makeApi($row);
    }

    /**
     * Get edit information
     *
     * @param Request $request request
     * @return \Xpressengine\Presenter\Presentable
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
     * Destroy a field.
     *
     * @param Request $request request
     * @return \Xpressengine\Presenter\Presentable
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
