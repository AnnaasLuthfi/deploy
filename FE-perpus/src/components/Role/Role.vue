<template>
  <div class="mx-auto px-8 py-20 my-100 rounded-xl" style="max-width: 90%">
    <div class="mt-10 mb-10">
      <h1 class="text-3xl text-center">Role Maintenance</h1>
    </div>
    <RouterLink :to="{ name: 'AddRole' }" class="btn bg-blue-600 text-white mb-10">Add Role</RouterLink>

    <div v-if="!roleAllData" class="flex items-center justify-center">
      <span class="loading loading-dots loading-lg text-6xl"></span>
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg" v-else>

      <table class="w-full text-sm text-left rtl:text-right text-blue-100 dark:text-blue-100">
        <thead class="text-xs text-white uppercase bg-blue-600 border-b border-blue-400 dark:text-white">
          <tr>
            <th scope="col" class="px-6 py-3">
              Id
            </th>
            <th scope="col" class="px-6 py-3">
              Role
            </th>
            <th scope="col" class="px-6 py-3">
              Action
            </th>
          </tr>
        </thead>
        <tbody>
          <tr class="bg-blue-600 border-b border-blue-400 hover:bg-blue-500" v-for="role in roleAllData">
            <th scope="row" class="px-6 py-4 font-medium text-blue-50 whitespace-nowrap dark:text-blue-100">
              {{ role.id }}
            </th>
            <td class="px-6 py-4">
              {{ role.name }}
            </td>
            <td class="px-6 py-4">
              <RouterLink :to="{ name: 'UpdateRole', params: { id: role.id } }" class="mr-5"><span
                  class="pi pi-pencil" /></RouterLink>
              <button @click="deleteRole(role.id)" class="mr-5"><span class="pi pi-trash" /></button>
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
  showAllRole()
})

const roleAllData = ref("")
const showAllRole = async () => {
  try {
    const { data } = await customeAPI.get('/role',
      {
        headers: { Authorization: `Bearer ${authStore.tokenUser}` },
      }
    )
    roleAllData.value = data.data
  } catch (error) {
    console.log(error);
    alert("Terjadi Kesalahan")
  }
}

const deleteRole = async (inp) => {
  try {
    const { data } = await customeAPI.post(`/role/${inp}?_method=DELETE`, null,
      {
        headers: { Authorization: `Bearer ${authStore.tokenUser}` },
      }
    )

    alert("Sukses Delete Role")
    router.push({ name: "Role" })
    location.reload()
  } catch (error) {
    console.log(error);
    alert("Terjadi Kesalahan")
  }
}
</script>