<?php
/**
 * This file is management Media package
 *
 * PHP version 5
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Media;

use Xpressengine\Media\Coordinators\Dimension;
use Xpressengine\Media\Exceptions\NotAvailableException;
use Xpressengine\Media\Exceptions\UnknownTypeException;
use Xpressengine\Media\Spec\Media;
use Xpressengine\Media\Spec\Image;
use Xpressengine\Storage\File;
use Xpressengine\Media\Handlers\AbstractHandler;

/**
 * # MediaManager
 * 미디어파일(이미지, 동영상) 형식에 맞는 handler 를 연결해주고
 * 섬네일 생성 및 제공 등의 역할을 수행 함
 *
 * ### app binding : xe.media 으로 바인딩 되어 있음
 * `Media` Facade 로 접근이 가능
 *
 * ### 미디어 파일 확인 및 캐스팅
 * ```php
 * if (Media::is($file)) {
 *      $media = Media::make($file);
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
 * $thumbnails = Media::createThumbnails($file, 'letter');
 * ```
 *
 * 두번째 인자로 타입을 전달하지 않으면
 * config 에 설정된 타입으로 생성
 * > `crop` 의 경우 별도의 좌표가 필요하기 때문에
 * 자동 섬네일 생성 사용에 추천되지 않음
 *
 * ### 원본 미디어를 통한 섬네일 반환
 * ```php
 * $thumbnails = Media::getThumbnails($media);
 * ```
 *
 * ### 미디어의 url
 * 미디어 객채의 url 은 Storage 의 UrlMaker 를 통해 제공됨
 * 이때 filesystem config 의 각 저장소별 설정에서 url 항목이
 * 작성되어진 경우 해당 항목을 이용해 직접 저장소의 파일에 접근할 수
 * 있는 url 을 제공하고 그렇지 않은경우 내부 시스템을 통해 제공되는
 * url 을 제공함
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class MediaManager
{
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
     * @param CommandFactory $factory CommandFactory instance
     * @param array          $config  config data
     */
    public function __construct(CommandFactory $factory, array $config)
    {
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
            if ($handler->isAvailable($file->getMime()) === true) {
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
        foreach ($this->handlers as $handler) {
            if ($handler->isAvailable($file->getMime()) === true) {
                return $handler->make($file);
            }
        }

        throw new NotAvailableException();
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
            if ($handler->isAvailable($file->getMime()) === true) {
                return true;
            }
        }

        return false;
    }

    /**
     * 미디어 삭제
     *
     * @param Media $media media instance
     * @return void
     */
    public function remove(Media $media)
    {
        $this->getHandlerByMedia($media)->remove($media);
    }

    /**
     * 섬네일 생성
     *
     * @param Media       $media media instance
     * @param string|null $type  섬네일 생성 방식
     * @return Image[]
     */
    public function createThumbnails(Media $media, $type = null)
    {
        $type = strtolower($type ?: $this->config['type']);
        $handler = $this->getHandlerByMedia($media);

        if (!$content = $handler->getPicture($media)) {
            return [];
        }

        $thumbnails = [];
        foreach ($this->config['dimensions'] as $code => $dimension) {
            $command = $this->factory->make($type);
            $command->setDimension(new Dimension($dimension['width'], $dimension['height']));

            $thumbnails[] = $this->getHandler(Media::TYPE_IMAGE)
                ->createThumbnails(
                    $content,
                    $command,
                    $code,
                    $this->config['disk'],
                    $this->config['path'],
                    $media->getFile()->getOriginId()
                );

        }

        return $thumbnails;
    }

    /**
     * Get a thumbnail image
     *
     * @param Media  $media       media instance
     * @param string $type        thumbnail make type
     * @param string $dimension   dimension code
     * @param bool   $defaultSelf if set true, returns self when thumbnail not exists
     * @return null|Image|Media
     */
    public function getThumbnail(Media $media, $type, $dimension, $defaultSelf = true)
    {
        return $this->getHandler(Media::TYPE_IMAGE)->getThumbnail($media, $type, $dimension, $defaultSelf);
    }

    /**
     * Get thumbnails
     *
     * @param Media       $media media instance
     * @param null|string $type  thumbnail make type
     * @return Image[]
     */
    public function getThumbnails(Media $media, $type = null)
    {
        return $this->getHandler(Media::TYPE_IMAGE)->getThumbnails($media, $type);
    }

    /**
     * 미디어 핸들러를 추가, 변경하여 기능 확장
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
