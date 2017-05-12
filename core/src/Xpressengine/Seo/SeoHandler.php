<?php
/**
 * This file is search engine optimizer handler.
 *
 * PHP version 5
 *
 * @category    Seo
 * @package     Xpressengine\Seo
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Seo;

use Xpressengine\Media\Models\Media;
use Xpressengine\Presenter\Html\FrontendHandler;
use Xpressengine\User\UserInterface;
use Xpressengine\Seo\Importers\AbstractImporter;
use Xpressengine\Translation\Translator;

/**
 * Class SeoHandler
 *
 * @category    Seo
 * @package     Xpressengine\Seo
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
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
     */
    public function __construct(array $importers, Setting $setting, Translator $translator, FrontendHandler $frontend)
    {
        $this->importers = $importers;
        $this->setting = $setting;
        $this->translator = $translator;
        $this->frontend = $frontend;
    }

    /**
     * Import to html header
     *
     * @param array|SeoUsable $items view 에서 사용되어지는 모든 아이템 목록
     * @return void
     */
    public function import($items)
    {
        if ($this->executable !== true || $this->isExecuted === true) {
            return;
        }

        $items = is_array($items) ? $items : [$items];

        $data = $this->resolveData($this->extract($items));

        foreach ($this->importers as $importer) {
            $importer->exec($data);
        }

        $this->isExecuted = true;
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
        $data['keywords'] = $item ? $item->getKeyword() : $this->setting->get('keywords');
        $data['author'] = $item ? $item->getAuthor() : '';
        $data['images'] = $item ? $item->getImages() : [];

        if (is_array($data['keywords'])) {
            $data['keywords'] = implode(',', $data['keywords']);
        }

        if ($data['author'] instanceof UserInterface) {
            $data['author'] = $data['author']->getDisplayName();
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
     * Returns Setting instance
     *
     * @return Setting
     */
    public function getSetting()
    {
        return $this->setting;
    }
}
