<template>
  <div class="my-modal" @click.self="closeModal">
    <div class="my-modal-content">
      <div class="my-modal-header">
        <h1>Add Media</h1>
      </div>
      <div class="my-modal-row">
        <div v-for="(f, index) in file" :key="`f-${index}`" class="single-row">
          <div class="img">
            <img :src="f.fileSrc" alt="" />
          </div>
          <div class="input">
            <sui-input
              :placeholder="f.fileName"
              :error="f.uploadError"
              v-model="f.fileInputName"
              @keydown="inputChangeName(f)"
            />
            <p v-if="f.status === 'ready'">
              Ready to Upload
            </p>
            <sui-progress
              v-else-if="f.status === 'uploading'"
              :percent="f.uploadPercentage"
              :state="f.uploadResult"
            />
            <p v-else>Failed, change the image name</p>
          </div>
          <div class="actions">
            <sui-icon @click="uploadSingle(f)" name="cloud upload" />
            <sui-icon name="times" />
          </div>
        </div>
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
  import axios from 'axios';
  import '../../css/modal.css';

  export default {
    data() {
      return {
        file: [],
        uploading: false,
        uploadResponse: '',
        uploadError: false,
      };
    },
    computed: {
      loadingStatus() {
        if (this.uploadResponse === 'failed') {
          this.uploadError = true;
          return 'error';
        } else if (this.uploadResponse === 'ok') {
          return 'success';
        } else {
          return;
        }
      },
    },
    name: 'Modal',
    methods: {
      inputChangeName(f) {
        f.uploadError = false;
        f.status = 'ready';
      },
      closeModal() {
        this.$emit('closeModal');
      },
      onFileChange(e) {
        let i = 0;
        for (i = 0; i < e.target.files.length; i++) {
          let fileAttr = e.target.files[i];
          let fileSrc = URL.createObjectURL(e.target.files[i]);
          let fileNameFetched = e.target.files[i].name;
          let fileNameFetchedOnly = fileNameFetched.substr(
            0,
            fileNameFetched.lastIndexOf('.')
          );
          let fileName = fileNameFetchedOnly;
          let status = 'ready';
          let uploadPercentage = 0;
          let uploadResult = null;
          let uploadError = false;
          let fileInputName = null;
          this.file.push({
            fileAttr,
            fileSrc,
            fileName,
            status,
            uploadPercentage,
            uploadResult,
            uploadError,
            fileInputName,
          });
        }
        console.log(this.file);
      },
      uploadSingle(f) {
        // this.uploadError = false;
        f.uploadResult = null;
        f.status = 'uploading';
        console.log('Uploading ' + f);
        let formData = new FormData();
        formData.append('file', f.fileAttr);
        formData.append(
          'fileName',
          f.fileInputName ? f.fileInputName : f.fileName
        );
        const config = {
          headers: { 'content-type': 'multipart/form-data' },
          onUploadProgress: function(progressEvent) {
            f.uploadPercentage = parseInt(
              Math.round(progressEvent.loaded / progressEvent.total) * 100
            );
          }.bind(f),
        };
        axios
          .post('http://127.0.0.1:8000/media', formData, config)
          .then((this.uploading = true))
          .then((response) => {
            console.log(response.data);
            if (response.data.status === 'ok') {
              f.uploadResult = 'success';
            } else {
              f.uploadResult = 'error';
              f.uploadError = true;
              f.status = 'error';
              f.uploadPercentage = 0;
            }
          });
      },
    },
  };
</script>

<style scoped>
  i.icon {
    height: auto !important;
  }

  .ui.progress:last-child {
    margin-bottom: 0 !important;
  }
</style>
