<template>
  <div class="mx-auto px-8 py-20 my-100 rounded-xl" style="max-width: 90%">

    <RouterLink :to="{ name: 'AddCategory' }" class="btn btn-error mb-10" v-if="authStore.currentUser && authStore.currentUser.role.name ===
      'owner'">Add Data</RouterLink>

    <div class="flex flex-col items-center justify-center grid md:grid-cols-2 lg:grid-cols-3 pd">
      <div v-if="!categoryAllData" class="flex items-center justify-center">
        <span class="loading loading-dots loading-lg text-6xl"></span>
      </div>
      <div
        class="card bg-base-100 image-full w-96 mb-10 shadow-xl z-0 w-full sm:w-80 md:w-96 transition duration-300 ease-in-out hover:scale-110"
        v-for="category in categoryAllData" v-else>
        <figure>
          <img class="bg-slate-400 w-full" />
        </figure>
        <div class="card-body">
          <h2 class="card-title">{{ category.name }}</h2>
          <div class="card-actions justify-end">


            <RouterLink :to="{ name: 'DetailCategory', params: { id: category.id } }" class="btn btn-primary">
              Detail<span class="pi pi-arrow-circle-right"></span>
            </RouterLink>

            <RouterLink :to="{ name: 'UpdateCategory', params: { id: category.id } }" class="btn btn-error text-white"
              v-if="authStore.currentUser && authStore.currentUser.role.name ===
                'owner'">
              Edit<span class="pi pi-pencil"></span>
            </RouterLink>

            <button class="btn btn-neutral" @click="deleteCategory(category.id)" v-if="authStore.currentUser && authStore.currentUser.role.name ===
              'owner'">
              Delete<span class="pi pi-trash"></span>
            </button>
          </div>
        </div>
      </div>
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
  showAllCategory()
})

const categoryAllData = ref("")
const showAllCategory = async () => {
  try {
    const { data } = await customeAPI.get('/category')
    categoryAllData.value = data.data
  } catch (error) {
    console.log(error);
  }
}

const deleteCategory = async (inp) => {
  try {
    const { data } = await customeAPI.post(`/category/${inp}?_method=DELETE`, null,
      {
        headers: { Authorization: `Bearer ${authStore.tokenUser}` },
      }
    )

    alert("Sukses Delete Category")
    router.push({ name: "Category" })
    location.reload()
  } catch (error) {
    console.log(error);
  }
}
</script>