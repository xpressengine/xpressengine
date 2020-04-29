<?php
/**
 * This file is twitter card importer.
 *
 * PHP version 7
 *
 * @category    Seo
 * @package     Xpressengine\Seo
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Seo\Importers;

use Illuminate\Http\Request;
use Xpressengine\Presenter\Html\FrontendHandler;

/**
 * TwitterCardImporter class
 *
 * @category    Seo
 * @package     Xpressengine\Seo
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class TwitterCardImporter extends AbstractImporter
{
    /**
     * meta items
     *
     * @var array
     */
    protected $metaItems = [
        'type' => 'twitter:card',
        'username' => 'twitter:site',
        'title' => 'twitter:title',
        'description' => 'twitter:description',
        'images' => 'twitter:image',
    ];

    /**
     * will be cut items name and length
     *
     * @var array
     */
    protected $cuts = [
        'description' => 100
    ];

    /**
     * items of need prepend host
     *
     * @var array
     */
    protected $needHost = ['images'];

    /**
     * Twitter username
     *
     * @var string
     */
    protected $username;

    /**
     * Constructor
     *
     * @param FrontendHandler $frontend FrontendHandler instance
     * @param Request         $request  Request instance
     * @param string          $username twitter username
     */
    public function __construct(FrontendHandler $frontend, Request $request, $username)
    {
        $this->username = $username;

        parent::__construct($frontend, $request);
    }

    /**
     * Execute import job
     *
     * @param array $data data array
     * @return void
     */
    public function exec(array $data)
    {
        if ($data['type'] != 'article' || $this->username === null) {
            return;
        }

        parent::exec(array_merge($data, ['type' => 'summary', 'username' => '@' . $this->username]));
    }
}
