{{ XeFrontend::js('/assets/core/common/js/dynamicField.js')->appendTo('body')->load() }}

<div id="__xe_container_DF_setting_{{$group}}" class="table-responsive" data-form=".__xe_add_form">
    <div class="pull-right">
        <button class="btn btn-primary __xe_btn_add" data-toggle="xe-modal">{{xe_trans('xe::add')}}</button>
    </div>

    <table class="table">
        <caption>{{xe_trans('xe::dynamicFieldManager')}}</caption>
        <thead>
        <tr>
            <th>#</th>
            <th>{{xe_trans('xe::id')}}</th>
            <th>{{xe_trans('xe::label')}}</th>
            <th>{{xe_trans('xe::type')}}</th>
            <th>{{xe_trans('xe::skin')}}</th>
            <th>{{xe_trans('xe::use')}}</th>
            <th>{{xe_trans('xe::config')}}</th>
            <th>{{xe_trans('xe::delete')}}</th>
        </tr>
        </thead>
        <tbody class="__xe_tbody">
        <tr class="__xe_row __dynamic-field-row" style="display:none">
            <td scope="row">#</td>
            <td class="__xe_column_id"></td>
            <td class="__xe_column_label"></td>
            <td class="__xe_column_typeName"></td>
            <td class="__xe_column_skinName"></td>
            <td class="__xe_column_use"></td>
            <td>
                <a class="text-light-blue __xe_btn_edit" href="#">{{xe_trans('xe::edit')}}</a>
            </td>
            <td>
                <a class="text-red __xe_btn_delete" href="#">{{xe_trans('xe::delete')}}</a>
            </td>
        </tr>
        </tbody>
    </table>

    <!-- Modal -->
    <div class="xe-modal __xe_df_modal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="xe-modal">&times;</button>
                    <h4 class="modal-title">{{xe_trans('xe::dynamicField')}}</h4>
                </div>
                <div class="modal-body">
                    <p><!-- form --></p>
                </div>
                <div class="xe-modal-footer">
                    <button type="button" class="xe-btn xe-btn-secondary __xe_btn_close" data-dismiss="xe-modal">{{xe_trans('xe::cancel')}}</button>
                    <button type="button" class="xe-btn xe-btn-primary __xe_btn_submit">{{xe_trans('xe::submit')}}</button>
                </div>
            </div>
        </div>
    </div>

    <form class="__xe_add_form" action="{{ route('manage.dynamicField.store') }}" style="display:none" data-rule="dynamicFieldSection">
        <input type="hidden" name="group" value="{{$group}}" />
        @if ($revision === true)
            <input type="hidden" name="revision" value="true" />
        @endif
        <div class="step">
            <div class="form-group">
                <label for="">{{xe_trans('xe::type')}}</label>
                <select name="typeId" class="form-control __xe_type_id">
                    <option value="">{{xe_trans('xe::select')}}</option>
                    @foreach($fieldTypes as $fieldType)
                        <option value="{{ $fieldType::getId() }}">{{ $fieldType->name() }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="">{{xe_trans('xe::id')}}</label>
                <small>{{xe_trans('xe::dynamicFieldIdDescription')}}</small>
                <input type="text" name="id" class="form-control">
            </div>
        </div>
        <div class="step">
            <div class="form-group">
                <label for="">{{xe_trans('xe::label')}}</label>
                <small>{{xe_trans('xe::dynamicFieldLabelDescription')}}</small>
                <div class="dynamic-lang-editor-box" data-name="label" data-lang-key="" data-valid-name="Label"></div>
            </div>
            <div class="form-group">
                <label for="">{{xe_trans('xe::dynamicFieldLabelDetailTitle')}}</label>
                <small>{{xe_trans('xe::dynamicFieldLabelDetailDescription')}}</small>
                <div class="dynamic-lang-editor-box" data-name="placeholder" data-lang-key="" data-valid-name="placeholder"></div>
            </div>
            <div class="form-group">
                <input type="hidden" name="use" value="true" />
                <input type="hidden" name="required" value="true" />
                <input type="hidden" name="sortable" value="true" />
                <input type="hidden" name="searchable" value="true" />
                <div class="checkbox mg-reset mg-bottom">
                    <label>
                        <input type="checkbox" class="__xe_checkbox-config" data-name="use" checked="checked"/>
                        {{xe_trans('xe::use')}}
                    </label>
                    <small>{{xe_trans('xe::dynamicFieldUseDescription')}}</small>
                </div>
                <div class="checkbox mg-reset mg-bottom">
                    <label>
                        <input type="checkbox" class="__xe_checkbox-config" data-name="required" checked="checked"/>
                        {{xe_trans('xe::inputRequired')}}
                    </label>
                    <small>{{xe_trans('xe::dynamicFieldRequiredDescription')}}</small>
                </div>
                <div class="checkbox mg-reset mg-bottom">
                    <label>
                        <input type="checkbox" class="__xe_checkbox-config" data-name="searchable" checked="checked"/>
                        {{xe_trans('xe::searchable')}}
                    </label>
                    <small>{{xe_trans('xe::dynamicFieldSearchableDescription')}}</small>
                </div>
            </div>
            <div class="form-group">
                <label for="">Skin</label>
                <select name="skinId" class="form-control __xe_skin_id" disabled="disabled">
                    <option value="">Select Type for getting skin options</option>
                </select>
            </div>
        </div>
        <div class="step __xe_additional_configure">
        </div>
    </form>
</div>

@expose_route('manage.dynamicField.index')
@expose_route('manage.dynamicField.update')
@expose_route('manage.dynamicField.getEditInfo')
@expose_route('manage.dynamicField.destroy')
@expose_route('manage.dynamicField.getSkinOption')
@expose_route('manage.dynamicField.getAdditionalConfigure')

<script>
    var dynamicFieldData = {
        group: "{{$group}}",
        databaseName: "{{$databaseName}}"
    };

    // 누적된 룰을 제거하고, 새로운 룰만 추가
    XE.Validator.$$on('setRules', function (eventName, ruleName, rules, additional, origin, reassign) {
        if (ruleName === 'dynamicFieldSection') {
            reassign($.extend({}, origin, additional))
        }
    })

    $(function () {
        XE.Validator.put('df_id', function ($dst, parameters) {
            var value = $dst.val();

            var pattern = /^[a-zA-Z]+([a-zA-Z0-9_]+)?[a-zA-Z0-9]+$/;
            if (value && !value.match(pattern)) {
                XE.Validator.error($dst, XE.Lang.trans('xe::validation.df_id', {attribute: $dst.data('valid-name') || $dst.attr('name')}));
                return false;
            }

            return true;
        });
    });
</script>
