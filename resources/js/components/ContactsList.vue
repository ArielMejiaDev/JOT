<template>
    <div>
        <div class="mx-auto h-screen text-blue-500 text-xl font-semibold" v-if="loading">Loading ...</div>
        <div v-else>
            <div v-if="contacts.length === 0">
                No Contacts yet. <router-link to="/contacts/create">Get started</router-link>
            </div>
            <div v-else>
                <div v-for="contact in contacts" :key="contact.contact_id">
                    <router-link :to="`/contacts/${contact.data.contact_id}`" class="flex items-center border-b border-gray-400 p-4 hover:bg-gray-100">
                        <UserCircle :name="contact.data.name" />
                        <div class="pl-4">
                            <p class="text-blue-400 font-bold">{{ contact.data.name }}</p>
                            <p class="text-gray-600">{{ contact.data.company }}</p>
                        </div>
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import UserCircle from '../components/UserCircle'
export default {
    name: 'ContactsList',
    components: {
        UserCircle
    },
    data() {
        return {
            loading: true,
            contacts: null,
        }
    },
    computed: {
        noContactsYet() {
            return this.contacts.length === 0
        }
    },
    props: ['endpoint'],
    mounted() {
        axios.get(this.endpoint)
            .then(response => {
                this.loading = false
                this.contacts = response.data.data
            })
            .catch(errors => {
                this.loading = false
                alert('Unable to fetch data.')
            })
    }
}
</script>
