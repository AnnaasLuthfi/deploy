import { createWebHistory, createRouter } from "vue-router";
import HomeView from "./page/HomeView.vue";
import BooksView from "./page/Book/BooksView.vue";
import PublicLayout from "./layouts/PublicLayout.vue";
import LoginView from "./page/Auth/LoginView.vue";
import RegisterView from "./page/Auth/RegisterView.vue";
import ProfileView from "./page/Profile/ProfileView.vue";
import UpdateProfileView from "./page/Profile/UpdateProfileView.vue";
import CategoryView from "./page/Category/CategoryView.vue";
import AddCategoryView from "./page/Category/AddCategoryView.vue";
import UpdateCategoryView from "./page/Category/UpdateCategoryView.vue";
import DetailCategoryView from "./page/Category/DetailCategoryView.vue";
import RoleView from "./page/Role/RoleView.vue";
import AddRoleView from "./page/Role/AddRoleView.vue";
import UpdateRoleView from "./page/Role/UpdateRoleView.vue";
import AddBooksView from "./page/Book/AddBooksView.vue";
import UpdateBooksView from "./page/Book/UpdateBooksView.vue";
import DetailBooksView from "./page/Book/DetailBooksView.vue";
import BorrowView from "./page/Borrow/BorrowView.vue";
import AddUpdateBorrowView from "./page/Borrow/AddUpdateBorrowView.vue";

import { useAuthStore } from "./stores/AuthStore";

const routes = [
  {
    path: "/",
    component: PublicLayout,
    children: [
      {
        path: "/",
        name: "Home",
        component: HomeView,
      },
      ////////////////////// Books ///////////////////////////////
      {
        path: "/books",
        name: "Books",
        component: BooksView,
      },
      {
        path: "/add/books",
        name: "AddBooks",
        component: AddBooksView,
        meta: { isAuth: true },
        meta: { isOwner: true },
      },
      {
        path: "/update/books/:id",
        name: "UpdateBooks",
        component: UpdateBooksView,
        meta: { isAuth: true },
        meta: { isOwner: true },
      },
      {
        path: "/detail/books/:id",
        name: "DetailBooks",
        component: DetailBooksView,
      },
      ////////////////////// Profile ///////////////////////////////
      {
        path: "/profile",
        name: "Profile",
        component: ProfileView,
        meta: { isAuth: true },
      },
      {
        path: "/update/add/profile",
        name: "ProfileChange",
        component: UpdateProfileView,
        meta: { isAuth: true },
      },
      ////////////////////// Category ///////////////////////////////
      {
        path: "/category",
        name: "Category",
        component: CategoryView,
      },
      {
        path: "/add/category",
        name: "AddCategory",
        component: AddCategoryView,
        meta: { isAuth: true },
        meta: { isOwner: true },
      },
      {
        path: "/update/category/:id",
        name: "UpdateCategory",
        component: UpdateCategoryView,
        meta: { isAuth: true },
        meta: { isOwner: true },
      },
      {
        path: "/detail/category/:id",
        name: "DetailCategory",
        component: DetailCategoryView,
      },
      ////////////////////// Role ///////////////////////////////
      {
        path: "/role",
        name: "Role",
        component: RoleView,
        meta: { isAuth: true },
        meta: { isOwner: true },
      },
      {
        path: "/add/role",
        name: "AddRole",
        component: AddRoleView,
        meta: { isAuth: true },
        meta: { isOwner: true },
      },
      {
        path: "/update/role/:id",
        name: "UpdateRole",
        component: UpdateRoleView,
        meta: { isAuth: true },
        meta: { isOwner: true },
      },
      ////////////////////// Borrow ///////////////////////////////
      {
        path: "/borrow",
        name: "Borrow",
        component: BorrowView,
        meta: { isAuth: true },
        meta: { isOwner: true },
      },
      {
        path: "/borrow/:id",
        name: "AddUpdateBorrow",
        component: AddUpdateBorrowView,
        meta: { isAuth: true },
      },
    ],
  },
  {
    path: "/login",
    name: "Login",
    component: LoginView,
    meta: { requiredAuth: true },
  },
  {
    path: "/register",
    name: "Register",
    component: RegisterView,
    meta: { requiredAuth: true },
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach(async (to, from) => {
  const authStore = await useAuthStore();
  if (to.meta.requiredAuth && authStore.tokenUser) {
    alert("Anda sudah login");
    return {
      path: "/",
    };
  }
  if (to.meta.isAuth && !authStore.tokenUser) {
    alert("Anda Belum Login");
    return {
      path: "/",
    };
  }
  if (to.meta.isOwner && authStore.tokenUser && authStore.currentUser && authStore.currentUser.role.name !== 'owner') {
    alert("Anda Tidak Bisa Mengakses Halaman Ini");
    return {
      path: "/",
    };
  }
  
});

export default router;
