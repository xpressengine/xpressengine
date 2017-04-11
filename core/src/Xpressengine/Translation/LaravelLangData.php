<?php
/**
 * LaravelLangData.php
 *
 * PHP version 5
 *
 * @category    Translation
 * @package     Xpressengine\Translation
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Translation;

use Xpressengine\Translation\Exceptions\InvalidLocaleException;

/**
 * Class LaravelLangData
 *
 * @category    Translation
 * @package     Xpressengine\Translation
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class LaravelLangData extends LangData
{
    protected $locale;

    /**
     * @param array $data 다국어 데이터
     * @return void
     */
    public function setData($data)
    {
        if (!$this->locale) {
            throw new InvalidLocaleException();
        }

        foreach (array_dot($data) as $key => $value) {
            $this->setLine($key, $this->locale, $value);
        }
    }

    /**
     * Set current locale.
     *
     * @param string $locale locale
     * @return $this
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }
}
