<template>
    <div class="font-poppins">
      <NavbarComponent v-if="showNavbar" />
      <!-- <NavbarComponent /> -->
  
      <RouterView v-slot="{ Component, route }">
        <transition name="fade" mode="out-in">
          <component :is="Component" :key="route.path" />
        </transition>
      </RouterView>
    </div>
  </template>
    
    <script setup>
  import { computed } from "vue";
  import { useRoute } from "vue-router";
  import NavbarComponent from "@/components/Navbar.vue";
  import { RouterView } from "vue-router";
  
  const route = useRoute();
  
  const showNavbar = computed(() => {
    const noNavbarRoutes = ["/login", "/register", "/verif"];
    return !noNavbarRoutes.includes(route.path);
  });
  </script>
    
    <style scoped>
  .fade-enter-active,
  .fade-leave-active {
    transition: opacity 0.5s;
  }
  .fade-enter,
  .fade-leave-to {
    opacity: 0;
  }
  </style>