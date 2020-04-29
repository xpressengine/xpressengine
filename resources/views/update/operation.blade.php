{{ app('xe.frontend')->js('assets/core/xe-ui-component/js/xe-page.js')->load() }}
@section('page_title')
    <h2>{{ xe_trans('xe::updates') }}</h2>
@endsection
<h3>
    @if($operator->isCore())
        {{ xe_trans('xe::coreUpdate') }}
    @elseif($operator->isPlugin())
        {{ xe_trans('xe::plugin') }} {{ xe_trans('xe::updates') }}
    @elseif($operator->isPrivate())
        {{ xe_trans('xe::custom') }} {{ xe_trans('xe::plugin') }}
    @endif
</h3>
<div class="panel">
    <div class="panel-body">
        <p class="help-block">
            @if($operator->isCore())
                {{ xe_trans('xe::alertUpdateCore') }}
            @else
                {{ xe_trans('xe::descUpdatePlugins') }}
            @endif
            <br>
            {{ xe_trans('xe::beMaintenanceModeWhileUpdating') }}
        </p>
    </div>
    <ul class="list-group list-plugin __xe_operation">
        <li class="list-group-item">
            <div class="left-group">
                <p style="color: #303030;font-size: 14px;"> Loading...</p>
            </div>
        </li>
    </ul>
    <div id="__xe-operation-log" style="display: none;padding:15px 10px;">
        <div class="well"></div>
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
          if(data.in_progress === true) {
            $('#__xe-dialog').modal({backdrop:'static'});
          } else {
            $('#__xe-dialog').modal('hide');
            clearInterval(loadOperation);
          }

            if (data.log) {
                $('#__xe-operation-log').show();
                var $well = $('#__xe-operation-log>.well');
                $well.html(data.log);
                $well.animate({ scrollTop: $well.prop('scrollHeight')}, 100);
            }

          if (data.succeed === true) {
            location.assign(data.redirect);
          }
        });
      }, 3000);
    })
</script>
