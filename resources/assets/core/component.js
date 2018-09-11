import App from 'xe/app'
import { eventify } from 'xe/utils'
import moment from 'moment'
import 'xe-common/griper' // @FIXME https://github.com/xpressengine/xpressengine/issues/765
import 'xe-transition' // @FIXME https://github.com/xpressengine/xpressengine/issues/765
import 'xe-modal' // @FIXME https://github.com/xpressengine/xpressengine/issues/765
import 'xe-dropdown' // @FIXME https://github.com/xpressengine/xpressengine/issues/765
import 'xe-tooltip' // @FIXME https://github.com/xpressengine/xpressengine/issues/765
import $ from 'jquery'

export default class Component extends App {
  constructor () {
    super()

    eventify(this)
  }

  static appName () {
    return 'Component'
  }

  boot (XE) {
    if (this.booted()) {
      return Promise.resolve(this)
    }

    return new Promise((resolve) => {
      super.boot(XE)

      moment.locale(this.$$config.getters['lang/current'].code)

      $(() => {
        this.$$xe.app('DynamicLoadManager').then((DynamicLoadManager) => {
          DynamicLoadManager.cssLoad('/assets/core/xe-ui-component/xe-ui-component.css')
        })

        $(document).on('boot.xe.timeago', '[data-xe-timeago]', function () {
          let $this = $(this)
          if ($this.data().xeTimeagoCalled === true) return false

          let dataDate = $this.data('xe-timeago')
          let isTimestamp = (parseInt(dataDate) == dataDate)

          if (isTimestamp) {
            dataDate = moment.unix(dataDate)
          } else {
            dataDate = moment(dataDate)
          }

          $this.text(dataDate.fromNow())
          $this.data().xeTimeagoCalled = true
        })

        $(document).on('boot.xe.dropdown', '[data-toggle=xe-dropdown]', function () {
          $(this).xeDropdown()
        })

        $(document).on('boot.xe.modal', '[data-toggle=xe-modal]', function () {
        })

        $(document).on('boot.xe.tooltip', '[data-toggle=xe-tooltip]', function () {
          $(this).xeTooltip()
        })

        $('[data-xe-timeago]').trigger('boot.xe.timeago')
        $('[data-toggle=xe-dropdown]').trigger('boot.xe.dropdown')
        $('[data-toggle=xe-modal]').trigger('boot.xe.modal')
        $('[data-toggle=xe-tooltip]').trigger('boot.xe.tooltip')
        $('[data-toggle=dropdown]').trigger('boot.dropdown')
      })

      resolve(this)
    })
  }

  /**
  * 시간 설정을 바인딩한다.
  * @memberof module:Component
  */
  timeago () {
    $('[data-xe-timeago]').trigger('boot.xe.timeago')
  }
}
