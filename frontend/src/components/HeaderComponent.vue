<script setup></script>

<template>
  <header class="flex gap-3 py-8 text-right">
    <RouterLink :to="{ name: 'register' }"> Register </RouterLink>
    <RouterLink :to="{ name: 'login' }"> Login </RouterLink>
  </header>
</template>
