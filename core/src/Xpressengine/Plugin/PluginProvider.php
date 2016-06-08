<?php
/**
 * AbstractPlugin class. This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    Plugin
 * @package     Xpressengine\Plugin
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Plugin;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use function GuzzleHttp\Psr7\str;
use Symfony\Component\HttpFoundation\Response;

/**
 * XE 자료실에 등록된 플러그인들을 조회할 때 사용하는 PluginProvider
 *
 * @category    Plugin
 * @package     Xpressengine\Plugin
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class PluginProvider
{
    protected $url;

    /**
     * PluginProvider constructor.
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * 자료실에서 주어진 아이디의 자료를 조회한다.
     *
     * @param string $id plugin id
     *
     * @return object
     */
    public function find($id)
    {
        $url = $id;
        try {
            $response = $this->request($url);
        } catch (ClientException $e) {
            if($e->getCode() === Response::HTTP_NOT_FOUND) {
                return null;
            }
            throw $e;
        }

        return $response;
    }

    /**
     * 자료실에서 주어진 아이디들의 자료를 조회한다
     *
     * @param $ids
     *
     * @return void
     */
    public function findAll($ids)
    {
    }

    public function findRelease($id, $version)
    {

        $url = "$id/releases/$version";
        try {
            $response = $this->request($url);
        } catch (ClientException $e) {
            if($e->getCode() === Response::HTTP_NOT_FOUND) {
                return null;
            }
            throw $e;
        }

        return $response;
    }

    /**
     * 현재 설치된 plugin들의 정보를 자료실에 등록된 정보를 가져와 적용한다.
     *
     * @param PluginCollection $plugins
     *
     * @return void
     */
    public function sync(PluginCollection $plugins)
    {
        $ids = array_keys($plugins->getList());
        $infos = $this->findAll($ids);
        foreach ($plugins as $id => $plugin) {
        }
    }

    protected function request($url, $queries = [])
    {
        $url = $this->url.'/'.trim($url, '/');

        $client = new Client();

        $res = $client->request(
            'GET',
            $url,
            [
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'query' => $queries,
            ]
        );

        return json_decode($res->getBody());
    }
}
