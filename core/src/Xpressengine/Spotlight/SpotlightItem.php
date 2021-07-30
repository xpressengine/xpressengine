<?php

namespace Xpressengine\Spotlight;

use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

class SpotlightItem implements Arrayable, JsonSerializable
{
    /** @var string */
    private $id;

    /** @var string */
    private $title;

    /** @var string */
    private $description;

    /** @var string */
    private $link;

    public static function make(array $inputs)
    {
        $required = ['id', 'title', 'link'];

        foreach ($required as $key)
        {
            if (is_null(array_get($inputs, $key))) {
                throw new \InvalidArgumentException(sprintf('Required value %s does not exist.', $key));
            }
        }

        return new self(
            array_get($inputs, 'id'),
            array_get($inputs, 'title'),
            array_get($inputs, 'description'),
            array_get($inputs, 'link')
        );
    }

    /**
     * @param $id
     * @param $title
     * @param $description
     * @param $link
     */
    public function __construct($id, $title, $description, $link)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->link = $link;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getLink()
    {
        return $this->link;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'link' => $this->link
        ];
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}