<template>
  <div>
    <Modal v-if="modal" v-on:closeModal="onCloseModal"></Modal>
    <div class="header">
      <div class="header-navigation">
        <sui-button primary @click="toggleModal">Add Media</sui-button>
      </div>
      <div class="header-filter">
        <sui-input placeholder="Name" disabled />
        <sui-dropdown text="Type" floating>
          <sui-dropdown-menu>
            <sui-dropdown-item>Image</sui-dropdown-item>
            <sui-dropdown-item>PDF</sui-dropdown-item>
            <sui-dropdown-item>Video</sui-dropdown-item>
          </sui-dropdown-menu>
        </sui-dropdown>
        <sui-dropdown text="Retired" floating>
          <sui-dropdown-menu>
            <sui-dropdown-item>True</sui-dropdown-item>
            <sui-dropdown-item>False</sui-dropdown-item>
          </sui-dropdown-menu>
        </sui-dropdown>
        <sui-input placeholder="Tags" />
      </div>
      <div class="header-icon">
        <sui-dropdown icon="eye" floating multiple>
          <sui-dropdown-menu>
            <sui-dropdown-item
              >ID <i class="fa fa-check" style="font-size: 14px"></i
            ></sui-dropdown-item>
            <sui-dropdown-item @click="showNameTableColumn"
              >Name
              <i
                v-if="nameTableColumn"
                class="fa fa-check"
                style="font-size: 14px"
              ></i
            ></sui-dropdown-item>
            <sui-dropdown-item>Type</sui-dropdown-item>
            <sui-dropdown-item>Thumbnail</sui-dropdown-item>
            <sui-dropdown-item>Duration</sui-dropdown-item>
            <sui-dropdown-item>Size</sui-dropdown-item>
            <sui-dropdown-item>Owner</sui-dropdown-item>
            <sui-dropdown-item>Permission</sui-dropdown-item>
            <sui-dropdown-item>File Name</sui-dropdown-item>
            <sui-dropdown-item>Created</sui-dropdown-item>
            <sui-dropdown-item>Modified</sui-dropdown-item>
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
            <sui-table-header-cell
              v-if="nameTableColumn"
              @click="orderByTableListName"
              >Name
              <sui-icon
                v-if="sortTableListName"
                :name="
                  this.tableListNameASC
                    ? 'sort alphabet up'
                    : 'sort alphabet down'
                "
            /></sui-table-header-cell>
            <sui-table-header-cell>Thumbnail</sui-table-header-cell>
            <sui-table-header-cell>Duration</sui-table-header-cell>
            <sui-table-header-cell @click="orderByTableListSize"
              >Size
              <sui-icon
                v-if="sortTableListSize"
                :name="
                  this.tableListSizeASC ? 'sort amount down' : 'sort amount up'
                "
            /></sui-table-header-cell>
            <sui-table-header-cell>Owner</sui-table-header-cell>
            <sui-table-header-cell>Permission</sui-table-header-cell>
            <sui-table-header-cell>File Name</sui-table-header-cell>
            <sui-table-header-cell></sui-table-header-cell>
          </sui-table-row>
        </sui-table-header>
        <TableRow
          v-for="list in tableList"
          v-bind:key="list.id"
          v-bind:list="list"
          v-bind:nameTableColumn="nameTableColumn"
        ></TableRow>
      </sui-table>
    </div>
    <div class="footer">
      <sui-button primary>Primary</sui-button>
    </div>
  </div>
</template>

<script>
  import axios from 'axios';
  import _ from 'lodash';

  import Modal from './components/Modal';
  import TableRow from './components/TableRow';
  import '../css/index.css';

  export default {
    mounted() {
      axios
        .get('http://127.0.0.1:8000/media/data')
        .then((res) => (this.tableList = res.data));
    },
    components: {
      Modal: Modal,
      TableRow: TableRow,
    },
    data() {
      return {
        nameTableColumn: true,
        tableList: {},
        modal: false,
        tableListNameASC: true,
        sortTableListName: false,
        sortTableListSize: false,
        tableListIdASC: true,
        tableListSizeASC: true,
        tableListFileNameASC: true,
      };
    },
    methods: {
      showNameTableColumn() {
        this.nameTableColumn = !this.nameTableColumn;
      },
      toggleModal() {
        this.modal = !this.modal;
      },
      onCloseModal() {
        this.modal = false;
        axios
          .get('http://127.0.0.1:8000/media/data')
          .then((res) => (this.tableList = res.data));
      },
      onUpdate() {
        this.modal = false;
        axios
          .get('http://127.0.0.1:8000/media/data')
          .then((res) => (this.tableList = res.data));
      },
      orderByTableListName() {
        this.sortTableListSize = false;
        this.sortTableListName = true;
        if (this.tableListNameASC) {
          let sortedTableListByNameASC = _.orderBy(
            this.tableList,
            ['name'],
            'asc'
          );
          this.tableList = sortedTableListByNameASC;
          this.tableListNameASC = false;
        } else {
          let sortedTableListByNameDESC = _.orderBy(
            this.tableList,
            ['name'],
            'desc'
          );
          this.tableList = sortedTableListByNameDESC;
          this.tableListNameASC = true;
        }
      },
      orderByTableListSize() {
        this.sortTableListName = false;
        this.sortTableListSize = true;
        let parsedSize = _.forEach(this.tableList, (val) => {
          let number = parseInt(val.size);
          val.size = number;
        });
        if (this.tableListSizeASC) {
          let sortedMediaBySizeASC = _.orderBy(parsedSize, 'size', 'asc');
          this.tableList = sortedMediaBySizeASC;
          this.tableListSizeASC = false;
        } else {
          let sortedMediaBySizeDESC = _.orderBy(parsedSize, ['size'], 'desc');
          this.tableList = sortedMediaBySizeDESC;
          this.tableListSizeASC = true;
        }
      },
    },
  };
</script>

<style scoped>
  .ui.multiple.dropdown {
    padding: 0 !important;
  }
</style>
