<script>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3'

export default {
    components: {
        MainLayout,
        Head,
        Link
    },
    data() {
        return {
            networking: false
        }
    },
    props: {
        product: {
            required: true,
            type: Object
        },
        permissions: {
            required: false,
            type: Object,
            default() {
                return {};
            }
        }
    },

    methods: {
        deleteProduct() {
            // Consider Sweet alert
            if (confirm('Are you sure?'))
                this.doDelete();
        },

        doDelete() {
            this.networking = true;
            const deleteUrl = route('api.products.destroy', this.product);
            axios.delete(deleteUrl)
                .then(response => {
                    alert('deleted');
                    router.visit(route('products.index'));
                })
                
                // handle any AJAX errors
                .catch(error => {})

                // in any case (success or failure)...
                .then(() => this.networking = false)
        }
    },

    computed: {
        title() {
            return 'Showing ' + this.product.title;
        }
    }
}

</script>

<template>
    <Head :title="title" />


</template>
