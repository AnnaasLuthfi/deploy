<template>
    <div class="mx-auto px-8 py-20 my-100 rounded-xl" style="max-width: 90%">

        <div class="flex items-center max-w-sm mx-auto">
            <label for="simple-search" class="sr-only">Search</label>
            <div class="relative w-full">

                <input type="text" v-model="searchQuery" id="simple-search"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5   dark:border-gray-600  "
                    placeholder="Search Book Name..." required />
            </div>
            <button type="submit"
                class="p-2.5 ms-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                </svg>
                <span class="sr-only">Search</span>
            </button>
        </div>


        <RouterLink class="btn btn-primary mb-7" :to="{ name: 'AddBooks' }" v-if="
            authStore.currentUser &&
            authStore.currentUser.role.name === 'owner'
        ">
            Add Data
        </RouterLink>

        <div class="flex flex-col items-center justify-center grid md:grid-cols-2 lg:grid-cols-3 pd">
            <div v-if="!books" class="flex items-center justify-center">
                <span class="loading loading-dots loading-lg text-6xl"></span>
            </div>

            <div class="relative flex w-96 flex-col rounded-xl bg-white bg-clip-border text-gray-700 shadow-md mb-5"
                v-for="book in filteredBooks" v-else>
                <div class="relative mx-4 mt-4 h-80 overflow-hidden rounded-xl bg-white bg-clip-border text-gray-700">
                    <img :src="book.image" class="h-full w-full object-cover" />
                </div>
                <div class="p-6">
                    <div class="mb-2 flex items-center justify-between">
                        <p class="block font-sans text-base font-medium leading-relaxed text-blue-gray-900 antialiased">
                            {{ book.title }}
                        </p>
                        <p class="block font-sans text-base font-medium leading-relaxed text-blue-gray-900 antialiased">
                            {{ book.category.name }}
                        </p>
                    </div>
                    <p class="block font-sans text-sm font-normal leading-normal text-gray-700 antialiased opacity-75">
                        {{ truncateString(book.summary) }}
                    </p>
                </div>
                <div class="p-6 pt-0">
                    <RouterLink :to="{ name: 'DetailBooks', params: { id: book.id } }"
                        class="block w-full py-3 px-6 text-center align-middle text-xs font-bold uppercase transition-all hover:scale-105 "
                        type="button">
                        Read Now
                    </RouterLink>
                    <RouterLink :to="{ name: 'UpdateBooks', params: { id: book.id } }"
                        class="block w-full py-3 px-6 text-center align-middle text-xs font-bold uppercase transition-all hover:scale-105 "
                        type="button" v-if="
                            authStore.currentUser &&
                            authStore.currentUser.role.name ===
                            'owner'">
                        Edit
                    </RouterLink>
                    <RouterLink :to="{ name: 'UpdateBooks', params: { id: book.id } }"
                        class="block w-full py-3 px-6 text-center align-middle text-xs font-bold uppercase transition-all hover:scale-105 "
                        type="button" v-if="
                            authStore.currentUser &&
                            authStore.currentUser.role.name ===
                            'owner'" @click="deleteBookData(book.id)">
                        Delete
                    </RouterLink>

                </div>
            </div>
        </div>
    </div>

</template>

<script setup>
import { onMounted, ref, computed } from "vue";
import { customeAPI } from "@/api";
import { useAuthStore } from "@/stores/AuthStore";
import { useRouter } from "vue-router";

const authStore = useAuthStore();
const router = useRouter();

onMounted(() => {
    allBooks(), allCategory()
});

////////////////
const category = ref("");
const allCategory = async () => {
    const { data } = await customeAPI.get("/category");
    // console.log(data.data);

    category.value = data.data;
};

const books = ref("");
const allBooks = async () => {
    const { data } = await customeAPI.get("/book");
    // console.log(data.data);

    books.value = data.data;
};

const deleteBookData = async (inp) => {
    try {
        const { data } = await customeAPI.post(
            `/book/${inp}?_method=DELETE`,
            null,
            {
                headers: { Authorization: `Bearer ${authStore.tokenUser}` },
            }
        );

        alert("Sukses Delete Book");
        router.push({ name: "Books" });
        location.reload();
    } catch (error) {
        console.log(error);
    }
};

const searchQuery = ref("");

// Computed property untuk memfilter buku berdasarkan query pencarian
const filteredBooks = computed(() => {
    if (searchQuery.value === "") {
        return books.value;
    } else {
        return books.value.filter((book) =>
            book.title.toLowerCase().includes(searchQuery.value.toLowerCase())
        );
    }
});

function truncateString(str) {
    if (str.length > 99) {
        return str.substring(0, 99) + "...";
    } else {
        return str;
    }
}
</script>
