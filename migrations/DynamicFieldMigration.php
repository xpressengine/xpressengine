<?php
/**
 * DynamicFieldMigration.php
 *
 * PHP version 7
 *
 * @category    Migrations
 * @package     Xpressengine\Migrations
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Migrations;

use Xpressengine\Config\ConfigEntity;
use Xpressengine\Support\Migration;

/**
 * Class DynamicFieldMigration
 *
 * @category    Migrations
 * @package     Xpressengine\Migrations
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class DynamicFieldMigration extends Migration
{
    /**
     * Run after installation.
     *
     * @return void
     */
    public function installed()
    {
        \DB::table('config')->insert([
            'name' => 'dynamicField',
            'vars' => '{"required":false,"sortable":false,"searchable":false,"use":true,"tableMethod":false}'
        ]);
    }

    /**
     * check need update
     *
     * @param null $installedVersion installed version
     *
     * @return bool
     */
    public function checkUpdated($installedVersion = null)
    {
        $isLatest = true;

        if ($this->checkNeedTableMerge() == true) {
            return false;
        }

        return $isLatest;
    }

    /**
     * run update
     *
     * @param null $installedVersion install version
     *
     * @return mixed|void
     */
    public function update($installedVersion = null)
    {
        if ($this->checkNeedTableMerge() == true) {
            $this->tableMerge();
        }

        parent::update($installedVersion);
    }

    /**
     * check need dynamic field table merge update
     *
     * @return bool
     */
    private function checkNeedTableMerge()
    {
        $dynamicFieldHandler = app('xe.dynamicField');
        $configHandler = $dynamicFieldHandler->getConfigHandler();
        $configManager = app('xe.config');

        //Dynamic Field를 가질 수 있는 config 목록
        $dynamicFieldConfigs = $configManager->children($configHandler->getDefault());
        foreach ($dynamicFieldConfigs as $config) {
            //실제 Dynamic Field를 가지고 있는 config를 대상으로 확인
            foreach ($configManager->children($config) as $fieldConfig) {
                if ($fieldConfig->get('migration', false) == false) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * run dynamic field table merge
     *
     * @return void
     */
    private function tableMerge()
    {
        $dynamicFieldHandler = app('xe.dynamicField');
        $configHandler = $dynamicFieldHandler->getConfigHandler();
        $configManager = app('xe.config');

        //Dynamic Field를 가질 수 있는 config 목록
        $dynamicFieldConfigs = $configManager->children($configHandler->getDefault());
        foreach ($dynamicFieldConfigs as $config) {
            //실제 Dynamic Field를 가지고 있는 config를 대상으로 확인
            foreach ($configManager->children($config) as $fieldConfig) {
                $type = $dynamicFieldHandler->getType($fieldConfig->get('group'), $fieldConfig->get('id'));

                //해당 Type의 Table이 있는지 확인해서 생성
                if ($type->checkExistTypeTables() == false) {
                    $type->createTypeTable();
                }

                if ($fieldConfig->get('migration', false) == true) {
                    continue;
                }

                //일반 데이터 추가
                $originalTable = $dynamicFieldHandler->connection()->table(
                    $this->getOriginalTableName($fieldConfig)
                );
                $newTable = $dynamicFieldHandler->connection()->table($type->getTableName());

                $fieldId = $fieldConfig->get('id');
                $group = $fieldConfig->get('group');

                //기존 Table에 있던 데이터를 새로운 Table에 저장
                $originData = $originalTable->get();
                foreach ($originData as $data) {
                    $insertParam = [];
                    $insertParam['field_id'] = $fieldId;
                    $insertParam['group'] = $group;
                    $insertParam['target_id'] = $data->{'dynamic_field_target_' . $fieldConfig->get('joinColumnName', 'id')};

                    foreach ($type->getColumns() as $column) {
                        $key = $fieldConfig->get('id') . '_' . $column->name;

                        if (isset($data->{$key}) == true) {
                            $insertParam[$column->name] = $data->{$key};
                        }
                    }

                    $newTable->insert($insertParam);
                }

                //revision 데이터 추가
                if ($fieldConfig->get('revision', false) == true) {
                    $originalRevisionTable = $dynamicFieldHandler->connection()->table(
                        $this->getOriginalRevisionTableName($fieldConfig)
                    );
                    $newRevisionTable = $dynamicFieldHandler->connection()->table($type->getRevisionTableName());

                    $fieldId = $fieldConfig->get('id');
                    $group = $fieldConfig->get('group');

                    //기존 Table에 있던 데이터를 새로운 Table에 저장
                    $originData = $originalRevisionTable->get();
                    foreach ($originData as $data) {
                        $insertParam = [];
                        $insertParam['revision_id'] = $data->{'revision_id'};
                        $insertParam['revision_no'] = $data->{'revision_no'};
                        $insertParam['field_id'] = $fieldId;
                        $insertParam['group'] = $group;
                        $insertParam['target_id'] = $data->{'dynamic_field_target_' . $fieldConfig->get('joinColumnName', 'id')};

                        foreach ($type->getColumns() as $column) {
                            $key = $fieldConfig->get('id') . '_' . $column->name;

                            if (isset($data->{$key}) == true) {
                                $insertParam[$column->name] = $data->{$key};
                            }
                        }

                        $newRevisionTable->insert($insertParam);
                    }
                }

                $fieldConfig->set('migration', true);
                $configHandler->put($fieldConfig);
            }
        }
    }

    /**
     * get original dynamic field table name
     *
     * @param ConfigEntity $config config
     *
     * @return string
     */
    private function getOriginalTableName(ConfigEntity $config)
    {
        return sprintf(
            '%s_%s_%s',
            'field',
            $config->get('group'),
            $config->get('id')
        );
    }

    /**
     * get original dynamic field revision table name
     *
     * @param ConfigEntity $config config
     *
     * @return string
     */
    private function getOriginalRevisionTableName(ConfigEntity $config)
    {
        return sprintf(
            '%s_revision_%s_%s',
            'field',
            $config->get('group'),
            $config->get('id')
        );
    }
}
