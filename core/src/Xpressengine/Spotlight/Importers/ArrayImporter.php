<?php

namespace Xpressengine\Spotlight\Importers;

use Xpressengine\Spotlight\SpotlightItem;

class ArrayImporter extends AbstractImporter
{
    public function convert($value)
    {
        if (! $this->checkTarget($value)) {
            throw new \InvalidArgumentException('This is not a array.');
        }

        return SpotlightItem::make($value);
    }

    public function checkTarget($value)
    {
        return is_array($value);
    }
}