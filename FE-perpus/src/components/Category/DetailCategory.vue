<template>
  <div class="mx-auto px-8 py-20 my-100 rounded-xl" style="max-width: 90%">
    <div v-if="!category.list_books" class="flex items-center justify-center">
      <span class="loading loading-dots loading-lg text-6xl"></span>
    </div>
    <section v-else>
      <div class="border-b border-primary pb-3">
        <h1 class="text-3xl text-center">{{ category.name }}</h1>
      </div>

      <div v-if="category.list_books.length">
        <div class="flex flex-col items-center justify-center grid md:grid-cols-2 lg:grid-cols-3 mt-7">

          <RouterLink :to="{ name: 'DetailBooks', params: { id: category.id } }" class="group relative flex h-72 w-96 rounded-xl shadow-xl  sm:w-80 md:w-96 mb-10" v-for="category in category.list_books" :key="category.id">
                <div
                    class="z-0 h-full w-full overflow-hidden rounded-xl border  opacity-80 transition duration-300 ease-in-out group-hover:opacity-100 ">
                    <img :src="category.image"
                        class="animate-fade-in block h-full w-full scale-100 transform object-cover object-center opacity-100 transition duration-300 group-hover:scale-110"
                        alt="" />
                </div>
                <div
                    class="absolute bottom-0 z-20 m-0 pb-4 ps-4 transition duration-300 ease-in-out group-hover:-translate-y-1 group-hover:translate-x-3 group-hover:scale-110">
                    <h1 class="font-serif text-2xl font-bold text-white shadow-xl">{{ category.title }}</h1>
                    <h1 class="text-sm font-light text-gray-200 shadow-xl">A Little Paradise in Portugal</h1>
                    
                </div>
            </RouterLink>



        </div>
      </div>

      <div v-else>
        <h1>Film Not Found</h1>
      </div>
    </section>
  </div>
</template>

<script setup>
import { customeAPI } from '@/api';
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';

const route = useRoute()

const category = ref("")
const categoryById = async () => {
  try {
    const { data } = await customeAPI.get(`/category/${route.params.id}`)
    // console.log(data);
    category.value = data.data

  } catch (error) {
    console.log(error);
  }
}

onMounted(() => {
  categoryById()
})


</script>