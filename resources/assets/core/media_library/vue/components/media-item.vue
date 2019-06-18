<template>
  <li class>
    <div class="media-manager__input-group media-manager-content-list__checkbox">
      <input type="checkbox" class="media-manager__input-checkbox">
    </div>
    <div class="media-manager-content-list__icon">
      <div class="media-manager-content-list__icon-thumb media-manager-content-list__icon-image" v-bind:style="{ 'background-mage': 'url(' + thumbnailUrl + ');' }"></div>
    </div>
    <div class="media-manager-content-list__content-box">
      <div class="media-manager-content-list__title">
        <span class="media-manager-content-list__text"><a href="#" @click="showMedia(media, $event)" data-target="#media-manager-modal">{{ media.title }}</a></span>
      </div>
      <div class="media-manager-content-list__writer">
        <span class="media-manager-content-list__text"><img :src="userProfileImage" style="width: 30px; height: 30px;"> {{ userName }}</span>
      </div>
      <div class="media-manager-content-list__size">
        <span class="media-manager-content-list__text">{{ filesize }}</span>
      </div>
      <div class="media-manager-content-list__date">
        <span class="media-manager-content-list__text">2019.05.16</span>
      </div>
    </div>
    <div class="media-manager-content-list__more">
      <span>모어</span>
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
        $(event.target)
          .closest(".media-item")
          .toggleClass("media-item--selected");

        if (
          $(event.target)
            .closest(".media-item")
            .hasClass("media-item--selected")
        ) {
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
        $("#media-manager-modal").modal("show");
        $("#media-manager-modal").one("hide.bs.modal", () => {
          console.debug("back");
          this.$router.go(-1);
        });
      }
    }
  },
  computed: {
    thumbnailUrl ({ $props }) {
      const media = $props.media;
      return "/storage/app/" + media.file.path + "/" + media.file.filename;
    },
    userName ({ $props }) {
      const media = $props.media;
      return media.user.display_name;
    },
    userProfileImage ({ $props }) {
      return $props.media.user.profile_image_url;
    },
    filesize ({ $props }) {
      return filesize($props.media.file.size);
    }
  }
};
</script>
