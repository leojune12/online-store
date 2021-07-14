<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Roles</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div
          v-if="!!alert"
          class="flex items-center p-5 mb-6 gap-x-5 bg-emerald-50 rounded-lg"
        >
          <svg
            style="width: 24px; height: 24px"
            viewBox="0 0 24 24"
            class="text-emerald-500"
          >
            <path
              fill="currentColor"
              d="M12 2C6.5 2 2 6.5 2 12S6.5 22 12 22 22 17.5 22 12 17.5 2 12 2M10 17L5 12L6.41 10.59L10 14.17L17.59 6.58L19 8L10 17Z"
            />
          </svg>
          <span class="font-semibold text-emerald-600">
            {{ alert.message }}
          </span>
        </div>
        <div class="flex justify-between items-center mb-3 sm:ml-0 ml-3">
          <inertia-link
            href="/permissions/create"
            class="
              rounded
              bg-emerald-500
              text-white
              px-3
              py-1
              hover:bg-emerald-600
              flex
              items-center
            "
          >
            Add Role
          </inertia-link>
        </div>
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <roles-table :roles="roles" />

          <!-- <pagination :pagination="roles" /> -->
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
    roles: Object,
    alert: {
      type: Object,
      default: null,
    },
  },
};
</script>

<style>
</style>
