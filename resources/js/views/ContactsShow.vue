<template>
    <div>

        <div v-if="loading" class="text-blue-500 text-xl font-semibold mx-auto h-screen flex justify-center items-center">Loading ...</div>

        <div v-else>

            <div class="flex justify-between items-center">
                <div class="text-blue-400">
                    <a href="#" @click="$router.back()"> < Back </a>
                </div>

                <div class="relative">
                    <router-link :to="`/contacts/${contact.contact_id}/edit`" class="px-4 py-2 text-green-500 border border-green-500 text-sm font-bold rounded">Edit</router-link>
                    <a href="#" class="px-4 py-2 text-red-500 border border-red-500 text-sm font-bold rounded" @click="modal = ! modal">Delete</a>

                    <div v-if="modal" class="absolute bg-blue-900 text-white rounded-lg z-20 p-8 w-64 right-0 mt-2 mr-6">
                        <p>Are you sure you want to delete this record?</p>
                        <div class="mt-6 flex items-center justify-end">
                            <button class="mr-4 focus:outline-none" @click="modal = ! modal">Cancel</button>
                            <button class="px-4 py-2 bg-red-500 rounded text-sm font-bold focus:outline-none" @click="destroy">Delete</button>
                        </div>
                    </div>

                </div>

                <div v-if="modal" class="absolute inset-0 bg-black opacity-25 z-10" @click="modal = ! modal"></div>

            </div>

            <div class="flex items-center mt-6">
                <UserCircle :name="contact.name" />
                <p class="pl-5 text-xl">{{ contact.name }}</p>
            </div>

            <p class="uppercase text-sm font-bold text-gray-600 pt-6">Contact</p>

            <p class="pt-2 text-blue-500">{{ contact.email }}</p>

            <p class="uppercase text-sm font-bold text-gray-600 pt-6">Company</p>

            <p class="pt-2 text-blue-500">{{ contact.company }}</p>

            <p class="uppercase text-sm font-bold text-gray-600 pt-6">Birthday</p>

            <p class="pt-2 text-blue-500">{{ contact.birthday }}</p>

        </div>

    </div>
</template>

<script>
import UserCircle from '../components/UserCircle'
export default {
    name: 'ContactsShow',
    components: {
        UserCircle,
    },
    data() {
        return {
            contact: null,
            errors: null,
            loading: true,
            modal: false,
        }
    },
    mounted() {
        axios.get(`/api/contacts/${this.$route.params.id}`)
            .then(response => {
                this.loading = false
                this.contact = response.data.data
            })
            .catch(errors => {
                this.loading = false
                this.errors = errors.response.data.errors
                if (errors.response.status === 404) {
                    this.$router.push('/contacts')
                }
            })
    },
    methods: {
        destroy() {
            axios.delete(`/api/contacts/${this.contact.contact_id}`)
                .then(response => this.$router.push('/contacts'))
                .catch(errors => alert('Internal Error. Unable to delete contact'))
        }
    }
}
</script>

<style>

</style>
