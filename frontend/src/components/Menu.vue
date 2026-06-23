<script setup>
import { ref } from 'vue'

const menu = ref([
  {
    link: '/',
    text: 'Главная'
  },
  {
    link: "/subscriptions",
    text: 'Подписки'
  }
])
</script>

<template>
  <section>
    <b-navbar>
      <template #start>
        <b-navbar-item v-for="menuItem in menu" :href="menuItem.link">
          {{ menuItem.text }}
        </b-navbar-item>
      </template>
    </b-navbar>
  </section>
</template>