<template>
    <div>
        <ContactsList :endpoint="'/api/birthdays'" />
    </div>
</template>

<script>
import ContactsList from '../components/ContactsList'
export default {
    name: 'BirthdaysIndex',
    components: {
        ContactsList,
    },
}
</script>

<style>

</style>
