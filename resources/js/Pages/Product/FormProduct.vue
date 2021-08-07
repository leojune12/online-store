<template>
    <app-layout>
        <template #header>
          	<h2 class="font-semibold text-xl text-gray-800 leading-tight">
				Products
			</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <jet-form-section @submitted="submitProduct">
                    <template #title> {{ title }} Product </template>

                    <template #description>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                        eiusmod tempor incididunt ut labore et dolore magna aliqua
                    </template>

                    <template #form>
						<!-- Category -->
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="category" value="Category" />
                            <select id="category" name="category" autocomplete="category" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" v-model="form.category">
								<option value="">Select Category</option>
								<option
									v-for="category in categories"
									:key="category.id"
									:value="category.id"
								>
									{{ category.name }}
								</option>
							</select>
                            <jet-input-error :message="form.errors.category" class="mt-2" />
                        </div>

                        <!-- Name -->
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="product" value="Product Name (Minimum of 20)" />
                            <jet-input
                                id="product"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.name"
                                autocomplete="product"
                            />
                            <jet-input-error :message="form.errors.name" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="description" value="Product Description (Minimum of 20)" />
                            <textarea-component
                                id="description"
                                rows="3"
                                class="mt-1 block w-full"
                                v-model="form.description"
                                autocomplete="description"
                            />
                            <jet-input-error :message="form.errors.description" class="mt-2" />
                        </div>

                        <!-- Photos -->
                        <div class="col-span-6 sm:col-span-4 flex flex-wrap gap-x-4">
                            <!-- Cover Photo -->
                            <div class="col-span-6 sm:col-span-4">
                                <image-input
                                    v-model="form.cover_photo"
                                />
                                <jet-label for="images" value="Cover Photo" />
                                <jet-input-error :message="form.errors.cover_photo" class="mt-2" />
                            </div>

                            <!-- Photo 1 -->
                            <div class="col-span-6 sm:col-span-4">
                                <image-input
                                    v-model="form.photo_1"
                                />
                                <jet-label for="images" value="Photo 1" />
                                <jet-input-error :message="form.errors.photo_1" class="mt-2" />
                            </div>

                            <!-- Photo 2 -->
                            <div class="col-span-6 sm:col-span-4">
                                <image-input
                                    v-model="form.photo_2"
                                />
                                <jet-label for="images" value="Photo 2" />
                                <jet-input-error :message="form.errors.photo_2" class="mt-2" />
                            </div>

                            <!-- Photo 3 -->
                            <div class="col-span-6 sm:col-span-4">
                                <image-input
                                    v-model="form.photo_3"
                                />
                                <jet-label for="images" value="Photo 3" />
                                <jet-input-error :message="form.errors.photo_3" class="mt-2" />
                            </div>
                        </div>
                    </template>

                    <template #actions>
                        <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                        	Saved.
                        </jet-action-message>

                        <inertia-link
							:href="route('categories.index')"
							class="mr-2"
							:class="{ 'opacity-25': form.processing }"
							:disabled="form.processing"
                        >
                        <jet-secondary-button type="button">
                            Cancel
                        </jet-secondary-button>
                        </inertia-link>

                        <jet-button
							class="bg-emerald-500 text-white hover:bg-emerald-600"
							:class="{ 'opacity-25': form.processing }"
							:disabled="form.processing"
                        >
                        	{{ title }}
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
import SelectComponent from "@/Components/Select";
import ImageInput from "@/Components/ImageInput";

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
	  SelectComponent,
      ImageInput
    },

    props: {
        title: {
            type: String,
            default: "Create",
        },
        categories: {
            type: Object,
        },
    },

    data() {
		return {
			form: this.$inertia.form({
				name: null,
				description: null,
				category: "",
                cover_photo: null,
                photo_1: null,
                photo_2: null,
                photo_3: null,
			}),
		};
    },

    methods: {
		submitProduct() {
			if (this.title == "Create") {
				this.form.post(route("categories.store"), {
					errorBag: "submitProduct",
					preserveScroll: true,
				});
			} else {
				this.form.patch(route("categories.update", this.category.id), {
					errorBag: "submitProduct",
					preserveScroll: true,
				});
			}
		},
    },
};
</script>

<style>
</style>
