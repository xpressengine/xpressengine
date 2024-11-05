<?php
/**
 * Translation.php
 *
 * PHP version 7
 *
 * @category    Translation
 * @package     Xpressengine\Translation
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Translation;

use Illuminate\Contracts\Translation\Translator as TranslatorContract;
use Illuminate\Support\Collection;
use Symfony\Component\Translation\MessageSelector;
use Xpressengine\Keygen\Keygen;
use Xpressengine\Translation\Exceptions\EmptyLocaleException;
use Xpressengine\Translation\Loaders\LoaderInterface;

/**
 * Class Translator
 * @category    Translation
 * @package     Xpressengine\Translation
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class Translator extends NamespacedItemResolver implements TranslatorContract
{
    /**
     * @var array
     */
    protected $locales = [];

    /**
     * @var array
     */
    protected $texts = [];

    /**
     * @var Keygen
     */
    protected $keyGen;

    /**
     * @var Repository
     */
    protected $repo;

    /**
     * @var LoaderInterface
     */
    protected $fileLoader;

    /**
     * @var LoaderInterface
     */
    protected $urlLoader;

    /**
     * @var string
     */
    protected $userKeyPrefix = 'user';

    /**
     * @var string
     */
    protected $preprocessorProtocol = 'xe_lang_preprocessor://';

    /**
     * @var array
     */
    protected static $aliases = [];

    /**
     * @param array           $config     설정
     * @param Keygen          $keyGen     사용자 정의 다국어용 키 생성기
     * @param Repository      $repo       다국어 저장소
     * @param LoaderInterface $fileLoader 다국어 파일 로더
     * @param LoaderInterface $urlLoader  다국어 URL 로더
     */
    public function __construct(
        $config,
        Keygen $keyGen,
        Repository $repo,
        LoaderInterface $fileLoader,
        LoaderInterface $urlLoader
    ) {
        $this->setLocales($config['locales']);
        $this->setLocaleTexts($config['localeTexts']);
        $this->keyGen = $keyGen;
        $this->repo = $repo;
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
     * 로케일에 해당하는 문자열 반환
     * 지정된 로케일이 없을 경우 현재 지정된 로케일을 사용
     *
     * @param string $locale 선택 로케일
     * @return string
     */
    public function getLocaleText($locale = null)
    {
        if ($locale === null) {
            $locale = $this->getLocale();
        }
        return isset($this->texts[$locale]) ? $this->texts[$locale] : $locale;
    }

    /**
     * 다국어를 번역합니다
     *
     * @param  string  $key
     * @param  array  $replace
     * @param  string|null  $locale  locale
     * @return mixed
     */
    public function trans($key, array $replace = [], $locale = null)
    {
        return $this->get($key, $replace, $locale);
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

        if (strpos($id, $userKeyHead) === 0) {
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
     * @param  string  $key
     * @param  Countable|int|array    $number     숫자
     * @param  array   $replace
     * @param null   $locale     locale
     * @return string
     */
    public function transChoice($key, $number, array $replace = [], $locale = null)
    {
        return $this->choice($key, $number, $replace, $locale);
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
        [$namespace, $item] = $this->parseKey($key);

        foreach ($this->parseLocale($locale) as $locale) {
            $line = $this->getLine($namespace, $item, $locale, $replace);
            if ($line) {
                break;
            }
        }

        if (!isset($line) || !$line) {
            return $this->makeUnknownSentence($key);
        }

        return $line;
    }

    /**
     * @param string $key     다국어 key
     * @param Countable|int|array    $number  숫자
     * @param array  $replace 변경 데이터
     * @param null   $locale  로케일
     * @return mixed
     */
    public function choice($key, $number, array $replace = [], $locale = null)
    {
        $line = $this->get($key, $replace, $locale = $locale ?: $this->getLocale());

        // @see \Illuminate\Translation\Translator@choice
        if (is_array($number) || $number instanceof Countable) {
            $number = count($number);
        }

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
        return $this->repo->getLine($namespace, $item, $this->getLocale());
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
        $namespace = $this->getOriginNamespace($namespace);
        $line = $this->repo->getLine($namespace, $item, $locale);

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
            if ($value instanceof self) {
                continue;
            }

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
     * @return array|Collection
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
     * @param bool   $force     force update
     * @param string $type      로더 타입
     * @return void
     */
    public function putFromLangDataSource($namespace, $source, $force = false, $type = 'file')
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

        $this->putLangData($namespace, $loader->load($source), $force);
    }

    /**
     * language data 를 주어진 네임스페이스로 저장합니다
     *
     * @param string   $namespace namespace
     * @param LangData $langData  LangData instance
     * @param bool     $force     force update
     * @return void
     */
    public function putLangData($namespace, LangData $langData, $force = false)
    {
        $this->repo->putLangData($namespace, $langData, $force);
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

        $this->repo->putLine($namespace, $item, $locale, $value, $multiLine, true);
    }

    /**
     * 미들웨어에서 생성된 다국어 참조 키를 분해하여 리턴합니다
     *
     * @param string $key LangPreprocessor 에서 생성한 키
     * @return array|null
     * @see \App\Http\Middleware\LangPreprocessor
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

    /**
     * alias namespace 를 등록합니다
     *
     * @param string $origin origin namespace
     * @param string $alias  alias namespace
     * @return void
     */
    public static function alias($origin, $alias)
    {
        static::$aliases[$alias] = $origin;
    }

    /**
     * 주어진 namespace 의 원래 이름을 반환합니다
     *
     * @param string $namespace namespace
     * @return string
     */
    protected function getOriginNamespace($namespace)
    {
        return isset(static::$aliases[$namespace]) ? static::$aliases[$namespace] : $namespace;
    }

    /**
     * Import laravel language data
     *
     * @param string $path  lang path
     * @param bool   $force force update
     * @return void
     */
    public function importLaravel($path, $force = false)
    {
        $dir = dir($path);
        $langData = new LaravelLangData();
        while ($entry = $dir->read()) {
            if (in_array($entry, ['vendor', '.', '..']) || !is_dir($path . DIRECTORY_SEPARATOR . $entry)) {
                continue;
            }

            $langData->setLocale($entry);
            $data = [];

            $localePath = $path . DIRECTORY_SEPARATOR . $entry;
            $localeDir = dir($localePath);
            while ($groupFile = $localeDir->read()) {
                $pathname = $localePath . DIRECTORY_SEPARATOR . $groupFile;
                if (is_dir($pathname) || !preg_match('#\.(php)$#i', $groupFile)) {
                    continue;
                }
                $group = substr($groupFile, 0, -4);

                $data[$group] = require $pathname;
            }

            $langData->setData($data);
        }

        $this->putLangData($this->getLaravelNamespace(), $langData, $force);
    }

    /**
     * @return string
     */
    public function getUserNamespace()
    {
        return $this->userKeyPrefix;
    }
}
