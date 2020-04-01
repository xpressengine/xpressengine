@include('editor.global._title')

@include('editor.global._tab', ['_active' => 'perm'])

<div class="container-fluid container-fluid--part">
    <div class="card-group" role="tablist" aria-multiselectable="true">
        <div class="card">
            <div class="card-heading">
                <div class="pull-left">
                    <h3 class="card-title">{{ xe_trans('xe::permission') }}</h3>
                </div>
            </div>
            <div class="panel-collapse collapse in">
                <form method="post" action="{{ route('settings.editor.global.perm') }}">
                    {{ csrf_field() }}
                    <div class="card-body">

                        <div class="card">
                            <div class="card-header">
                                <div class="pull-left">
                                    <h4 class="card-title">{{ xe_trans('xe::htmlEditPermission') }}</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                {!! uio('permission', $permArgs['html']) !!}
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-heading">
                                <div class="pull-left">
                                    <h4 class="card-title">{{ xe_trans('xe::basicToolUsePermission') }}</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                {!! uio('permission', $permArgs['tool']) !!}
                            </div>
                        </div>


                        <div class="card">
                            <div class="card-header">
                                <div class="pull-left">
                                    <h4 class="card-title">{{ xe_trans('xe::uploadPermission') }}</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                {!! uio('permission', $permArgs['upload']) !!}
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-heading">
                                <div class="pull-left">
                                    <h4 class="card-title">{{ xe_trans('xe::downloadPermission') }}</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                {!! uio('permission', $permArgs['download']) !!}
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <div class="pull-right">
                            <button type="submit" class="btn btn-primary">{{ xe_trans('xe::save') }}</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
