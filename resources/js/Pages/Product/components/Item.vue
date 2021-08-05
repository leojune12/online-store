<template>
	<inertia-link :href="route('products.show', item.slug)" class="transform hover:-translate-y-1 hover:shadow-xl delay-75 ease-in transition bg-white">
		<div class="block relative h-48 overflow-hidden">
			<img
				alt="ecommerce"
				class="object-cover object-center w-full h-full block"
				src="https://picsum.photos/200"
			/>
		</div>
		<div class="mt-4 flex flex-col p-2">
			<div>
				<h3 class="text-gray-500 text-xs tracking-widest title-font mb-1">
					{{ item.category.name }}
				</h3>
				<h2 class="text-gray-900 title-font text-lg font-medium">
					{{ item.name }}
				</h2>
			</div>
			<p class="mt-1 text-orange-500">
				&#8369;{{ getPrice(item.price) }}
			</p>
		</div>
	</inertia-link>
</template>

<script>

export default {
	props: {
		item: {
			type: Object,
		}
	},

	methods: {
		getPrice (price) {

			return new Intl.NumberFormat('en-IN', { maximumSignificantDigits: 3 }).format(price)
		}
	},
};

</script>

<style lang="">
</style>
