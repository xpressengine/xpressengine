<?php

declare(strict_types=1);

namespace Xpressengine\Menu\Models\Concerns;

use Xpressengine\Translation\Translator;

/**
 * Trait MenuItemLocalizeTrait
 *
 * @package Xpressengine\Menu\Models\Concerns
 */
trait MenuItemLocalizeTrait
{
    /**
     * "title" attribute
     *
     * @param $title
     * @return string|null
     */
    public function getTitleAttribute($title)
    {
        return $title ? xe_trans($title) : null;
    }

    /**
     * "title_lang_key" attribute
     *
     * @return string|null
     */
    public function getTitleLangKeyAttribute()
    {
        return $this->getTitleLangKey();
    }

    /**
     * Get menu item's title lang key
     *
     * @return string|null
     */
    public function getTitleLangKey()
    {
        $translator = app(Translator::class);

        if (blank($titleLangKey = array_get($this->getAttributes(), 'title'))) {
            return null;
        }

        [$langNamespace] = $translator->parseKey($titleLangKey);
        if ($langNamespace === $translator->getLaravelNamespace()) {
            $titleLangKey = put_translator_lang_data($translator->getUserNamespace(), [
                $translator->getLocale() => $titleLangKey
            ]);

            $this->update(['title' => $titleLangKey]);
        }

        return $titleLangKey;
    }

    /**
     * "description" attribute
     *
     * @param $description
     * @return string|null
     */
    public function getDescriptionAttribute($description)
    {
        return $description ? xe_trans($description) : null;
    }

    /**
     * "description_lang_key" attribute
     *
     * @return string|null
     */
    public function getDescriptionLangKeyAttribute()
    {
        return $this->getDescriptionLangKey();
    }

    /**
     * Get Menu Item's Description Lang Key
     *
     * @return string|null
     */
    public function getDescriptionLangKey()
    {
        $translator = app(Translator::class);

        if (blank($descriptionLangKey = array_get($this->getAttributes(), 'description'))) {
            return null;
        }

        [$langNamespace] = $translator->parseKey($descriptionLangKey);
        if ($langNamespace === $translator->getLaravelNamespace()) {
            $descriptionLangKey = put_translator_lang_data($translator->getUserNamespace(), [
                $translator->getLocale() => $descriptionLangKey
            ]);

            $this->update(['description' => $descriptionLangKey]);
        }

        return $descriptionLangKey;
    }
}
