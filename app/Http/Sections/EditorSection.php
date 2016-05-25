<?php
namespace App\Http\Sections;

use View;
use Xpressengine\Editor\EditorHandler;

class EditorSection extends Section
{
    protected $instanceId;

    public function __construct($instanceId)
    {
        $this->instanceId = $instanceId;
    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        /**
         * @var EditorHandler $handler
         */
        $handler = app('xe.editor');

        $editors = $handler->getAll();
        $selected = $handler->get($this->instanceId);

        return view('editor.section', [
            'instanceId' => $this->instanceId,
            'editors' => $editors,
            'selected' => $selected,
        ]);
    }
}
