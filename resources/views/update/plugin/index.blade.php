<h3>플러그인 업데이트</h3>
@if(count($plugins) < 1)
<div class="panel">
    <div class="panel-body">
        <p class="help-block">업데이트할 플러그인이 없습니다.</p>
        <a href="{{ route('settings.plugins.install.index') }}" >새로운 플러그인 설치하기</a>
    </div>
</div>
@else
<form id="__xe_form-update-plugins" action="{{ route('settings.plugins.manage.update') }}" method="post">
    {{ csrf_field() }}
    <div class="panel">

        <div class="panel-body">
            <p class="help-block">
                아래 플러그인의 새버전이 있습니다. 업데이트를 할 플러그인을 확인하시고 "플러그인 업데이트"를 누르세요.
            </p>
            <button type="submit" class="xe-btn xe-btn-positive-outlin xe-btn-lg">플러그인 업데이트</button>
        </div>

        <div style="padding: 14px 20px;">
            <label class="xe-label">
                <input type="checkbox" class="__xe_chk-all">
                <span class="xe-input-helper"></span>
                <span class="xe-label-text">전체선택</span>
            </label>
        </div>

        <ul class="list-group list-plugin">
            @foreach($plugins as $plugin)
                @include('update.plugin.item')
            @endforeach
        </ul>

    </div>
</form>

<script>
    jQuery(function ($) {
      $('.__xe_chk-all', '#__xe_form-update-plugins').change(function () {
        var $items = $('input[type=checkbox]', $(this).closest('form')).not(this);
        if ($(this).is(':checked')) {
          $items.prop('checked', true);
        } else {
          $items.prop('checked', false);
        }
      });
      $('#__xe_form-update-plugins').submit(function (e) {
        var $items = $('input[type=checkbox]:checked', this).not('.__xe_chk-all');
        if ($items.length < 1) {
          e.preventDefault();
          return false;
        }
      });
    })
</script>
@endif