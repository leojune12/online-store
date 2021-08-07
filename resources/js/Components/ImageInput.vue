<template>
    <div @click="selectNewPhoto" class="h-20 w-20 border border-gray-400 border-dashed bg-gray-100">
        <div>
            <input
                type="file"
                accept="image/*"
                class="hidden"
                :value="modelValue"
                @input="$emit('update:modelValue', $event.target.value)"
                ref="photo"
                @change="updatePhotoPreview"
            >

            <!-- Current Profile Photo -->
            <div v-show="! photoPreview" class="">
                <img
                    v-if="src"
                    :src="src"
                    alt="image"
                    class="h-20 w-20 object-cover"
                />
                <!-- <svg v-else style="width:60px;height:60px" viewBox="0 0 24 24" class="text-gray-500">
                    <path fill="currentColor" d="M5,15H3V19A2,2 0 0,0 5,21H9V19H5M5,5H9V3H5A2,2 0 0,0 3,5V9H5M19,3H15V5H19V9H21V5A2,2 0 0,0 19,3M19,19H15V21H19A2,2 0 0,0 21,19V15H19M12,8A4,4 0 0,0 8,12A4,4 0 0,0 12,16A4,4 0 0,0 16,12A4,4 0 0,0 12,8M12,14A2,2 0 0,1 10,12A2,2 0 0,1 12,10A2,2 0 0,1 14,12A2,2 0 0,1 12,14Z" />
                </svg> -->
                <svg
                    style="width:32px;height:32px"
                    viewBox="0 0 24 24"
                    class="text-gray-500"    
                >
                    <path fill="currentColor" d="M21 6H17.8L16 4H10V6H15.1L17 8H21V20H5V11H3V20C3 21.1 3.9 22 5 22H21C22.1 22 23 21.1 23 20V8C23 6.9 22.1 6 21 6M8 14C8 18.45 13.39 20.69 16.54 17.54C19.69 14.39 17.45 9 13 9C10.24 9 8 11.24 8 14M13 11C14.64 11.05 15.95 12.36 16 14C15.95 15.64 14.64 16.95 13 17C11.36 16.95 10.05 15.64 10 14C10.05 12.36 11.36 11.05 13 11M5 6H8V4H5V1H3V4H0V6H3V9H5" />
                </svg>
            </div>

            <!-- New Profile Photo Preview -->
            <div v-show="photoPreview">
                <span class="block w-20 h-20"
                        :style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'">
                </span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            modelValue: {
                type: null,
                default: null,
            },
            src: {
                type: String,
                default: null
            }
        },

        emits: ['update:modelValue'],

        data () {
            return {
                photoPreview: null,
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
            },

            deletePhoto() {
                // this.$inertia.delete(route('current-user-photo.destroy'), {
                //     preserveScroll: true,
                //     onSuccess: () => {
                        this.photoPreview = null;
                        this.clearPhotoFileInput();
                    // },
                // });
            },

            clearPhotoFileInput() {
                if (this.$refs.photo?.value) {
                    this.$refs.photo.value = null;
                }
            },
        }
    }
</script>