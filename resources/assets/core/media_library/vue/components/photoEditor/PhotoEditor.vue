<template>
  <div class="medialibrary-photoeditor"></div>
</template>

<script>
import EventBus from '../eventBus'
import _ from 'lodash'

export default {
  props: ['media'],
  mounted: function() {
    const that = this

    EventBus.$on('photoeditor.command', function(command, args) {
    })

    EventBus.$on('photoeditor.save', function(command, args) {
    })
  },
  data: function() {
    return {
      command: []
    }
  },
  action: {
    addCommand(command, args) {
      this.commnad[command] = args

      EventBus.$on('photoeditor.addCommand')
    },
    resetCommand() {
      this.command = []

      EventBus.$on('photoeditor.resetCommand')
    },
    removeCommand (command) {
      delete this.command[command]
      EventBus.$on('photoeditor.removeCommand', command)
    }
  }
}
</script>
