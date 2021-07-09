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
                  Roles
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
                  Permissions
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
              <tr v-for="person in people" :key="person.email">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">{{ person.title }}</div>
                  <div class="text-sm text-gray-500">
                    {{ person.department }}
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">{{ person.title }}</div>
                  <div class="text-sm text-gray-500">
                    {{ person.department }}
                  </div>
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
                  <a href="#" class="text-indigo-600 hover:text-indigo-900"
                    >Edit</a
                  >
                  <a href="#" class="text-red-600 hover:text-red-900">Delete</a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
const people = [
  {
    name: "Jane Cooper",
    title: "Regional Paradigm Technician",
    department: "Optimization",
    role: "Admin",
    email: "jane.cooper@example.com",
    image:
      "https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60",
  },
  // More people...
];

export default {
  props: {
    roles: Array,
  },

  setup() {
    return {
      people,
    };
  },
};
</script>
