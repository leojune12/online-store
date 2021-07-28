<template>
    <app-layout>
		<template #header>
			<h2 class="font-semibold text-xl text-gray-800 leading-tight">Products</h2>
		</template>

        <div class="text-gray-600 body-font">
			<!-- <div class="container px-5 py-24 mx-auto"> -->
			<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-24">
				<!-- <div class="flex flex-wrap gap-2"> -->
				<div class="grid lg:grid-cols-6 md:grid-cols-4 grid-cols-2 gap-4">
      				<item v-for="item in products.data" :key="item.id" :item="item" />
				</div>
			</div>
    	</div>
    </app-layout>
</template>

<script>
import Item from "@/Components/Item";
import AppLayout from "@/Layouts/AppLayout";

export default {
  components: {
    Item,
    AppLayout,
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
