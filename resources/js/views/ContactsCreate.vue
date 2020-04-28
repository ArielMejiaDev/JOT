<template>
    <div>
        <form @submit.prevent="submitForm">
            <InputField :label="'contact name'" :name="'name'" :placeholder="'Contact Name'" @update:field="form.name = $event" :errors="errors" />
            <InputField :label="'contact email'" :name="'email'" :placeholder="'Contact Email'" @update:field="form.email = $event" :errors="errors" />
            <InputField :label="'company'" :name="'company'" :placeholder="'Company'" @update:field="form.company = $event" :errors="errors" />
            <InputField :label="'birthday'" :name="'birthday'" :placeholder="'MM/DD/YYYY'" @update:field="form.birthday = $event" :errors="errors" />
            <div class="flex justify-end">
                <button class="py-2 px-4 text-red-700 rounded border hover:border-red-700 mr-5 focus:outline-none focus:border-red-700">Cancel</button>
                <button class="bg-blue-500 py-2 px-4 text-white rounded hover:bg-blue-400 focus:outline-none focus:shadow-outline">Add New Contact</button>
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
            axios.post('/api/contacts', this.form)
                .then(response => {
                    this.$router.push(response.data.links.self)
                })
                .catch(errors => {
                    this.errors = errors.response.data.errors
                })
        }
    }
}
</script>
