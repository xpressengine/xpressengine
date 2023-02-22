@include('editor.global._title')

<div class="container-fluid container-fluid--part">
    @include('editor.global._tab', ['_active' => 'perm'])
</div>

<div class="container-fluid container-fluid--part">
    <div class="panel-group" role="tablist" aria-multiselectable="true">
        <div class="panel">
            <div class="panel-heading">
                <div class="pull-left">
                    <h3 class="panel-title">{{ xe_trans('xe::permission') }}</h3>
                </div>
            </div>
            <div class="panel-collapse collapse in">
                <form method="post" action="{{ route('settings.editor.global.perm') }}">
                    {{ csrf_field() }}
                    <div class="panel-body">

                        <div class="panel">
                            <div class="panel-heading">
                                <div class="pull-left">
                                    <h4 class="panel-title">{{ xe_trans('xe::htmlEditPermission') }}</h4>
                                </div>
                            </div>
                            <div class="panel-body">
                                {!! uio('permission', $permArgs['html']) !!}
                            </div>
                        </div>

                        <div class="panel">
                            <div class="panel-heading">
                                <div class="pull-left">
                                    <h4 class="panel-title">{{ xe_trans('xe::basicToolUsePermission') }}</h4>
                                </div>
                            </div>
                            <div class="panel-body">
                                {!! uio('permission', $permArgs['tool']) !!}
                            </div>
                        </div>


                        <div class="panel">
                            <div class="panel-heading">
                                <div class="pull-left">
                                    <h4 class="panel-title">{{ xe_trans('xe::uploadPermission') }}</h4>
                                </div>
                            </div>
                            <div class="panel-body">
                                {!! uio('permission', $permArgs['upload']) !!}
                            </div>
                        </div>

                        <div class="panel">
                            <div class="panel-heading">
                                <div class="pull-left">
                                    <h4 class="panel-title">{{ xe_trans('xe::downloadPermission') }}</h4>
                                </div>
                            </div>
                            <div class="panel-body">
                                {!! uio('permission', $permArgs['download']) !!}
                            </div>
                        </div>

                    </div>
                    <div class="panel-footer">
                        <div class="pull-right">
                            <button type="submit" class="btn btn-primary">{{ xe_trans('xe::save') }}</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
