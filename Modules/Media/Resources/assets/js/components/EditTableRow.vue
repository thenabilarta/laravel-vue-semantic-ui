<template>
  <div class="edit-table-modal" @click.self="closeModal">
    <div class="edit-table-modal-content">
      <div class="edit-table-modal-header">
        <h1>Edit Media</h1>
      </div>
      <div class="edit-table-modal-body">
        <div class="edit-table-modal-body-1">
          <sui-input placeholder="Media Name" />
          <sui-icon name="plus" inverted bordered fitted />
          <sui-input type="number" class="edit-table-input-number" />
          <sui-icon name="minus" inverted bordered fitted />
        </div>
        <div class="edit-table-modal-body-2">
          <sui-input placeholder="Media Tags" fluid />
        </div>
        <div class="edit-table-modal-body-3">
          <div class="edit-table-modal-body-3-1">
            <input type="checkbox" />
            <p>Retired</p>
          </div>
          <div class="edit-table-modal-body-3-2">
            <input type="checkbox" />
            <p>Update in all layouts where they have benn assigned</p>
          </div>
        </div>
      </div>
      <div class="edit-table-modal-actions">
        <sui-button size="small" color="green">Replace</sui-button>
        <sui-button size="small" color="yellow">Cancel</sui-button>
        <sui-button size="small" color="teal">Help</sui-button>
      </div>
    </div>
  </div>
</template>

<script>
  import '../../css/edit-table-modal.css';

  export default {
    name: 'EditTableRow',
    methods: {
      closeModal() {
        this.$emit('closeModal');
      },
    },
  };
</script>

<style scoped>
  i.icon {
    margin: 0 !important;
  }
</style>
