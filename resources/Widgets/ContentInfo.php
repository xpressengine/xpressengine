<?php
namespace Xpressengine\Widgets;

use Comment;
use Document;
use View;
use XeUser;
use Xpressengine\Widget\AbstractWidget;

/**
 * ContentInfo.php
 *
 * PHP version 5
 *
 * @category
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class ContentInfo extends AbstractWidget
{

    protected static $id = 'widget/xpressengine@contentInfo';

    /**
     * init
     *
     * @return mixed
     */
    protected function init()
    {
        // TODO: Implement init() method.
    }

    /**
     * getCodeCreationForm
     *
     * @return mixed
     */
    public function getCodeCreationForm()
    {
        // TODO: Implement getCodeCreationForm() method.
    }

    /**
     * render
     *
     * @param array $args to render parameter array
     *
     * @return mixed
     */
    public function render(array $args)
    {
        $viewData = [
            'totalDocument' => Document::count([]),
            'totalComment' => Comment::countAll(),
            'totalMember' => XeUser::users()->count(),
        ];
        return View::make('widget.widgets.contentInfo.show', [
            'viewData' => $viewData,
        ]);
    }
}
