<template>
    <div class="mx-auto px-8 py-20 my-100 rounded-xl" style="max-width: 90%">
        <div class="text-center">
            <h2 class="mt-6 text-3xl font-bold text-gray-900">Borrow Book</h2>
        </div>

        <div class="justify-center flex mt-20">
            <form @submit.prevent="handleBorrow">
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="borrow-date">
                            Borrow Book
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input
                            class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                            type="date" disabled v-model="bookData.borrow_date">
                    </div>
                </div>

                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="return-date">
                            Return Book
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input
                            class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                            id="return-date" type="date" v-model="bookData.load_date">
                    </div>
                </div>

                <div class="md:flex md:items-center">
                    <div class="md:w-1/3"></div>
                    <div class="md:w-2/3">
                        <input
                            class="shadow bg-purple-500 hover:bg-purple-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded"
                            type="submit" value="Borrow Book" />
                    </div>
                </div>
            </form>
        </div>
    </div>

</template>

<script setup>
import { ref, reactive, onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";
import { customeAPI } from "@/api";
import { useAuthStore } from "@/stores/AuthStore";

const route = useRoute();
const authStore = useAuthStore()
const router = useRouter()


const bookData = reactive({
  borrow_date: "",
  load_date: "",
  book_id: route.params.id,
  user_id: authStore.currentUser ? authStore.currentUser.id : "Id tidak tersedia"
});

const handleBorrow = async () => {
  try {
    if (bookData.load_date < bookData.borrow_date) {
        alert('Maaf tanggal return date tidak boleh lebih kecil dari borrow date')
    } else {
        const response = await customeAPI.post('/borrow', bookData, {
          headers: { Authorization: `Bearer ${authStore.tokenUser}` }
        });
        console.log(response.data);
        router.push({ name: 'DetailBooks' })
        location.reload()
        alert("Sukses Menambah atau Update")
    }
  } catch (error) {
    alert('Terjadi Kesalahan')
    console.error(error);
  }
};

onMounted(() => {
  const today = new Date().toISOString().split('T')[0];
  bookData.borrow_date = today;
});

</script>