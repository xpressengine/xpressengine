<?php
namespace App\Http\Sections;

use View;
use XeEditor;

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
        $editors = XeEditor::getAll();
        $selected = XeEditor::get($this->instanceId);

        return view('editor.section', [
            'instanceId' => $this->instanceId,
            'editors' => $editors,
            'selected' => $selected,
        ]);
    }
}
