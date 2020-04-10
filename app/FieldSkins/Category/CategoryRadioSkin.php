<?php
/**
 * CategoryRadioSkin.php
 *
 * PHP version 7
 *
 * @category    FieldSkins
 * @package     App\FieldSkins\Category
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\FieldSkins\Category;

use Xpressengine\Category\Models\Category;
use Xpressengine\DynamicField\AbstractSkin;

/**
 * Class CategoryRadioSkin
 *
 * @category    FieldSkins
 * @package     App\FieldSkins\Category
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class CategoryRadioSkin extends AbstractSkin
{
    protected static $id = 'fieldType/xpressengine@Category/fieldSkin/xpressengine@radio';
    protected $name = 'Category radio';
    protected $description = '카테고리 라디오 스킨';

    /**
     * get name of skin
     *
     * @return string
     */
    public function name()
    {
        return 'Category radio';
    }

    /**
     * get view file directory path
     *
     * @return string
     */
    public function getPath()
    {
        return 'dynamicField/category/radio';
    }

    /**
     * 다이나믹필드 생성할 때 스킨 설정에 적용될 rule 반환
     *
     * @return array
     */
    public function getSettingsRules()
    {
        return [];
    }

    /**
     * 등록 form 에 추가될 html 코드 반환
     * return html tag string
     *
     * @param array $args parameters
     *
     * @return \Illuminate\View\View
     */
    public function create(array $args)
    {
        $this->setCategoryId();

        $this->addMergeData(['items' => $this->getCategoryItems()]);

        return parent::create($args);
    }

    /**
     * 수정 form 에 추가될 html 코드 반환
     * return html tag string
     *
     * @param array $args parameters
     * @return \Illuminate\View\View
     */
    public function edit(array $args)
    {
        $this->setCategoryId();

        $this->addMergeData(['items' => $this->getCategoryItems()]);

        return parent::edit($args);
    }

    /**
     * 조회할 때 사용 될 html 코드 반환
     * return html tag string
     *
     * @param array $args arguments
     * @return \Illuminate\View\View
     */
    public function show(array $args)
    {
        $this->setCategoryId();

        $items = $this->getCategoryItems();
        $selectedCategoryItemId = $args[$this->config->get('id') . '_item_id'];
        $selectedItemText = '';
        foreach ($items as $item) {
            if ($item['value'] == $selectedCategoryItemId) {
                $selectedItemText = $item['text'];
            }
        }

        $this->addMergeData(['selectedItemText' => $selectedItemText]);

        return parent::show($args);
    }

    /**
     * 리스트에서 검색할 때 검색 form 에 사용될 html 코드 반환
     * return html tag string
     *
     * @param array $args arguments
     * @return string
     */
    public function search(array $args)
    {
        $this->setCategoryId();

        $this->addMergeData(['items' => $this->getCategoryItems()]);

        return parent::search($args);
    }

    /**
     * 카테고리 ID를 config에 공통된 이름으로 설정
     *
     * @return void
     */
    private function setCategoryId()
    {
        if ($this->config->get('category_id') == null && $this->config->get('categoryId') != null) {
            $this->config->set('category_id', $this->config->get('categoryId'));
        }
    }

    /**
     * 확장필드에 지정된 Category를 가져옴
     *
     * @return array
     */
    private function getCategoryItems()
    {
        $items = [];
        $categoryItems = Category::find($this->config->get('category_id'))->items;
        foreach ($categoryItems as $categoryItem) {
            $items[] = [
                'value' => $categoryItem->id,
                'text' => $categoryItem->word,
            ];
        }

        return $items;
    }
}
