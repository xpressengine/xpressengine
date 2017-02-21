<?php
/**
 * PluginProvider class. This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    Plugin
 * @package     Xpressengine\Plugin
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
namespace Xpressengine\Plugin;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\HttpFoundation\Response;

/**
 * XE 자료실에 등록된 플러그인들을 조회할 때 사용하는 클래스
 *
 * @category    Plugin
 * @package     Xpressengine\Plugin
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class PluginProvider
{
    /**
     * @var string
     */
    protected $url;

    /**
     * @var array
     */
    private $auth;

    /**
     * PluginProvider constructor.
     *
     * @param string $url  server url
     * @param array  $auth information of http basic auth
     */
    public function __construct($url, array $auth = null)
    {
        $this->url = $url;
        $this->auth = $auth;
    }

    public function search($keyword = null, $page = 1, $count = 10)
    {
        $url = 'plugins/search';
        $q = implode(',', (array) $keyword);

        try {
            $response = $this->request($url, compact('q','page','count'));
        } catch (ClientException $e) {
            if ($e->getCode() === Response::HTTP_NOT_FOUND) {
                return null;
            }
            throw $e;
        }
        return $response;
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
        $url = 'plugins/show/'.$id;
        try {
            $response = $this->request($url);
        } catch (ClientException $e) {
            if ($e->getCode() === Response::HTTP_NOT_FOUND) {
                return null;
            }
            throw $e;
        }
        return $response;
    }

    /**
     * 자료실에서 주어진 아이디들의 자료를 조회한다
     *
     * @param array $ids list of plugin id
     *
     * @return array
     */
    public function findAll(array $ids)
    {
        $url = 'plugins/find';
        $queries = ['name' => implode(',', $ids)];

        try {
            $response = $this->request($url, $queries);
        } catch (ClientException $e) {
            if ($e->getCode() === Response::HTTP_NOT_FOUND) {
                return [];
            }
            throw $e;
        }

        return $response;
    }

    /**
     * findRelease
     *
     * @param string $id      plugin id
     * @param string $version version of release
     *
     * @return array|null
     */
    public function findRelease($id, $version)
    {

        $url = "plugins/show/$id/releases/$version";
        try {
            $response = $this->request($url);
        } catch (ClientException $e) {
            if ($e->getCode() === Response::HTTP_NOT_FOUND) {
                return null;
            }
            throw $e;
        }

        return $response;
    }

    /**
     * 현재 설치된 plugin들의 정보를 자료실에 등록된 정보를 가져와 적용한다.
     *
     * @param PluginEntity|PluginEntity[] $plugins list of plugins
     *
     * @return bool 성공여부
     */
    public function sync($plugins)
    {
        if (!is_array($plugins)) {
            $plugins = [$plugins->getId() => $plugins];
        }
        $ids = array_keys($plugins);
        try {
            $infos = $this->findAll($ids);
        } catch (ConnectException $e) {
            return false;
        } catch (RequestException $e) {
            return false;
        }

        foreach ($infos as $data) {

            list($vendor, $id) = explode('/', $data->name);
            $plugin = $plugins[$id];
            if ($plugin->isDevelopMode() === false) {
                $plugin->setRemoteData($data);
            }
        }

        return true;
    }

    /**
     * send request to server.
     *
     * @param string $url     request url
     * @param array  $queries list of query string
     *
     * @return mixed
     */
    protected function request($url, $queries = [])
    {
        $url = $this->url.'/'.trim($url, '/');

        $client = new Client();

        $options = [
            'headers' => [
                'Accept' => 'application/json',
            ],
            'query' => $queries,
        ];
        if ($this->auth !== null) {
            $options['auth'] = $this->auth;
        }
        $res = $client->request(
            'GET',
            $url,
            $options
        );

        return json_decode($res->getBody());
    }
}
