<?php namespace Xpressengine\UIObjects\Settings;

use Xpressengine\UIObject\AbstractUIObject;
use View;

class ChakIt extends AbstractUIObject
{
    protected static $id = 'uiobject/xpressengine@chakIt';

    protected $chakApikey = "cbde2b3c23ddadc0fc9b44ecb86beed6-forum";

    protected $maxShowItemDepth;

    public function render()
    {
        $category = $this->arguments;

        return View::make('uiobjects.settings.chakIt', [
            'category' => $category,
            'chakApiKey' => $this->chakApikey,
        ])->render();

        return parent::render();
    }

    public static function boot()
    {
        // TODO: Implement boot() method.
    }

    public static function getSettingsURI()
    {
    }
}
