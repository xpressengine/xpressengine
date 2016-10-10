<?php
/**
 * This file is tag handler class
 *
 * PHP version 5
 *
 * @category    Tag
 * @package     Xpressengine\Tag
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Tag;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;

/**
 * # TagHandler
 * Tag 패키지는 등록, 삭제, 관련데이터 처리를 담당하고
 * 자동완성을 위한 기능이 제공됨.
 *
 * ### app binding : xe.tag 로 바인딩 되어 있음
 * `XeTag` Facade 로 접근이 가능
 *
 * ### 등록 및 반환
 * ```php
 *  // 등록
 *  XeTag::set('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx', ['word1', 'word2', 'word3']);
 *  // 각각의 인스턴스를 구분하고자 하는 경우 위해 대상의 인스턴스 아이디를 전달하면 됩니다.
 *  XeTag::set('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx', ['word1', 'word2', 'word3'], '인스턴스 아이디');
 *  // 반환
 *  $tags = Tag::getByTaggable('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx');
 * ```
 *
 * ### 자동 완성
 * 단어를 쉽게 완성할 수 있도록 기존에 등록된 단어중 입력중인 문자와 유사한 단어들을
 * 검색하여 반환해줍니다.
 * ```php
 *  $tags = XeTag::similar('ap');
 *  // result: app, application, apm, append, apple ...
 *  특정 인스턴스에서만 검색하고자 하는 경우 인스턴스 아이디를 인자로 넘겨주면 됩니다.
 *  $tags = XeTag::similar('ap', 10, '인스턴스 아이디');
 * ```
 *
 * ### 인기태그
 * 어떤 태그가 많이 사용되는지 알수 있습니다.
 * ```php
 *  // 전체
 *  $tags = Tag::getPopular();
 *  // 기간별
 *  $tags = Tag::getPopularPeriod('시작일', '종료일');
 * ```
 *
 * @category    Tag
 * @package     Xpressengine\Tag
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class TagHandler
{
    /**
     * Decomposer instance
     *
     * @var Decomposer
     */
    protected $decomposer;

    /**
     * Tag model
     *
     * @var string
     */
    protected $model = Tag::class;

    /**
     * TagHandler constructor.
     *
     * @param Decomposer $decomposer Decomposer instance
     */
    public function __construct(Decomposer $decomposer)
    {
        $this->decomposer = $decomposer;
    }

    /**
     * Set taggable's tags
     *
     * @param string      $taggableId taggable id
     * @param array       $words      tag word
     * @param string|null $instanceId instance id of taggable
     * @return Collection model collection
     */
    public function set($taggableId, array $words, $instanceId = null)
    {
        $words = array_unique($words);
        
        $model = $this->createModel();
        $tags = $model->newQuery()->where('instanceId', $instanceId)->whereIn('word', $words)->get();

        // 등록되지 않은 단어가 있다면 등록 함
        foreach (array_diff($words, $tags->pluck('word')->all()) as $word) {
            $tag = $model::create([
                'word' => $word,
                'decomposed' => $this->decomposer->execute($word),
                'instanceId' => $instanceId,
            ]);

            $tags->push($tag);
        }

        // 넘겨준 태그와 대상 아이디를 연결
        $tags = $this->multisort($words, $tags->all());
        $this->attach($taggableId, $tags);

        // 이전에 대상 아이디에 연결된 태그중
        // 전달된 단어 해당하는 태그가 없는경우 연결 해제 처리
        $olds = $model::getByTaggable($taggableId);
        $removes = $olds->diff($tags);

        $this->detach($taggableId, $removes);

        return $model->newCollection($tags);
    }

    /**
     * Sort tags by given words
     *
     * @param array $std  standard array for sort
     * @param array $tags tags array
     * @return array
     */
    private function multisort($std, $tags)
    {
        $std = array_values($std);

        $words = [];
        foreach ($tags as $tag) {
            $words[] = $tag->word;
        }
        $index = array_merge(array_flip($words), array_flip($std));
        array_multisort($index, $tags);

        return $tags;
    }

    /**
     * Attach tag to taggable
     *
     * @param string             $taggableId taggable id
     * @param \ArrayAccess|array $tags       tag instances
     * @return void
     */
    protected function attach($taggableId, $tags)
    {
        $position = 0;
        /** @var Tag $tag */
        foreach ($tags as $tag) {
            $conn = $tag->getConnection();
            try {
                // 대상아이디와 태그 아이템 아이디가 unique 키로 설정되어
                // 존재 유무와 상관없이 insert 시도 함
                // duplicate error 무시
                $conn->table($tag->getTaggableTable())->insert([
                    'tagId' => $tag->getKey(),
                    'taggableId' => $taggableId,
                    'position' => $position,
                    'createdAt' => Carbon::now()
                ]);

                $tag->increment('count');
            } catch (QueryException $e) {
                if ($e->getCode() != "23000") {
                    throw $e;
                }

                $conn->table($tag->getTaggableTable())
                    ->where('tagId', $tag->getKey())
                    ->where('taggableId', $taggableId)
                    ->update(['position' => $position]);
            }

            $position++;
        }
    }

    /**
     * Detach tag to taggable
     *
     * @param string             $taggableId taggable id
     * @param \ArrayAccess|array $tags       tag instances
     * @return void
     */
    protected function detach($taggableId, $tags)
    {
        /** @var Tag $tag */
        foreach ($tags as $tag) {
            $tag->getConnection()->table($tag->getTaggableTable())
                ->where('tagId', $tag->getKey())
                ->where('taggableId', $taggableId)
                ->delete();

            $tag->decrement('count');
        }
    }

    /**
     * Search similar tags by given string
     *
     * @param string      $string     partial of word
     * @param int         $take       take count
     * @param string|null $instanceId instance id of taggable
     * @return Collection|static[]
     */
    public function similar($string, $take = 15, $instanceId = null)
    {
        $model = $this->createModel();

        $query = $model->newQuery()->where('decomposed', 'like', $this->decomposer->execute($string) . '%')
            ->orderBy('count', 'desc')
            ->take($take);

        if ($instanceId) {
            $query->where('instanceId', $instanceId);
        }

        return $query->get();
    }

    /**
     * Search similar words by given string
     *
     * @param string      $string     partial of word
     * @param int         $take       take count
     * @param string|null $instanceId instance id of taggable
     * @return array
     */
    public function similarWord($string, $take = 15, $instanceId = null)
    {
        $tags = $this->similar($string, $take, $instanceId);

        return array_unique($tags->pluck('word')->all());
    }

    /**
     * Create tag model
     *
     * @return Tag
     */
    public function createModel()
    {
        return new $this->model;
    }

    /**
     * Returns tag model
     *
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set tag model
     *
     * @param string $model model class
     * @return $this
     */
    public function setModel($model)
    {
        $this->model = '\\' . ltrim($model, '\\');

        return $this;
    }
}
