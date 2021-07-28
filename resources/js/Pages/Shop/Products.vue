<template>
    <app-layout>
		<template #header>
			<h2 class="font-semibold text-xl text-gray-800 leading-tight">Products</h2>
		</template>

        <div class="text-gray-600 body-font">
			<!-- <div class="container px-5 py-24 mx-auto"> -->
			<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-24">
				<!-- <div class="flex flex-wrap gap-2"> -->
				<div class="grid lg:grid-cols-6 md:grid-cols-4 grid-cols-2 gap-4 mb-6">
      				<item v-for="item in products.data" :key="item.id" :item="item" />
				</div>

                <pagination :pagination="products" />
			</div>
    	</div>
    </app-layout>
</template>

<script>
import Item from "@/Pages/Shop/components/Item";
import AppLayout from "@/Layouts/AppLayout";
import Pagination from "@/Components/Pagination"

export default {
  components: {
    Item,
    AppLayout,
    Pagination,
  },

  props: {
    products: {
      type: Object,
    }
  }
};
</script>

<style>
</style>
