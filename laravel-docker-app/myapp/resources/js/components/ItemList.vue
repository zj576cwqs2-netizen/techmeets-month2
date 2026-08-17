<template>
  <div>
    <p v-if="loading">
      読み込み中...
    </p>
    <p v-else-if="error">
      エラーが発生しました
    </p>
    <ul v-else>
      <ItemCard
        v-for="item in items"
        :key="item.id"
        :item="item"
      />
    </ul>
  </div>
</template>

<script setup>
import ItemCard from './ItemCard.vue'

defineProps({
  items: {
    type: Array,
    required: true
  },
  loading: {
    type: Boolean,
    default: false
  },
  error: {
    type: Boolean,
    default: false
  }
})
</script>