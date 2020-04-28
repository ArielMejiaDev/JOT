<template>
    <div>
        <div class="pl-6 bg-gray-200 w-48 h-screen border-r-2 border-gray-400">
            <nav class="pt-4">
                <router-link to="/">
                    <Logo :classnames="'text-blue-600 w-12 h-12'"/>
                </router-link>
                <p class="uppercase text-gray-500 font-bold text-xs pt-12">Create</p>
                <router-link to="/contacts/create" class="flex items-center hover:text-blue-600 py-2 text-sm">
                    <PlusIcon />
                    <div class="tracking-wide pl-3">Add new</div>
                </router-link>
                <p class="uppercase text-gray-500 font-bold text-xs pt-12">General</p>
                <router-link to="/contacts" class="flex items-center hover:text-blue-600 py-2 text-sm">
                    <CalendarIcon />
                    <div class="tracking-wide pl-3">Contacts</div>
                </router-link>
                <router-link to="/birthdays" class="flex items-center hover:text-blue-600 py-2 text-sm">
                    <BirthdayCakeIcon />
                    <div class="tracking-wide pl-3">Birthday</div>
                </router-link>
                <p class="uppercase text-gray-500 font-bold text-xs pt-12">Settings</p>
                <router-link to="/logout" class="flex items-center hover:text-blue-600 py-2 text-sm">
                    <LogoutIcon />
                    <div class="tracking-wide pl-3">Logout</div>
                </router-link>
            </nav>
        </div>
    </div>
</template>

<script>
import Logo from './Logo'
import PlusIcon from './PlusIcon'
import CalendarIcon from './CalendarIcon'
import BirthdayCakeIcon from './BirthdayCakeIcon'
import LogoutIcon from './LogoutIcon'
export default {
    name: 'Sidebar',
    components: {
        Logo,
        PlusIcon,
        CalendarIcon,
        BirthdayCakeIcon,
        LogoutIcon,
    }
}
</script>
