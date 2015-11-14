<?php namespace Xpressengine\UIObjects\Menu;

use Xpressengine\UIObject\AbstractUIObject;

class Permission extends AbstractUIObject
{
    protected static $id = 'uiobject/xpressengine@permission';
    protected $maxShowItemDepth;

    public function render()
    {
        $htmlString = [];
        $args = $this->arguments;

        $grant = $args['grant'];
        $groups = $args['groups'];
        $inputTitle = $args['title'];
        if(isset($args['mode']))
            $htmlString[] = $this->generateHeaderHtml($inputTitle, $args['mode']);
        $htmlString[] = $this->generateRatingHtml($inputTitle, $grant['rating']);
        $htmlString[] = $this->generateGroupHtml($inputTitle, $groups, $grant['group']);
        $htmlString[] = $this->generateUsersHtml($inputTitle, $grant['user']);
        $htmlString[] = $this->generateExceptHtml($inputTitle, $grant['except']);
        $this->template = implode('', $htmlString);

        return parent::render();
    }

    public static function boot()
    {
        // TODO: Implement boot() method.
    }

    public static function getSettingsURI()
    {
    }

    protected function generateHeaderHtml($inputTitle, $grantMode)
    {
        $modeStringArr = ['inherit', 'manual'];

        $inputTitle = studly_case($inputTitle);
        $html=[];
        $html[] = '<p>';
        $html[] = '<i class="fa fa-info-circle" data-toggle="popover" data-content="접근 권한 설정을 상위 메뉴와 동일하게 설정할 수 있습니다." data-original-title=""></i> ';
        $html[] = "<label>{$inputTitle}</label> ";
        $html[] = "<select name='menu{$inputTitle}'>";

        foreach($modeStringArr as $mode)
        {
            $html[] = "<option value='".$mode."'";
            if($mode === $grantMode) $html[] = "selected";
            $html[] = "/> {$mode}</option>";
        }
        $html[] = '</select>';
        $html[] = '</p>';

        return implode('',$html);
    }

    protected function generateRatingHtml($inputTitle, $value)
    {
        $ratingStringArr = ['super', 'manager', 'member', 'guest'];

        $html = '<p>';
        $html.= '<i class="fa fa-info-circle" data-toggle="popover" data-content="사용자의 등급에 따라 접근을 제한할 수 있습니다." data-original-title=""></i> ';
        $html.= "<label>등급</label><br/>";
        $html.= "<ul>";

        foreach($ratingStringArr as $rating)
        {
            $html.= "<li><input type='radio' name='{$inputTitle}Rating' value='{$rating}' title='{$rating}' ";
            if($rating === $value) $html.= "checked";
            $html.= "/> {$rating}</li>";
        }
        $html.= "</ul></p>";
        return $html;
    }

    protected function generateGroupHtml($inputTitle, $groups, $groupArr)
    {
        $html = '<p>';
        $html.= '<i class="fa fa-info-circle" data-toggle="popover" data-content="접근을 허용할 그룹을 지정할 수 있습니다." data-original-title=""></i> ';
        $html.= "<label>그룹</label><br/>";
        $html.= "<ul>";

        foreach($groups as $group)
        {
            $html.= "<li><input type='checkbox' name='{$inputTitle}Group[]' value='{$group->id}' title='{$group->name}' ";
            if(in_array($group->id, $groupArr)) $html.= "checked";
            $html.= "/> {$group->name}</li>";
        }

        $html.= "</ul></p>";

        return $html;
    }

    protected function generateUsersHtml($inputTitle, $users)
    {
        $html = '<p>';
        $html.= '<i class="fa fa-info-circle" data-toggle="popover" data-content="접근을 허용할 개별 사용자를 지정할 수 있습니다." data-original-title=""></i> ';
        $html.= "<label>포함할 사용자</label><br/>";

        $usersString = implode(',',$users);

        $html.= "<input type='text' class='form-control' placeholder='접근을 허용할 사용자를 입력하십시오' name='{$inputTitle}User' value='{$usersString}'/>";

        $html.= "</p>";

        return $html;
    }

    protected function generateExceptHtml($inputTitle, $excepts)
    {
        $html = '<p>';
        $html.= '<i class="fa fa-info-circle" data-toggle="popover" data-content="접근을 제할 개별 사용자를 지정할 수 있습니다." data-original-title=""></i> ';
        $html.= "<label>제외할 사용자</label><br/>";

        $exceptString = implode(',',$excepts);

        $html.= "<input type='text' class='form-control' placeholder='접근을 제한할 사용자를 입력하십시오' name='{$inputTitle}Except' value='{$exceptString}'/>";
        $html.= "</p>";

        return $html;
    }
}
