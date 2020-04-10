<?php
/**
 * JsonPresenter
 *
 * PHP version 7
 *
 * @category  Presenter
 * @package   Xpressengine\Presenter
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Presenter\Json;

use Illuminate\Contracts\Support\Arrayable;
use Xpressengine\Presenter\Presentable;
use Xpressengine\Presenter\Presenter;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;

/**
 * JsonPresenter
 *
 * * API 로 출력할 때 출력방식을 JSON 으로 선택한 경우 동작
 *
 * @category  Presenter
 * @package   Xpressengine\Presenter
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class JsonPresenter implements Presentable, Jsonable, Arrayable
{
    /**
     * @var Presenter
     */
    protected $presenter;

    /**
     * skin output id
     *
     * @var string
     */
    protected $id;

    /**
     * The array of view data.
     *
     * @var array
     */
    protected $data = [];

    /**
     * Create a new Renderer instance.
     *
     * @param Presenter $presenter presenter
     */
    public function __construct(Presenter $presenter)
    {
        $this->presenter = $presenter;
    }

    /**
     * Illuminate\Http\Request::initializeFormats() 에서 정의된 formats 에서 하나의 format
     *
     * @return string
     */
    public static function format()
    {
        return 'json';
    }

    /**
     * data convert to array
     *
     * @param mixed $data data
     * @param mixed $key  key
     * @return array
     */
    private function convert($data, $key = null)
    {
        if (is_array($data)) {
            foreach ($data as $key => $item) {
                $data[$key] = $this->convert($item, $key);
            }
        }

        if (is_object($data)) {
            return $this->getObjectToArray($data);
        } elseif (method_exists($data, 'getAttributes')) {
            return json_decode(json_encode($data->getAttributes()));
        }

        return $data;
    }

    /**
     * get object to array
     *
     * @param mixed $data data
     * @return mixed|string
     */
    private function getObjectToArray($data)
    {
        if ($data instanceof JsonSerializable) {
            return $data->jsonSerialize();
        } elseif ($data instanceof Arrayable) {
            return $data->toArray();
        } elseif ($data instanceof Jsonable) {
            return json_decode($data->toJson(), true);
        } elseif (method_exists($data, 'getAttributes')) {
            return $data->getAttributes();
        } else {
            return (array) $data;
        }
    }

    /**
     * return json format string
     *
     * @param int $options options
     * @return string
     */
    public function toJson($options = 0)
    {
        $this->data = $this->convert($this->toArray());
        return json_encode($this->data, $options);
    }

    /**
     * return json format string
     *
     * @return string
     */
    public function render()
    {
        return $this->toJson();
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->presenter->getData();
    }
}
