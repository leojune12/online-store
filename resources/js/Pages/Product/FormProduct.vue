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
                        <!-- Images -->
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="images" value="Product Image" />
                            <div id="images" class="flex flex-wrap gap-x-6 mt-1">
                                <!-- Cover Image -->
                                <div class="col-span-6 sm:col-span-4">
                                    <image-input
                                        id="cover_image"
                                        v-model:model-image="form.cover_image"
                                        v-model:model-default-image="cover_image"
                                        v-model:image-id="form.cover_image_id"
                                    />
                                    <jet-label for="cover_image" value="Cover Image" class="mt-1 text-center" />
                                </div>

                                <!-- Image 1 -->
                                <div class="col-span-6 sm:col-span-4">
                                    <image-input
                                        id="image_1"
                                        v-model:model-image="form.image_1"
                                        v-model:model-default-image="image_1"
                                        v-model:image-id="form.image_1_id"
                                    />
                                    <jet-label for="image_1" value="Image 1" class="mt-1 text-center" />
                                </div>

                                <!-- Image 2 -->
                                <div class="col-span-6 sm:col-span-4">
                                    <image-input
                                        id="image_2"
                                        v-model:model-image="form.image_2"
                                        v-model:model-default-image="image_2"
                                        v-model:image-id="form.image_2_id"
                                    />
                                    <jet-label for="image_2" value="Image 2" class="mt-1 text-center" />
                                </div>

                                <!-- Image 3 -->
                                <div class="col-span-6 sm:col-span-4">
                                    <image-input
                                        id="image_3"
                                        v-model:model-image="form.image_3"
                                        v-model:model-default-image="image_3"
                                        v-model:image-id="form.image_3_id"
                                    />
                                    <jet-label for="image_3" value="Image 3" class="mt-1 text-center" />
                                </div>
                            </div>
                            <jet-input-error :message="form.errors.cover_image" class="mt-2" />
                            <jet-input-error :message="form.errors.image_1" class="mt-2" />
                            <jet-input-error :message="form.errors.image_2" class="mt-2" />
                            <jet-input-error :message="form.errors.image_3" class="mt-2" />
                        </div>

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

                        <!-- Price -->
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="price" value="Price" />
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                    &#8369;
                                </span>
                                <input
                                    type="number"
                                    name="price"
                                    class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300"
                                    autocomplete="price"
                                    v-model="form.price"
                                />
                            </div>
                            <jet-input-error :message="form.errors.price" class="mt-2" />
                        </div>

                        <!-- Stock -->
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="stock" value="Stock" />
                            <jet-input
                                id="stock"
                                type="number"
                                class="mt-1 block w-full"
                                v-model="form.stock"
                                autocomplete="stock"
                            />
                            <jet-input-error :message="form.errors.stock" class="mt-2" />
                        </div>

                        <!-- Condition -->
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="condition" value="Condition" />
                            <select id="condition" name="condition" autocomplete="condition" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" v-model="form.condition">
								<option value="1">New</option>
								<option value="0">Used</option>
							</select>
                            <jet-input-error :message="form.errors.condition" class="mt-2" />
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
							class="bg-purple-600 text-white hover:bg-purple-700"
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
        product: {
            type: Object,
        },
        cover_image: {
            type: Object
        },
        image_1: {
            type: Object,
            default: null
        },
        image_2: {
            type: Object,
            default: null
        },
        image_3: {
            type: Object,
            default: null
        },
    },

    data() {
		return {
			form: this.$inertia.form({
				name: this.product?.name ?? null,
                description: this.product?.description ?? null,
                category: this.product?.category_id ?? "",
                price: this.product?.price ?? 1,
                stock: this.product?.stock ?? 1,
                condition: this.product?.condition ?? 1,

                cover_image: null,
                image_1: null,
                image_2: null,
                image_3: null,

                cover_image_id: null,
                image_1_id: null,
                image_2_id: null,
                image_3_id: null,
			}),
		};
    },

    methods: {
		submitProduct() {
			if (this.title == "Create") {
				this.form.post(route("products.store"), {
					errorBag: "submitProduct",
					preserveScroll: true,
				});
			} else {
				this.form.post(route("products.update-product", this.product.slug), {
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
