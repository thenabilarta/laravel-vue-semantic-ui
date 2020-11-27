<template>
  <div>
    <Modal
        v-if="modal"
        v-on:closeModal="onCloseModal"
      ></Modal>
    <div class="header">
      <div class="header-navigation">
        <sui-button primary @click="toggleModal">Add Media</sui-button>
      </div>
      <div class="header-filter">
        <sui-input placeholder="Name" />
        <sui-dropdown text="Type">
          <sui-dropdown-menu>
            <sui-dropdown-item>Image</sui-dropdown-item>
            <sui-dropdown-item>PDF</sui-dropdown-item>
            <sui-dropdown-item>Video</sui-dropdown-item>
          </sui-dropdown-menu>
        </sui-dropdown>
        <sui-dropdown text="Retired">
          <sui-dropdown-menu>
            <sui-dropdown-item>True</sui-dropdown-item>
            <sui-dropdown-item>False</sui-dropdown-item>
          </sui-dropdown-menu>
        </sui-dropdown>
        <sui-input placeholder="Tags" />
      </div>
      <div class="header-icon">
        <sui-dropdown icon="eye">
          <sui-dropdown-menu>
            <sui-dropdown-item>True</sui-dropdown-item>
            <sui-dropdown-item>False</sui-dropdown-item>
          </sui-dropdown-menu>
        </sui-dropdown>
        <i class="fas fa-print"></i>
      </div>
    </div>
    <div class="body">
      <sui-table selectable celled>
        <sui-table-header>
          <sui-table-row>
            <sui-table-header-cell>ID</sui-table-header-cell>
            <sui-table-header-cell>Name</sui-table-header-cell>
            <sui-table-header-cell>Thumbnail</sui-table-header-cell>
            <sui-table-header-cell>Duration</sui-table-header-cell>
            <sui-table-header-cell>Size</sui-table-header-cell>
            <sui-table-header-cell>Owner</sui-table-header-cell>
            <sui-table-header-cell>Permission</sui-table-header-cell>
            <sui-table-header-cell>File Name</sui-table-header-cell>
            <sui-table-header-cell></sui-table-header-cell>
          </sui-table-row>
        </sui-table-header>
        <sui-table-body>
          <sui-table-row>
            <sui-table-cell>1</sui-table-cell>
            <sui-table-cell>John Cena</sui-table-cell>
            <sui-table-cell></sui-table-cell>
            <sui-table-cell>10</sui-table-cell>
            <sui-table-cell>12972</sui-table-cell>
            <sui-table-cell>Admin</sui-table-cell>
            <sui-table-cell>Null</sui-table-cell>
            <sui-table-cell>johncena.jpg</sui-table-cell>
            <sui-table-cell>
              <sui-dropdown>
                <sui-dropdown-menu>
                  <sui-dropdown-item>Edit</sui-dropdown-item>
                  <sui-dropdown-item>Delete</sui-dropdown-item>
                </sui-dropdown-menu>
              </sui-dropdown>
            </sui-table-cell>
          </sui-table-row>
        </sui-table-body>
      </sui-table>
    </div>
    <div class="footer">
      <sui-button primary>Primary</sui-button>
    </div>
  </div>
</template>

<script>
import Modal from "./components/Modal";
import "../css/index.css";

export default {
  components: {
    Modal: Modal,
  },
  data() {
    return {
      modal: false,
    };
  },
  methods: {
    toggleModal() {
      this.modal = !this.modal;
    },
    onCloseModal() {
      this.modal = false;
    },
  },
};
</script>
