<?php
/**
 * DynamicFieldMigration.php
 *
 * PHP version 7
 *
 * @category    Migrations
 * @package     Xpressengine\Migrations
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Migrations;

use Xpressengine\Config\ConfigEntity;
use Xpressengine\Config\ConfigManager;
use Xpressengine\DynamicField\ConfigHandler;
use Xpressengine\DynamicField\DynamicFieldHandler;
use Xpressengine\Support\Migration;

/**
 * Class DynamicFieldMigration
 *
 * @category    Migrations
 * @package     Xpressengine\Migrations
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class DynamicFieldMigration extends Migration
{
    /** @var DynamicFieldHandler $dynamicFieldHandler */
    protected $dynamicFieldHandler;

    /** @var ConfigHandler $configHandler */
    protected $configHandler;

    /** @var ConfigManager $configManager */
    protected $configManager;

    /**
     * DynamicFieldMigration constructor.
     */
    public function __construct()
    {
        $this->dynamicFieldHandler = app('xe.dynamicField');
        $this->configHandler = $this->dynamicFieldHandler->getConfigHandler();
        $this->configManager = app('xe.config');
    }

    /**
     * Run after installation.
     *
     * @return void
     */
    public function installed()
    {
        \DB::table('config')->insert(['name' => 'dynamicField', 'vars' => '{"required":false,"sortable":false,"searchable":false,"use":true,"tableMethod":false}']);
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
        //Dynamic Field를 가질 수 있는 config 목록
        $dynamicFieldConfigs = $this->configManager->children($this->configHandler->getDefault());
        foreach ($dynamicFieldConfigs as $config) {
            //실제 Dynamic Field를 가지고 있는 config를 대상으로 확인
            foreach ($this->configManager->children($config) as $fieldConfig) {
                $type = $this->dynamicFieldHandler->getType($fieldConfig->get('group'), $fieldConfig->get('id'));

                if ($type->checkExistTypeTables() == false) {
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
        //Dynamic Field를 가질 수 있는 config 목록
        $dynamicFieldConfigs = $this->configManager->children($this->configHandler->getDefault());
        foreach ($dynamicFieldConfigs as $config) {
            //실제 Dynamic Field를 가지고 있는 config를 대상으로 확인
            foreach ($this->configManager->children($config) as $fieldConfig) {
                $type = $this->dynamicFieldHandler->getType($fieldConfig->get('group'), $fieldConfig->get('id'));

                //해당 Type의 Table이 있는지 확인해서 생성
                if ($type->checkExistTypeTables() == false) {
                    $type->createTypeTable();
                }

                //일반 데이터 추가
                $originalTable = $this->dynamicFieldHandler->connection()->table(
                    $this->getOriginalTableName($fieldConfig)
                );
                $newTable = $this->dynamicFieldHandler->connection()->table($type->getTableName());

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
                    $originalRevisionTable = $this->dynamicFieldHandler->connection()->table(
                        $this->getOriginalRevisionTableName($fieldConfig)
                    );
                    $newRevisionTable = $this->dynamicFieldHandler->connection()->table($type->getRevisionTableName());

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
