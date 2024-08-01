<template>
    <div class="mx-auto px-8 py-20 my-100 rounded-xl" style="max-width: 90%">
        <div class="text-center">
            <h2 class="mt-6 text-3xl font-bold text-gray-900">Update Books</h2>
        </div>

        <div class="justify-center flex mt-20">
            <form @submit.prevent="handleSubmit">
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4"
                            for="inline-full-name">
                            Title
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input
                            class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                            id="inline-full-name" type="text" placeholder="Title" v-model="book.title">
                    </div>
                </div>

                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4"
                            for="inline-password">
                            Summary
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input
                            class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                            id="inline-password" type="text" placeholder="Summary" v-model="book.summary">
                    </div>
                </div>

                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4"
                            for="inline-password">
                            Stock
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input
                            class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                            id="inline-password" type="number" placeholder="Stock" v-model="book.stok">
                    </div>
                </div>

                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4"
                            for="inline-password">
                            Category
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <select
                            class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
                            v-model="book.category_id">
                            <option :value="category.id" v-for="category in category">{{ category.name }}</option>

                        </select>
                        <div
                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4"
                            for="inline-password">
                            Image
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input
                            class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                            id="inline-password" type="file" placeholder="Image" @change="handleUpload">
                    </div>
                </div>

                <div class="md:flex md:items-center">
                    <div class="md:w-1/3"></div>
                    <div class="md:w-2/3">
                        <input
                            class="shadow bg-purple-500 hover:bg-purple-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded"
                            type="submit" value="Update" />
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { onMounted, reactive, ref } from 'vue';
import { customeAPI } from '@/api';
import { useAuthStore } from "@/stores/AuthStore";
import { useRouter, useRoute } from 'vue-router';

const authStore = useAuthStore()
const router = useRouter();
const route = useRoute()

const category = ref("")
const allCategory = async () => {
    const { data } = await customeAPI.get('/category')

    category.value = data.data
}

const book = reactive({
    title: "",
    summary: "",
    image: null,
    category_id: "",
    stok: "",
});

const handleUpload = (e) => {
    const selectImage = e.target.files[0];
    book.image = selectImage;
};

const handleSubmit = async () => {
    try {
        // isError.value = false;
        // errorMessage.value = "";
        let formData = new FormData();
        formData.append("title", book.title);
        formData.append("summary", book.summary);
        formData.append("image", book.image);
        formData.append("category_id", book.category_id);
        formData.append("stok", book.stok);

        const { updateFilm } = await customeAPI.post(`/book/${route.params.id}?_method=PUT`, formData, {
            headers: { Authorization: `Bearer ${authStore.tokenUser}` },
        });

        alert("Sukses Update")
        router.push({ name: "Books" });
    } catch (error) {
        // isError.value = true;
        // errorMessage.value = error.response.data.message;
        console.log(error);
    }
};

const bookTitle = ref("")
const bookSummary = ref("")
const bookImage = ref("")
const bookStok = ref("")
const bookCategory_id = ref("")

const bookDetailById = async () => {
    try {
        const { data } = await customeAPI.get(`/book/${route.params.id}`)

        bookTitle.value = data.data.title
        bookSummary.value = data.data.summary
        bookImage.value = data.data.image
        bookStok.value = data.data.stok
        bookCategory_id.value = data.data.category_id

    } catch (error) {
        console.log(error);
    }
}



onMounted(() => {
    allCategory(),
        bookDetailById(),
        book.title = bookTitle || "",
        book.summary = bookSummary || "",
        book.image = bookImage || "",
        book.stok = bookStok || "",
        book.category_id = bookCategory_id || ""
})

</script>
