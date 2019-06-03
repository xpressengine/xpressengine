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
    <div id="__xe-operation-log" style="display: none;padding:15px 10px;">
        <div class="well" style="overflow-y:auto; max-height: 150px;"></div>
    </div>
</div>

<div class="modal fade" id="__xe-dialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 0; margin: auto; top: 50%;">
        <i class="xi-spinner-5 xi-spin xi-5x"></i>
    </div>
</div>

<script>
    jQuery(function ($) {
      var loadOperation = setInterval(function(){
        var url = "{{ route('settings.operation.progress') }}";
        XE.page(url, '.__xe_operation', {}, function(response){
          var data = response.data;
          if(data.in_progress !== true) {
            $('#__xe-dialog').modal('hide');
            clearInterval(loadOperation);
            location.reload();
          } else {
            $('#__xe-dialog').modal({backdrop:'static'});
            if (data.log) {
              $('#__xe-operation-log').show();
              var $well = $('#__xe-operation-log>.well');
              $well.html(data.log);
              $well.animate({ scrollTop: $well.prop('scrollHeight')}, 100);
            }
          }
        });
      }, 3000);
    })
</script>
