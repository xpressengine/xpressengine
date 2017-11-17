<div id="widgetbox-{{ $id }}">
    @if($widgetbox)
        <div class="widgetbox-content">
        {!! $content !!}
        </div>
        @if(auth()->user()->isAdmin())
        <hr>
        <div class="widget-controll">
            <p>
                <button type="button" onclick="window.open('{{route('widgetbox.edit', ['id' => $id])}}', 'widgetboxEditor', 'directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no');return false"> {{ $link or $widgetbox->title.' 위젯박스 편집' }}</button>
            </p>
        </div>
        @endif
    @else
        @if(auth()->user()->isAdmin())

        {{ app('xe.frontend')->js(['assets/core/xe-ui-component/js/xe-page.js', 'assets/core/xe-ui-component/js/xe-form.js'])->load() }}

        <div class="widget-controll">
        <p>위젯박스[{{ $id }}]를 찾을 수 없습니다. <a href="#" data-url="{{  route('widgetbox.create', ['id' => $id]) }}" data-toggle="xe-page-modal" >바로 생성하기</a></p>
        </div>
        @endif
    @endif
</div>
