@section('page_title')
    <h2>{{ xe_trans('xe::addExtension') }}</h2>
@stop

@section('page_description')
    <small>{{ xe_trans('xe::addExtensionDescription') }}</small>
@endsection

<div class="row">
    <div class="col-sm-12">
        <form method="get" action="{{route('settings.extension.install')}}" class="plugin-install-form">
            <input type="hidden" value="{{Request::get('sale_type', 'free')}}" name="sale_type">
            <input type="hidden" value="{{Request::get('category', '')}}" name="category">
            <input type="hidden" value="{{Request::get('order_key', '')}}" name="order_key">
            <input type="hidden" value="{{Request::get('target', '')}}" name="target">

            <div class="admin-tab-info">
                <ul class="admin-tab-info-list">
                    <li class="free @if (Request::get('sale_type', 'free') == 'free') on @endif">
                        <a href="#" class="__plugin-install-link admin-tab-info-list__link" data-type="sale_type" data-value="{{'free'}}">{{ xe_trans('xe::noCharge') }} <span class="admin-tab-info-list__count">{{$storeExtensionCounts->free}}</span></a>
                    </li>
                    <li class="charge @if (Request::get('sale_type') == 'charge') on @endif">
                        <a href="#" class="__plugin-install-link admin-tab-info-list__link" data-type="sale_type" data-value="{{'charge'}}">{{ xe_trans('xe::charge') }} <span class="admin-tab-info-list__count">{{$storeExtensionCounts->charge}}</span></a>
                    </li>
                    <li class="my_site @if (Request::get('sale_type') == 'my_site') on @endif">
                        <a href="#" class="__plugin-install-link admin-tab-info-list__link" data-type="sale_type" data-value="{{'my_site'}}">{{ xe_trans('xe::purchased') }} {{xe_trans('xe::extension')}} <span class="admin-tab-info-list__count">{{$storeExtensionCounts->mySite}}</span></a>
                    </li>
                </ul>
            </div>

            <div class="panel-heading">
                <div class="search-group-box">
                    <div class="input-group search-group">
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <span class="selected-type">
                                    @if (\Request::has('tags'))
                                        {{xe_trans('xe::tag')}}
                                    @elseif (\Request::has('authors'))
                                        {{xe_trans('xe::creatorName')}}
                                    @else
                                        {{xe_trans('xe::keyword')}}
                                    @endif
                                </span>
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="#" data-target="query"><span>{{xe_trans('xe::keyword')}}</span></a>
                                </li>
                                <li>
                                    <a href="#" data-target="authors"><span>{{xe_trans('xe::creatorName')}}</span></a>
                                </li>
                                <li>
                                    <a href="#" data-target="tags"><span>{{xe_trans('xe::tag')}}</span></a>
                                </li>
                            </ul>
                        </div>
                        <div class="search-input-group">
                            <input type="text" class="form-control" placeholder="{{xe_trans('xe::enterKeyword')}}"
                                @if (Request::has('authors'))
                                    value="{{Request::get('authors')}}" name="authors"
                                @elseif (Request::has('tags'))
                                    value="{{Request::get('tags')}}" name="tags"
                                @else
                                   value="{{Request::get('query')}}" name="query"
                                @endif>
                            <button class="btn-link">
                                <i class="xi-search"></i><span class="sr-only">{{xe_trans('xe::search')}}</span>
                            </button>
                        </div>
                        <div class="input-group-btn">
                            <a href="{{route('settings.plugins.manage.upload', ['type' => 'extension'])}}" class="xu-button xu-button--default admin-button--active" data-toggle="xe-page-modal">{{xe_trans('xe::extension')}} {{xe_trans('xe::upload')}}</a>
                        </div>
                    </div>
                </div>
            </div>

            <h3 class="blind">테마 카드 리스트</h3>
            <div class="clearfix">
                <div class="pull-right">
                    <div class="dropdown" style="display: inline-block">
                        <button type="button" class="btn btn-default--transparent dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                            <span class="__xe_text">
                                @if (Request::get('category', '') != '')
                                    {{$extensionCategories[Request::get('category')]}}
                                @else
                                    {{xe_trans('xe::category')}}
                                @endif
                            </span> <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right" role="menu" style="overflow: auto; height: 200px;">
                            <li><a href="#" class="__plugin-install-link" data-type="category" data-value="">{{xe_trans('xe::all')}}</a></li>
                            @foreach ($extensionCategories as $value => $category)
                                <li @if (Request::get('category') == $value) class="active" @endif><a href="#" class="__plugin-install-link" data-type="category" data-value="{{$value}}">{{$category}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="dropdown" style="display: inline-block">
                        <button type="button" class="btn btn-default--transparent dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                            <span class="__xe_text">
                                @if (Request::get('order_key', '') != '')
                                    {{$orderTypes[Request::get('order_key')]['name']}}
                                @else
                                    {{xe_trans('xe::order')}}
                                @endif
                            </span> <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right" role="menu" style="overflow: auto; height: 200px;">
                            @foreach ($orderTypes as $idx => $value)
                                <li @if (Request::get('order_key') == $idx) class="active" @endif><a href="#" class="__plugin-install-link" data-type="order_key" data-value="{{$idx}}">{{$value['name']}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </form>

        @if ($extensions->count() > 0)
            <ul class="list-group list-card list-extension">
                @foreach ($extensions as $idx => $extension)
                    @include($_skin::view('extension.item'))
                @endforeach
            </ul>

            <div>
                {{$extensions->render()}}
            </div>
        @else
            @php
                $message = xe_trans('xe::noExistExtension');
            @endphp
            @include($_skin::view('empty'))
        @endif
    </div>
</div>

<form action="{{ route('settings.plugins.install') }}" method="POST" id="xe-install-plugin">
    {{ csrf_field() }}
    <input type="hidden" name="pluginId[]">
</form>

<script>
    $(function(){
        $(document).on('click','.plugin-install',function(){
            $("#xe-install-plugin").find('[name="pluginId[]"]').val($(this).data('target'));
            $("#xe-install-plugin").submit();
        })
        $(document).on('click','.search-group li a',function(){
            $(".search-group").find('input[type="text"]').attr('name', $(this).data('target'));
            $(".search-group").find('.selected-type').text($(this).text());
        })

        $('.__plugin-install-link').click(function () {
            $('.plugin-install-form').find('input[name=' + $(this).data('type') + ']').val($(this).data('value'));
            $(this).closest('form').submit();
        });
    });
</script>
