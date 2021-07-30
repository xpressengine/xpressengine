<?php

namespace Xpressengine\Spotlight\Importers;

use Xpressengine\Settings\SettingsMenu;
use Xpressengine\Spotlight\SpotlightItem;

class SettingsMenuImporter extends AbstractImporter
{
    public function convert($value)
    {
        if (! $this->checkTarget($value)) {
            throw new \InvalidArgumentException('This is not a Settings Menu.');
        }

        return new SpotlightItem(
            $value->id,
            xe_trans($value->get('title')),
            xe_trans($value->get('description')),
            $value->link()
        );
    }

    public function checkTarget($value)
    {
        return $value instanceof SettingsMenu;
    }
}