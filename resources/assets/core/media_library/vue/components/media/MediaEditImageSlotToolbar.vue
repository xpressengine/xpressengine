<template>
  <div class="media-library-layer-popup_button-box" style="display: flex;">
    <div class="media-library-button-data">
      <button
        @click="toggleDropdown"
        type="button"
        class="media-library__button media-library__button--subtle media-library__button--icon"
      >
        <span class="media-library__button-icon media-library__button-icon--crop"></span>
      </button>
      <ul class="media-library-button-data__list">
        <li>
          <button @click="crop('free')" type="button" class="media-library-button-data__button">임의</button>
        </li>
        <li>
          <button @click="crop('original')" type="button" class="media-library-button-data__button">원본 비율</button>
        </li>
        <li>
          <button @click="crop(1)" type="button" class="media-library-button-data__button">정사각형</button>
        </li>
        <li>
          <button @click="crop(1.777777778)" type="button" class="media-library-button-data__button">16:9</button>
        </li>
        <li>
          <button @click="crop(1.333333333)" type="button" class="media-library-button-data__button">4:3</button>
        </li>
        <li>
          <button @click="crop(1.5)" type="button" class="media-library-button-data__button">3:2</button>
        </li>
      </ul>
    </div>

    <button
      v-if="!modeCommand"
      @click="cropperRotate"
      type="button"
      class="media-library__button media-library__button--subtle media-library__button--icon"
    >
      <span class="media-library__button-icon media-library__button-icon--rotation"></span>
    </button>

    <button
      @click="reset"
      type="button"
      class="media-library__button media-library__button--subtle"
    >재설정</button>
  </div>
</template>

<script>
import EventBus from '../eventBus'

export default {
  props: ['media'],
  data: function() {
    return {
      modeCommand: null
    }
  },
  mounted: function() {
    EventBus.$on('photoeditor.modeCommand', payload => {
      this.modeCommand = payload.command
    })
  },
  computed: {},
  methods: {
    crop (ratio) {
      EventBus.$emit('photoeditor.cropper.crop', {
        ratio
      })
    },
    toggleDropdown (event) {
      let button = event.target
      if (event.target.tagName !== 'BUTTON') {
        button = event.target.parentElement
      }

      const $dropdownList = $(button).siblings('ul')

      $dropdownList.one('click', function () {
        $dropdownList.hide()
      })

      $dropdownList.show()
    },
    cropperRotate() {
      EventBus.$emit('photoeditor.cropper.rotate', -90)
    },
    reset() {
      EventBus.$emit('photoeditor.reset')

      this.$store.dispatch('media/replaceMedia', {
        id: this.$props.media.id,
        data: {
          objectURL: null
        }
      })

      EventBus.$emit('photoeditor.complete')
    }
  }
}
</script>
