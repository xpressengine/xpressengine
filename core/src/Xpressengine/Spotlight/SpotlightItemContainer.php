<?php

namespace Xpressengine\Spotlight;

use Xpressengine\Plugins\Board\Components\Modules\BoardModule;
use Xpressengine\Spotlight\Importers\AbstractImporter;

final class SpotlightItemContainer
{
    /** @var \Illuminate\Support\Collection  */
    private $items;

    /** @var array */
    private $importers = [];

    public static function bootSingleton()
    {
        app()->singleton(self::class, function() {
            $container = new self();

            $container->extendImporter('array', new Importers\ArrayImporter);
            $container->extendImporter('menu', new Importers\MenuImporter);
            $container->extendImporter('menuItem', new Importers\MenuItemImporter);
            $container->extendImporter(BoardModule::getId(), new Importers\BoardModuleImporter);
            $container->extendImporter('board@comment', new Importers\CommentImporter);
            $container->extendImporter('settingsMenu', new Importers\SettingsMenuImporter);

            return $container;
        });
    }

    /**
     * @return self
     */
    public static function make()
    {
        return app(self::class);
    }

    public function __construct()
    {
        $this->items = collect([]);
    }

    public function has($key)
    {
        return $this->items->has($key);
    }

    public function get($key, $default = null)
    {
        $this->items->get($key, $default);
    }

    public function all()
    {
        return $this->items->all();
    }

    public function add($value, $importerKey = null)
    {
        $item = $this->convert($value, $importerKey);

        if (! is_array ($item)) {
            $item = array($item);
        }

        foreach ($item as $value) {
            if (! $this->isSpotlightItem($value)) {
                throw new \InvalidArgumentException('This is not a spotlight item.');
            }

            $this->items->put($value->getId(), $value);
        }
    }

    public function extendImporter($key, Importers\AbstractImporter $importer)
    {
        $this->importers[$key] = $importer;
    }

    /**
     * @param $value
     * @param null $importerKey
     * @return mixed|SpotlightItem
     */
    private function convert($value, $importerKey = null)
    {
        $importer = $importerKey ? $this->importers[$importerKey] : $this->getTargetImporter($value);
        return $importer !== null ? $importer->convert($value): $value;
    }

    /**
     * @param $value
     * @return AbstractImporter|null
     */
    private function getTargetImporter($value)
    {
        $targetImporter = null;

        foreach ($this->importers as $importer) {
            if ($importer->checkTarget($value)) {
                $targetImporter = $importer;
                break;
            }
        }

        return $targetImporter;
    }

    private function isSpotlightItem($item)
    {
        return $item instanceof SpotlightItem;
    }
}
