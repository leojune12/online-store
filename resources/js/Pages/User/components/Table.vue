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
                                    <span v-for="role in user.roles" :key="role.id" class="text-sm text-white rounded-full py-1 px-3" :class="getRoleBgColor(role.name)">
                                        {{ role.name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-white rounded-full py-1 px-3" :class="getStatus(user.is_active).bgColor">
                                        {{ getStatus(user.is_active).text }}
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
                                    <a href="#" :class="getAction(user.is_active).textColor" @click="confirmUserDisablement(user.id, user.is_active)">
                                        {{ getAction(user.is_active).text }}
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <pagination :pagination="users" />
                </div>
            </div>
        </div>

        <!-- Disable Account Confirmation Modal -->
        <jet-dialog-modal :show="confirmingUserDisablement" @close="closeModal">
          <template #title> {{ getModalAction.text }} User </template>

          <template #content>
            Are you sure?
          </template>

          <template #footer>
            <jet-secondary-button @click="closeModal">
              Cancel
            </jet-secondary-button>

            <button
                class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:ring disabled:opacity-25 transition ml-2"
                :class="[ form.processing ? 'opacity-25' : '', getModalAction.bgColor ]"
                :disabled="form.processing"
                @click="disableUser"
            >
                {{ getModalAction.text }}
            </button>
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
            confirmingUserDisablement: false,

            form: this.$inertia.form({
                user_id: null,
                is_active: null,
            })
        }
    },

    methods: {
        confirmUserDisablement (id, is_active) {
            this.confirmingUserDisablement = true;
            this.form.user_id = id
            this.form.is_active = !is_active
        },

        disableUser () {
            this.form.post(route('users.disable', this.form.user_id), {
                preserveScroll: true,
                onSuccess: () => this.closeModal(),
            })
        },

        closeModal () {
            this.confirmingUserDisablement = false
        },

        getStatus (is_active) {
            if (is_active) {
                return {
                    text: "Active",
                    bgColor: "bg-green-500"
                }
            } else {
                return {
                    text: "Inactive",
                    bgColor: "bg-red-500"
                }
            }
        },

        getRoleBgColor (role) {
            if (role == 'Superadmin') {
                return 'bg-purple-500'
            } else if (role == 'Admin') {
                return 'bg-yellow-500'
            } else if (role == 'User') {
                return 'bg-blue-500'
            } else {
                return 'bg-gray-500'
            }
        },

        getAction (is_active) {
            if (is_active) {
                return {
                    text: 'Disable',
                    textColor: 'text-red-600 hover:text-red-900',
                    bgColor: 'bg-red-600 hover:bg-red-500 focus:border-red-700 focus:ring-red-200 active:bg-red-600'
                }
            } else {
                return {
                    text: 'Enable',
                    textColor: 'text-green-600 hover:text-green-900',
                    bgColor: 'bg-green-600 hover:bg-green-500 focus:border-green-700 focus:ring-green-200 active:bg-green-600'
                }
            }
        }
    },

    computed: {
        getModalAction () {
            return this.getAction(!this.form.is_active)
        }
    }
};
</script>
