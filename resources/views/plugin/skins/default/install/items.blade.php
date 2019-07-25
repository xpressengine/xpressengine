<div class="row">
    <div class="col-sm-12">
        <div class="panel admin-tab">
            <button class="admin-tab-left" style="display:none"><i class="xi-angle-left"></i><span class="xe-sr-only">처음으로 이동</span></button>
            <ul class="admin-tab-list __xe-tab-list">
                <li class=" @if($filter === 'extension')on @endif extension"><a href="{{ route('settings.plugins.install.items', ['filter' => 'extension']) }}" data-toggle="xe-page" data-target=".__xe_plugin_items" >{{ xe_trans('xe::extension') }}</a></li>
                <li class=" @if($filter === 'theme')on @endif theme"><a href="{{ route('settings.plugins.install.items', ['filter' => 'theme']) }}" data-toggle="xe-page" data-target=".__xe_plugin_items">{{ xe_trans('xe::theme') }}</a></li>
                <li class=" @if($filter === 'purchased')on @endif purchased"><a href="{{ route('settings.plugins.install.items', ['filter' => 'purchased']) }}" data-toggle="xe-page" data-target=".__xe_plugin_items" >{{ xe_trans('xe::mySitePlugins') }}</a></li>
            </ul>
            <button class="admin-tab-right"><i class="xi-angle-right"></i><span class="xe-sr-only">끝으로 이동</span></button>
            <div class="admin-tab-search desktop">
                <div class="input-group search-group">
                    <form action="{{ route('settings.plugins.install.items') }}" data-submit="xe-plugin-items" method="GET">

                        <div class="input-group-btn">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <span class="selected-type">키워드</span>
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="#" data-target="q"><span>키워드</span></a>
                                </li>
                                <li>
                                    <a href="#" data-target="author"><span>창작자명</span></a>
                                </li>
                                <li>
                                    <a href="#" data-target="tag"><span>태그</span></a>
                                </li>
                            </ul>
                        </div>
                        <div class="search-input-group">
                            <input type="text" class="form-control" placeholder="{{xe_trans('xe::enterKeyword')}}" name="q" value="">
                            <button class="btn-link">
                                <i class="xi-close"></i><span class="sr-only">{{xe_trans('xe::search')}}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@if(isset($site_error))
    <div class="well">
        {!! $site_error !!}
    </div>
    @else
<div class="row">
    <div class="col-sm-12">
        <p>XE Store에 등록된 내 사이트에 추가한 플러그인을 쉬운설치할 수 있습니다.</p>
        <div class="pull-right">
            <nav class="__xe_plugin_items_link" data-url="">
                {!! $plugins->links($_skin::view('install.pagination')) !!}
            </nav>
        </div>
        <div class="pull-right" style="line-height: 33px">
            <p>
                {{$plugins->total()}}개의 플러그인
            </p>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="">
            <div class="admin-tab-search mobile">
                <div class="input-group search-group">
                    <form action="{{ route('settings.plugins.install.items') }}" data-submit="xe-plugin-items" method="GET">

                        <div class="input-group-btn">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <span class="selected-type">키워드</span>
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="#" data-target="q"><span>키워드</span></a>
                                </li>
                                <li>
                                    <a href="#" data-target="author"><span>창작자명</span></a>
                                </li>
                                <li>
                                    <a href="#" data-target="tag"><span>태그</span></a>
                                </li>
                            </ul>
                        </div>
                        <div class="search-input-group">
                            <input type="text" class="form-control" placeholder="{{xe_trans('xe::enterKeyword')}}" name="q" value="">
                            <button class="btn-link">
                                <i class="xi-close"></i><span class="sr-only">{{xe_trans('xe::search')}}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- plugin list --}}
@if($plugins->count())
    <div class="row">

        @foreach($plugins as $plugin)
            @include($_skin::view('install.item'))
        @endforeach
    </div>
@else
    <p>{{ xe_trans('xe::noPlugins') }}</p>
@endif
@endif
<style>
    .panel.admin-tab{
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .media-heading{
        word-break: break-all;
    }
    .admin-tab-search{
        margin-right: 10px;
    }
    .admin-tab-search.mobile{
        display: none;
    }
    .media-heading-box{
        display: flex;
        justify-content: space-between;
    }
    @media(max-width: 768px){
        .admin-tab-search.desktop{
            display: none;
        }
        .admin-tab-search.mobile{
            display: block;
            margin: 0 0 10px -8px;
        }
        .media-heading-box{
            display: block;
        }
    }
</style>
