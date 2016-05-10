<?php
namespace Xpressengine\Editor;

use Xpressengine\Plugin\ComponentInterface;
use Xpressengine\Plugin\ComponentTrait;

class AbstractParts implements ComponentInterface
{
    use ComponentTrait;

    public static function getInstanceSettingURI($instanceId)
    {
        return null;
    }
}
