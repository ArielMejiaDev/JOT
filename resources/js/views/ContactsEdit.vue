<template>
    <div>

        <div class="flex justify-between items-center">
            <div class="text-blue-400">
                <a href="#" @click="$router.back()"> < Back </a>
            </div>
        </div>
        <form @submit.prevent="submitForm">
            <InputField :label="'contact name'" :name="'name'" :placeholder="'Contact Name'" @update:field="form.name = $event" :errors="errors" :data="form.name" />
            <InputField :label="'contact email'" :name="'email'" :placeholder="'Contact Email'" @update:field="form.email = $event" :errors="errors" :data="form.email" />
            <InputField :label="'company'" :name="'company'" :placeholder="'Company'" @update:field="form.company = $event" :errors="errors" :data="form.company" />
            <InputField :label="'birthday'" :name="'birthday'" :placeholder="'MM/DD/YYYY'" @update:field="form.birthday = $event" :errors="errors" :data="form.birthday" />
            <div class="flex justify-end">
                <button class="py-2 px-4 text-red-700 rounded border hover:border-red-700 mr-5 focus:outline-none focus:border-red-700">Cancel</button>
                <button class="bg-blue-500 py-2 px-4 text-white rounded hover:bg-blue-400 focus:outline-none focus:shadow-outline">Save</button>
            </div>
        </form>
    </div>
</template>

<script>
import InputField from '../components/InputField'
export default {
    name: 'ContactsCreate',
    components: {
        InputField,
    },
    data() {
        return {
            form: {
                'name': '',
                'email': '',
                'company': '',
                'birthday': '',
            },
            errors: null,
        }
    },
    methods: {
        submitForm() {
            axios.patch(`/api/contacts/${this.$route.params.id}`, this.form)
                .then(response => {
                    this.$router.push(response.data.links.self)
                })
                .catch(errors => {
                    this.errors = errors.response.data.errors
                })
        }
    },
    mounted() {
        axios.get(`/api/contacts/${this.$route.params.id}`)
            .then(response => {
                this.loading = false
                this.form = response.data.data
            })
            .catch(errors => {
                this.loading = false
                this.errors = errors.response.data.errors
                if (errors.response.status === 404) {
                    this.$router.push('/contacts')
                }
            })
    },
}
</script>
