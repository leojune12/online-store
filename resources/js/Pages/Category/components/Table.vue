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
                                    Name
                                </th>
								<th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Slug
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
                            <tr v-for="category in categories.data" :key="category.id">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ category.id }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ category.name }}
                                    </div>
                                </td>
								<td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ category.slug }}
                                    </div>
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium flex flex-1 gap-x-3"
                                >
                                    <Link :href="route('categories.show', category.id)" class="text-green-600 hover:text-green-900">
                                        View
                                    </Link>
                                    <Link :href="route('categories.edit', category.id)" class="text-indigo-600 hover:text-indigo-900">
                                        Update
                                    </Link>
                                    <button type="button" class="text-red-600 hover:text-red-900" @click="confirmCategoryDeletion(category.id)">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <pagination :pagination="categories" />
                </div>
            </div>
        </div>

        <!-- Delete Account Confirmation Modal -->
        <jet-dialog-modal :show="confirmingCategoryDeletion" @close="closeModal">
          <template #title> Delete Category </template>

          <template #content>
            Are you sure?
          </template>

          <template #footer>
            <jet-secondary-button @click="closeModal">
              Cancel
            </jet-secondary-button>

            <jet-danger-button
              class="ml-2"
              @click="deleteCategory"
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
import { Link } from '@inertiajs/inertia-vue3'

export default {

    components: {
        Pagination,
        JetDialogModal,
        JetDangerButton,
        JetSecondaryButton,
        Link
    },

    props: {
        categories: Object,
    },

    data() {
        return {
            confirmingCategoryDeletion: false,

            form: this.$inertia.form({
                category_id: null,
            })
        }
    },

    methods: {
        confirmCategoryDeletion(id) {
            this.confirmingCategoryDeletion = true;
            this.form.category_id = id
        },

        deleteCategory() {
            this.form.delete(route('categories.destroy', this.form.category_id), {
                preserveScroll: true,
                onSuccess: () => this.closeModal(),
            })
        },

        closeModal() {
            this.confirmingCategoryDeletion = false
        },
    },

};
</script>
