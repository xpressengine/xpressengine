<?php
/**
 * Presenter
 *
 * PHP version 5
 *
 * @category  Presenter
 * @package   Xpressengine\Presenter
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */
namespace Xpressengine\Presenter;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse as BaseRedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * RedirectResponse
 *
 * redirect 할 때 요청 포멧이 json인 경우 json으로 응답 처리
 *
 * 컨트롤러를 API로 사용할 때 redirect 하는 컨트롤러를 사용할 수 없는 문 해결
 *
 * ```php
 * xeRedirect()->to(...)->setData(['item' => $item]);
 * ```
 * > 요청 포멧이 html인 경우는 redirect 처리되고 json일 경우는
 * setData 의 데이터를 json으로 반환
 *
 * @category  Presenter
 * @package   Xpressengine\Presenter
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
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
        if ($request->getRequestFormat() === 'json') {
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
