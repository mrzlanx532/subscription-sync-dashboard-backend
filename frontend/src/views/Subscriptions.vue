<script setup lang="ts">
import {ref, onMounted, reactive} from "vue";
import { BButton, BTable } from "buefy";
import api from "@/api.js";

const data = ref([])
const customers = ref([])

const initialParams = {
  customer_id: undefined
}
const params = reactive({ ...initialParams })

const fetch = async () => {
  try {
    const response = await api.get(`/subscriptions`, {
      params
    })

    data.value = response.data
  } catch (e) {
    console.error(e)
  }
}

const onChangeFilter = async () => {
  await fetch()
}

const onResetFilters = async () => {
  Object.assign(params, initialParams)
  await fetch()
}

const loadFilters = async () => {
  try {
    const response = await api.get(`/customers`)

    customers.value = response.data
  } catch (e) {
    console.error(e)
  }
}

onMounted(async () => {
  await Promise.all([
    loadFilters(),
    fetch()
  ])
})
</script>

<template>

  <div class="filters-panel" v-if="data.length">
    <div class="filters">
      <b-select v-model="params.customer_id" class="select" @change="onChangeFilter" placeholder="Клиент">
        <option
            v-for="option in customers"
            :value="option.id"
            :key="option.id"
        >
          {{ option.value }}
        </option>
      </b-select>
    </div>
    <b-button @click="onResetFilters">Сбросить фильтры</b-button>
  </div>

  <b-table :data="data">

    <template #empty>
      <div class="has-text-centered py-5">
        Нет данных
      </div>
    </template>

    <b-table-column
        field="id"
        label="ID"
        v-slot="props"
    >
      {{ props.row.id }}
    </b-table-column>

    <b-table-column
        field="stripe_id"
        label="Stripe ID"
        v-slot="props"
    >
      {{ props.row.stripe_id }}
    </b-table-column>

    <b-table-column
        field="customer"
        label="Клиент"
        v-slot="props"
    >
      {{ props.row.customer.name }}
    </b-table-column>

    <b-table-column
        field="created_at"
        label="Дата создания"
        v-slot="props"
    >
      {{ props.row.created_at }}
    </b-table-column>

    <b-table-column
        field="status"
        label="Статус"
        v-slot="props"
    >
      <b-tag>
        {{ props.row.status }}
      </b-tag>
    </b-table-column>
  </b-table>
</template>

<style scoped>
.filters-panel {
  padding: 16px;
  border-radius: 6px;
  background-color: var(--bulma-background);
  margin-bottom: 16px;
  display: flex;
  justify-content: space-between;
}

.select {
}
</style>