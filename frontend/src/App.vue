<script setup>
import Menu from '@/components/Menu.vue'
</script>

<template>
  <div class="cabinet-bg">
    <div class="orb orb-a"></div>
    <div class="orb orb-b"></div>
    <div class="orb orb-c"></div>
  </div>
  <main class="shell">
    <section id="screen-cabinet">
      <div class="cabinet-layout">
        <Menu />
        <div class="page">
          <router-view />
        </div>
      </div>
    </section>
  </main>
</template>