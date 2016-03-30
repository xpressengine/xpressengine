
<div class="row">
    <div class="col-sm-12">
        <div class="panel-group">
            <div class="panel">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h3 class="panel-title">다국어 입력</h3>
                    </div>
                </div>
                <div class="panel-heading">
                    {{---todo: 좌측 분류, 우측 검색영역--}}
                    {{--<div class="pull-left">--}}
                        {{--<div class="btn-group btn-fillter" role="group">--}}
                            {{--<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">--}}
                                {{--<span class="caret"></span>--}}
                            {{--</button>--}}
                            {{--<ul class="dropdown-menu" role="menu">--}}
                                {{--<li class="active"><a href="#">전체</a></li>--}}
                                {{--<li><a href="#">board</a></li>--}}
                                {{--<li><a href="#">comment_service</a></li>--}}
                                {{--<li><a href="#">user</a></li>--}}
                                {{--<li><a href="#">xe</a></li>--}}
                            {{--</ul>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    <div class="pull-right">
                        <div class="input-group search-group">
                            <div id="namespace" data-namespace="{{ $selected_namespace ?: '' }}">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">{{ $selected_namespace ?: XeLang::trans('lang::admin.search.all') }} <span class="caret"></span></button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#" data-namespace="">{{ XeLang::trans('lang::admin.search.all') }}</a></li>
                                        @foreach ( $namespaces as $namespace )
                                        <li><a href="#" data-namespace="{{ $namespace }}">{{ $namespace }}</a></li>
                                        @endforeach
                                    </ul>
                                </div><!-- /btn-group -->
                                <input type="text" class="form-control" aria-label="Text input with dropdown button" placeholder="검색어를 입력하세요." value="{{ $selected_keyword }}">
                                <button class="btn-link" id="btn-search">
                                    <i class="xi-magnifier"></i><span class="sr-only">{{ XeLang::trans('lang::admin.search-short') }}</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    @foreach( $searchList as $search )
                        <?php $keyString = ($search['namespace'] ? $search['namespace'].'::' : '').$search['item']; ?>
                    <form>
                    <div class="form-group">
                        <label for="item-title">{{ $keyString }}</label>
                        @include('lang.editorbox', [
                            'name' => $keyString,
                            'langKey' => $keyString,
                            'lines' => $search['lines'],
                            'multiline' => $search['multiline'],
                        ])
                        <div class="input-group clearfix">
                            <button type="button" class="btn btn-primary pull-right save" data-line-id="{{ $search['id'] }}">
                                <i class="xi-download"></i>{{ XeLang::trans('lang::admin.editor.save') }}
                            </button>
                        </div>
                    </div>
                    </form>
                    @endforeach
                </div>
                <div class="panel-footer">
                    <div class="pull-left">
                        {!! $pagination->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    System.import('xecore:/common/js/xe.bundle').then(function() {
        $(function () {
            $('button.save').click(function (e) {
                var url = '/settings/lang/save',
                        data = $(this).closest('form').serializeArray();
                $.ajax({
                    type: 'PUT', url: url, dataType: 'json', data: data,
                    success: function (data, textStatus) {
                        alertBox('success', XE.Lang.trans('lang::admin.editor.saved'));
                    },
                    error: function (request, status, error) {
                        alertBox('danger', XE.Lang.trans('lang::admin.editor.failed'));
                    }
                });
                return false;
            });

            $("#namespace .dropdown-menu li a").click(function () {
                var selText = $(this).text();
                var selNamespace = $(this).data('namespace');
                $(this).parents('.input-group').find('.dropdown-toggle').html(selText + ' <span class="caret"></span>');
                $(this).closest('#namespace').data('namespace', selNamespace);
                $('.open .dropdown-toggle').dropdown('toggle');
                return false;
            });

            $('#btn-search').click(function () {
                var namespace = $('#namespace').data('namespace');
                var keyword = $('#namespace input').val();
                var url = '/' + XE.options.managePrefix + '/lang';

                if (!namespace && !keyword) {
                    document.location.href = url;
                    return;
                } else if (!namespace && keyword) {
                    namespace = 'äll';
                }

                document.location.href = url + '/' + namespace + (keyword ? '/' + keyword : '');
            });
        });
    });
</script>

