<template>
  <div>
    <h2>商品登録</h2>
    <ItemForm @create="createItem" />

    <h2>商品一覧</h2>
    <ItemList
      :items="items"
      :loading="loading"
      :error="error"
    />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import ItemForm from './components/ItemForm.vue'
import ItemList from './components/ItemList.vue'

const items = ref([])
const loading = ref(true)
const error = ref(false)

async function fetchItems() {
  loading.value = true
  try {
    const response = await axios.get('http://localhost/api/items')
    items.value = response.data.data
    error.value = false
  } catch (e) {
    error.value = true
    console.error('取得失敗:', e)
  } finally {
    loading.value = false
  }
}

async function createItem(newItem) {
  try {
    await axios.post('http://localhost/api/items', newItem)
    await fetchItems()
  } catch (e) {
    console.error('登録失敗:', e.response?.data)
  }
}

onMounted(() => {
  fetchItems()
})
</script>