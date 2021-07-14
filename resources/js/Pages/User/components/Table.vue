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
                                    User
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
                                    Status
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
                            <tr v-for="user in users.data" :key="user.id">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ user.id }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ user.name }}
                                    </div>
                                </td>
								<td class="px-6 py-4 whitespace-nowrap">
                                    <span v-for="role in user.roles" :key="role.id" class="text-sm text-white rounded-full py-1 px-3 bg-blue-500">
                                        {{ role.name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-white rounded-full py-1 px-3" :class="[ user.status ? 'bg-green-500' : 'bg-red-500' ]">
                                        {{ getStatus(user.status) }}
                                    </span>
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium flex flex-1 gap-x-3"
                                >
                                    <inertia-link :href="users.path + '/' + user.id + '/edit'" class="text-green-600 hover:text-green-900">
                                        View
                                    </inertia-link>
                                    <inertia-link :href="users.path + '/' + user.id + '/edit'" class="text-indigo-600 hover:text-indigo-900">
                                        Update
                                    </inertia-link>
                                    <a href="#" class="text-red-600 hover:text-red-900" @click="confirmUserDeletion(user.id)">
                                        Disable
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <pagination :pagination="users" />
                </div>
            </div>
        </div>

        <!-- Delete Account Confirmation Modal -->
        <jet-dialog-modal :show="confirmingUserDeletion" @close="closeModal">
          <template #title> Delete User </template>

          <template #content>
            Are you sure?
          </template>

          <template #footer>
            <jet-secondary-button @click="closeModal">
              Cancel
            </jet-secondary-button>

            <jet-danger-button
              class="ml-2"
              @click="deleteUser"
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
        users: Object,
    },

    data() {
        return {
            confirmingUserDeletion: false,

            form: this.$inertia.form({
                user_id: null,
            })
        }
    },

    methods: {
        confirmUserDeletion (id) {
            this.confirmingUserDeletion = true;
            this.form.user_id = id
        },

        deleteUser () {
            this.form.delete(route('permissions.destroy', this.form.user_id), {
                preserveScroll: true,
                onSuccess: () => this.closeModal(),
            })
        },

        closeModal () {
            this.confirmingUserDeletion = false
        },

        getStatus (status) {
            if (status) {
                return "Active"
            } else {
                return "Inactive"
            }
        }
    },

};
</script>
