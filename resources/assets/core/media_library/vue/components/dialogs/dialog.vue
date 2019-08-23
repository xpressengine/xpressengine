<template>
  <div v-if="visible" :media="media" class="media-library-dialog-popup">
    <div class="media-library-dialog-popup-table">
      <div class="media-library-dialog-popup-table-cell">
        <div class="media-library-dialog-popup-content-box">
          <component :is="slots.content"></component>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import EventBus from '../eventBus'

export default {
  props: ['media'],
  data() {
    return {
      visible: false,
      slots: {
        content: null
      }
    }
  },
  methods: {
    open() {
      this.visible = true
    },
    close() {
      this.visible = false
    }
  },
  created: function() {
    console.debug('dialog created')

    EventBus.$on('dialog.open', (component) => {
      this.visible = true
      this.slots.content = component
    })

    EventBus.$on('dialog.close', () => {
      this.visible = false
    })
  }
}
</script>
