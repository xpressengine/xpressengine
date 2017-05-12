<?php
/**
 * This file is unique key generate class
 *
 * PHP version 5
 *
 * @category    Keygen
 * @package     Xpressengine\Keygen
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 * @mainpage
 * ### configure
 * ```
 * return ['version' => 4, 'namespace' => 'xe-core'];
 * ```
 * > `namespace`는 version 3, 5에서만 필요
 *
 * ### install
 * * composer.json
 * ```
 * "require": {
 *      "xpressengine/keygen": "dev-master"
 * }
 * ```
 *
 * ### usage
 * ```
 * $generator = Xpressengine\Keygenn\Keygen($config);
 * $id = $generator->generate();  // 25769c6c-d34d-4bfe-ba98-e0ee856f3e7a
 * ```
 */
namespace Xpressengine\Keygen;

use Rhumsaa\Uuid\Uuid;
use Rhumsaa\Uuid\Exception\UnsatisfiedDependencyException;
use Xpressengine\Keygen\Exceptions\UnknownGeneratorVersionException;

/**
 * Class Keygen
 *
 * @category    Keygen
 * @package     Xpressengine\Keygen
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class Keygen
{
    /**
     * config array
     *
     * @var array
     */
    protected $config;

    /**
     * used version
     *
     * @var int
     */
    protected $version;

    /**
     * default config
     *
     * @var array
     */
    protected $default = ['version' => 4, 'namespace' => 'xpressengine'];

    /**
     * constructor
     *
     * @param array $config config array
     */
    public function __construct(array $config = [])
    {
        $this->config = empty($config) === false ? $config : $this->default;
    }

    /**
     * unique key generator
     *
     * @return string
     * @throws UnknownGeneratorVersionException
     */
    public function generate()
    {
        $version = $this->getMode();
        $method = 'createIdVersion' . $version;

        if (!method_exists($this, $method)) {
            throw new UnknownGeneratorVersionException(['version' => $version]);
        }

        try {
            if (in_array($version, [3, 5])) {
                return $this->$method($this->config['namespace']);
            }

            return $this->$method();
        } catch (UnsatisfiedDependencyException $e) {
            throw $e;
        }
    }

    /**
     * mode setter
     *
     * @param int $version uuid version. 1, 3, 4 and 5
     * @return void
     */
    public function setMode($version)
    {
        $this->version = $version;
    }

    /**
     * mode getter
     *
     * @return int
     */
    public function getMode()
    {
        if (!$this->version) {
            $this->version = $this->config['version'];
        }

        return $this->version;
    }

    /**
     * generate time base uuid
     *
     * @return string
     */
    protected function createIdVersion1()
    {
        return Uuid::uuid1()->toString();
    }

    /**
     * generate name base and hashed md5 uuid
     *
     * @param string $namespace base name
     * @return string
     */
    protected function createIdVersion3($namespace)
    {
        return Uuid::uuid3(Uuid::NAMESPACE_DNS, $namespace)->toString();
    }

    /**
     * generate random string base uuid
     *
     * @return string
     */
    protected function createIdVersion4()
    {
        return Uuid::uuid4()->toString();
    }

    /**
     * generate name base and hashed sha1 uuid
     *
     * @param string $namespace base name
     * @return string
     */
    protected function createIdVersion5($namespace)
    {
        return Uuid::uuid5(Uuid::NAMESPACE_DNS, $namespace)->toString();
    }
}
