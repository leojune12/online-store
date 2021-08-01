<template>
    <textarea class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md"  :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" ref="textarea" />
</template>

<script>
    export default {
        props: ['modelValue'],

        emits: ['update:modelValue'],

        methods: {
            focus() {
                this.$refs.textarea.focus()
            }
        }
    }
</script>
