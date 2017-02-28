<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\FieldSkins\Address;

use View;
use Xpressengine\Config\ConfigEntity;
use Xpressengine\DynamicField\AbstractSkin;
use Xpressengine\DynamicField\DynamicFieldHandler;
use XeFrontend;

class DefaultSkin extends AbstractSkin
{
    protected static $id = 'fieldType/xpressengine@Address/fieldSkin/xpressengine@default';

    protected static $loaded = false;

    /**
     * get name of skin
     *
     * @return string
     */
    public function name()
    {
        return 'Address default skin';
    }

    /**
     * 다이나믹필스 생성할 때 스킨 설정에 적용될 rule 반환
     *
     * @return array
     */
    public function getSettingsRules()
    {
        return [];
    }

    /**
     * get view file directory path
     *
     * @return string
     */
    public function getPath()
    {
        return 'dynamicField/address/default';
    }

//    /**
//     * Dynamic Field 설정 페이지에서 skin 설정 등록 페이지 반환
//     * return html tag string
//     *
//     * @param ConfigEntity $config dynamic field config entity
//     * @return string
//     */
//    public function settings(ConfigEntity $config = null, $view = 'dynamicField/address/default/createSkin')
//    {
//        return View::make($view, ['config' => $config,])->render();
//    }

    protected function appendScript()
    {
        XeFrontend::html('dynamicField.address')->content('
            <script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
    <script>
        function foldDaumPostcode(fieldId) {
            $(\'#\'+fieldId+\'-daumPostcodeWrap\').hide();
        }

        function execDaumPostcode(fieldId) {
            // 현재 scroll 위치를 저장해놓는다.
            var currentScroll = Math.max(document.body.scrollTop, document.documentElement.scrollTop);
            new daum.Postcode({
                oncomplete: function(data) {
                    // 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                    // 각 주소의 노출 규칙에 따라 주소를 조합한다.
                    // 내려오는 변수가 값이 없는 경우엔 공백(\'\')값을 가지므로, 이를 참고하여 분기 한다.
                    var fullAddr = data.address; // 최종 주소 변수
                    var extraAddr = \'\'; // 조합형 주소 변수

                    // 기본 주소가 도로명 타입일때 조합한다.
                    if(data.addressType === \'R\'){
                        //법정동명이 있을 경우 추가한다.
                        if(data.bname !== \'\'){
                            extraAddr += data.bname;
                        }
                        // 건물명이 있을 경우 추가한다.
                        if(data.buildingName !== \'\'){
                            extraAddr += (extraAddr !== \'\' ? \', \' + data.buildingName : data.buildingName);
                        }
                        // 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
                        fullAddr += (extraAddr !== \'\' ? \' (\'+ extraAddr +\')\' : \'\');
                    }

                    // 우편번호와 주소 정보를 해당 필드에 넣는다.
                    $(\'[name="\'+fieldId+\'Postcode"]\').val(data.zonecode);
                    $(\'[name="\'+fieldId+\'Address1"]\').val(fullAddr);

                    // iframe을 넣은 element를 안보이게 한다.
                    // (autoClose:false 기능을 이용한다면, 아래 코드를 제거해야 화면에서 사라지지 않는다.)
                    $(\'#\'+fieldId+\'-daumPostcodeWrap\').hide();

                    // 우편번호 찾기 화면이 보이기 이전으로 scroll 위치를 되돌린다.
                    document.body.scrollTop = currentScroll;
                },
                // 우편번호 찾기 화면 크기가 조정되었을때 실행할 코드를 작성하는 부분. iframe을 넣은 element의 높이값을 조정한다.
                onresize : function(size) {
                    $(\'#\'+fieldId+\'-daumPostcodeWrap\').css(\'height\', size.height+\'px\');
                },
                width : \'100%\',
                height : \'100%\'
            }).embed($(\'#\'+fieldId+\'-daumPostcodeWrap\')[0]);

            // iframe을 넣은 element를 보이게 한다.
            $(\'#\'+fieldId+\'-daumPostcodeWrap\').show();
        }
    </script>
            ')->appendTo('body.prepend')->load();;
    }

    /**
     * 등록 form 에 추가될 html 코드 반환
     * return html tag string
     *
     * @param array $args parameters
     * @return \Illuminate\View\View
     */
    public function create(array $args)
    {
        if (self::$loaded === false) {
            self::$loaded = true;
            $this->appendScript();
        }

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
        if (self::$loaded === false) {
            self::$loaded = true;
            $this->appendScript();
        }

        return parent::edit($args);
    }

    /**
     * 데이터 출력
     *
     * @param string $name dynamic field name
     * @param array $args 데이터
     * @return mixed
     */
    public function output($name, array $args)
    {
        $config = $this->config;

        return sprintf(
            '%s %s',
            $args[$config->get('id') . 'Address1'],
            $args[$config->get('id') . 'Address2']
        );
    }
}
