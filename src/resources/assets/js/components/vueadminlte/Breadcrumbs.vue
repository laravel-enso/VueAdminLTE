<template>

	<ol class="breadcrumb">
        <li v-for="breadcrumb in breadcrumbs">
            <a :class="getClass(breadcrumb)"
            	:href="breadcrumb.link || null">
                {{ breadcrumb.label }}
            </a>
        </li>
	</ol>

</template>

<script>

	export default {
		data() {
			return {
				breadcrumbs: Store.breadcrumbs
			}
		},

		methods: {
			getClass(breadcrumb) {
				return breadcrumb.link ? null : 'greyed';
			}
		}
	};

</script>