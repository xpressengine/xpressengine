<?php
/**
 * This file is tag handler class
 *
 * PHP version 5
 *
 * @category    Tag
 * @package     Xpressengine\Tag
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Tag;

/**
 * # TagHandler
 * Tag 패키지는 등록, 삭제, 관련데이터 처리를 담당하고
 * 자동완성을 위한 기능이 제공됨.
 *
 * ### app binding : xe.tag 로 바인딩 되어 있음
 * `Tag` Facade 로 접근이 가능
 *
 * ### 등록 및 반환
 * ```php
 *  // 등록
 *  // 각각의 인스턴스를 구분하기위해 대상의 인스턴스 아이디가 전달되어야 합니다.
 *  Tag::set('instanceId', 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx', ['word1', 'word2', 'word3']);
 *  // 반환
 *  $tags = Tag::get('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx');
 * ```
 *
 * ### 자동 완성
 * 단어를 쉽게 완성할 수 있도록 기존에 등록된 단어중 입력중인 문자와 유사한 단어들을
 * 검색하여 반환해줍니다.
 * ```php
 *  $tags = Tag::autoCompletion('ap');
 *  // app, application, apm, append, apple ...
 * ```
 *
 * @category    Tag
 * @package     Xpressengine\Tag
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class TagHandler
{
    /**
     * Repository instance
     *
     * @var TagRepository
     */
    protected $repo;

    /**
     * Decomposer instance
     *
     * @var Decomposer
     */
    protected $decomposer;

    /**
     * Constructor
     *
     * @param TagRepository $repo       Repository instance
     * @param Decomposer    $decomposer Decomposer instance
     */
    public function __construct(TagRepository $repo, Decomposer $decomposer)
    {
        $this->repo = $repo;
        $this->decomposer = $decomposer;
    }

    /**
     * Set tag to target
     *
     * @param string $instanceId target belongs to instance's id
     * @param string $targetId   target id
     * @param array  $words      tag word list
     * @return void
     */
    public function set($instanceId, $targetId, array $words)
    {
        $olds = $this->get($targetId);

        $usedIds = [];
        foreach ($words as $word) {
            $tag = $this->make($instanceId, $word);
            $this->used($targetId, $tag);

            $usedIds[] = $tag->id;
        }

        foreach ($olds as $old) {
            if (in_array($old->id, $usedIds) === false) {
                $this->unused($targetId, $old);
            }
        }
    }

    /**
     * Get target's tags
     *
     * @param string $targetId target id
     * @return TagEntity[]
     */
    public function get($targetId)
    {
        return $this->repo->hasMany($targetId);
    }

    /**
     * Make word to tag
     *
     * @param string $instanceId instance id
     * @param string $word       tag word
     * @return TagEntity
     */
    protected function make($instanceId, $word)
    {
        if (!$tag = $this->repo->findByInstanceIdAndWord($instanceId, $word)) {
            $tag = $this->create($instanceId, $word);
        }

        return $tag;
    }

    /**
     * Create a new tag
     *
     * @param string $instanceId instance id
     * @param string $word       tag word
     * @return TagEntity
     */
    protected function create($instanceId, $word)
    {
        $tag = new TagEntity();
        $tag->instanceId = $instanceId;
        $tag->word = $word;
        $tag->decomposed = $this->decomposer->execute($word);

        return $this->repo->insert($tag);
    }

    /**
     * Set tag used
     *
     * @param string    $targetId target id
     * @param TagEntity $tag      tag object
     * @return void
     */
    protected function used($targetId, TagEntity $tag)
    {
        if ($this->repo->existsUsed($targetId, $tag) !== true) {
            $this->repo->insertUsed($targetId, $tag);

            $this->repo->increment($tag);
        }
    }

    /**
     * Unset tag used
     *
     * @param string    $targetId target id
     * @param TagEntity $tag      tag object
     * @return void
     */
    protected function unused($targetId, TagEntity $tag)
    {
        if ($this->repo->existsUsed($targetId, $tag) === true) {
            $this->repo->deleteUsed($targetId, $tag);

            $this->repo->decrement($tag);
        }
    }

    /**
     * Search tag for auto completion
     *
     * @param string      $string     unfinished word string
     * @param string|null $instanceId instance id
     * @param int         $take       take item count
     * @return TagEntity[]
     */
    public function autoCompletion($string, $instanceId = null, $take = 15)
    {
        return $this->repo->fetchSimilar($this->decomposer->execute($string), $instanceId, $take);
    }

    /**
     * Get popular tags
     *
     * @param string|null $instanceId instance id
     * @param string|null $since      since datetime
     * @param string|null $until      until datetime
     * @param int         $take       take item count
     * @return TagEntity[]
     */
    public function popular($instanceId, $since = null, $until = null, $take = 15)
    {
        return $this->repo->popular($instanceId, $since, $until, $take);
    }

    /**
     * Get several tags of popular
     *
     * @param string $instanceId instance id
     * @param int    $take       take item count
     * @return TagEntity[]
     */
    public function popularTake($instanceId, $take)
    {
        return $this->popular($instanceId, null, null, $take);
    }

    /**
     * Get popular tags in whole
     *
     * @param string|null $since since datetime
     * @param string|null $until until datetime
     * @param int         $take  take item count
     * @return TagEntity[]
     */
    public function popularWhole($since = null, $until = null, $take = 15)
    {
        return $this->popular(null, $since, $until, $take);
    }

    /**
     * Get several tags of popular in whole
     *
     * @param int $take take item count
     * @return TagEntity[]
     */
    public function popularWholeTake($take)
    {
        return $this->popularTake(null, $take);
    }

    /**
     * Get recently popular tags
     *
     * @param string $instanceId instance id
     * @param string $since      since datetime
     * @param int    $take       take item count
     * @return TagEntity[]
     */
    public function latestPopular($instanceId, $since, $take = 15)
    {
        return $this->popular($instanceId, $since, date('Y-m-d H:i:s'), $take);
    }

    /**
     * Get recently popular tags in whole
     *
     * @param string $since since datetime
     * @param int    $take  take item count
     * @return TagEntity[]
     */
    public function latestPopularWhole($since, $take = 15)
    {
        return $this->popularWhole($since, date('Y-m-d H:i:s'), $take);
    }

    /**
     * Count of used tag
     *
     * @param string      $instanceId instance id
     * @param string|null $word       search specific word
     * @param string|null $since      since datetime
     * @param string|null $until      until datetime
     * @return int
     */
    public function count($instanceId, $word = null, $since = null, $until = null)
    {
        return $this->repo->count($instanceId, $word, $since, $until);
    }

    /**
     * Count of used tag in whole
     *
     * @param string|null $word  search specific word
     * @param string|null $since since datetime
     * @param string|null $until until datetime
     * @return int
     */
    public function countWhole($word = null, $since = null, $until = null)
    {
        return $this->count(null, $word, $since, $until);
    }

    /**
     * Count of recently used tag
     *
     * @param string      $instanceId instance id
     * @param string      $since      since datetime
     * @param string|null $word       search specific word
     * @return int
     */
    public function latestCount($instanceId, $since, $word = null)
    {
        return $this->count($instanceId, $word, $since, date('Y-m-d H:i:s'));
    }

    /**
     * Count of recently used tag in whole
     *
     * @param string      $since since datetime
     * @param string|null $word  search specific word
     * @return int
     */
    public function latestCountWhole($since, $word = null)
    {
        return $this->latestCount(null, $since, $word);
    }

    /**
     * Specific word used target information
     *
     * return sample
     *   ['freeboard' => ['xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx', 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx']]
     *
     * @param string $word       specific word
     * @param string $instanceId instance id
     * @return array
     */
    public function getUsed($word, $instanceId = null)
    {
        return $this->repo->getUsed($word, $instanceId);
    }
}
