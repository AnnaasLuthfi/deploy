<template>
    <div class="mx-auto px-8 py-20 my-100 rounded-xl" style="max-width: 90%">
        <div class="h-full w-full">
            <div class="relative w-full">
                <img :src="book.image"
                    class="mb-3 h-[70vh] w-full rounded-xl 3xl:h-full 3xl:w-full" alt="">
            </div>
            
            <div class="mb-3 flex items-center justify-between px-1 md:items-start">
                <div class="mb-2">
                    <p class="text-lg font-bold text-navy-700"> {{ book.title }} </p>
                    <p class="mt-1 text-sm font-medium text-gray-600 md:mt-2">By Authorrs </p>
                </div>
                <div class="flex flex-row-reverse md:mt-2 lg:mt-0">
                    <RouterLink class="btn btn-active btn-link" :to="{ name: 'AddUpdateBorrow', params: { id: book.id } }">
                        Borrow Book
                    </RouterLink>

                </div>
            </div>
            <h1 class="text-lg font-bold text-navy-700">Summary</h1>
            <div class="flex items-center justify-between md:items-center lg:justify-between ">
                <div class="flex">
                    <p class="!mb-0 text-sm text-brand-500">{{ book.summary }}</p>
                </div>
                
            </div>
        </div>

    </div>


</template>

<script setup>
import { ref, reactive, onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";
import { customeAPI } from "@/api";
import { useAuthStore } from "@/stores/AuthStore";

const route = useRoute();
const book = ref("")
const authStore = useAuthStore()
const router = useRouter()

const bookById = async () => {
  try {
    const { data } = await customeAPI.get(`/book/${route.params.id}`);
    book.value = data.data;
    console.log(book);
  } catch (error) {
    console.error(error);
  }
};

onMounted(()=>{
    bookById()
})


</script>