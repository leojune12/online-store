<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Shop</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <alert />

                <jet-form-section @submitted="submitShop">
                    <template #title> {{ title }} Shop </template>

                    <template #description>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                        eiusmod tempor incididunt ut labore et dolore magna aliqua
                    </template>

                    <template #form>
                        <!-- Profile Photo -->
                        <div class="col-span-6 sm:col-span-4">
                            <!-- Profile Photo File Input -->
                            <input
                                type="file"
                                class="hidden"
                                ref="photo"
                                @change="updatePhotoPreview"
                                accept="image/*"
                            >

                            <jet-label for="photo" value="Cover Photo" />

                            <!-- Profile Photo -->
                            <div class="mt-2 bg-gray-200">
                                <!-- Current Profile Photo -->
                                <img :src="getCoverPhoto" :alt="shop.name" class="w-full h-80 object-contain" v-if="!photoPreview">

                                <!-- New Profile Photo Preview -->
                                <span class="block w-full h-80"
                                    :style="'background-size: contain; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'" v-else>
                                </span>
                            </div>

                            <jet-secondary-button class="mt-2 mr-2" type="button" @click.prevent="selectNewPhoto">
                                Select A New Photo
                            </jet-secondary-button>

                            <jet-secondary-button type="button" class="mt-2" @click.prevent="deletePhoto" v-if="cover_photo">
                                Remove Photo
                            </jet-secondary-button>

                            <jet-input-error :message="form.errors.photo" class="mt-2" />
                        </div>

                        <!-- Name -->
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="name" value="Shop Name" />
                            <jet-input
                                id="name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.name"
                                autocomplete="name"
                            />
                            <jet-input-error :message="form.errors.name" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="description" value="Shop Description" />
                            <textarea-component
                                id="description"
                                rows="3"
                                class="mt-1 block w-full"
                                v-model="form.description"
                                autocomplete="description"
                            />
                            <jet-input-error :message="form.errors.description" class="mt-2" />
                        </div>
                    </template>

                    <template #actions>
                        <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                        Saved.
                        </jet-action-message>

                        <jet-button
                        class="bg-emerald-500 text-white hover:bg-emerald-600"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        >
                        {{ title }} Shop
                        </jet-button>
                    </template>
                </jet-form-section>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import JetButton from "@/Jetstream/Button";
import JetFormSection from "@/Jetstream/FormSection";
import JetInput from "@/Jetstream/Input";
import JetInputError from "@/Jetstream/InputError";
import JetLabel from "@/Jetstream/Label";
import JetActionMessage from "@/Jetstream/ActionMessage";
import JetSecondaryButton from "@/Jetstream/SecondaryButton";
import TextareaComponent from "@/Components/Textarea";
import Alert from "@/Components/Alert";

export default {
    components: {
        AppLayout,
        JetActionMessage,
        JetButton,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
        JetSecondaryButton,
        TextareaComponent,
        Alert,
    },

    props: {
        title: {
            type: String,
            default: "Create",
        },
        shop: {
            type: Object,
            default: {
                id: null,
                name: null,
                description: null,
            },
        },
        cover_photo: {
            type: String,
        }
    },

    data() {
        return {
            form: this.$inertia.form({
                name: this.shop.name,
                description: this.shop.description,
                photo: null
            }),

            photoPreview: null,
        };
    },

    computed: {
        getCoverPhoto () {
            return this.cover_photo ? this.cover_photo : 'https://ui-avatars.com/api/?name=' + this.shop.name + '&color=7F9CF5&background=EBF4FF'
        }
    },

    methods: {
        submitShop() {

            if (this.$refs.photo) {
                this.form.photo = this.$refs.photo.files[0]
            }

            if (this.title == "Create") {
                this.form.post(route("shop.store"), {
                    errorBag: "submitShop",
                    preserveScroll: true,
                });
            } else {
                this.form.post(route("shop.update-info", this.shop.id), {
                    errorBag: "submitShop",
                    preserveScroll: true,
                });
            }
        },

        updateProfileInformation() {
            if (this.$refs.photo) {
                this.form.photo = this.$refs.photo.files[0]
            }

            this.form.post(route('user-profile-information.update'), {
                errorBag: 'updateProfileInformation',
                preserveScroll: true,
                onSuccess: () => (this.clearPhotoFileInput()),
            });
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
            this.$inertia.delete(route('shop.delete-cover-photo', this.shop.id), {
                preserveScroll: true,
                onSuccess: () => {
                    this.photoPreview = null;
                    this.clearPhotoFileInput();
                },
            });
        },

        clearPhotoFileInput() {
            if (this.$refs.photo?.value) {
                this.$refs.photo.value = null;
            }
        },
    },
};
</script>

<style>
</style>
