<template>
    <div
        class="flex items-center p-5 mb-3 gap-x-4 rounded-lg"
        :class="currentStatus.bgColor"
    >
        <svg
            v-if="alert.status == 'success'"
            style="width: 24px; height: 24px"
            viewBox="0 0 24 24"
            class="text-emerald-500"
        >
            <path
            fill="currentColor"
            d="M12 2C6.5 2 2 6.5 2 12S6.5 22 12 22 22 17.5 22 12 17.5 2 12 2M10 17L5 12L6.41 10.59L10 14.17L17.59 6.58L19 8L10 17Z"
        />
        </svg>
        <span class="font-semibold" :class="currentStatus.textColor">
            {{ alert.message }}
        </span>
    </div>
</template>

<script>
export default {

    props: {
        alert: {
            type: Object,
        }
    },

    data () {
        return {
            status: {
                success: {
                    bgColor: 'bg-emerald-50',
                    textColor: 'text-emerald-600'
                }
            }
        }
    },

    computed: {
        currentStatus () {
            if (this.alert.status == 'success') {
                return this.status.success
            }
        }
    }

}
</script>

<style>

</style>