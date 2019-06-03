{{ app('xe.frontend')->js('assets/core/xe-ui-component/js/xe-page.js')->load() }}
@section('page_title')
    <h2>업데이트</h2>
@endsection
<h3>
    @if($operator->isCore())
        XE 업데이트
    @elseif($operator->isPlugin())
        플러그인 업데이트
    @elseif($operator->isPrivate())
        커스텀 플러그인
    @endif
</h3>
<div class="panel">
    <div class="panel-body">
        <p class="help-block">
            작업이 진행중입니다. 최대 수분이 소요될 수 있습니다.<br>
            사이트가 업데이트되는 동안 유지관리 모드가 됩니다.
        </p>
    </div>
    <ul class="list-group list-plugin __xe_operation">
        <li class="list-group-item">
            <div class="left-group">
                <p style="color: #303030;font-size: 14px;"> 로딩 중...</p>
            </div>
        </li>
    </ul>
</div>

<script>
    jQuery(function ($) {
      var loadOperation = setInterval(function(){
        var url = "{{ route('settings.operation.progress') }}";
        XE.page(url, '.__xe_operation', {}, function(response){
          var data = response.data;
          if(data.in_progress !== true) {
            clearInterval(loadOperation);
            location.reload();
          }
        });
      }, 3000);

      {{--var loadOperation = function(url) {--}}
        {{--XE.page(url, '.__xe_operation', {}, function(response){--}}
          {{--var data = response.data;--}}
          {{--if(data.in_progress !== true) {--}}
            {{--location.reload();--}}
          {{--} else {--}}
            {{--loadOperation("{{ route('settings.operation.progress') }}");--}}
          {{--}--}}
        {{--});--}}
      {{--};--}}
      {{--loadOperation("{{ route('settings.operation.progress', ['s' => 1]) }}");--}}
    })
</script>
