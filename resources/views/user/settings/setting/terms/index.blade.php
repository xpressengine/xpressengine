{{ XeFrontend::js('/assets/vendor/jqueryui/jquery-ui.min.js')->appendTo('head')->load() }}
{{ XeFrontend::css('assets/core/xe-ui/css/xe-ui-without-base.css')->load() }}

<div class="container-fluid container-fluid--all">
    <div class="row">
        <div class="col-sm-3" style="margin-bottom: 8px;">
            <!-- 약관 항목 -->
            <!-- 드래그 리스트 -->
            <ul class="sort-list sort-list--button-type __ui-sortable">
                <!-- [D] class="sort-list__button" 클릭 시 해당 부모 영역 li 태그에 class="on" 추가 (버튼 클릭 시 선택 표시) -->
                {{-- @foreach ($terms as $item)
                <li class="list-group-item">
                    <button type="button" class="btn handler"><i class="xi-drag-vertical"></i></button>
                    <span ><input type="checkbox" name="id[]" value="{{ $item->id }}"></span>
                    <em class="item-title"><a href="{{ route('settings.user.setting.terms.edit', $item->id) }}">{{ xe_trans($item->title) }}</a></em>
                    <div class="xe-btn-toggle pull-right">
                        <label>
                            <span class="sr-only">toggle</span>
                            <input type="checkbox" name="enable[]" value="{{ $item->id }}" {{$item->is_enabled ? 'checked' : ''}}>
                            <span class="toggle"></span>
                        </label>
                    </div>
                </li>
                @endforeach --}}
                @foreach ($terms as $term)
                <li>
                    <div class="sort-list__handler">
                        <button type="button" class="xu-button xu-button--subtle-link xu-button--icon __handler" data-term-id="{{ $term->id }}">
                            <span class="xu-button__icon"><i class="xi-drag-vertical"></i></span>
                        </button>
                    </div>
                    <button type="button" class="sort-list__button">{{ xe_trans($term->title) }}</button>
                </li>
                @endforeach
            </ul>

            <div class="setting-terms__sort-list-button">
                <button type="button" class="xu-button xu-button--link" data-url="{{ route('settings.user.setting.terms.create') }}">
                    <span class="xu-button__text">새 약관 만들기</span>
                </button>
            </div>
            <!-- //약관 항목 -->
        </div>

        <div class="col-sm-9">
            <div class="setting-area-group">
                <!-- 각 세팅 박스 -->
                <section class="setting-area">
                    <div class="setting-area__body">
                        <div class="setting-box">

                            <div class="xu-form-group">
                                <label>약관명</label>
                                <!-- UI 오브젝트 영역(input) -->
                                <input type="input" class="xu-form-group__control">
                                <!-- //UI 오브젝트 영역(input) -->
                            </div>
                        </div>

                        <div class="setting-box">
                            <label class="xu-label-checkradio">
                                <input type="radio">
                                <span class="xu-label-checkradio__helper"></span>
                                <span class="xu-label-checkradio__text">사용 <span class="xu-label-checkradio__empase">(필수)</span></span>
                            </label>
                            <label class="xu-label-checkradio">
                                <input type="radio">
                                <span class="xu-label-checkradio__helper"></span>
                                <span class="xu-label-checkradio__text">사용 <span class="xu-label-checkradio__empase">(선택)</span></span>
                            </label>
                            <label class="xu-label-checkradio">
                                <input type="radio">
                                <span class="xu-label-checkradio__helper"></span>
                                <span class="xu-label-checkradio__text">사용안함</span>
                            </label>
                        </div>

                        <div class="setting-box">
                            <div class="xu-form-group">
                                <label>약관 설명</label>
                                <!-- UI 오브젝트 영역(textarea) -->
                                <textarea class="xu-form-group__control"></textarea>
                                <!-- //UI 오브젝트 영역(textarea) -->
                            </div>
                        </div>

                        <div class="setting-box">
                            <div class="xu-form-group setting-box__terms-content">
                                <!-- UI 오브젝트 영역(textarea) -->
                                <textarea class="xu-form-group__control"></textarea>
                                <!-- //UI 오브젝트 영역(textarea) -->
                            </div>
                        </div>
                    </div>
                </section>

                <!-- 전체 페이지 버튼 영역 -->
                <div class="setting-button-box" style="text-align: right;">
                    <button type="button" class="xu-button xu-button--default">삭제</button>
                    <button type="button" class="xu-button xu-button--primary">저장하기</button>
                    <button type="button" class="xu-button xu-button--primary">추가하기</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function() {
        $(".item-setting").sortable({
            handle: '.handler',
            cancel: ''
        }).disableSelection();

        $('.btn-destroy').click(function () {
            if ($('input[name="id[]"]:checked', '#index_form').length < 1) {
                return;
            }
            if (!confirm('{{ xe_trans('xe::confirmDelete') }}')) {
                return;
            }

            $('#index_form').attr('action', '{{ route('settings.user.setting.terms.destroies') }}')
            .append('{{ method_field('delete') }}');
            $('#index_form').submit();
        });

        $('.btn-submit').click(function() {
            $('#index_form').attr('action', '{{ route('settings.user.setting.terms.enable') }}');
            $('#index_form').submit();
        });
    });
</script>
