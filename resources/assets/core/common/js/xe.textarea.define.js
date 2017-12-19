/**
 * @class XEtextarea
 * */
XEeditor.define(/** @lends XEtextarea */{
  /**
   * @prop {object} editorSettings
   * @prop {string} editorSettings.name
   * @prop {object} editorSettings.config
   * */
  editorSettings: {
    name: 'XEtextarea',
    configs: {},
  },
  /**
   * @prop {object} interfaces
   * @prop {function(selector,options)} interfaces.initialize
   * <pre>
   *   arguments
   *   - selector : string
   *   - options : object
   * </pre>
   * @prop {function} interfaces.getContents 에디터 컨텐츠를 리턴한다.
   * @prop {function} interfaces.setContents 에디터에 컨텐츠를 덮어쓴다.
   * <pre>
   *   arguments
   *   - text : string
   * </pre>
   * @prop {function} interfaces.addContents 에디터에 컨텐츠를 추가한다.
   * <pre>
   *   arguments
   *   - text : string
   * </pre>
   * @prop {function} interfaces.on 에디터에 이벤트 핸들러를 추가한다.
   * <pre>
   *   arguments
   *   - eventName : string
   *   - callback : function
   * </pre>
   * @prop {function} interfaces.reset 에디터 컨텐츠를 초기화한다.
   * */
  interfaces: {
    initialize: function (selector, options) {

      var options = $.extend(true, {
        fileUpload: {},
        suggestion: {},
        names: {
          file: {
            image: {},
          },
          tag: {},
          mention: {},
        },
        extensions: [],
        fontFamily: [],
        perms: {},
        files: [],
      }, options);

      var $editor = $('#' + selector);
      var height = options.height;
      var fontFamily = options.fontFamily;
      var fontSize = options.fontSize;

      this.addProps({
        editor: $editor, selector: selector, options: options,
      });

      if (height) {
        $editor.css('height', height + 'px');
      }

      if (fontFamily || fontSize) {
        if (fontFamily && fontFamily.length > 0) {
          $editor.css('font-family', fontFamily.join(','));
        }

        if (fontSize) {
          $editor.css('font-size', fontSize);
        }
      }

      $editor.parents('form').on('submit', function () {
        var $contentsTarget = $($editor.val()).clone().wrap('<div>').parent();
        var tagClass = options.names.tag.class;
        var tagInput = options.names.tag.input;
        var $hashTags = $contentsTarget.find('.' + tagClass);
        var tagLen = $hashTags.length;
        var mentionClass = options.names.mention.class;
        var mentionInput = options.names.mention.input;
        var $mentions = $contentsTarget.find('.' + mentionClass);
        var mentionIdentifier = options.names.mention.identifier;
        var mentionLen = $mentions.length;
        var fileInput = options.names.file.input;
        var files = options.files;
        var $paramWrap = $();

        //tag, mention, files input삭제 후 생성
        $editor.nextAll('.paramWrap').remove();
        $editor.after("<div class='paramWrap'>");
        $paramWrap = $editor.nextAll('.paramWrap');

        //hashtag
        if (tagLen > 0) {
          $hashTags.each(function () {
            var val = $(this).text().replace(/#(.+)/g, '$1');

            $paramWrap.append("<input type='hidden' name='" + tagInput + "[]' value='" + val + "' />");
          });
        }

        //mention
        if (mentionLen > 0) {
          $mentions.each(function () {
            var val = $(this).attr(mentionIdentifier);

            $paramWrap.append("<input type='hidden' name='" + mentionInput + "[]' value='" + val + "' />");
          });
        }

        //files
        if (files.length > 0) {
          for (var i = 0, max = files.length; i < max; i += 1) {
            var file = files[i];

            $paramWrap.append("<input type='hidden'name='" + fileInput + "[]' value='" + file.id + "' />");
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
    },

    reset: function () {
      //contents 삭제
      this.props.editor.val('').focus();

      //input hidden 삭제
      this.props.editor.nextAll('.paramWrap').remove();
    },
  },
});
