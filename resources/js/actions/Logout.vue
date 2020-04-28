<template>

</template>

<script>
export default {
    name: 'Logout',
    created() {
        axios.post('/logout', {})
            .finally(errors => window.location = '/login')
    }
}
</script>
