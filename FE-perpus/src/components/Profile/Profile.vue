<template>
  <div class="mx-auto px-8 py-20 my-100 rounded-xl bg-gray-100" style="max-width: 90%">
    <div class="max-w-lg mx-auto my-10 bg-white rounded-lg shadow-md p-5">
      <img class="w-32 h-32 rounded-full mx-auto" src="https://picsum.photos/200" alt="Profile picture">
      <h2 class="text-center text-2xl font-semibold mt-3">{{ authStore.currentUser.name }}</h2>
      <p class="text-center text-gray-600 mt-1">{{ authStore.currentUser.email }}</p>
      <div class="flex justify-center mt-5">
        <a href="#" class="mx-3"></a>
        <RouterLink :to="{ name: 'ProfileChange' }" class="text-blue-500 hover:text-blue-700 mx-3">Update / Edit Profile
        </RouterLink>
        <a href="#" class="mx-3"></a>
      </div>
      <div class="mt-5">
        <h3 class="text-xl font-semibold">Bio</h3>
        <p class="text-gray-600 mt-2">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source.</p>
      </div>
    </div>
  </div>
</template>

<script setup>

import { useAuthStore } from "@/stores/AuthStore";
import { reactive, onMounted } from "vue";

const authStore = useAuthStore();
const { updateUser } = authStore;

const userInput = reactive({
  name: "",
});

onMounted(() => {
  userInput.name = authStore.currentUser.name || "";
});

const handleUpdateData = () => {
  updateUser(userInput);
  // console.log(userInput);
};

</script>