<script>
    $(function() {
        $('button.save').click(function(e) {
            var url = '/settings/lang/save',
                    data = $(this).closest('form').serializeArray();
            XE.ajax({type: 'PUT', url: url, dataType: 'json', data: data,
                success: function(data, textStatus) {
                    alertBox('success', XE.Lang.trans('lang::admin.editor.saved'));
                },
                error: function(request, status, error) {
                    alertBox('danger', XE.Lang.trans('lang::admin.editor.failed'));
                }
            });
            return false;
        });

        $("#namespace .dropdown-menu li a").click(function() {
            var selText = $(this).text();
            var selNamespace = $(this).data('namespace');
            $(this).parents('.input-group').find('.dropdown-toggle').html(selText + ' <span class="caret"></span>');
            $(this).closest('#namespace').data('namespace', selNamespace);
            $('.open .dropdown-toggle').dropdown('toggle');
            return false;
        });

        $('#btn-search').click(function() {
            var namespace = $('#namespace').data('namespace');
            var keyword = $('#namespace input').val();
            var url = '/' + XE.options.managePrefix + '/lang';

            if ( !namespace && !keyword ) {
                document.location.href = url;
                return;
            } else if ( !namespace && keyword ) {
                namespace = 'äll';
            }

            document.location.href = url + '/' + namespace + (keyword ? '/' + keyword : '');
        });
    });
</script>

<h3>{{ XeLang::trans('lang::admin.search-long') }}</h3>
<div class="row">
    <div class="col-lg-6">
        <div id="namespace" class="input-group" data-namespace="{{ $selected_namespace ?: '' }}">
            <div class="input-group-btn">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $selected_namespace ?: XeLang::trans('lang::admin.search.all') }} <span class="caret"></span></button>
                <ul class="dropdown-menu">
                    <li><a href="#" data-namespace="">{{ XeLang::trans('lang::admin.search.all') }}</a></li>
                    <li role="separator" class="divider"></li>
                    @foreach ( $namespaces as $namespace )
                        <li><a href="#" data-namespace="{{ $namespace }}">{{ $namespace }}</a></li>
                    @endforeach
                </ul>
            </div>
            <input type="text" class="form-control" value="{{ $selected_keyword }}" />
            <span class="input-group-btn">
                <button id="btn-search" class="btn btn-default" type="button">
                    {{ XeLang::trans('lang::admin.search-short') }}
                </button>
            </span>
        </div>
    </div>
</div>

<br/>

<table class="table table-striped">
    <tbody>
    @foreach( $searchList as $search )
        <tr>
            <td>
                <form>
                    <?php $keyString = ($search['namespace'] ? $search['namespace'].'::' : '').$search['item']; ?>
                    {{ $keyString }}<br/>
                    @include('lang.editorbox', [
                        'name' => $keyString,
                        'langKey' => $keyString,
                        'lines' => $search['lines'],
                        'multiline' => $search['multiline'],
                    ])
                    <button type="button" class="btn btn-primary btn-xs save" data-line-id="{{ $search['id'] }}">
                        {{ XeLang::trans('lang::admin.editor.save') }}
                    </button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{!! $pagination->render() !!}

{!! uio('uiobject/xpressengine@chakIt', 'Settings:다국어') !!}