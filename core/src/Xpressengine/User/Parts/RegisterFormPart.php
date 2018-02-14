<?php

/**
 * Parts.php
 *
 * PHP version 5
 *
 * @category
 * @package
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\User\Parts;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\HtmlString;
use Xpressengine\Http\Request;
use Xpressengine\Skin\SkinEntity;
use Xpressengine\Support\ValidatesRequestsTrait;

abstract class RegisterFormPart
{
    use ValidatesRequestsTrait {
        ValidatesRequestsTrait::validate as traitValidate;
    }

    protected $request;

    const ID = '';

    const NAME = '';

    const DESCRIPTION = '';

    protected static $implicit = false;

    protected static $view = '';

    protected static $resolver;

    protected static $container;

    protected $skinKey = 'user/auth';

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function render()
    {
        return new HtmlString($this->getSkin()->setView(static::$view)->setData($this->data())->render());
    }

    public static function isImplicit()
    {
        return static::$implicit;
    }

    protected function data()
    {
        return [];
    }

    public function rules()
    {
        return [];
    }

    public function validate()
    {
        return $this->traitValidate($this->request, $this->rules());
    }

    public static function setView($view)
    {
        static::$view = $view;
    }

    public static function getView()
    {
        return static::$view;
    }

    public function getSkin()
    {
        return static::resolveSkin($this->getSkinKey());
    }

    public function getSkinKey()
    {
        return $this->skinKey;
    }

    public function setSkinKey($key)
    {
        $this->skinKey = $key;
    }

    /**
     * @param string $key
     * @return SkinEntity
     */
    public static function resolveSkin($key)
    {
        return static::$resolver->getAssigned($key);
    }

    public static function setSkinResolver($resolver)
    {
        static::$resolver = $resolver;
    }

    public static function getSkinResolver()
    {
        return static::$resolver;
    }

    public function service($abstract)
    {
        return static::$container->make($abstract);
    }

    public static function setContainer(Container $container)
    {
        static::$container = $container;
    }
}
