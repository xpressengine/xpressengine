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

use Illuminate\Support\Collection;
use XeDB;

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
        return XeDB::transaction(
            function () use ($taggableId, $words, $instanceId) {
                $words = array_values(
                    array_unique($words)
                );

                $tagQuery = $this->repo->query()->where('instance_id', '=', $instanceId);

                $tags = collect();

                if (filled($words)) {
                    $placeholders = implode(', ', array_fill(0, count($words), '?'));

                    $tags = $tagQuery
                        ->whereRaw(sprintf('BINARY `word` IN (%s)', $placeholders), $words)
                        ->get();
                }

                $registeredWords = $tags->pluck('word')->all();
                $unregisteredWords = array_diff($words, $registeredWords);

                foreach ($unregisteredWords as $word) {
                    $tags->push($this->repo->create([
                        'word' => $word,
                        'decomposed' => $this->decomposer->execute($word),
                        'instance_id' => $instanceId,
                    ]));
                }

                $tags = $this->multisort(
                    $words,
                    $tags->all()
                );

                $this->repo->sync(
                    $taggableId,
                    $tags
                );

                return $this->repo->newCollection($tags);
            }
        );
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
