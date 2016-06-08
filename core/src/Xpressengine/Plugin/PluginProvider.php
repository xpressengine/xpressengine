<?php
/**
 * AbstractPlugin class. This file is part of the Xpressengine package.
 *
 * @category    Plugin
 * @package     Xpressengine\Plugin
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */
namespace Xpressengine\Plugin;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Symfony\Component\HttpFoundation\Response;
use function GuzzleHttp\Psr7\str;

/**
 * XE 자료실에 등록된 플러그인들을 조회할 때 사용하는 PluginProvider
 *
 * @category    Plugin
 * @package     Xpressengine\Plugin
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
     * @param string $url
     * @param array $auth
     */
    public function __construct($url, array $auth = null)
    {
        $this->url = $url;
        $this->auth = $auth;
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
     * @param array $ids
     *
     * @return void
     */
    public function findAll(array $ids)
    {
        $url = 'list';
        $queries = ['name'=> implode(',', $ids)];

        try {
            $response = $this->request($url, $queries);
        } catch (ClientException $e) {
            if($e->getCode() === Response::HTTP_NOT_FOUND) {
                return [];
            }
            throw $e;
        }

        return $response;
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
     * @param PluginEntity[] $plugins
     *
     * @return void
     */
    public function sync(array $plugins)
    {
        $ids = array_keys($plugins);
        $infos = $this->findAll($ids);

        foreach ($infos as $data) {

            list($vendor , $id) = explode('/', $data->name);
            $plugin = $plugins[$id];
            $plugin->setRemoteData($data);
        }
    }

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
        if($this->auth !== null) {
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
