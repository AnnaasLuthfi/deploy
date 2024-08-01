import axios from "axios";
// import { useAuthStore } from "./stores/AuthStore";

// const authStore = useAuthStore()

export const customeAPI = axios.create({
  baseURL: "/api/v1",
});

export const tokenApi = axios.create({
    baseURL: "/api/v1",
    headers: {
        'Authorization':`Bearer ${localStorage.getItem('token')}`
    }
    
    
})


// export default customeAPI