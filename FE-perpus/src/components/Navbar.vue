<template>
  <div class="fixed z-10 navbar bg-base-100">
    <div class="navbar-start">
      <div class="dropdown">
        <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
          </svg>
        </div>
        <ul tabindex="0" class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow">
          <li>
            <RouterLink to="/books">Book</RouterLink>
          </li>
          <li>
            <RouterLink to="/category">Category</RouterLink>
          </li>
          <li>
            <RouterLink :to="{ name: 'Role' }" v-if="
              authStore.currentUser &&
              authStore.currentUser.role.name ===
              'owner'
            ">
              Roles Maintenance</RouterLink>
          </li>
          <li>
            <RouterLink :to="{ name: 'Borrow' }" v-if="
              authStore.currentUser &&
              authStore.currentUser.role.name ===
              'owner'
            ">
              Borrow List</RouterLink>
          </li>
        </ul>
      </div>
      <RouterLink to="/" class="btn btn-ghost text-xl">Perpus</RouterLink>
    </div>
    <div class="navbar-center hidden lg:flex">
      <ul class="menu menu-horizontal px-1">
        <li>
          <RouterLink to="/books">Book</RouterLink>
        </li>
        <li>
          <RouterLink to="/category">Category</RouterLink>
        </li>
        <li>
          <RouterLink :to="{ name: 'Role' }" v-if="
            authStore.currentUser &&
            authStore.currentUser.role.name ===
            'owner'
          ">
            Roles Maintenance</RouterLink>
        </li>
        <li>
          <RouterLink :to="{ name: 'Borrow' }" v-if="
            authStore.currentUser &&
            authStore.currentUser.role.name ===
            'owner'
          ">
            Borrow List</RouterLink>
        </li>
      </ul>
    </div>
    <div class="navbar-end mr-10">
      <div class="dropdown dropdown-end">
        <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
          <div class="w-10 rounded-full">
            <img alt="Tailwind CSS Navbar component"
              src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp" />
          </div>
        </div>

        <ul tabindex="0" class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow"
          v-if="authStore.currentUser && authStore.tokenUser">
          <li>
            <RouterLink :to="{ name: 'Profile' }">Profile</RouterLink>
          </li>
          <li><a to='/logout' v-if="authStore.tokenUser" @click="handleLogout">Logout</a></li>
        </ul>

        <ul tabindex="0" class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow"
          v-else>
          <li v-for="navProf in listNavProfileNotLogReg" :key="navProf.id">
            <RouterLink :to='navProf.url'>{{ navProf.name }}</RouterLink>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useAuthStore } from "@/stores/AuthStore";
import { useRouter } from 'vue-router';

const authStore = useAuthStore();
const router = useRouter()


const handleLogout = () => {
  authStore.logoutUser();
};

const listNavProfileNotLogReg = [
  {
    id: 1,
    name: "Login",
    url: "/login",
  },
  {
    id: 2,
    name: "Register",
    url: "/register",
  },
];

</script>
