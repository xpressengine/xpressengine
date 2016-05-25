<?php
namespace Xpressengine\Editor;

use Xpressengine\Plugin\ComponentInterface;
use Xpressengine\Plugin\ComponentTrait;

abstract class AbstractTool implements ComponentInterface, \JsonSerializable
{
    use ComponentTrait;

    protected $instanceId;

    public function __construct($instanceId)
    {
        $this->instanceId = $instanceId;
    }
    
    abstract public function initAssets();

    abstract public function getIcon();

    public function getOptions()
    {
        return [];
    }

    public function enable()
    {
        return true;
    }

    public static function getInstanceSettingURI($instanceId)
    {
        return null;
    }

    abstract public function compile($content);

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'icon' => $this->getIcon(),
            'options' => $this->getOptions(),
            'enable' => $this->enable(),
        ];
    }
}
