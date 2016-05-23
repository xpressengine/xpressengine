<?php
namespace Xpressengine\Editor;

use Xpressengine\Plugin\ComponentInterface;
use Xpressengine\Plugin\ComponentTrait;

abstract class AbstractTool implements ComponentInterface
{
    use ComponentTrait;

    protected $instanceId;

    protected $userResolver;
    
    public function setInstanceId($instanceId)
    {
        $this->instanceId = $instanceId;
    }
    
    abstract public function initAssets();

    abstract public function getName();

    abstract public function getIcon();

    public function getOptions()
    {
        return [];
    }

    public function allows()
    {
        return true;
    }

    public static function getInstanceSettingURI($instanceId)
    {
        return null;
    }
}
