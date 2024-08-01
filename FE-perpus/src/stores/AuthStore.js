import { ref } from "vue";
import { defineStore } from "pinia";
import { useRouter } from "vue-router";
import { customeAPI } from "@/api";
import axios from "axios";

export const useAuthStore = defineStore("user", () => {
    const router = useRouter();
    const tokenUser = ref(
        localStorage.getItem("token")
            ? JSON.parse(localStorage.getItem("token"))
            : null
    );
    const currentUser = ref(
        localStorage.getItem("user")
            ? JSON.parse(localStorage.getItem("user"))
            : null
    );
    const isError = ref(false);
    const errorMessage = ref("");

    const loginUser = async (inputData) => {
        try {
            // console.log(inputData);
            isError.value = false;
            errorMessage.value = "";

            const { email, password } = inputData;

            const { data } = await customeAPI.post("/auth/login", {
                email: email,
                password: password,
            });

            const { token, user } = data;

            console.log(token, user);

            // store pinia
            tokenUser.value = token;
            currentUser.value = user;

            // localStorage
            localStorage.setItem("token", JSON.stringify(token));
            localStorage.setItem("user", JSON.stringify(user));

            router.push({ name: "Home" });
        } catch (error) {
            isError.value = true;
            errorMessage.value = error.response.data.message;
            console.log(error.response.data.message);
            console.log(error);
        }
    };

    const registerUser = async (inputData) => {
        try {
            isError.value = false;
            errorMessage.value = "";

            const { name, email, password, password_confirmation } = inputData;

            const { data } = await customeAPI.post("/auth/register", {
                name: name,
                email: email,
                password: password,
                password_confirmation: password_confirmation,
            });

            const { token, user } = data;

            console.log(token, user);

            // store pinia
            tokenUser.value = token;
            currentUser.value = user;

            // localStorage
            localStorage.setItem("token", JSON.stringify(token));
            localStorage.setItem("user", JSON.stringify(user));

            router.push({ name: "Home" });
        } catch (error) {
            isError.value = true;
            errorMessage.value = error.response.data.message;
            // console.log(error.response.data.message);
        }
    };

    const updateUser = async (inputData) => {
        try {
            isError.value = false;
            errorMessage.value = "";

            const { name } = inputData;
            console.log("isi name:",name);

            const { data } = await customeAPI.post(
                "/update-user",
                {
                    name: name,
                },
                {
                    headers: { Authorization: `Bearer ${tokenUser.value}` },
                }
            );

            const { user } = data;
            console.log("ABIS UPDATE" ,user)
            // localStorage.setItem("user", JSON.stringify(user));

            if (typeof localStorage !== "undefined") {
                localStorage.setItem("user", JSON.stringify(user));
                console.log("INI ISINYA:" , JSON.stringify(user))
            } else {
                console.error("localStorage is not available.");
            }
            currentUser.value = user;

            console.log("User updated successfully!");
            errorMessage.value = "Sukses Update data";
            alert("Sukses Edit Akun")
            router.push({ name: "Home" });
        } catch (error) {
            isError.value = true;
            // errorMessage.value = error.response.data.message;
            // console.log(error.response.data.message);
            console.log(error);
        }
    };

    const getMe = async () => {
        try {
            const response = await customeAPI.get("/me", {
                headers: { Authorization: `Bearer ${tokenUser.value}` },
            });

            console.log(response);
        } catch (error) {
            console.log(error);
        }
    };

    const logoutUser = async () => {
        
            localStorage.setItem("token", null);
            localStorage.setItem("user", null);
    
            tokenUser.value = "";
            currentUser.value = "";
                
            const res = await customeAPI.post("/auth/logout", {
                headers: { Authorization: `Bearer ${tokenUser.value}` },
            });
    
            console.log(res);
    
            alert("Sukses Logout")
            router.push({ name: "Home" });
        
    };

    return {
        loginUser,
        isError,
        errorMessage,
        currentUser,
        tokenUser,
        getMe,
        logoutUser,
        registerUser,
        updateUser,
        // resendOtp,
        // verificationOTP
    };
});
