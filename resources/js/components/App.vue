<template>
  <div class="h-screen bg-white">
    <div class="flex">

        <Sidebar/>

        <div class="flex flex-col h-screen overflow-y-hidden flex-1">

            <div class="h-16 px-6 flex justify-between items-center border-b border-gray-400">

                <div>{{ title }}</div>

                <div class="flex items-center">
                    <Searchbar />
                    <UserCircle :name="user.name" />
                </div>

            </div>

            <div class="flex flex-col overflow-y-hidden flex-1">
                <router-view class="p-6 overflow-x-hidden border-none"></router-view>
            </div>

        </div>

    </div>
  </div>
</template>

<script>
import Sidebar from './Sidebar'
import UserCircle from './UserCircle'
import Searchbar from './Searchbar'
export default {
    name: 'App',
    components: {
        Sidebar,
        UserCircle,
        Searchbar,
    },
    props: ['user'],
    created() {
        this.title = this.$route.meta.title
        window.axios.interceptors.request.use(
            (config) => {
                if (config.method === 'get') {
                    config.url = config.url + '?api_token=' + this.user.api_token
                    return config
                }
                config.data = {
                    ...config.data,
                    api_token: this.user.api_token
                }
                return config
            }
        )
    },
    data() {
        return {
            title: '',
        }
    },
    watch: {
        // this grabs the next route on "to" and change the value of title,
        // then the watcher detect a title change and by this it change the document title
        // to the title property that will be fill with the "to" route meta property and title property
        $route(to, from) {
            this.title = to.meta.title
        },
        // todo grab the app name from env file using config helper to preserve the value and pass the param to the app to change dinamically the app name in the title
        title() {
            document.title = `${this.title} | Jot - SPA App`
        }
    }
}
</script>

<style lang="scss">

</style>
