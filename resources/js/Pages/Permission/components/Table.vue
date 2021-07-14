<!-- This example requires Tailwind CSS v2.0+ -->
<template>
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div
                  class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg"
                >
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    ID
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Role
                                </th>
								<th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Permissions
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="role in roles.data" :key="role.id">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ role.id }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ role.name }}</div>
                                </td>
								<td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900"></div>
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium flex flex-1 gap-x-3"
                                >
                                    <inertia-link :href="roles.path + '/' + role.id + '/edit'" class="text-green-600 hover:text-green-900">
                                        View
                                    </inertia-link>
                                    <inertia-link :href="roles.path + '/' + role.id + '/edit'" class="text-indigo-600 hover:text-indigo-900">
                                        Update
                                    </inertia-link>
                                    <a href="#" class="text-red-600 hover:text-red-900" @click="confirmRoleDeletion(role.id)">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <pagination :pagination="roles" />
                </div>
            </div>
        </div>

        <!-- Delete Account Confirmation Modal -->
        <jet-dialog-modal :show="confirmingRoleDeletion" @close="closeModal">
          <template #title> Delete Role </template>

          <template #content>
            Are you sure?
          </template>

          <template #footer>
            <jet-secondary-button @click="closeModal">
              Cancel
            </jet-secondary-button>

            <jet-danger-button
              class="ml-2"
              @click="deleteRole"
              :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
            >
              Delete
            </jet-danger-button>
          </template>
        </jet-dialog-modal>
    </div>
</template>

<script>

import Pagination from "@/Components/Pagination"
import JetDialogModal from '@/Jetstream/DialogModal'
import JetDangerButton from '@/Jetstream/DangerButton'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'

export default {

    components: {
      Pagination,
      JetDialogModal,
      JetDangerButton,
      JetSecondaryButton
    },

    props: {
      roles: Object,
    },

    data() {
    return {
      confirmingRoleDeletion: false,

      form: this.$inertia.form({
        role_id: null,
      })
    };
  },

  methods: {
    confirmRoleDeletion(id) {
        this.confirmingRoleDeletion = true;
        this.form.role_id = id
    },

    deleteRole() {
        this.form.delete(route('permissions.destroy', this.form.role_id), {
            preserveScroll: true,
            onSuccess: () => this.closeModal(),
        })
    },

    closeModal() {
        this.confirmingRoleDeletion = false
    },
  },

};
</script>
