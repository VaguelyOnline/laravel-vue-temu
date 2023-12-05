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

    <MainLayout>
        <h1 style="color: rgb(32, 125, 255)">
            {{ product.title }}

            <Link :href="route('products.edit', product)" v-if="permissions.update" class="btn btn-outline-secondary me-3 ms-5">Edit</Link>
            <Link :href="route('products.email.preview', product)" class="btn btn-outline-secondary me-3">Preview email</Link>
            <button :disabled="networking" v-if="permissions.delete" @click="deleteProduct" class="btn btn-outline-danger">Delete</button>
        </h1>

        <div class="row">
            <div class="col-md-9">
                <p>
                    {{ product.description }}
                </p>

                <Link class="btn btn-outline-secondary" :href="route('products.index')">View all products</Link>
            </div>
            <div class="col-md-3">
                <img 
                    v-for="image in product.images" 
                    :key="image.id" 
                    :src="image.url"
                    class="img-fluid mb-3 img-thumbnail"> 
            </div>
        
        </div>
    </MainLayout>
</template>
