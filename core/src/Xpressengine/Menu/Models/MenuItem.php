<?php
/**
 * MenuItem
 *
 * PHP version 5
 *
 * @category  Menu
 * @package   Xpressengine\Menu
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Menu\Models;

use Closure;
use Xpressengine\Category\Models\CategoryItem;
use Xpressengine\Media\Models\Image;
use Xpressengine\Routing\InstanceRoute;

/**
 * Class MenuItem
 *
 * @category  Menu
 * @package   Xpressengine\Menu
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 *
 * @property string $id          자동 생성된 고유한 식별자
 * @property string $menu_id     소속된 MenuEntity 의 ID
 * @property string $parent_id    부모의 ID
 * @property string $url         해당 메뉴의 URL
 * @property string $pre_title    UI 에서 출력을 위해서 사용되는 property title 출력전에 추가
 * @property string $title       사용자에게 보여지는 이름
 * @property string $post_title   UI 에서 출력을 위해서 사용되는 property title 출력후에 추가
 * @property string $description 설명
 * @property string $target      링크의 클릭시 옵션
 * @property bool   $activated   활성/비활성 유무
 * @property string $type        해당 메뉴의 type
 * @property int    $ordering    정렬을 위한 순서
 * @property Menu   $menu        객체가 속한 메뉴
 */
class MenuItem extends CategoryItem
{

    /**
     * @var Closure
     */
    protected static $linkResolver = null;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'menu_item';

    /**
     * The hierarchy table associated with the model.
     *
     * @var string
     */
    protected $closureTable = 'menu_closure';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'menu_id', 'parent_id', 'title', 'url', 'description', 'target', 'type' , 'ordering', 'activated',
        'basic_image_id', 'hover_image_id', 'selected_image_id', 'm_basic_image_id', 'm_hover_image_id', 'm_selected_image_id',
    ];

    /**
     * Indicates if the model selected.
     *
     * @var bool
     */
    protected $selected = false;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'activated' => 'integer',
    ];

    /**
     * todo: see CategoryItem class
     *
     * @var string
     */
    protected static $aggregator = Menu::class;

    /**
     * Alias aggregator
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function menu()
    {
        return $this->aggregator();
    }

    /**
     * Instance route relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function route()
    {
        return $this->hasOne(InstanceRoute::class, 'instance_id');
    }

    /**
     * Basic link image relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function basicImage()
    {
        return $this->belongsTo(Image::class, 'basic_image_id');
    }

    /**
     * Hover link image relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hoverImage()
    {
        return $this->belongsTo(Image::class, 'hover_image_id');
    }

    /**
     * Selected link image relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function selectedImage()
    {
        return $this->belongsTo(Image::class, 'selected_image_id');
    }

    /**
     * Get hover link image of model
     *
     * @return Image|null
     */
    public function getHoverImage()
    {
        if (!$this->getAttribute('hover_image_id')) {
            return $this->getRelationValue('basicImage');
        }

        return $this->getRelationValue('hoverImage');
    }

    /**
     * Get selected link image of model
     *
     * @return Image|null
     */
    public function getSelectedImage()
    {
        if (!$this->getAttribute('selected_image_id')) {
            return $this->getHoverImage();
        }

        return $this->getRelationValue('selectedImage');
    }

    /**
     * Mobile basic link image relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mBasicImage()
    {
        return $this->belongsTo(Image::class, 'm_basic_image_id');
    }

    /**
     * Mobile hover link image relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mHoverImage()
    {
        return $this->belongsTo(Image::class, 'm_hover_image_id');
    }

    /**
     * Mobile selected link image relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mSelectedImage()
    {
        return $this->belongsTo(Image::class, 'm_selected_image_id');
    }

    /**
     * Get mobile basic link image of model
     *
     * @return Image|null
     */
    public function getMBasicImage()
    {
        if (!$this->getAttribute('m_basic_image_id')) {
            return $this->getRelationValue('basicImage');
        }

        return $this->getRelationValue('mBasicImage');
    }

    /**
     * Get mobile hover link image of model
     *
     * @return Image|null
     */
    public function getMHoverImage()
    {
        if (!$this->getAttribute('m_hover_image_id')) {
            return $this->getMBasicImage();
        }

        return $this->getRelationValue('mHoverImage');
    }

    /**
     * Get mobile selected link image of model
     *
     * @return Image|null
     */
    public function getMSelectedImage()
    {
        if (!$this->getAttribute('m_selected_image_id')) {
            return $this->getMHoverImage();
        }

        return $this->getRelationValue('mSelectedImage');
    }

    /**
     * Get a children collection of model
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getChildren()
    {
        $rfc = new \ReflectionClass($this);
        $method = $rfc->getParentClass()->getParentClass()->getMethod('getChildren');

        return $method->invoke($this);
    }

    /**
     * Get the aggregator key name for model
     *
     * @return string
     */
    public function getAggregatorKeyName()
    {
        return 'menu_id';
    }

    /**
     * Set model selected
     *
     * @param bool $bool boolean value
     * @return void
     */
    public function setSelected($bool = true)
    {
        $this->selected = $bool;

        if ($this->parent) {
            $this->parent->setSelected($bool);
        }
    }

    /**
     * Determine if model is selected
     *
     * @return bool
     */
    public function isSelected()
    {
        return $this->selected === true;
    }

    /**
     * Convert the model instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return array_merge(parent::toArray(), [
            'items' => $this->getChildren(),
        ]);
    }

    /**
     * Set the link resolver callback
     *
     * @param Closure $callback resolver callback
     * @return void
     */
    public static function setLinkResolver(Closure $callback)
    {
        static::$linkResolver = $callback;
    }

    /**
     * Get link attribute
     *
     * @return string
     */
    public function getLinkAttribute()
    {
        $callback = static::$linkResolver;
        return $callback($this);
    }
}
