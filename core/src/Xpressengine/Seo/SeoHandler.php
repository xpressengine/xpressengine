<?php
/**
 * This file is search engine optimizer handler.
 *
 * PHP version 7
 *
 * @category    Seo
 * @package     Xpressengine\Seo
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Seo;

use Xpressengine\Media\Models\Media;
use Xpressengine\Presenter\Html\FrontendHandler;
use Xpressengine\Presenter\Presenter;
use Xpressengine\User\UserInterface;
use Xpressengine\Seo\Importers\AbstractImporter;
use Xpressengine\Translation\Translator;

/**
 * Class SeoHandler
 *
 * @category    Seo
 * @package     Xpressengine\Seo
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class SeoHandler
{
    /**
     * Importer instances
     *
     * @var AbstractImporter[]
     */
    protected $importers;

    /**
     * Setting instance
     *
     * @var Setting
     */
    protected $setting;

    /**
     * Translator instances
     *
     * @var Translator
     */
    protected $translator;

    /**
     * FrontendHandler instance
     *
     * @var FrontendHandler
     */
    protected $frontend;

    /**
     * Presenter instance
     *
     * @var Presenter $presenter
     */
    protected $presenter;

    /**
     * Will be executed
     *
     * @var bool
     */
    protected $executable = true;

    /**
     * Already executed
     *
     * @var bool
     */
    protected $isExecuted = false;

    /**
     * Constructor
     *
     * @param AbstractImporter[] $importers  Importer instances
     * @param Setting            $setting    Setting instances
     * @param Translator         $translator Translator instances
     * @param FrontendHandler    $frontend   Frontend instance
     * @param Presenter          $presenter  Presenter instance
     */
    public function __construct(
        array $importers,
        Setting $setting,
        Translator $translator,
        FrontendHandler $frontend,
        Presenter $presenter
    ) {
        $this->importers = $importers;
        $this->setting = $setting;
        $this->translator = $translator;
        $this->frontend = $frontend;
        $this->presenter = $presenter;
    }

    /**
     * Import to html header
     *
     * @param array|SeoUsable $items view 에서 사용되어지는 모든 아이템 목록
     * @return void
     */
    public function import($items)
    {
        if ($this->executable !== true) {
            $this->noIndex();
            return;
        }

        if ($this->isExecuted !== true) {
            $items = is_array($items) ? $items : [$items];

            $data = $this->resolveData($this->extract($items));

            foreach ($this->importers as $importer) {
                $importer->exec($data);
            }

            $this->isExecuted = true;
        }
    }

    /**
     * Extract item of seo usable
     *
     * @param array $items view 에서 사용되어지는 모든 아이템 목록
     * @return null|SeoUsable
     */
    protected function extract(array $items)
    {
        $seoUsable = null;
        foreach ($items as $item) {
            if ($item instanceof SeoUsable) {
                $seoUsable = $item;
                break;
            }
        }

        return $seoUsable;
    }

    /**
     * Data resolve
     *
     * @param SeoUsable $item item instance
     * @return array
     */
    protected function resolveData(SeoUsable $item = null)
    {
        $data = [];
        $data['type'] = $item ? 'article' : 'website';
        $data['siteName'] = $this->translator->trans($this->setting->get('mainTitle'));
        $data['url'] = $item ? $item->getUrl() : '';
        $data['title'] = $this->makeTitle($item);
        $data['description'] = $item ? $item->getDescription()
            : $this->translator->trans($this->setting->get('description'));
        $data['keywords'] = $item ? $item->getKeyword() : $this->translator->trans($this->setting->get('keywords'));
        $data['author'] = $item ? $item->getAuthor() : '';
        $data['images'] = $item ? $item->getImages() : [];

        if (is_array($data['keywords'])) {
            $data['keywords'] = implode(',', $data['keywords']);
        }

        if ($data['author'] instanceof UserInterface) {
            $data['author'] = $data['author']->getDisplayName();
        }

        $menuItem = $this->presenter->getInstanceConfig()->getMenuItem();
        if ($menuItem && $image = $menuItem->menuImage) {
            $data['images'][] = $image;
        }

        if ($image = $this->setting->getSiteImage()) {
            $data['images'][] = $image;
        }

        foreach ($data['images'] as &$image) {
            if (is_string($image)) {
                $image = ['url' => $image];
            } elseif ($image instanceof Media) {
                $image = [
                    'url' => $image->url(),
                    'width' => $image->meta->width,
                    'height' => $image->meta->height,
                ];
            }
        }

        return array_filter($data);
    }

    /**
     * Make title text
     *
     * @param SeoUsable $item item instance
     * @return string
     */
    protected function makeTitle(SeoUsable $item = null)
    {
        $siteTitle = $this->frontend->output('title');
        $mainTitle = $this->setting->get('mainTitle');
        if ($mainTitle != '') {
            $siteTitle = $mainTitle;
        }

        if ($item) {
            $title = $item->getTitle() . ' - ' . $this->translator->trans($siteTitle);
            $title = strip_tags(html_entity_decode($title));
            $this->frontend->title($title);

            return $title;
        }

        $subTitle = $this->setting->get('subTitle');
        if ($mainTitle == '' && $subTitle == '') {
            return $this->translator->trans($siteTitle);
        } else {
            return implode(' - ', [
                $this->translator->trans($mainTitle),
                $this->translator->trans($subTitle)
            ]);
        }
    }

    /**
     * Add Importer
     *
     * @param AbstractImporter $importer Importer instance
     * @return void
     */
    public function addImporter(AbstractImporter $importer)
    {
        $this->importers[] = $importer;
    }

    /**
     * Set will not executed
     *
     * @return void
     */
    public function notExec()
    {
        $this->executable = false;
    }

    /**
     * Add meta for no-index
     *
     * @return void
     */
    protected function noIndex()
    {
        $this->frontend->meta('robots')->name('robots')->content('noindex')->load();
    }

    /**
     * Returns Setting instance
     *
     * @return Setting
     */
    public function getSetting()
    {
        return $this->setting;
    }
}
