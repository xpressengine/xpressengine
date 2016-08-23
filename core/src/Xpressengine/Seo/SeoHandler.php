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
use Xpressengine\User\UserInterface;
use Xpressengine\Seo\Importers\AbstractImporter;
use Xpressengine\Translation\Translator;

/**
 * # SeoHandler
 * 페이지 상단 meta tag 를 노출시키기 위해 html 랜더링 전
 * 정보를 가진 대상 객체를 추출하여 데이터를 정리하고 각 Importer 에
 * 전달하는 역할을 수행
 *
 * ### app binding : xe.seo 로 바인딩 되어 있음
 * `XeSEO` Facade 로 접근이 가능
 *
 * ### Usage
 * SEO 를 사용하기 위해선 `SeoUsable` 인터페이스를 적용하고자하는
 * 대상 객체에 구현해야 함.
 *
 * 예를 들어 Document 라는 객체를 SEO 에 적용 시키고자 하면
 * 다음과 같이 코드를 작성 해야함.
 *
 * ```php
 * class Document implements SeoUsable
 * {
 *      ...
 * ```
 *
 * 위와 같이 구현된 객체를 Presenter 를 통해 전달하게 되면
 * 객체로부터 내용을 수집하여 meta tag 등 으로 노출하게 되어짐.
 *
 * ```php
 * XePresenter::make('some.view', [$seoUsableObject, $var1, $var2, ...]);
 * ```
 *
 * * Not execution
 * 간혹 어떤 상황에서 html 렌더링이 이루어지더라도 SEO 처리가 되지
 * 않길 원하는 경우 `XeSEO::notExec()` 를 실행하면 SEO 관련 태그들이
 * 적용되지 않음
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
     */
    public function __construct(array $importers, Setting $setting, Translator $translator)
    {
        $this->importers = $importers;
        $this->setting = $setting;
        $this->translator = $translator;
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
            } else if ($image instanceof Media) {
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
        if ($item) {
            return $item->getTitle() . ' - ' . $this->translator->trans($this->setting->get('mainTitle'));
        }

        return implode(' - ', [
            $this->translator->trans($this->setting->get('mainTitle')),
            $this->translator->trans($this->setting->get('subTitle'))
        ]);
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
