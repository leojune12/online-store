<template>
	<inertia-link :href="route('products.show', item.slug)" class="transform hover:-translate-y-1 hover:shadow-xl delay-75 ease-in transition bg-white">
		<div class="block relative h-48 overflow-hidden">
			<img
				alt="ecommerce"
				class="object-cover object-center w-full h-full block"
				:src="this.item.cover_image_url"
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
				&#8369;{{ price }}
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

	data () {
		return {
			imageBroken: false
		}
	},

	computed: {
		price () {

			return new Intl.NumberFormat('en-IN', { maximumSignificantDigits: 3 }).format(this.item.price)
		},

		imageUrl () {
			return !this.imageBroken ? this.item?.cover_image_url : 'https://ui-avatars.com/api/?name=' + this.item.name + '&color=7F9CF5&background=EBF4FF'
		}
	}
};

</script>

<style lang="">
</style>
