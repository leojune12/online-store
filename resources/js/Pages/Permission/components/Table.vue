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
                                  class="
                                    px-6
                                    py-3
                                    text-left text-xs
                                    font-medium
                                    text-gray-500
                                    uppercase
                                    tracking-wider
                                  "
                                >
                                    ID
                                </th>
                                <th
                                  scope="col"
                                  class="
                                    px-6
                                    py-3
                                    text-left text-xs
                                    font-medium
                                    text-gray-500
                                    uppercase
                                    tracking-wider
                                  "
                                >
                                    Role
                                </th>
                                <th
                                  scope="col"
                                  class="
                                    px-6
                                    py-3
                                    text-left text-xs
                                    font-medium
                                    text-gray-500
                                    uppercase
                                    tracking-wider
                                  "
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
                                    <!-- <div v-for="permission in role.permissions" :key="permission.id" class="text-sm text-gray-500">
                                      {{ role.name }}
                                    </div> -->
                                </td>
                                <td
                                    class="
                                      px-6
                                      py-4
                                      whitespace-nowrap
                                      text-sm
                                      font-medium
                                      flex flex-1
                                      gap-x-3
                                    "
                                >
                                    <a href="#" class="text-green-600 hover:text-green-900"
                                      >View</a
                                    >
                                    <a :href="roles.path + '/' + role.id + '/edit'" class="text-indigo-600 hover:text-indigo-900"
                                      >Update</a
                                    >
                                    <a href="#" class="text-red-600 hover:text-red-900">Delete</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <pagination :pagination="roles" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import Pagination from "@/Components/Pagination"

export default {

    components: {
      Pagination,
    },

    props: {
      roles: Object,
    },

};
</script>
