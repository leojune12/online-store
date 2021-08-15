<template>
    <div class="relative">

        <!-- Remove Button -->
        <button type="button" class="w-5 h-5 absolute right-1 top-1 rounded-full bg-red-500 text-white hover:bg-red-600 flex items-center justify-center transform hover:scale-105 transition duration-500 ease-in-out" title="Remove" v-if="!!defaultModelUrl || !!photoPreview" @click="clearPhotoFileInput">
            <svg
                style="width:20px;height:20px"
                viewBox="0 0 24 24"
                class=""
            >
                 <path fill="currentColor" d="M12,2C17.53,2 22,6.47 22,12C22,17.53 17.53,22 12,22C6.47,22 2,17.53 2,12C2,6.47 6.47,2 12,2M15.59,7L12,10.59L8.41,7L7,8.41L10.59,12L7,15.59L8.41,17L12,13.41L15.59,17L17,15.59L13.41,12L17,8.41L15.59,7Z" />
            </svg>
        </button>

        <div
            class="h-20 w-20 flex items-center justify-center cursor-pointer hover:bg-gray-100" :class="{ 'border border-purple-400 border-dashed': !photoPreview && !defaultModelUrl }"
            @click="selectNewPhoto"
        >
            <input
                type="file"
                accept="image/*"
                class="hidden"
                @input="$emit('update:modelImage', $refs.photo.files[0])"
                ref="photo"
                @change="updatePhotoPreview"
            >

            <!-- Current Profile Photo -->
            <div v-show="!photoPreview">
                <img
                    v-if="defaultModelUrl"
                    alt="image"
                    :src="defaultModelUrl"
                    class="h-20 w-20 object-cover border"
                />
                <svg
                    v-if="!defaultModelUrl"
                    style="width:24px;height:24px"
                    viewBox="0 0 24 24"
                    class="text-purple-400"
                >
                    <path fill="currentColor" d="M21 6H17.8L16 4H10V6H15.1L17 8H21V20H5V11H3V20C3 21.1 3.9 22 5 22H21C22.1 22 23 21.1 23 20V8C23 6.9 22.1 6 21 6M8 14C8 18.45 13.39 20.69 16.54 17.54C19.69 14.39 17.45 9 13 9C10.24 9 8 11.24 8 14M13 11C14.64 11.05 15.95 12.36 16 14C15.95 15.64 14.64 16.95 13 17C11.36 16.95 10.05 15.64 10 14C10.05 12.36 11.36 11.05 13 11M5 6H8V4H5V1H3V4H0V6H3V9H5" />
                </svg>
            </div>

            <!-- New Profile Photo Preview -->
            <div v-show="photoPreview">
                <span class="block w-20 h-20 border"
                        :style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'">
                </span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            modelImage: {
                type: null,
                default: null,
            },
            modelDefaultImage: {
                type: Object,
                default: null,
            },
            modelId: {
                type: null,
                default: null
            }
        },

        emits: [
            'update:modelImage',
            'update:modelDefaultImage',
            'update:modelId',
        ],

        data () {
            return {
                photoPreview: null,
                showLoadedImage: true
            }
        },

        methods: {
            focus() {
                this.$refs.photo.focus()
            },

            selectNewPhoto() {
                this.$refs.photo.click();
            },

            updatePhotoPreview() {
                const photo = this.$refs.photo.files[0];

                if (! photo) return;

                const reader = new FileReader();

                reader.onload = (e) => {
                    this.photoPreview = e.target.result;
                };

                reader.readAsDataURL(photo);

                if (this.showLoadedImage) {

                    this.showLoadedImage = false

                    this.$emit('update:modelId', this.defaultModelId)
                }
            },

            clearPhotoFileInput() {
                if (this.$refs.photo?.value) {

                    this.photoPreview = null;

                    this.$emit('update:modelImage', null)
                }

                if (this.showLoadedImage) {

                    this.showLoadedImage = false

                    this.$emit('update:modelId', this.defaultModelId)
                }
            },
        },

        computed: {
            defaultModelUrl () {
                return this.showLoadedImage ? this.modelDefaultImage?.url ?? null : null
            },

            defaultModelId () {
                return this.modelDefaultImage?.id ?? null
            },
        }
    }
</script>
