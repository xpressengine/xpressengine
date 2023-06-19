{{ XeFrontend::js('/assets/vendor/jqueryui/jquery-ui.min.js')->appendTo('head')->load() }}
{{ XeFrontend::js('//cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.4/clipboard.min.js')->load() }}

<div class="container-fluid container-fluid--part">
    <div class="panel-group">
        <div class="panel">

            <div class="panel-heading">
                <div class="pull-left">
                    <h3 class="panel-title">{{ xe_trans('xe::termsSettings') }}</h3>
                </div>
            </div>
            <div class="panel-body">
                <form id="index_form" method="post">
                    {{ csrf_field() }}
                    <div class="panel">
                        <a href="{{ route('settings.user.setting.terms.create') }}" class="btn btn-primary"><i class="xi-plus"></i> <span>{{ xe_trans('xe::add') }}</span></a>

                        <ul class="list-group item-setting">
                            @foreach ($terms as $item)
                                <li class="list-group-item">
                                    <input type="hidden" name="orders[]" value="{{ $item->id }}">
                                    <button type="button" class="btn handler"><i class="xi-drag-vertical"></i></button>
                                    <span ><input type="checkbox" name="id[]" value="{{ $item->id }}"></span>
                                    <em class="item-title"><a href="{{ route('settings.user.setting.terms.edit', $item->id) }}">{{ xe_trans($item->title) }}</a></em>
                                    <div class="xe-btn-toggle pull-right">
                                        <button type="button" class="xe-btn xe-btn-sm __clipboard-copy" data-clipboard-text="{{ route('terms', $item->id) }}">주소 복사</button>
                                        <a href="{{ route('terms', $item->id) }}" class="xe-btn xe-btn-sm" target="_blank">미리보기</a>
                                        <label>
                                            <span class="sr-only">toggle</span>
                                            <input type="checkbox" name="enable[]" value="{{ $item->id }}" {{ $item->is_enabled ? 'checked' : '' }}>
                                            <span class="toggle"></span>
                                        </label>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </form>

            </div>
            <div class="panel-footer">
                <div class="pull-left">
                    <button type="button" class="btn btn-danger btn-lg btn-destroy">{{xe_trans('xe::deleteSelected')}}</button>
                </div>
                <div class="pull-right">
                    <button type="button" class="btn btn-primary btn-lg btn-submit">{{xe_trans('xe::save')}}</button>
                </div>
            </div>

        </div>
    </div>
</div>


<script>
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

        clipboard = new ClipboardJS('.__clipboard-copy');
    });
</script>
