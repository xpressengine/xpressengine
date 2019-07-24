<template>
  <li v-if="media.file" @dblclick="$root.showDetailMedia(media.id)" @click="selectMedia">
    <div class="media-library__input-group media-library-content-list__checkbox">
      <label class="media-library__label">
        <input type="checkbox" class="media-library__input-checkbox" />
        <span class="media-library__input-helper"></span>
      </label>
    </div>
    <div class="media-library-content-list__icon">
      <div class="media-library-content-list__icon-thumb media-library-content-list__icon-preview" :style="{ 'background-image': 'url(' + thumbnailUrl + ')' }"></div>
    </div>
    <div class="media-library-content-list__content-box">
      <div class="media-library-content-list__title">
        <button type="button" class="media-library-content-list__text">
          <span class="media-library-content-list__text-ellipsis">{{ media.title }}</span>
        </button>
      </div>
      <div class="media-library-content-list__writer">
        <span class="media-library-content-list__text">{{ userName }}</span>
      </div>
      <div class="media-library-content-list__size">
        <span class="media-library-content-list__text">{{ filesize }}</span>
      </div>
      <div class="media-library-content-list__date">
        <span class="media-library-content-list__text">{{ date }}</span>
      </div>
    </div>
    <div v-if="false" class="media-library-content-list__more">
      <button type="button" class="media-library__button-ellipsis">
        <span class="blind">파일 관리</span>
      </button>
      <ul class="media-library-content-list__more-list">
        <li>
          <button @click="modify" type="button" class="media-library-content-list__more-list-button">편집하기</button>
        </li>
        <li>
          <button @click="remove" type="button" class="media-library-content-list__more-list-button media-library-content-list__more-list-button--delete">삭제</button>
        </li>
      </ul>
    </div>
  </li>
</template>

<script>
import filesize from 'filesize'
import moment from 'moment'

export default {
  props: ['media'],
  data() {
    return {}
  },
  methods: {
    selectMedia (event) {
      if (event) {
        $(event.target).closest('li').toggleClass('active')
        if ( $(event.target).closest('li').hasClass('active') ) {
          this.$root.putSelectedMedia(this)
          $(event.target).closest('li').find('.media-library__input-checkbox').prop('checked', true)
        } else {
          this.$root.removeSelectedMedia(this)
          $(event.target).closest('li').find('.media-library__input-checkbox').prop('checked', false)
        }
      }
    },
    showMedia (media, event) {
      event.preventDefault()
      if (typeof media.id !== 'undefined') {
        // this.$router.push({ path: `media_manager/show/${media.id}` })
        $('#media-library-modal').modal('show')
        $('#media-library-modal').one('hide.bs.modal', () => {
          // console.debug('back')
          // this.$router.go(-1)
        })
      }
    }
  },
  computed: {
    thumbnailUrl({ $props }) {
      return $props.media.file.url
    },
    userName({ $props }) {
      return $props.media.user.display_name
    },
    filesize({ $props }) {
      return filesize($props.media.file.size)
    },
    date ({ $props }) {
      return moment($props.created_at).format('L')
    }
  }
}
</script>
