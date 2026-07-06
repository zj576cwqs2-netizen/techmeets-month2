<template>
    <div class="card">
        <h3>{{ item.name }}</h3>
        <p>価格: ¥{{ item.price }}</p>
    </div>
</template>

<script setup>
defineProps({
    item: {
        type: Object,
        required: true
    }
})
</script>