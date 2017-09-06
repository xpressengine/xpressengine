{{ XeFrontend::css('https://gitcdn.github.io/bootstrap-toggle/2.2.0/css/bootstrap-toggle.min.css')->before('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css')->load() }}
{{ XeFrontend::js('https://gitcdn.github.io/bootstrap-toggle/2.2.0/js/bootstrap-toggle.min.js')->appendTo('head')->before('https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js')->load() }}
{{ XeFrontend::js('/assets/vendor/jqueryui/jquery-ui.js')->appendTo('head')->load() }}

<div class="table-responsive item-setting">
    <table class="table table-sortable">
        <colgroup>
            <col width="200">
            <col>
            <col>
        </colgroup>
        <tbody>
        @foreach($guards as $key => $guard)
            <tr>
                <td>
                    <button class="btn handler"><i class="xi-drag-vertical"></i></button>
                    <em class="item-title">{{ $guard['title'] }}</em>
                </td>
                <td>
                    <span class="item-subtext">{{ $guard['description'] }}</span>
                </td>
                <td>
                    <div class="xe-btn-toggle pull-right">
                        <label>
                            <span class="sr-only">toggle</span>
                            <input type="checkbox" name="guards[{{$key}}]" value="Y" @if($guard['activated']) checked="checked" @endif />
                            <span class="toggle"></span>
                        </label>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<script type="text/javascript">
    $(function() {
        // sortable 한 table 구현해야 함
        $(".table-sortable tbody").sortable({
            handle: '.handler',
            cancel: '',
            update: function( event, ui ) {
            },
            start: function(e, ui) {
                ui.placeholder.height(ui.helper.outerHeight());
                ui.placeholder.css("display", "table-row");
                ui.helper.css("display", "table");
            },
            stop: function(e, ui) {
                $(ui.item.context).css("display", "table-row");
            }
        }).disableSelection();
    });
</script>
