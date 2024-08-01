<template>
    <div class="mx-auto px-8 py-20 my-100 rounded-xl" style="max-width: 90%">
        <div class="sliderAx h-auto">
            <div id="slider-1" class="container mx-auto">
                <div class="bg-cover bg-center  h-auto text-white py-24 px-10 object-fill"
                    style="background-image: url(https://lib.usim.edu.my/wp-content/uploads/2018/10/RAK-1024x413.jpg)">
                    <div class="md:w-1/2">
                        <p class="font-bold text-sm uppercase">Services</p>
                        <p class="text-3xl font-bold">PerPus</p>
                        <p class="text-2xl mb-10 leading-none">Find your favorites books</p>
                        <RouterLink :to="{ name: 'Books' }"
                            class="bg-purple-800 py-4 px-8 text-white font-bold uppercase text-xs rounded hover:bg-gray-200 hover:text-gray-800">
                            Explore</RouterLink>
                    </div>
                </div> <!-- container -->
                <br>
            </div>

            <div id="slider-2" class="container mx-auto">
                <div class="bg-cover bg-top  h-auto text-white py-24 px-10 object-fill"
                    style="background-image: url(https://company.overdrive.com/wp-content/uploads/2020/03/2020-03-19-16_27_28-Presentation1-PowerPoint-1200x422.jpg)">

                    <p class="font-bold text-sm uppercase"> .</p>
                    <p class="text-3xl font-bold"> .</p>
                    <p class="text-2xl mb-10 leading-none"> .</p>
                    <a href="#"
                        class="bg-purple-800 py-4 px-8 text-white font-bold uppercase text-xs rounded hover:bg-gray-200 hover:text-gray-800">Contact
                        us</a>

                </div> <!-- container -->
                <br>
            </div>
        </div>
        <div class="flex justify-between w-12 mx-auto pb-2">
            <button id="sButton1" onclick="sliderButton1()" class="bg-purple-400 rounded-full w-4 pb-2 "></button>
            <button id="sButton2" onclick="sliderButton2() " class="bg-purple-400 rounded-full w-4 p-2"></button>
        </div>
        

        <div>
            <div class="flex mt-10">
                <h1 class="text-2xl font-bold justify-start">Popular</h1>
                <a href="#" class="text-1l font-bold flex justify-end ml-auto">view all</a>
            </div>

            <div class="flex flex-col items-center justify-center grid md:grid-cols-2 lg:grid-cols-3 pd">
                <div class="relative flex w-96 flex-col rounded-xl bg-white bg-clip-border text-gray-700 shadow-md mb-5" v-for="book in mostPopular">
                    <div
                        class="relative mx-4 mt-4 h-80 overflow-hidden rounded-xl bg-white bg-clip-border text-gray-700">
                        <img :src="book.image"
                            class="h-full w-full object-cover" />
                    </div>
                    <div class="p-6">
                        <div class="mb-2 flex items-center justify-between">
                            <p
                                class="block font-sans text-base font-medium leading-relaxed text-blue-gray-900 antialiased">
                                {{ book.title }}
                            </p>
                            <p
                                class="block font-sans text-base font-medium leading-relaxed text-blue-gray-900 antialiased">
                                {{ book.category.name }}
                            </p>
                        </div>
                        <p
                            class="block font-sans text-sm font-normal leading-normal text-gray-700 antialiased opacity-75">
                            {{ truncateString(book.summary) }}
                        </p>
                    </div>
                    <div class="p-6 pt-0">
                        <RouterLink :to="{ name: 'DetailBooks', params: { id: book.id } }"
                            class="block w-full py-3 px-6 text-center align-middle text-xs font-bold uppercase transition-all hover:scale-105 "
                            type="button">
                            Read Now
                        </RouterLink>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>

import { customeAPI } from '@/api';
import { useAuthStore } from '@/stores/AuthStore';
import { data } from 'autoprefixer';
import { onMounted, ref } from 'vue';

const authStore = useAuthStore()
const mostPopular = ref("")
const getLimitData = async () => {
  try {
    const { data } = await customeAPI.get('/bookPopular')
    mostPopular.value = data.data
    console.log(data);

  } catch (error) {
    console.log(error);
  }
}

onMounted(() => {
  getLimitData()
})

function truncateString(str) {
  if (str.length > 99) {
    return str.substring(0, 99) + "...";
  } else {
    return str;
  }
}


// carousel
var cont = 0;
function loopSlider() {
    var xx = setInterval(function () {
        switch (cont) {
            case 0: {
                $("#slider-1").fadeOut(400);
                $("#slider-2").delay(400).fadeIn(400);
                $("#sButton1").removeClass("bg-purple-800");
                $("#sButton2").addClass("bg-purple-800");
                cont = 1;

                break;
            }
            case 1:
                {

                    $("#slider-2").fadeOut(400);
                    $("#slider-1").delay(400).fadeIn(400);
                    $("#sButton2").removeClass("bg-purple-800");
                    $("#sButton1").addClass("bg-purple-800");

                    cont = 0;

                    break;
                }


        }
    }, 8000);

}

function reinitLoop(time) {
    clearInterval(xx);
    setTimeout(loopSlider(), time);
}

function sliderButton1() {

    $("#slider-2").fadeOut(400);
    $("#slider-1").delay(400).fadeIn(400);
    $("#sButton2").removeClass("bg-purple-800");
    $("#sButton1").addClass("bg-purple-800");
    reinitLoop(4000);
    cont = 0
}

function sliderButton2() {
    $("#slider-1").fadeOut(400);
    $("#slider-2").delay(400).fadeIn(400);
    $("#sButton1").removeClass("bg-purple-800");
    $("#sButton2").addClass("bg-purple-800");
    reinitLoop(4000);
    cont = 1
}

$(window).ready(function () {
    $("#slider-2").hide();
    $("#sButton1").addClass("bg-purple-800");
    loopSlider();
});



</script>