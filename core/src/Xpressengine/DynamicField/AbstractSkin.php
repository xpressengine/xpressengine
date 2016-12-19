<?php
/**
 * AbstractSkin
 *
 * PHP version 5
 *
 * @category    DynamicField
 * @package     Xpressengine\DynamicField
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\DynamicField;

use Xpressengine\Config\ConfigEntity;
use Xpressengine\Plugin\ComponentTrait;
use Xpressengine\Plugin\ComponentInterface;

/**
 * AbstractSkin
 *
 * * Type 에서 출력할 때 사용할 스킨 필요
 *
 * @category    DynamicField
 * @package     Xpressengine\DynamicField
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
abstract class AbstractSkin implements ComponentInterface
{

    use ComponentTrait;

    /**
     * @var DynamicFieldHandler
     */
    protected $handler;

    /**
     * skin name
     *
     * @var string
     */
    protected $name;

    /**
     * @var ConfigEntity
     */
    protected $config;

    /**
     * validation settings rules
     *
     * @var array
     */
    protected $settingsRules;

    /**
     * view file directory path
     *
     * @var
     */
    protected $path;

    /**
     * path delimiter
     *
     * @var string
     */
    protected $delimiter = '/';

    /**
     * output glue
     * default space
     *
     * @var string
     */
    protected $glue = ' ';

    /**
     * merge data
     *
     * @var array
     */
    protected $mergeData = [];

    /**
     * get name of skin
     *
     * @return string
     */
    abstract public function name();

    /**
     * get view file directory path
     *
     * @return string
     */
    abstract public function getPath();

    /**
     * 다이나믹필스 생성할 때 스킨 설정에 적용될 rule 반환
     *
     * @return array
     */
    abstract public function getSettingsRules();

    /**
     * boot
     *
     * @return void
     */
    public static function boot()
    {
    }

    /**
     * create instance
     *
     * @param DynamicFieldHandler $handler dynamic field handler
     */
    public function __construct(DynamicFieldHandler $handler)
    {
        $this->handler = $handler;
        $this->name = $this->name();
        $this->settingsRules = $this->getSettingsRules();
        $this->path = $this->getPath();
    }

    /**
     * set config
     *
     * @param ConfigEntity $config dynamic field config entity
     * @return void
     */
    public function setConfig(ConfigEntity $config)
    {
        $this->config = $config;
    }


    /**
     * get view file directory path
     *
     * @param string $name view name
     * @param string $path view path
     * @return string
     */
    public function getViewPath($name, $path = null)
    {
        $name = $this->delimiter . ltrim($name, $this->delimiter);

        if ($path === null) {
            $path = $this->path;
        }
        return $path . $name;
    }

    /**
     * get field type
     *
     * @return AbstractType
     */
    protected function getType()
    {
        return $this->handler->getRegisterHandler()->getType($this->handler, $this->config->get('typeId'));
    }

    /**
     * arguments filter
     *
     * @param array $args arguments
     * @return array
     */
    protected function filter(array $args)
    {
        $data = [];
        $key = [];
        foreach ($this->getType()->getColumns() as $columnName => $columns) {
            $dataName = $this->config->get('id') . ucfirst(camel_case('_' . $columnName));
            $key[$columnName] = $dataName;
            if (isset($args[$dataName])) {
                $data[$columnName] = $args[$dataName];
            } else {
                $data[$columnName] = '';
            }
        }

        return [$data, $key];
    }

    /**
     * add merge data
     *
     * @param array $data data
     * @return void
     */
    public function addMergeData(array $data)
    {
        $this->mergeData = array_merge($data, $this->mergeData);
    }

    /**
     * set merge data
     *
     * @param array $data data
     * @return void
     */
    public function setMergeData(array $data)
    {
        $this->mergeData = $data;
    }
    
    /**
     * 등록 form 에 추가될 html 코드 반환
     * return html tag string
     *
     * @param array $args arguments
     * @return \Illuminate\View\View
     */
    public function create(array $args)
    {
        $viewFactory = $this->handler->getViewFactory();

        list($data, $key) = $this->filter($args);

        return $viewFactory->make($this->getViewPath('create'), [
            'config' => $this->config,
            'data' => array_merge($data, $this->mergeData),
            'key' => $key,
        ])->render();
    }

    /**
     * 수정 form 에 추가될 html 코드 반환
     * return html tag string
     *
     * @param array $args arguments
     * @return \Illuminate\View\View
     */
    public function edit(array $args)
    {
        list($data, $key) = $this->filter($args);

        $viewFactory = $this->handler->getViewFactory();
        return $viewFactory->make($this->getViewPath('edit'), [
            'config' => $this->config,
            'data' => array_merge($data, $this->mergeData),
            'key' => $key,
        ])->render();
    }

    /**
     * 조회할 때 사용 될 html 코드 반환
     * return html tag string
     *
     * @param array $args arguments
     * @return \Illuminate\View\View
     */
    public function show(array $args)
    {
        list($data, $key) = $this->filter($args);

        $viewFactory = $this->handler->getViewFactory();
        return $viewFactory->make($this->getViewPath('show'), [
            'config' => $this->config,
            'data' => array_merge($data, $this->mergeData),
            'key' => $key,
        ])->render();
    }

    /**
     * 리스트에서 검색할 때 검색 form 에 사용될 html 코드 반환
     * return html tag string
     *
     * @param array $args arguments
     * @return string
     */
    public function search(array $args)
    {
        if ($this->config->get('searchable') !== true) {
            return '';
        }

        list($data, $key) = $this->filter($args);

        $viewFactory = $this->handler->getViewFactory();
        return $viewFactory->make($this->getViewPath('search'), [
            'config' => $this->config,
            'data' => array_merge($data, $this->mergeData),
            'key' => $key,
        ])->render();
    }

    /**
     * 데이터 출력
     *
     * @param string $id   dynamic field name
     * @param array  $args arguments
     * @return string|null
     */
    public function output($id, array $args)
    {
        $data = [];
        foreach ($this->getType()->getColumns() as $columnName => $columns) {
            $dataName = $id . ucfirst(camel_case('_' . $columnName));
            if (isset($args[$dataName])) {
                $data[$dataName] = $args[$dataName];
            } else {
                $data[$dataName] = '';
            }
        }
        if (count($data) == 0) {
            return null;
        }

        $output = implode($this->glue, $data);

        if (trim($output) == '') {
            return null;
        }

        return $output;
    }

    /**
     * Dynamic Field 설정 페이지에서 skin 설정 등록 페이지 반환
     * return html tag string
     *
     * @param ConfigEntity $config dynamic field config entity
     * @return string
     */
    public function settings(ConfigEntity $config = null)
    {
        $viewFactory = $this->handler->getViewFactory();
        return $viewFactory->make($this->getViewPath('settings'), [
            'config' => $config,
        ])->render();
    }

    /**
     * Dynamic Field 에 데이터 입력
     *
     * @param array $args parameters
     * @return void
     */
    public function insert(array $args)
    {
    }

    /**
     * Dynamic Field 에 데이터 수정
     *
     * @param array $args   parameters
     * @param array $wheres \Illuminate\Database\Query\Builder's wheres attribute
     * @return void
     */
    public function update(array $args, array $wheres)
    {
    }

    /**
     * Dynamic Field 에 데이터 삭제
     *
     * @param array $wheres \Illuminate\Database\Query\Builder's wheres attribute
     * @return void
     */
    public function delete(array $wheres)
    {
    }
}
