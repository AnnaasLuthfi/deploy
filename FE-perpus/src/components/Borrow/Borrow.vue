<template>
    <div class="mx-auto px-8 py-20 my-100 rounded-xl" style="max-width: 90%">
        <h1 class="flex justify-center text-3xl mb-20">List Borrows Books</h1>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

            <table class="w-full text-sm text-left rtl:text-right text-blue-100 dark:text-blue-100">
                <thead class="text-xs text-white uppercase bg-blue-600 border-b border-blue-400 dark:text-white">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Id
                        </th>
                        <th scope="col" class="px-6 py-3">
                            User
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Book
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Book Date
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Return Date
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-blue-600 border-b border-blue-400 hover:bg-blue-500" v-for="borrow in borrowAllData">
                        <th scope="row" class="px-6 py-4 font-medium text-blue-50 whitespace-nowrap dark:text-blue-100">
                            {{ borrow.id }}
                        </th>
                        <td class="px-6 py-4">
                            {{ borrow.user.name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ borrow.books.title }}
                        </td>
                        <td class="px-6 py-4">
                            {{ borrow.borrow_date }}
                        </td>
                        <td class="px-6 py-4">
                            {{ borrow.load_date }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup>
  import { customeAPI } from '@/api';
  import { useAuthStore } from '@/stores/AuthStore';
  import { onMounted, ref } from 'vue';
  import { useRouter } from 'vue-router';
  
  const authStore = useAuthStore()
  const router = useRouter()
  
  onMounted(() => {
    showAllBorrow()
  })
  
  const borrowAllData = ref("")
  const showAllBorrow = async () => {
    try {
      const { data } = await customeAPI.get('/borrow',
        {
          headers: { Authorization: `Bearer ${authStore.tokenUser}` },
        }
      )
      borrowAllData.value = data.data
    } catch (error) {
      console.log(error);
      alert("Terjadi Kesalahan")
    }
  }
</script>