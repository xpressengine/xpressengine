<?php
/**
 * This file is tag handler class
 *
 * PHP version 7
 *
 * @category    Tag
 * @package     Xpressengine\Tag
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Tag;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;

/**
 * Class TagHandler
 *
 * @category    Tag
 * @package     Xpressengine\Tag
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class TagHandler
{
    /**
     * TagRepository instance
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
     * TagHandler constructor.
     *
     * @param TagRepository $repo       TagRepository instance
     * @param Decomposer    $decomposer Decomposer instance
     */
    public function __construct(TagRepository $repo, Decomposer $decomposer)
    {
        $this->repo = $repo;
        $this->decomposer = $decomposer;
    }

    /**
     * Set taggable's tags
     *
     * @param string      $taggableId taggable id
     * @param array       $words      tag word
     * @param string|null $instanceId instance id of taggable
     * @return Collection|Tag[] model collection
     */
    public function set($taggableId, array $words = [], $instanceId = null)
    {
        $words = array_unique($words);

        $whereInWords = array_map(static function (string $word) {
            return \DB::raw("binary '$word'");
        }, $words);
        
        $tags = $this->repo->query()
             ->where('instance_id', $instanceId)
             ->whereIn('word', $whereInWords)
             ->get();

        // 등록되지 않은 단어가 있다면 등록 함
        foreach (array_diff($words, $tags->pluck('word')->all()) as $word) {
            $tag = $this->repo->create([
                'word' => $word,
                'decomposed' => $this->decomposer->execute($word),
                'instance_id' => $instanceId,
            ]);

            $tags->push($tag);
        }

        // 넘겨준 태그와 대상 아이디를 연결
        $tags = $this->multisort($words, $tags->all());
        $this->repo->attach($taggableId, $tags);

        // 이전에 대상 아이디에 연결된 태그중
        // 전달된 단어 해당하는 태그가 없는경우 연결 해제 처리
        $olds = $this->repo->fetchByTaggable($taggableId);
        $removes = $olds->diff($tags);

        $this->repo->detach($taggableId, $removes);

        return $this->repo->newCollection($tags);
    }

    /**
     * Sort tags by given words
     *
     * @param array $std  standard array for sort
     * @param Tag[] $tags tags array
     * @return Tag[]
     */
    private function multisort($std, $tags)
    {
        $std = array_map([$this, 'nonNumeric'], array_values($std));
        $words = array_map(function ($tag) {
            return $this->nonNumeric($tag->word);
        }, $tags);

        $index = array_merge(array_flip($words), array_flip($std));
        array_multisort($index, $tags);

        return $tags;
    }

    /**
     * Convert to non numeric string
     *
     * @param string|int $v string
     * @return string
     */
    private function nonNumeric($v)
    {
        return is_numeric($v) ? '_'.$v : $v;
    }

    /**
     * Search similar tags by given string
     *
     * @param string      $string     partial of word
     * @param int         $take       take count
     * @param string|null $instanceId instance id of taggable
     * @return Collection|Tag[]
     */
    public function similar($string, $take = 15, $instanceId = null)
    {
        return $this->repo->fetchSimilar($this->decomposer->execute($string), $take, $instanceId);
    }

    /**
     * Search similar words by given string
     *
     * @param string      $string     partial of word
     * @param int         $take       take count
     * @param string|null $instanceId instance id of taggable
     * @return string[]
     */
    public function similarWord($string, $take = 15, $instanceId = null)
    {
        $tags = $this->similar($string, $take, $instanceId);

        return array_unique($tags->pluck('word')->all());
    }

    /**
     * Get the decomposer instance.
     *
     * @return Decomposer
     */
    public function getDecomposer()
    {
        return $this->decomposer;
    }

    /**
     * Set the decomposer instance.
     *
     * @param Decomposer $decomposer decomposer instance
     * @return void
     */
    public function setDecomposer(Decomposer $decomposer)
    {
        $this->decomposer = $decomposer;
    }

    /**
     * __call
     *
     * @param string $name      method name
     * @param array  $arguments arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->repo, $name], $arguments);
    }
}
