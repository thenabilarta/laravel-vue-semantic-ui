<template>
  <sui-table-body>
    <sui-table-row v-if="list">
      <sui-table-cell>{{ list.media_id }}</sui-table-cell>
      <sui-table-cell v-if="nameTableColumn">{{ list.name }}</sui-table-cell>
      <sui-table-cell class="td-table-image">
        <img
          class="table-image"
          :src="`/storage/uploads/${list.file_name}`"
          alt=""
        />
      </sui-table-cell>
      <sui-table-cell>{{ list.duration }}</sui-table-cell>
      <sui-table-cell>{{ list.size }}</sui-table-cell>
      <sui-table-cell>Admin</sui-table-cell>
      <sui-table-cell>Null</sui-table-cell>
      <sui-table-cell>{{ list.file_name }}</sui-table-cell>
      <sui-table-cell>
        <sui-dropdown floating>
          <sui-dropdown-menu>
            <sui-dropdown-item @click="toEdit">Edit</sui-dropdown-item>
            <sui-dropdown-item @click="toDelete">Delete</sui-dropdown-item>
          </sui-dropdown-menu>
        </sui-dropdown>
      </sui-table-cell>
      <EditTableRow
        v-on:closeModal="onCloseModal"
        v-if="isEditing"
      ></EditTableRow>
    </sui-table-row>
  </sui-table-body>
</template>

<script>
  import EditTableRow from './EditTableRow';

  export default {
    components: {
      EditTableRow: EditTableRow,
    },
    name: 'TableRow',
    props: {
      list: Object,
      index: Number,
      nameTableColumn: Boolean,
    },
    data() {
      return {
        listProps: this.list,
        isEditing: false,
      };
    },
    methods: {
      toDelete() {
        console.log(this.listProps.media_id);
      },
      toEdit() {
        this.isEditing = true;
      },
      onCloseModal() {
        this.isEditing = false;
      },
    },
  };
</script>
