<template>
	<app-layout>
		<template #header>
			<h2 class="font-semibold text-xl text-gray-800 leading-tight">Roles</h2>
		</template>

		<div class="py-12">
			<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
				<alert />
				<div class="flex justify-between items-center mb-3 sm:ml-0 ml-3">
					<inertia-link
						:href="route('permissions.create')"
						class="rounded bg-emerald-500 text-white px-3 py-1 hover:bg-emerald-600 flex items-center"
					>
						Add Role
					</inertia-link>
				</div>
				<div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
					<data-table :roles="roles" />
				</div>
			</div>
		</div>
	</app-layout>
</template>

<script>

	import AppLayout from "@/Layouts/AppLayout";
	import Alert from "@/Components/Alert"
	import DataTable from "@/Pages/Permission/components/Table";

	export default {
		components: {
			AppLayout,
			Alert,
			DataTable
		},

		props: {
			roles: Object,
		},
	};

</script>

<style>
</style>
