(function ($, XE, _) {
  $.widget('xe.uioMedialibraryImage', {
    // default options
    options: {
      valueTarget: 'media_id',
      name: 'image[]',
      seq: 0,
      preview: true,
      limit: 0,
      typeFilter: 'image/*',
      files: [],
      image: null,
      templates: {
        // previewContainer: '<ul class="xeuio-ml__preview"></ul>',
        previewItem: '<li class="xeuio-ml__preview-item"><input type="hidden" class="xeuio-ml__field" name="image[]"><img class="xeuio-ml__preview-image" /><button type="button" class="xeuio-ml__button xeuio-ml__remove">삭제</button></li>',
        addItem: '<li class="xeuio-ml__add-item"><button type="button" class="xeuio-ml__button xeuio-ml__add"><i class="xi-plus"></i> 추가</button></li>',
      }
    },


    // The constructor
    _create: function () {
      const that = this
      const $medialibraryContainer = $(this.element)

      if (_.has(that, 'options.browser')) {
        XE.app('MediaLibrary').then(function (appMediaLibrary) {
          appMediaLibrary.createUploader($medialibraryContainer.find('input[type="file"]'), {instance_id: that.options.instanceId}, {
            dropZone: $medialibraryContainer,
            dragover: function () {
              $medialibraryContainer.addClass('drag')
            },
            dragleave: function () {
              $medialibraryContainer.removeClass('drag')
            },
            drop: function () {
              $medialibraryContainer.removeClass('drag')
            }
          })
          $medialibraryContainer.on('done.upload.editor', function (event, media) {
            if (event.type !== 'done') {
              XE.toast('danger', '이미지 업로드에 실패하였습니다.');
              return;
            }
            that.options.files.push({
              file_id: _.get(media, 'file.file_id', null),
              media_id: _.get(media, 'file.id', null),
              preview: _.get(media, 'file.file.thumbnail_url', null)
            });
            that._refresh()
          })
        })
      } else {
        $medialibraryContainer.on('click', '.xeuio-ml__add', function () {
          that._importFile()
        })
      }

      $medialibraryContainer.on('click', '.xeuio-ml__remove', function () {
        const $previewItem = $(this).closest('li')
        that._removeFile($previewItem.find('input').val())
      })

      this.options.limit = Number(this.options.limit)
      this._refresh()
    },

    // Called when created, and later when changing options
    _refresh: function () {
      this._renderList()

      if (this.options.field && $(this.options.field).length) {
        if (this.options.files[0]) {
          $(this.options.field).val(_.get(this.options.files[0], 'file_id', null))
        } else {
          $(this.options.field).val(null)
        }
      }

      if (this.options.limit === 1) {
        if ($(this.element).find('.xeuio-ml__preview-item').length >= 1) {
          $(this.element).find('.xeuio-ml__add-item').hide()
        } else {
          $(this.element).find('.xeuio-ml__add-item').show()
        }
      }

      $(this.element).trigger('media/uploadedPreviewMounted')
    },

    _importFile: function () {
      var that = this

      XE.app('MediaLibrary').then(function (appMediaLibrary) {
        appMediaLibrary.open({
          selected: function (mediaList) {
            var list = []
            _.forEach(mediaList, function (media) {
              list.push({
                media_id: media.id,
                file_id: media.file_id,
                preview: _.get(media, 'file.url', null)
              })
            })

            that._addFiles(list)
            that._refresh()
          }
        })
      })
    },

    _removeFile: function (targetId) {
      var that = this
      this.options.files.splice(_.findIndex(this.options.files, function (item) {
        return item.file_id === targetId
      }), 1)
      that._refresh()
    },

    _renderList: function () {
      var that = this
      var fileList = this._getFiles()
      var $tempEl = $('<ul>')

      _.forEach(fileList, function (file) {

        var $item = $(that.options.templates.previewItem)
        var fieldValue = (that.options.valueTarget === 'file_id') ? file.fileId() : file.mediaId()

        $item.find('.xeuio-ml__preview-image').attr('src', file.previewUrl())
        $item.find('.xeuio-ml__field')
          .attr('name', that.options.name)
          .val(fieldValue)

        $tempEl.append($item)
      })

      if (!that.options.limit || fileList.length < that.options.limit) {
        if (!_.isEmpty(that.options.browser)) {
          $tempEl.append($(that.options.templates.addItem))
        }
      }

      $(this.element).find('.xeuio-ml__preview').empty().append($tempEl.find('li'))
    },

    _addFiles: function (files) {
      var that = this
      _.forEach(files, function (file) {
        that._addFile(file)
      })
    },

    _addFile: function (file) {
      var that = this

      // 파일 수 제한
      if (that.options.limit) {
        if (that.options.limit === 1) {
          that.options.files = [file]
        } else if (that.options.files.length >= that.options.limit) {
          return
        }
      }

      this.options.files.push(file)
    },

    _getFiles: function () {
      var that = this
      var files = []

      if (that.options.limit) {
        that.options.files = that.options.files.slice(0, that.options.limit)
      }

      _.forEach(this.options.files, function (item) {
        files.push(new FileItem(item))
      })

      return files
    },

    // Events bound via _on are removed automatically
    // revert other modifications here
    _destroy: function () {

      // remove generated elements
      // this.changer.remove()

      // this.element
      //   .removeClass('custom-colorize')
      //   .enableSelection()
      //   .css('background-color', 'transparent')
    },

    _renderMedia: function (payload, $form) {
      var that = this
      var $container
      var isCover = false
      var media = this._normalizeFileData(payload)

      this.options.$el.fileThumbsContainer.removeClass('xe-hidden')

      if (this.options.useSetCover && window.XE.Utils.isImage(media.mime)) {
        isCover = media.fileId === that.options.coverId
      }

      if (window.XE.Utils.isImage(media.mime)) {
        if (!this.options.coverId) {
          this.options.coverId = media.fileId
          this._setCover(media.fileId)
        }
        $container = $form.find(this.options.$el.fileThumbsContainer).find('.thumbnail-list')
      } else {
        $container = $form.find(this.options.$el.fileListContainer)
      }

      if ($container.find('[data-id=' + media.fileId + ']').length) {
        return
      }

      var html = []
      var itemClass = ['file-item']
      if (isCover) {
        itemClass.push('is-cover')
      }
      if (!window.XE.Utils.isImage(media.mime)) {
        itemClass.push('xe-col-md-6')
      }

      html.push('<li class="' + itemClass.join(' ') + '" data-media-id="' + media.mediaId + '" data-id="' + media.fileId + '" title="' + media.title + '">')

      if (window.XE.Utils.isImage(media.mime)) {
        html.push('<img src="' + media.imageUrl + '" alt="' + media.title + '">')
      } else {
        html.push('<div class="file-item-group">')
        html.push('<p class="filename xe-pull-left">' + media.title + '</p>')
      }

      // 커버로 지정
      if (this.options.useSetCover && window.XE.Utils.isImage(media.mime)) {
        html.push('<button type="button" class="btn-cover">' + XE.Lang.trans('ckeditor::cover') + '</button>')
      }

      // 첨부 삭제
      if (window.XE.Utils.isImage(media.mime)) {
        html.push('<button type="button" class="btn-delete btnDelFile"><i class="xi-close"></i><span class="xe-sr-only">' + XE.Lang.trans('ckeditor::deleteAttachment') + '</span></button>')
      } else {
        html.push('<div class="xe-pull-right"><button type="button" class="btn-insert"><i class="xi-arrow-up"></i></button><button type="button" class="btn-delete"><i class="xi-close"></i><span class="xe-sr-only">' + XE.Lang.trans('ckeditor::deleteAttachment') + '</span></button></div>')
      }

      // 본문 삽입
      if (window.XE.Utils.isImage(media.mime)) {
        html.push('<button type="button" class="btn-insert"><i class="xi-arrow-up"></i></button>')
      }

      html.push('<input type="hidden" name="' + this.options.names.file.input + '[]" value="' + media.fileId + '" />')

      if (!window.XE.Utils.isImage(media.mime)) {
        html.push('</div>')
      }

      html.push('</li>')

      var $item = $(html.join(''))

      // 커버로 지정
      $item.on('click', '.btn-cover', function () {
        that._setCover(media.fileId)
      })

      // 삭제, 제거
      $item.find('.btn-delete').on('click', function () {
        that._removeFromDocument({
          fileId: media.fileId,
          mediaId: media.mediaId || null
        })
        $item.remove()

        if (!that.options.names.cover) {
          if (this.options.$el.fileThumbsContainer.find('[name=' + that.options.names.cover.input + ']').val() == media.fileId) {
            this.options.$el.fileThumbsContainer.find('[name=' + that.options.names.cover.input + ']').val('')
          }
        }
      })

      // 본문 삽입
      $item.find('.btn-insert').on('click', function () {
        that._insertToDocument(media)
      })


      $container.append($item)
    },


    // _setOptions is called with a hash of all options that are changing
    // always refresh when changing options
    _setOptions: function () {
      // _super and _superApply handle keeping the right this-context
      this._superApply(arguments)
      this._refresh()
    },

    // _setOption is called for each individual option that is changing
    _setOption: function (key, value) {
      this._super(key, value)
    }
  })

  var FileItem = function (item) {
    this.item = item

    var that = this

    return {
      fileId: function () {
        return _.get(that.item, 'file_id', null)
      },
      mediaId: function () {
        return _.get(that.item, 'media_id', null)
      },
      mime: function () {
        return _.get(that.item, 'mime', null)
      },
      previewUrl: function () {
        return _.get(that.item, 'preview', null)
      },
      hasPreview: function () {
        return !!_.get(that.item, 'preview', false)
      },

      raw: this.item
    }
  }


})(window.jQuery, window.XE, window._)
