<?php

namespace Xpressengine\Spotlight\Importers;

use Xpressengine\Spotlight\SpotlightItem;

abstract class AbstractImporter
{
    /**
     * @param $value
     * @return mixed
     */
    public abstract function convert($value);

    /**
     * @param $value
     * @return boolean
     */
    public abstract function checkTarget($value);
}