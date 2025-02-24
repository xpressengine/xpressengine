<?php

namespace Xpressengine\Category\Values;

/**
 * Class CategoryItemDynamicGroupKey
 *
 * @package Xpressengine\Category\Values
 */
final class DynamicGroupKey implements \Stringable
{
    private $categoryId;

    private $key;

    /**
     * @param int $categoryId
     */
    public function __construct(int $categoryId)
    {
        $this->categoryId = $categoryId;
        $this->key = implode('_', ['category_dynamic_group', $this->categoryId]);
    }

    /**
     * Creates a new instance from an ID.
     *
     * @param int $id
     * @return self
     */
    public static function fromId(int $id)
    {
        return new self($id);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->key;
    }

    /**
     * @return string[]
     */
    public function toProxyOption(): array
    {
        return [
            'group' => $this->__toString(),
        ];
    }
}
