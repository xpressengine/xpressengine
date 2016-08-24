        {{-- select widget --}}
        <div class="widget-selector">
            {{ uio('formSelect', ['label'=>'위젯', 'class'=>'__xe_select_widget', 'name'=>'widget', 'options'=>$widgets, 'selected'=>$widget] ) }}
        </div>

        {{-- select skin --}}
        <div class="widget-skins" data-url="{{route('settings.widget.skin')}}">
            @include('widget.skins')
        </div>

        {{-- form fields --}}
        <div class="widget-form">
            @include('widget.form')
        </div>
