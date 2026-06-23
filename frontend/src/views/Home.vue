<script setup>
import { ref } from 'vue'
import api from "@/api.js";
import { useNotification } from 'buefy'

const isLoading = ref(false)
const Notification = useNotification();

const onClick = async () => {

  isLoading.value = true

  try {
    await api.post('/subscriptions/sync')

    Notification.open({
      duration: 3000,
      message: `Подписки были синхронизированы`,
      position: "is-bottom-right",
      type: "is-success",
      closable: false,
    })
  } catch (e) {
    Notification.open({
      duration: 3000,
      message: `Что-то пошло не так! <b>Синхронизация не удалась</b>`,
      position: "is-bottom-right",
      type: "is-danger",
      closable: false,
    })
  }

  isLoading.value = false
}

</script>
<template>
  <h1 class="title">Приветствую, я тестовое задание для <a class="navbar-brand" href="https://sunshine.group/">
    <img alt="Sunshine company logo" src="/sunshine-group.svg">
  </a></h1>

  <p class="title is-size-6">Для того чтобы синхронизировать подписки нажми кнопку ниже:</p>
  <div class="btn-container">
    <b-button
        expanded
        class="btn"
        type="is-success"
        @click="onClick"
        :loading="isLoading"
    >
      Синхронизировать
    </b-button>
  </div>
</template>

<style scoped lang="css">
  .btn {
    max-width: 240px;
  }
  .btn-container {
    margin-top: 20px;
  }
</style>