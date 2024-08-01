<template>
  <div class="mx-auto px-8 py-20 my-100 rounded-xl" style="max-width: 90%">

    <div class="text-center">
      <h2 class="mt-6 text-3xl font-bold text-gray-900">Add / Update profile</h2>
    </div>

    <div class="justify-center flex mt-20">
      <form @submit.prevent="handleData">
        <div class="md:flex md:items-center mb-6">
          <div class="md:w-1/3">
            <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="inline-full-name">
              My Bio
            </label>
          </div>
          <div class="md:w-2/3">
            <input
              class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
              id="inline-full-name" type="text" placeholder="Bio" v-model="formData.bio">
          </div>
        </div>

        <div class="md:flex md:items-center mb-6">
          <div class="md:w-1/3">
            <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="inline-full-name">
              Age
            </label>
          </div>
          <div class="md:w-2/3">
            <input
              class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
              id="inline-full-name" type="number" placeholder="Age" v-model="formData.age">
          </div>
        </div>


        <div class="md:flex md:items-center">
          <div class="md:w-1/3"></div>
          <div class="md:w-2/3">
            <input
              class="shadow bg-purple-500 hover:bg-purple-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded"
              type="submit" value="Submit" />
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { customeAPI } from "@/api";
import { useAuthStore } from "@/stores/AuthStore";
import { reactive } from "vue";
import { useRouter } from "vue-router";

const authStore = useAuthStore()
const router = useRouter()

const formData = reactive({
  bio: "",
  age: "",
  user_id: authStore.currentUser ? authStore.currentUser.id : "Id tidak tersedia",
});


const handleData = async () => {
  try {


    const {data} = await customeAPI.post("/profile", formData, {
      headers: { Authorization: `Bearer ${authStore.tokenUser}` },
    });

    alert("Sukses Update / Add Profile")
    router.push({ name: "Profile" })
  } catch (error) {
    console.log(error);
    alert("Terjadi Kesalahan")
  }
}
</script>