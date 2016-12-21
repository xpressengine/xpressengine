<?php
/**
 * Class Translation
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

use Illuminate\Support\Collection;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Translation\MessageSelector;
use Xpressengine\Keygen\Keygen;
use Xpressengine\Translation\Exceptions\EmptyLocaleException;
use Xpressengine\Translation\Loaders\LoaderInterface;

/**
 * @category    Translation
 * @package     Xpressengine\Translation
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class Translator extends NamespacedItemResolver implements TranslatorInterface
{
    protected $locales = [];
    protected $texts = [];
    protected $keyGen;
    protected $cachedDb;
    protected $fileLoader;
    protected $urlLoader;
    protected $userKeyPrefix = 'user';
    protected $preprocessorProtocol = 'xe_lang_preprocessor://';

    /**
     * @param array               $config     설정
     * @param Keygen              $keyGen     사용자 정의 다국어용 키 생성기
     * @param TransCachedDatabase $cachedDb   다국어 캐시 디비
     * @param LoaderInterface     $fileLoader 다국어 파일 로더
     * @param LoaderInterface     $urlLoader  다국어 URL 로더
     */
    public function __construct(
        $config,
        Keygen $keyGen,
        TransCachedDatabase $cachedDb,
        LoaderInterface $fileLoader,
        LoaderInterface $urlLoader
    ) {
        $this->setLocales($config['locales']);
        $this->setLocaleTexts($config['localeTexts']);
        $this->keyGen = $keyGen;
        $this->cachedDb = $cachedDb;
        $this->fileLoader = $fileLoader;
        $this->urlLoader = $urlLoader;
    }

    /**
     * 로케일 목록의 배열을 리턴
     *
     * @return array
     */
    public function getLocales()
    {
        return $this->locales;
    }

    /**
     * 로케일 목록을 입력
     *
     * 이미 존재하는 로케일이 발견되면 나중의 것을 필터링 합니다.
     *
     * @param array $locales 로케일 배열
     * @return void
     * @throws EmptyLocaleException
     */
    public function setLocales(array $locales)
    {
        $this->locales = array_values(array_filter(array_unique($locales)));
        if (count($this->locales) == 0) {
            throw new EmptyLocaleException();
        }
    }

    /**
     * 현재 선택 로케일을 리턴
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locales[0];
    }

    /**
     * 현재 로케일을 선택
     *
     * 존재하지 않는 로케일을 선택할 수 없습니다.
     *
     * @param string $locale 선택 로케일
     * @return void
     */
    public function setLocale($locale)
    {
        if (!in_array($locale, $this->locales)) {
            return;
        }
        $this->setLocales(array_merge([$locale], $this->locales));
    }

    /**
     * 로케일 표현 문자열 등록
     *
     * @param array $texts 로케일 문자열 배열
     * @return void
     */
    public function setLocaleTexts(array $texts)
    {
        $this->texts = array_merge($this->texts, $texts);
    }

    /**
     * 로케일에 해당하는 문자열 반환, 지정된 로케일이 없을 경우 현재 지정된 로케일을 사용
     *
     * @param string $locale 선택 로케일
     * @return string
     */
    public function getLocaleText($locale = null)
    {
        if($locale === null) {
            $locale = $this->getLocale();
        }
        return isset($this->texts[$locale]) ? $this->texts[$locale] : $locale;
    }

    /**
     * 단위당 다국어 캐시를 그룹화 하기 위한 캐시 키를 지정
     *
     * 단위당 다국어 캐시(예를 들어, 한 웹 페이지)를 구룹화 하기 위한 캐시키를 지정.
     *
     * @param string $key 설정 키
     * @return void
     */
    public function setCurrentCacheKey($key)
    {
        $this->cachedDb->setCacheKey($key);
    }

    /**
     * 다국어를 번역합니다
     *
     * @param string $id         다국어 key
     * @param array  $parameters 인자
     * @param null   $domain     domain
     * @param null   $locale     locale
     * @return mixed
     */
    public function trans($id, array $parameters = array(), $domain = null, $locale = null)
    {
        $sentence = $this->get($id, $parameters, $locale);

        if ($sentence == $id) {
            return $this->makeUnknownSentence($id);
        }

        return $sentence;
    }

    /**
     * 언어가 없는 키가 표현될 문자를 생성합니다
     *
     * @param string $id 다국어 key
     * @return string
     */
    protected function makeUnknownSentence($id)
    {
        if (strpos($id, '::') === false) {
            return $id;
        }

        $userKeyHead = $this->userKeyPrefix . '::';
        if (substr($id, 0, strlen($userKeyHead)) == $userKeyHead) {
            return '';
        }

        $parts = explode('::', $id);
        $keyBody = array_pop($parts);
        $bodyParts = explode('.', $keyBody);

        return array_pop($bodyParts);
    }

    /**
     * 선택이 가능한 다국어를 번역합니다
     *
     * @param string $id         다국어 key
     * @param int    $number     숫자
     * @param array  $parameters 인자
     * @param null   $domain     domain
     * @param null   $locale     locale
     * @return mixed
     */
    public function transChoice($id, $number, array $parameters = array(), $domain = null, $locale = null)
    {
        $sentence = $this->choice($id, $number, $parameters, $locale);

        if ($sentence == $id) {
            return $number . ' ' . $this->makeUnknownSentence($id);
        }

        return $sentence;
    }

    /**
     * 다국어로 번역되기 전 원형 문장을 읽어옵니다
     *
     * @param string $key     다국어 key
     * @param array  $replace 변경 데이터
     * @param null   $locale  로케일
     * @return mixed
     */
    public function get($key, array $replace = [], $locale = null)
    {
        list($namespace, $item) = $this->parseKey($key);
        foreach ($this->parseLocale($locale) as $locale) {
            $line = $this->getLine($namespace, $item, $locale, $replace);
            if ($line) {
                break;
            }
        }
        if (!isset($line) || !$line) {
            return $key;
        }
        return $line;
    }

    /**
     * @param string $key     다국어 key
     * @param int    $number  숫자
     * @param array  $replace 변경 데이터
     * @param null   $locale  로케일
     * @return mixed
     */
    public function choice($key, $number, array $replace = [], $locale = null)
    {
        $line = $this->get($key, $replace, $locale = $locale ?: $this->getLocale());

        $replace['count'] = $number;

        return $this->makeReplacements($this->getSelector()->choose($line, $number, $locale), $replace);
    }

    /**
     * @param string $key 다국어 key
     * @return mixed
     */
    public function getOriginalLine($key)
    {
        list($namespace, $item) = $this->parseKey($key);
        return $this->cachedDb->getLine($namespace, $item, $this->getLocale());
    }

    /**
     * @param string $namespace Namespace
     * @param string $item      아이템
     * @param string $locale    로케일
     * @param array  $replace   변경 데이터
     * @return mixed
     */
    protected function getLine($namespace, $item, $locale, array $replace)
    {
        $line = $this->cachedDb->getLine($namespace, $item, $locale);

        return $this->makeReplacements($line, $replace);
    }

    /**
     * 인자를 넘겨 번역할 수 있는 다국어 라인을 번역합니다
     *
     * @param string $line    원시 라인
     * @param array  $replace 변경 데이터
     * @return mixed
     */
    protected function makeReplacements($line, array $replace)
    {
        $replace = $this->sortReplacements($replace);

        foreach ($replace as $key => $value) {
            $line = str_replace(':'.$key, $value, $line);
        }

        return $line;
    }

    /**
     * 인자를 넘겨 번역할 수 있는 다국어 처리 중 인자 이름이 더 긴 순으로 정렬합니다.
     *
     * 정렬을 통해 앞 부분이 같은 인자 중 좀 더 긴 글자로 매칭되는 인자를
     * 먼저 해석하여 정확도를 높여줍니다.
     *
     * @param array $replace 변경 데이터
     * @return array
     */
    protected function sortReplacements(array $replace)
    {
        return (new Collection($replace))->sortBy(function ($value, $key) {
            return mb_strlen($key) * -1;
        });
    }

    /**
     * 외부의 다국어 파일을 주어진 네임스페이스로 저장합니다
     *
     * @param string $namespace Namespace
     * @param string $source    소스
     * @param string $type      로더 타입
     * @return void
     */
    public function putFromLangDataSource($namespace, $source, $type = 'file')
    {
        $loader = null;
        switch ($type) {
            case 'file':
                $loader = $this->fileLoader;
                break;
            /*
            case 'url?':
                $loader = $this->urlLoader;
                break;
            */
            default:
                $loader = $this->fileLoader;
                break;
        }
        $langData = $loader->load($source);
        $this->cachedDb->putLangData($namespace, $langData);
    }

    /**
     * 주어진 로케일을 기반으로 fallback 처리를 위한 locales 목록을 리턴합니다
     *
     * @param string $locale 선택 로케일
     * @return array
     */
    protected function parseLocale($locale)
    {
        if (!is_null($locale)) {
            return array_values(array_filter(array_unique(array_merge([$locale], $this->locales))));
        }

        return array_values(array_filter(array_unique($this->locales)));
    }

    /**
     * 메세지 선택을 위한 셀렉터를 얻습니다
     *
     * @return MessageSelector
     */
    public function getSelector()
    {
        if (! isset($this->selector)) {
            $this->selector = new MessageSelector;
        }

        return $this->selector;
    }

    /**
     * 사용자 정의 다국어로 사용될 수 있는 키를 생성합니다
     *
     * @return string
     */
    public function genUserKey()
    {
        return $this->userKeyPrefix . '::' . $this->keyGen->generate();
    }

    /**
     * 다국어 라인을 저장합니다
     *
     * 캐시된 데이터 갱신을 위해 다국어 캐시를 비웁니다
     *
     * @param string  $key       다국어 키
     * @param string  $locale    로케일
     * @param string  $value     번역문
     * @param boolean $multiLine 멀티라인 지원 여부
     * @return void
     */
    public function save($key, $locale, $value, $multiLine = false)
    {
        list($namespace, $item) = $this->parseKey($key);

        $this->cachedDb->putLine($namespace, $item, $locale, $value, $multiLine);
    }

    /**
     * 미들웨어에서 생성된 다국어 참조 키를 분해하여 리턴합니다
     *
     * @param string $key LangPreprocessor 에서 생성한 키
     * @return array|null
     * @see App\Http\Middleware\LangPreprocessor
     */
    public function parsePreprocessor($key)
    {
        $protocol = $this->preprocessorProtocol;
        $len = strlen($protocol);

        if (starts_with($key, $protocol)) {
            $params = explode("/", substr($key, $len));
            array_shift($params);
            return !empty($params) ? $params : null;
        }

        return null;
    }

    /**
     * LangPreprocessor 로 만들어진 다국어 정보에서
     * 현재 설정에서 사용해야할 값들을 리턴합니다.
     *
     * @param array  $inputs        inputs
     * @param string $sessionLocale 세션 로케일 정보
     * @return array
     */
    public function getPreprocessorValues(array $inputs, $sessionLocale = null)
    {
        $names = [];
        $expressions = [];
        foreach ($inputs as $key => $value) {
            if ($params = $this->parsePreprocessor($key)) {
                list($kSeq, $seq, $command) = $params;
                if ($command == 'name') {
                    $names[$seq] = $value;
                }
                if ($command == 'locale') {
                    list($kSeq, $seq, $kLocale, $locale) = $params;
                    if ($locale == ($sessionLocale ?: $this->getLocale())) {
                        $expressions[$seq] = $value;
                    }
                }
            }
        }

        $values = [];
        foreach ($names as $seq => $name) {
            $values[$name] = $expressions[$seq];
        }

        return $values;
    }
}
