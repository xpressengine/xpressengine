XEeditor.define({
    editorSettings: {
        name: 'XEtextarea',
        configs: {}
    },
    interfaces: {
        initialize: function (selector, options) {

            var options = $.extend(true, {
                fileUpload: {},
                suggestion: {},
                names: {
                    file: {
                        image: {}
                    },
                    tag: {},
                    mention: {}
                },
                extensions: [],
                fontFamily: [],
                perms: {},
                files: []
            }, options);

            console.log("options", options);

            var editor = $("#" + selector), self = this;
            var height = options.height
                , fontFamily = options.fontFamily
                , fontSize = options.fontSize;

            this.addProps({
                editor: editor
                , selector: selector
                , options: options
            });

            if(height) {
                this.props.editor.css('height', height+"px");
            }

            if(fontFamily || fontSize) {
                var bodyStyle = "";

                if(fontFamily && fontFamily.length > 0) {
                    this.props.editor.css('font-family', fontFamily.join(","));
                }

                if(fontSize) {
                    this.props.editor.css('font-size', fontSize);
                }
            }

            editor.parents("form").on("submit", function() {
                var $contentsTarget = $(editor.val()).clone().wrap("<div>").parent();
                var tagClass = options.names.tag.class
                    , tagInput = options.names.tag.input
                    , $hashTags = $contentsTarget.find("." + tagClass)
                    , tagLen = $hashTags.length
                    , mentionClass = options.names.mention.class
                    , mentionInput = options.names.mention.input
                    , $mentions = $contentsTarget.find("." + mentionClass)
                    , mentionIdentifier = options.names.mention.identifier
                    , mentionLen = $mentions.length
                    , fileInput = options.names.file.input
                    , files = options.files;

                var $paramWrap = $();

                //tag, mention, files input삭제 후 생성
                editor.nextAll(".paramWrap").remove();
                editor.after("<div class='paramWrap'>");
                $paramWrap = editor.nextAll(".paramWrap")

                //hashtag
                if(tagLen > 0) {
                    $hashTags.each(function() {
                        var val = $(this).val();

                        $paramWrap.append("<input name='" + tagInput + "[]' value='" + val + "' />");
                    });
                }

                //mention
                if(mentionLen > 0) {
                    $mentions.each(function() {
                        var val = $(this).attr(mentionIdentifier);

                        $paramWrap.append("<input name='" + mentionInput + "[]' value='" + val + "' />");
                    });
                }

                //files
                if(files.length > 0) {
                    for(var i = 0, max = files.length; i < max; i += 1) {
                        var file = files[i];

                        $paramWrap.append("<input name='" + fileInput + "[]' value='" + file.id + "' />");
                    }
                }
            });

        },
        getContents: function () {
            return this.props.editor.val();
        },
        setContents: function (text) {
            this.props.editor.val(text);
        },
        addContents: function (text) {
            var html = this.props.editor.val();
            this.props.editor.val(html);
        },
        on: function (eventName, callback) {
            this.props.editor.on(eventName, callback);
        }
    }
});