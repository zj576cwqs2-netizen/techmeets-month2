<<template>
  <form @submit.prevent="submit">
    <input v-model="form.name" placeholder="商品名" required />
    <input v-model.number="form.price" type="number" placeholder="価格" required />
    <button type="submit">登録する</button>
  </form>
</template>

<script setup>
import { ref } from 'vue'

const emit = defineEmits(['create'])

const form = ref({ name: '', price: '' })

function submit() {
  emit('create', { ...form.value })
  form.value = { name: '', price: '' } // 入力欄をリセット
}
</script>