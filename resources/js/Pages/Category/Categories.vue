<template>
    <app-layout>
		<template #header>
			<h2 class="font-semibold text-xl text-gray-800 leading-tight">Categories</h2>
		</template>

		<div class="py-10">
			<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
				<alert />
                <div class="flex justify-between items-center mb-3 sm:ml-0 ml-3">
					<inertia-link
						:href="route('categories.create')"
						class="rounded bg-emerald-500 text-white px-3 py-1 hover:bg-emerald-600 flex items-center"
					>
						Add Category
					</inertia-link>
				</div>
				<div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
					<data-table :categories="categories" />
				</div>
			</div>
		</div>
	</app-layout>
</template>

<script>

    import AppLayout from "@/Layouts/AppLayout";
	import Alert from "@/Components/Alert"
	import DataTable from "@/Pages/Category/components/Table";

	export default {
		components: {
			AppLayout,
			Alert,
			DataTable,
		},

		props: {
			categories: Object,
		},
	};

</script>

<style>

</style>
