<?php
/**
 * JsonRenderer
 *
 * PHP version 5
 *
 * @category  Presenter
 * @package   Xpressengine\Presenter
 * @author    XE Team (developers) <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      http://www.xpressengine.com
 */
namespace Xpressengine\Presenter\Json;

use Xpressengine\Presenter\RendererInterface;
use Xpressengine\Presenter\Presenter;
use Illuminate\Contracts\Support\Jsonable;

use JsonSerializable;
use Illuminate\Http\JsonResponse;
use Xpressengine\Skin\AbstractSkin;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Http\Request;
use Illuminate\View\Factory;
use Illuminate\Routing\Route;
use Xpressengine\Interception\Proxy as InterceptionProxy;

/**
 * JsonRenderer
 * > Default Presenter for json format
 *
 * @category  Presenter
 * @package   Xpressengine\Presenter
 * @author    XE Team (developers) <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      http://www.xpressengine.com
 */
class JsonRenderer implements RendererInterface, Jsonable
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
     * @param array $data data
     * @return mixed|string
     */
    private function getObjectToArray($data)
    {
        if ($data instanceof JsonSerializable) {
            return $data->jsonSerialize();
        } elseif (method_exists($data, 'getAttributes')) {
            return $data->getAttributes();
        } else {
            return get_class($data);
        }
    }

    /**
     * return json format string
     *
     * @param int $options opitons
     * @return string
     */
    public function toJson($options = 0)
    {
        $this->data = $this->convert($this->presenter->getData());
        return json_encode($this->data);
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
}
