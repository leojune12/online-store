<template>
	<app-layout>
		<template #header>
			<h2 class="font-semibold text-xl text-gray-800 leading-tight">Users</h2>
		</template>

		<div class="py-10">
			<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
				<alert
					v-if="!!alert"
					:alert="alert"
				/>
				<div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
					<data-table :users="users" />
				</div>
			</div>
		</div>
	</app-layout>
</template>

<script>

	import AppLayout from "@/Layouts/AppLayout";
	import Alert from "@/Components/Alert"
	import DataTable from "@/Pages/User/components/Table";

	export default {
		components: {
			AppLayout,
			Alert,
			DataTable,
		},

		props: {
			alert: {
				type: Object,
				default: null,
			},
			users: Object,
		},
	};

</script>

<style>
</style>
