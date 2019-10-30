<template>
  <div class="media-library">
    <div class="media-library-upload">
      <form method="post" enctype="multipart/form-data">
        여기에 선택한 파일을 드래그해 업로드 하거나 파일을 선택하세요.
        <br />
        <div class="media-library__button media-library__button--primary fileinput-button">
          파일선택
          <input type="file" name="file" multiple class="form-control--file" />
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import $ from 'jquery'
import EventBus from './components/eventBus'

export default {
  props: ['renderMode', 'currentMedia'],
  components: {},
  methods: {},
  created() {
    console.debug('this.$root', this.$root)
    Promise.all([window.XE.Router, window.XE.Lang]).then(() => {
      this.$emit('init')
    })
  },
  mounted: function() {
    const that = this
    console.debug('mounted attachment')

    this.$on('init', () => {
      $(function() {
        if (typeof $.fn.fileupload !== 'undefined') {
          $('.form-control--file').fileupload({
            url: window.XE.route('media_library.upload'),
            dataType: 'json',
            sequentialUploads: true,
            formData: () => {
              return [
                {
                  name: '_token',
                  value: window.XE.options.userToken
                }
              ]
            },
            add: function(e, data) {
              console.debug('image add data', data)
              data.submit()
            },
            done: function(e, data) {
              $.each(data.result.files, function(index, file) {
                $('<p/>')
                  .text(file.name)
                  .appendTo(document.body)
              })
              store.dispatch('media/loadData', {
                folder_id: that.$xe.config.getters['mediaLibrary/currentFolder'].id
              })
            }
          })
        } else {
          console.error('파일 업로더가 없음')
        }
      })
    })
  },
  data() {
    return {
      files: []
    }
  }
}
</script>

