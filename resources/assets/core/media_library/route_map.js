import MediaListContainer from './vue/components/media-list-container.vue'
import MediaDetail from './vue/components/media/media-detail.vue'

export default {
  routes: [
    {
      name: 'home',
      path: '/media_manager',
      components: {
        default: MediaListContainer
      }
    },
    {
      name: 'detail',
      path: '/media_manager/show/:id',
      components: {
        default: MediaListContainer,
        modal_body: MediaDetail
      }
    }
  ]
}
