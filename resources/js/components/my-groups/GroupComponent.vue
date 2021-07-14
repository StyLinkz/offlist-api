<template>
  <div class="group-item d-flex justify-content-between align-items-center py-4">
    <div class="d-flex align-items-center">
      <div class="group-item__info d-flex flex-column">
        <span class="group-item__name">
          {{ group.name }}
        </span>
        <div class="group-item__description mt-2">
          {{ group.description}}
        </div>
      </div>
    </div>
    <div class="group-item__action d-flex justify-content-end align-items-center">
      <a
        href="javascript:void(0);"
        class="group-item__edit button-icon button-icon--large"
        role="button"
        @click="handleEdit"
      >
        <i class="la la-pencil"></i>
      </a>
      <a
        href="javascript:void(0);"
        class="group-item__delete button-icon button-icon--large ml-3"
        role="button"
        @click="handleDelete"
      >
        <i class="la la-trash"></i>
      </a>
    </div>
  </div>
</template>

<script>
export default {
  props: ["group"],

  data: () => ({}),

  methods: {
    handleEdit() {
      this.$emit('edit', this.group);
    },

    handleDelete() {
      this.$emit('delete', this.group);
    },
  },
};
</script>
