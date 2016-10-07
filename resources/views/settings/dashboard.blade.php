@section('page_title')
    <h2>DashBoard</h2>
@stop

@section('page_description')
@stop

{{ uio('widgetbox', ['id' => $widgetbox->id]) }}

{{--<div class="row">
    <div class="col-md-6 _card" data-card-id="1">
        {{ widget('widget/xpressengine@systemInfo', []) }}
    </div>
    <div class="col-md-6 _card" data-card-id="2">
        {{ widget('widget/xpressengine@storageSpace', array (
            'limit' => '10'
        )) }}
    </div>
</div>
<div class="row">
    <div class="col-md-6 _card" data-card-id="2">
        {{ widget('widget/xpressengine@contentInfo', []) }}
    </div>
    <div class="col-md-6 _card" data-card-id="2">
        {{ widget('widget/news_client@news', []) }}
    </div>
</div>--}}
