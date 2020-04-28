<template>
    <div>
        <div class="relative py-4">
            <label :for="name" class="absolute uppercase text-xs font-semibold text-blue-500">{{ label }}</label>
            <input
                type="text"
                :name="name"
                :id="name"
                class="outline-none border-b w-full pt-8 text-gray-900 pb-2 focus:border-blue-400"
                :class="errorInput(name)"
                :placeholder="placeholder"
                v-model="value"
                @input="updateField(name)">
                <p class="text-red-600 text-sm" v-text="errorMessage(name)"></p>
        </div>
    </div>
</template>

<script>
export default {
    name: 'InputField',
    props: [
        'name', 'label', 'placeholder', 'errors', 'data'
    ],
    data() {
        return {
            value: '',
        }
    },
    computed: {
        hasError() {
            return this.errors && this.errors[this.name] && this.errors[this.name].length > 0
        }
    },
    methods: {
        updateField: function() {
            this.clearErrors(this.name)
            this.$emit('update:field', this.value)
        },
        clearErrors: function() {
            if (this.hasError) {
                return this.errors[this.name] = null
            }
        },
        errorMessage() {
            if (this.hasError) {
                return this.errors[this.name][0]
            }
        },
        errorInput() {
            return {
                'error-input' : this.hasError
            }
        }
    },
    watch: {
        data(inputValue) {
            this.value = inputValue
        }
    }
}
</script>

<style scoped>
    .error-input {
        @apply .border-red-500 .border-b-2;
    }
</style>
