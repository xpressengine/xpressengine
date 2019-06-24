@section('page_title')
    <h2>{{ xe_trans('xe::addTheme') }}</h2>
@stop

@section('page_description')
    <small>{{ xe_trans('xe::addThemeDescription') }}</small>
@endsection

<div class="row">
    <div class="col-sm-12">
        <form method="get" action="{{route('settings.theme.install')}}">
            <div class="panel-heading">
                <div class="pull-right">
                    <div class="input-group search-group">
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <span class="selected-type">{{ xe_trans('xe::keyword') }}</span>
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
                            <input type="text" class="form-control" placeholder="검색어를 입력하세요" name="query" value="{{Request::get('')}}">
                            <button class="btn-link">
                                <i class="xi-close"></i><span class="sr-only">검색</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel admin-tab">
                <button class="admin-tab-left" style="display:none"><i class="xi-angle-left"></i><span class="xe-sr-only">처음으로 이동</span></button>
                <ul class="admin-tab-list">
                    <li class="free on"><a href="{{ route('settings.plugins.install.items', ['free' => true]) }}" data-toggle="xe-page" data-target=".__xe_plugin_items" >{{ xe_trans('xe::무료') }}</a></li>
                    <li class="charge"><a href="{{ route('settings.plugins.install.items', ['free' => false]) }}" data-toggle="xe-page" data-target=".__xe_plugin_items">{{ xe_trans('xe::유료') }}</a></li>
                    <li class="my_site"><a href="{{ route('settings.plugins.install.items', ['free' => 'purchased']) }}" data-toggle="xe-page" data-target=".__xe_plugin_items" >{{ xe_trans('xe::mySitePlugins') }}</a></li>
                </ul>
                <button class="admin-tab-right"><i class="xi-angle-right"></i><span class="xe-sr-only">끝으로 이동</span></button>
            </div>

            <h3 class="blind">테마 카드 리스트</h3>
            <div class="clearfix">
                <div class="pull-right">
                    <div class="dropdown" style="display: inline-block">
                        <!-- [D] 버튼 보더와 배경색 제거를 위해 class="btn-default--transparent" 으로 버튼 스타일 추가 -->
                        <button type="button" class="btn btn-default--transparent dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                            <span class="__xe_text">카테고리</span> <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right" role="menu" style="overflow: auto; height: 200px;">
                            <li class=""><a href="#" value="">전체</a></li>
                            <li><a href="#" value="">Blog</a></li>
                            <li class="active"><a href="#" value="">Gallery</a></li>
                            <li><a href="#" value="">Board</a></li>
                            <li><a href="#" value="">헬프센터 게시판</a></li>
                            <li><a href="#" value="">Notice</a></li>
                        </ul>
                    </div>
                    <div class="dropdown" style="display: inline-block">
                        <!-- [D] 버튼 보더와 배경색 제거를 위해 class="btn-default--transparent" 으로 버튼 스타일 추가 -->
                        <button type="button" class="btn btn-default--transparent dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                            <span class="__xe_text">인기순</span> <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right" role="menu" style="overflow: auto; height: 200px;">
                            <li class=""><a href="#" value="">전체2</a></li>
                            <li><a href="#" value="26bf2a59">Blog2</a></li>
                            <li class="active"><a href="#" value="29ced82a">Gallery2</a></li>
                            <li><a href="#" value="2aa71eee">Board2</a></li>
                            <li><a href="#" value="6cbb0719">헬프센터 게시판2</a></li>
                            <li><a href="#" value="e447aabb">Notice2</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </form>

        @if ($plugins->count() > 0)
            <ul class="list-group list-card list-theme">
                @foreach ($plugins as $idx => $theme)
                    @include($_skin::view('theme.item'))
                @endforeach
            </ul>
        @else
            @php
                $message = 'no theme';
            @endphp
            @include($_skin::view('empty'))
        @endif
    </div>
</div>

<script>
    $(function(){
        $(document).on('click','.plugin-install',function(){
            $("#xe-install-plugin").find('[name="pluginId[]"]').val($(this).data('target'));
            $("#xe-install-plugin").submit();
        })
        $(document).on('click','.search-group li a',function(){
            $(".search-group").find('input[type="text"]').attr('name',$(this).data('target'));
            $(".search-group").find('.selected-type').text($(this).text());
        })
    });
</script>
