<?php
/**
 * PluginProvider class. This file is part of the Xpressengine package.
 *
 * PHP version 7
 *
 * @category    Plugin
 * @package     Xpressengine\Plugin
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
namespace Xpressengine\Plugin;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * XE 자료실에 등록된 플러그인들을 조회할 때 사용하는 클래스
 *
 * @category    Plugin
 * @package     Xpressengine\Plugin
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
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

    /**
     * search plugin by keyword
     *
     * @param array $filters filters for searching
     * @param int   $page    search result page number
     * @param int   $count   limit
     *
     * @return mixed|null
     */
    public function search($filters = [], $page = 1, $count = 10)
    {
        $url = 'plugins/items';

        $query = array_get($filters, 'query');
        $q = implode(',', (array) $query);

        $authors_query = array_get($filters, 'authors');
        $tags_query = array_get($filters, 'tags');

        $authors = implode(',', (array) $authors_query);
        $tags = implode(',', (array) $tags_query);

        $collection = array_get($filters, 'collection');

        $order = array_get($filters, 'order');
        $order_type = array_get($filters, 'order_type');

        $sale_type = array_get($filters, 'sale_type');

        $category = array_get($filters, 'category');

        $site_token = array_get($filters, 'site_token');

        $response = $this->request(
            $url,
            compact(
                'q',
                'authors',
                'tags',
                'page',
                'count',
                'collection',
                'order',
                'order_type',
                'site_token',
                'sale_type',
                'category'
            )
        );

        return $response;
    }

    /**
     * Get category
     *
     * @param string $collection collection keyword
     * @return mixed|null
     */
    public function getPluginCategories($collection)
    {
        $url = 'categories';
        $response = $this->request($url, compact('collection'));

        return $response;
    }

    /**
     * retrieve purchased plugin list
     *
     * @param string $site_token site_token
     *
     * @return mixed|null
     */
    public function purchased($site_token)
    {
        $url = 'plugins/purchased';
        $response = $this->request($url, compact('site_token'));

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
        $response = $this->request($url);

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

        $response = $this->request($url, $queries) ?: [];

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
        $response = $this->request($url);

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
        $infos = $this->findAll($ids) ?: [];

        foreach ($infos as $data) {
            list($vendor, $id) = explode('/', $data->name);
            $plugin = $plugins[$id];
            if ($plugin->isSelfInstalled() === false) {
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
//            'http_errors' => false,
        ];
        if ($this->auth !== null) {
            $options['auth'] = $this->auth;
        }

        try {
            $res = $client->request(
                'GET',
                $url,
                $options
            );
        } catch (ClientException $e) {
            if ($e->getCode() == Response::HTTP_BAD_REQUEST) {
                throw new HttpException(403, xe_trans('xe::needSiteTokenToViewListOfPurchasedStore', [
                    'link' => sprintf('<a href="%s">%s</a>', route('settings.setting.edit'), xe_trans('xe::moveToSetting'))
                ]));
            }

            if ($e->getCode() === Response::HTTP_NOT_FOUND) {
                return null;
            }

            throw $e;
        }

        return json_decode($res->getBody());
    }
}
