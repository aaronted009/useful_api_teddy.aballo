<script setup>
import { useAuthStore } from '@/stores/authStore'
import router from '@/router'

const authStore = useAuthStore()

const isUserAuthenticated = authStore.getToken ? true : false
const logout = async () => {
  const loggedOut = await authStore.logout()

  if (loggedOut) {
    router.push('/') // redirect logged out user to home page.
  }
}
</script>

<template>
  <header class="flex gap-3 py-8 text-right">
    <div v-if="isUserAuthenticated">
      <RouterLink :to="{ name: 'dashboard' }"> Dashboard </RouterLink>
      <button type="button" class="cursor-pointer" @click="logout">Logout</button>
    </div>
    <div v-else>
      <RouterLink :to="{ name: 'register' }"> Register </RouterLink>
      <RouterLink :to="{ name: 'login' }"> Login </RouterLink>
    </div>
  </header>
</template>
