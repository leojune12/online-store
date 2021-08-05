<template>
    <select id="select" name="select" autocomplete="select" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" v-model="modelValue" ref="select">
        <option value="">Select {{ option }}</option>
        <option v-for="item in items" :key="item.id" :value="item.id">{{ item.name }}</option>
    </select>
</template>

<script>
    export default {
        props: {
            option: {
                type: String,
                default: "Option"
            },
            items: {
                type: Object,
            },
            modelValue: {
                type: null,
            }
        },

        emits: ['update:modelValue'],

        methods: {
            focus() {
                this.$refs.select.focus()
            }
        }
    }
</script>
