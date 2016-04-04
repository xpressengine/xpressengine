<?php
/**
 * MenuItem
 *
 * PHP version 5
 *
 * @category  Menu
 * @package   Xpressengine\Menu
 * @author    XE Team (developers) <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      http://www.xpressengine.com
 */
namespace Xpressengine\Menu\Models;

use Illuminate\Database\Eloquent\Builder;
use Xpressengine\Category\Models\Category;
use Xpressengine\Category\Models\CategoryItem;
use Xpressengine\Routing\InstanceRoute;
use Xpressengine\Support\Tree\Node;

/**
 * Class MenuItem
 *
 * @category  Menu
 * @package   Xpressengine\Menu
 * @author    XE Team (developers) <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      http://www.xpressengine.com
 *
 * @property string $id          자동 생성된 고유한 식별자
 * @property string $menuId      소속된 MenuEntity 의 ID
 * @property string $parentId    부모의 ID
 * @property string $url         해당 메뉴의 URL
 * @property string $preTitle    UI 에서 출력을 위해서 사용되는 property title 출력전에 추가
 * @property string $title       사용자에게 보여지는 이름
 * @property string $postTitle   UI 에서 출력을 위해서 사용되는 property title 출력후에 추가
 * @property string $description 설명
 * @property string $target      링크의 클릭시 옵션
 * @property bool   $activated   활성/비활성 유무
 * @property string $type        해당 메뉴의 type
 * @property int    $ordering    정렬을 위한 순서
 */
//class MenuItem extends Node
class MenuItem extends CategoryItem
{
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
    protected $fillable = ['parentId', 'title', 'url', 'description', 'target', 'type' , 'ordering', 'activated'];

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
        return $this->hasOne(InstanceRoute::class, 'instanceId');
    }

    public function getChildren()
    {
        $rfc = new \ReflectionClass($this);
        $method = $rfc->getParentClass()->getParentClass()->getMethod('getChildren');

        return $method->invoke($this);
    }
    
    /**
     * Get the aggregator model name for model
     *
     * @return string
     */
    public function getAggregatorModel()
    {
        return Menu::class;
    }

    /**
     * Get the aggregator key name for model
     *
     * @return string
     */
    public function getAggregatorKeyName()
    {
        return 'menuId';
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
}
