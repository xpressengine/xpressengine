
var LangEditorBox = React.createClass({
    getInitialState: function () {
        var state = {
            name: this.props.name || '',
            langKey: this.props.langKey || '',
            multiline: this.props.multiline || false,
            lines: this.props.lines || []
        };
        return state;
    },
    render: function () {
        LangEditor.seq++;
        return (
            <div className="lang-editor">
                <LangEditor
                    key={LangEditor.seq}
                    seq={LangEditor.seq}
                    name={this.state.name}
                    langKey={this.state.langKey}
                    multiline={this.state.multiline}
                    lines = {this.state.lines}
                    />
            </div>
        );
    }
});

var LangEditor = React.createClass({
    statics: {seq: 0},
    getInitialState: function () {
        var lines = this.props.lines || [];
        return {lines: lines};
    },
    setLines: function (lines) {
        var self = this;
        self.setState({lines: lines});
        XE.Lang.locales.map(function (locale) {
            var selector = '#input-' + self.props.seq + '-' + locale,
                value = self.getValueFromLinesWithLocale(locale);
            $(selector).val(value);
        });
    },
    getValueFromLinesWithLocale: function (locale) {
        var lines = this.state.lines,
            i = lines.length,
            l = {};
        while (i--) {
            l = lines[i];
            if (l['locale'] == locale) {
                return l['value'];
            }
        }
        return "";
    },
    componentDidMount: function () {
        if (this.isMounted()) {
            var self = this;
            var el = this.getDOMNode();

            if ( this.props.langKey ) {
                if ( this.state.lines.length == 0 ) {
                    XE.ajax({
                        type: 'get',
                        dataType: 'json',
                        url: '/' + XE.options.managePrefix + '/lang/lines/' + this.props.langKey,
                        success: function(result) {
                            if (this.isMounted()) { self.setLines(result); }
                        }.bind(this)
                    });
                }
            }

            $(el).find('input[type=text]:first,textarea:first').autocomplete({
                source: '/' + XE.options.managePrefix + '/lang/search/' + Translator.locale,
                minLength: 1,
                focus: function(event, ui) { event.preventDefault(); },
                select: function(event, ui) { self.setLines(ui.item.lines); }
            });
        }
    },
    getFlagClass: function (locale) {
        var code = XE.Lang.getLangCode(locale),
            arr = code.split('-'),
            keyword = arr[1].toLowerCase();

        return 'flag ' + keyword;
    },
    getEditor: function (resource, locale, value) {
        var edit = null,
            id = ('input-' + this.props.seq + '-' + locale),
            name = (resource + '/locale/' + locale);

        if (!this.props.multiline) {
            edit = <input type="text" className="inpt_txt" id={id} name={name} defaultValue={value} />;
        } else {
            edit = <textarea id={id} name={name} defaultValue={value} />;
        }
        return edit;
    },
    render: function () {
        var self = this,
            locale = XE.Lang.locales[0],
            fallback = XE.Lang.locales.slice(1),
            resource = 'xe_lang_preprocessor://lang/seq/' + this.props.seq,
            value = this.getValueFromLinesWithLocale(locale),
            inputClass = this.props.multiline ? 'textarea' : 'text';

        var multiline = this.props.multiline
            ? <input type="hidden" name={resource + '/multiline'} defaultValue='true' />
            : null;

        return (
            <div className={inputClass}>
                <input type="hidden" name="xe_use_request_preprocessor" value="Y" />
                <input type="hidden" name={resource + '/name'} defaultValue={this.props.name} />
                <input type="hidden" name={resource + '/key'} defaultValue={this.props.langKey} />
                {multiline}
                <input type="hidden" name={this.props.name} defaultValue={this.props.langKey} />
                <div className="main">
                    <div className="inpt_bd">
                        {self.getEditor(resource, locale, value)}
                        <span className="flag_code"><i className={self.getFlagClass(locale)}></i>{locale}</span>
                    </div>
                </div>
                <div className="sub">{fallback.map(function (locale) {
                    var value = self.getValueFromLinesWithLocale(locale);
                    return (
                        <div key={locale} className="inpt_bd">
                            {self.getEditor(resource, locale, value)}
                            <span className="flag_code"><i className={self.getFlagClass(locale)}></i>{locale}</span>
                        </div>
                    );
                })}</div>
            </div>

        );
    }
});

var langEditorBoxRender = function ($o) {
    var name = $o.data('name'),
        langKey = $o.data('lang-key'),
        multiline = $o.data('multiline'),
        lines = $o.data('lines');

    React.render(<LangEditorBox name={name} langKey={langKey} multiline={multiline} lines={lines} />, $o[0]);
}

$('.lang-editor-box').each(function(i) {
    langEditorBoxRender($(this));
});

$(document).on('focus', '.lang-editor .main input, textarea', function() {

    var el = $(this).closest('.lang-editor').find('.sub');
    if ($(el).is(':hidden')) {
        $(el).slideDown('fast');
    }

    $(".lang-editor textarea").expanding();
});
