<?php
/**
 * This file is management Media package
 *
 * PHP version 5
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Media;

use Illuminate\Database\Eloquent\Collection;
use Xpressengine\Media\Coordinators\Dimension;
use Xpressengine\Media\Exceptions\NotAvailableException;
use Xpressengine\Media\Exceptions\UnknownTypeException;
use Xpressengine\Media\Models\Media;
use Xpressengine\Media\Models\Image;
use Xpressengine\Storage\File;
use Xpressengine\Media\Handlers\AbstractHandler;
use Xpressengine\Storage\Storage;

/**
 * # MediaManager
 * 미디어파일(이미지, 동영상) 형식에 맞는 handler 를 연결해주고
 * 섬네일 생성 및 제공 등의 역할을 수행 함
 *
 * ### app binding : xe.media 으로 바인딩 되어 있음
 * `XeMedia` Facade 로 접근이 가능
 *
 * ### 미디어 파일 확인 및 캐스팅
 * ```php
 * if (XeMedia::is($file)) {
 *      $media = XeMedia::make($file);
 * }
 * ```
 *
 * ### 섬네일 생성
 * * 지원되는 섬네일 생성 타입
 *  - `fit` : 지정된 사이즈에 꽉차고 넘치는 영역은 무시
 *  - `letter` : 지정된 사이즈안에 이미지가 모두 들어가도록 생성
 *  - `widen` : 가로 기준으로 생성
 *  - `heighten` : 세로 기준으로 생성
 *  - `stretch` : 비율을 무시하고 지정된 사이즈로 변경
 *  - `spill` : 지정된 사이즈에 꽉차고 넘치는 영역을 보존
 *  - `crop` : 지정된 좌표로부터 지정된 사이즈만큼 잘라냄
 *
 * ```php
 * $thumbnails = XeMedia::createThumbnails($file, 'letter');
 * ```
 *
 * 두번째 인자로 타입을 전달하지 않으면
 * config 에 설정된 타입으로 생성
 * > `crop` 의 경우 별도의 좌표가 필요하기 때문에
 * 자동 섬네일 생성 사용에 추천되지 않음
 *
 * ### 원본 미디어를 통한 섬네일 반환
 * ```php
 * $thumbnails = Image::getThumbnails($media);
 * ```
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class MediaManager
{
    /**
     * Storage instance
     *
     * @var Storage
     */
    protected $storage;

    /**
     * CommandFactory instance
     *
     * @var CommandFactory
     */
    protected $factory;

    /**
     * config data
     *
     * @var array
     */
    protected $config = [];

    /**
     * media handlers
     *
     * @var AbstractHandler[]
     */
    protected $handlers = [];

    /**
     * Constructor
     *
     * @param Storage        $storage Storage instance
     * @param CommandFactory $factory CommandFactory instance
     * @param array          $config  config data
     */
    public function __construct(Storage $storage, CommandFactory $factory, array $config)
    {
        $this->storage = $storage;
        $this->factory = $factory;
        $this->config = $config;
    }

    /**
     * Returns handler
     *
     * @param string $type media type
     * @return AbstractHandler
     * @throws UnknownTypeException
     */
    public function getHandler($type)
    {
        if (isset($this->handlers[$type]) !== true) {
            throw new UnknownTypeException();
        }

        return $this->handlers[$type];
    }

    /**
     * Returns handler by storage File instance
     *
     * @param File $file file instance
     * @return AbstractHandler
     * @throws UnknownTypeException
     */
    public function getHandlerByFile(File $file)
    {
        if (!$type = $this->getFileType($file)) {
            throw new UnknownTypeException();
        }

        return $this->getHandler($type);
    }

    /**
     * 파일이 특정 미디어 타입과 매칭된다며 해당 타입 반환
     *
     * @param File $file file instance
     * @return string|null
     */
    public function getFileType(File $file)
    {
        foreach ($this->handlers as $type => $handler) {
            if ($handler->isAvailable($file->mime) === true) {
                return $type;
            }
        }

        return null;
    }

    /**
     * Returns handler by storage Media instance
     *
     * @param Media $media media instance
     * @return AbstractHandler
     */
    public function getHandlerByMedia(Media $media)
    {
        return $this->getHandler($media->getType());
    }

    /**
     * 파일을 타입에 맞는 미디어 객체로 재생성하여 반환
     *
     * @param File $file file instance
     * @return Media
     * @throws NotAvailableException
     */
    public function make(File $file)
    {
        return $this->getHandlerByFile($file)->make($file);
    }

    /**
     * 파일을 미디어 타입으로 변환, 메타데이터는 생성하지 않음
     *
     * @param File $file file instance
     * @return Media
     */
    public function cast(File $file)
    {
        return $this->getHandlerByFile($file)->createModel($file);
    }

    /**
     * 파일이 미디어 파일인지 확인
     *
     * @param File $file file instance
     * @return bool
     */
    public function is(File $file)
    {
        foreach ($this->handlers as $type => $handler) {
            if ($handler->isAvailable($file->mime) === true) {
                return true;
            }
        }

        return false;
    }

    /**
     * 미디어 삭제
     *
     * @param Media $media media instance
     * @return bool
     */
    public function remove(Media $media)
    {
        $this->metaRemove($media);

        return $this->storage->remove($media);
    }

    /**
     * Meta data 삭제
     *
     * @param Media $media media instance
     * @return void
     */
    public function metaRemove(Media $media)
    {
        if ($media->meta) {
            $media->meta->delete();
        }
    }

    /**
     * 섬네일 생성
     *
     * @param Media       $media      media instance
     * @param string|null $type       섬네일 생성 방식
     * @param array|null  $dimensions 섬네일 크기
     * @return Collection|Image[]
     */
    public function createThumbnails(Media $media, $type = null, array $dimensions = null)
    {
        $type = strtolower($type ?: $this->config['type']);
        $dimensions = $dimensions ?: $this->config['dimensions'];
        $handler = $this->getHandlerByMedia($media);

        if (!$content = $handler->getPicture($media)) {
            return [];
        }

        $thumbnails = [];
        foreach ($dimensions as $code => $dimension) {
            $command = $this->factory->make($type);
            $command->setDimension(new Dimension($dimension['width'], $dimension['height']));

            $thumbnails[] = $this->getHandler(Media::TYPE_IMAGE)
                ->createThumbnails(
                    $content,
                    $command,
                    $code,
                    $this->config['disk'],
                    $this->config['path'],
                    $media->getOriginKey()
                );

        }

        return new Collection($thumbnails);
    }

    /**
     * 동적으로 생성된 미디어 파일 반환
     *
     * @param Media $media media instance
     * @return Collection|Media[]
     */
    public function getDerives(Media $media)
    {
        $files = $media->getRawDerives();

        foreach ($files as $key => $file) {
            $files[$key] = $this->is($file) ? $this->make($file) : null;
        }

        return $files->filter();
    }

    /**
     * 미디어 핸들러를 추가, 변경하여 기능 확장
     *
     * is() method 를 통해 파일이 미디어 인지 판별할 수 있어야 하므로
     * 각각의 handler 들은 활성화된 상태로 전달 받도록 함
     *
     * @param string          $type    media type
     * @param AbstractHandler $handler media handler
     * @return void
     */
    public function extend($type, AbstractHandler $handler)
    {
        $this->handlers[$type] = $handler;
    }
}
