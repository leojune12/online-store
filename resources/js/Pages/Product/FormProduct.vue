<template>
    <app-layout>
        <template #header>
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">Products</h2>
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
                        <!-- Name -->
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="category" value="Product Name (Minimum of 20)" />
                            <jet-input
                                id="category"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.name"
                                autocomplete="category"
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
  },

  props: {
    title: {
      type: String,
      default: "Create",
    },
    category: {
      type: Object,
      default: {
        id: null,
        name: null,
      },
    },
  },

  data() {
    return {
      form: this.$inertia.form({
        name: this.category.name,
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
