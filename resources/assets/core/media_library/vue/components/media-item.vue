<template>
  <li class>
    <div class="media-library__input-group media-library-content-list__checkbox">
      <label class="media-library__label">
        <input type="checkbox" class="media-library__input-checkbox" @click="selectMedia">
        <span class="media-library__input-helper"></span>
      </label>
    </div>
    <div class="media-library-content-list__icon">
      <div
        class="media-library-content-list__icon-thumb"
        style="background-image: url(https://www.xpressengine.io/plugins/official_homepage/Components/Themes/ThemeV3/assets/img/img-spot.png)"
      ></div>
    </div>
    <div class="media-library-content-list__content-box">
      <div class="media-library-content-list__title">
        <span class="media-library-content-list__text">{title}</span>
      </div>
      <div class="media-library-content-list__writer">
        <span class="media-library-content-list__text">admin</span>
      </div>
      <div class="media-library-content-list__size">
        <span class="media-library-content-list__text">{filesize}</span>
      </div>
      <div class="media-library-content-list__date">
        <span class="media-library-content-list__text">2019.05.16</span>
      </div>
    </div>
    <div class="media-library-content-list__more">
      <button type="button" class="media-library__button-ellipsis">
        <span class="blind">편집하기, 삭제 팝업 버튼</span>
      </button>
      <ul class="media-library-content-list__more-list">
        <li>
          <button type="button" class="media-library-content-list__more-list-button">편집하기</button>
        </li>
        <li>
          <button type="button" class="media-library-content-list__more-list-button media-library-content-list__more-list-button--delete">삭제</button>
        </li>
      </ul>
    </div>
  </li>
</template>

<script>
import filesize from "filesize";

export default {
  props: ["media"],
  data() {
    return {};
  },
  mounted() {},
  methods: {
    selectMedia: function(event) {
      if (event) {
        console.debug('event.target', $(event.target).closest('li'))
        $(event.target).closest('li').toggleClass('active')

        if ($(event.target).closest('li').hasClass('active')) {
          this.$root.putSelectedMedia(this);
        } else {
          this.$root.removeSelectedMedia(this);
        }
      }
    },
    showMedia(media, event) {
      event.preventDefault();
      if (typeof media.id !== "undefined") {
        this.$router.push({ path: `media_manager/show/${media.id}` });
        $("#media-library-modal").modal("show");
        $("#media-library-modal").one("hide.bs.modal", () => {
          console.debug("back");
          this.$router.go(-1);
        });
      }
    }
  },
  computed: {
    thumbnailUrl({ $props }) {
      const media = $props.media;
      return "/storage/app/" + media.file.path + "/" + media.file.filename;
    },
    userName({ $props }) {
      const media = $props.media;
      return media.user.display_name;
    },
    userProfileImage({ $props }) {
      return $props.media.user.profile_image_url;
    },
    filesize({ $props }) {
      return filesize($props.media.file.size);
    }
  }
};
</script>
