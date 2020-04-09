<template>
  <li v-if="media.file" @dblclick="showMedia(media.id)" @click="selectMedia">
    <div class="media-library__input-group media-library-content-list__checkbox">
      <label class="media-library__label">
        <input type="checkbox" class="media-library__input-checkbox" />
        <span class="media-library__input-helper"></span>
      </label>
    </div>

    <div class="media-library-content-list__icon">
      <div
        :class="{
          'media-library-content-list__icon-thumb': true,
          'media-library-content-list__icon-preview': preview,
          'media-library-content-list__icon-etc': !preview
        }"
        :style="{ 'background-image': thumbnailBackground }">{{ (!preview) ? ext : '' }}</div>
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
import EventBus from './eventBus'

import ModalSlotsDetailBody from './modal/slots/detail-body.vue'

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
    showMedia (mediaId, event) {
      if (typeof mediaId !== 'undefined') {
        EventBus.$emit('modal.open', mediaId, {
          headerTitle: '파일 상세정보',
          body: ModalSlotsDetailBody
        })
      }
    }
  },
  computed: {
    ext ({ $props }) {
      return $props.media.ext
    },
    preview () {
      return !!this.thumbnailUrl
    },
    thumbnailUrl({ $props }) {
      if (typeof $props.media.file.thumbnail_url !== 'undefined') {
        return $props.media.file.thumbnail_url
      } else if (typeof $props.media.file.url !== 'undefined') {
        return $props.media.file.url
      }

      return false;
    },
    thumbnailBackground({ $props }) {
      if (!!this.thumbnailUrl) {
        return `url('${$props.media.file.url}')`
      }

      return false
    },
    userName({ $props }) {
      if ($props.media.user) {
        return $props.media.user.display_name || ''
      }
      return ''
    },
    filesize({ $props }) {
      return filesize($props.media.file.size)
    },
    date ({ $props }) {
      return moment($props.media.updated_at).format('L')
    }
  }
}
</script>
