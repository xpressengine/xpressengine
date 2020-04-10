<?php
/**
 * Presenter
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
namespace Xpressengine\Presenter;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse as BaseRedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * RedirectResponse
 *
 * @category  Presenter
 * @package   Xpressengine\Presenter
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */
class RedirectResponse extends BaseRedirectResponse
{
    /** @var array data */
    protected $data = [];

    /**
     * set data
     *
     * @param array $data data
     * @return $this
     */
    public function setData(array $data = [])
    {
        $this->data = array_merge($data, $this->data);

        return $this;
    }

    /**
     * 요청 포멧이 html 이 아닐 경우 redirect 하지 않고 데이터 형식으로 결과 출력
     *
     * @param Request $request request
     * @return mixed
     */
    public function prepare(Request $request)
    {
        if ($request->format() === 'json') {
            return new JsonResponse(array_merge(
                $this->data,
                ['links' => [
                    'rel' => 'self',
                    'href' => $this->targetUrl,
                ]]
            ));
        }

        return parent::prepare($request);
    }
}
