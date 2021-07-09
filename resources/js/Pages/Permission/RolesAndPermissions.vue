<template>
  <app-layout>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <roles-table :roles="roles" />
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import RolesTable from "@/Pages/Permission/components/Table";

export default {
  components: {
    AppLayout,
    RolesTable,
  },

  props: {
    roles: Array,
  },

  data() {
    return {
      //   roles: [],
    };
  },
};
</script>

<style>
</style>
