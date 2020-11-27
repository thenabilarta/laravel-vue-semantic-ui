<template>
  <div class="my-modal" @click.self="closeModal">
    <div class="my-modal-content">
      <div class="my-modal-header">
        <h1>Add Media</h1>
      </div>
      <div class="my-modal-row">
        <!-- <i class="cloud upload icon"></i>
        <p>Add Files</p> -->
      </div>
      <div class="my-modal-actions">
        <label for="input-file" style="margin: none !important">
          <sui-button positive class="add">Add Files</sui-button>
        </label>
        <input
          type="file"
          id="input-file"
          class="input-file"
          name="input-file"
          v-on:change="onFileChange"
          ref="file"
          multiple
        />
        <sui-button primary>Upload All</sui-button>
        <sui-button color="yellow">Cancel All</sui-button>
      </div>
    </div>
  </div>
</template>

<script>
import "../../css/modal.css";

export default {
  data() {
    return {
      file: {
        fileAttr: [],
        fileSrc: [],
        fileName: [],
      },
    };
  },
  name: "Modal",
  methods: {
    closeModal() {
      this.$emit("closeModal");
    },
    onFileChange(e) {
      let i = 0;
      for (i = 0; i < e.target.files.length; i++) {
        this.file.fileAttr.push(e.target.files[i]);
        this.file.fileSrc.push(URL.createObjectURL(e.target.files[i]));
        console.log(e.target.files[i].name);
        let fileNameFetched = e.target.files[i].name;
        let fileNameFetchedOnly = fileNameFetched.substr(
          0,
          fileNameFetched.lastIndexOf(".")
        );
        this.file.fileName.push(fileNameFetchedOnly);
      }
      console.log(this.file);
    },
  },
};
</script>
