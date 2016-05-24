<?php
namespace Xpressengine\Editor;

class Textarea extends AbstractEditor
{
    protected static $id = 'editor/xpressengine@textarea';

    protected static $componentInfo = [
        'name' => 'Textarea'
    ];

    public function getName()
    {
        return 'Textarea';
    }

    /**
     * @return array
     */
    public function getConfigData()
    {
        return [];
    }

    /**
     * @return array
     */
    public function getActivateToolIds()
    {
        return [];
    }

    /**
     * 에디터로 등록된 내용 출력
     *
     * @param string $content content
     * @return string
     */
    public function compile($content)
    {
        return $content;
    }
}
