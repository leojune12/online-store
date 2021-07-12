<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Roles
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <jet-form-section @submitted="submitRole">
                    <template #title>
                        {{ title }} Role
                    </template>

                    <template #description>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua
                    </template>

                    <template #form>

                        <!-- Name -->
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="role" value="Role Name" />
                            <jet-input id="role" type="text" class="mt-1 block w-full" v-model="form.name" autocomplete="role" />
                            <jet-input-error :message="form.errors.name" class="mt-2" />
                        </div>
                    </template>

                    <template #actions>
                        <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                            Saved.
                        </jet-action-message>

                        <inertia-link href="/permissions" class="mr-2">
                            <jet-secondary-button type="button" class="bg">
                                Cancel
                            </jet-secondary-button>
                        </inertia-link>

                        <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Save
                        </jet-button>
                    </template>
                </jet-form-section>
            </div>
        </div>
    </app-layout>
</template>

<script>

import AppLayout from "@/Layouts/AppLayout";
import JetButton from '@/Jetstream/Button'
import JetFormSection from '@/Jetstream/FormSection'
import JetInput from '@/Jetstream/Input'
import JetInputError from '@/Jetstream/InputError'
import JetLabel from '@/Jetstream/Label'
import JetActionMessage from '@/Jetstream/ActionMessage'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'

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
    },

    props: {
        title: {
            type: String,
            default: "Create"
        },
        role: {
            type: Object,
            default: {
                id: null,
                name: null
            }
        }
    },

    data () {
        return {
            form: this.$inertia.form({
                name: this.role.name,
            }),
        }
    },

    methods: {
        submitRole () {

            if (this.title == 'Create') {

                this.form.post(route('permissions.store'), {
                    errorBag: 'submitRole',
                    preserveScroll: true,
                })
            } else {

                this.form['_method'] = 'PUT'

                console.log(this.form)

                this.form.post(route('permissions.update', this.role.id), {
                    errorBag: 'submitRole',
                    preserveScroll: true,
                })
            }
        },
    },
}
</script>

<style>

</style>
