<?php
/**
 * Class Translation
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

namespace Xpressengine\Translation\Loaders;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use InvalidArgumentException;
use Xpressengine\Translation\LangData;

/**
 * LangData 클래스에 의해 해석될 수 있는 다국어 데이터 파일 로더
 *
 * @category    Translation
 * @package     Xpressengine\Translation
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class LangFileLoader implements LoaderInterface
{
    private $files;

    /**
     * LangFileLoader constructor.
     *
     * @param Filesystem $files 라라벨 파일 시스템
     */
    public function __construct(Filesystem $files)
    {
        $this->files = $files;
    }

    /**
     * Load the messages by a given source
     *
     * @param  string  $source  데이터 소스
     *
     * @return LangData
     *
     * @throws FileNotFoundException
     */
    public function load($source)
    {
        if (strtolower(pathinfo($source, PATHINFO_EXTENSION)) !== 'php' || !$this->files->isFile($source)) {
            throw new InvalidArgumentException(
                'Invalid language file.'
            );
        }

        $data = $this->files->getRequire($source);

        if (!is_array($data)) {
            throw new \UnexpectedValueException(
                'Language file must return an array.'
            );
        }

        $langData = new LangData();
        $langData->setData($data);
        return $langData;
    }
}
