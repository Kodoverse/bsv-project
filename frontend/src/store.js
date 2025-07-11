import { reactive } from "vue";
import axios from "axios";


export const store = reactive({
  isLoggedIn: false,
  CurrentUser: null,
});

export async function getCurrentUser() {
  try {
    await axios.get("http://localhost:8000/sanctum/csrf-cookie", {
      withCredentials: true,
    });

    const response = await axios.get("http://localhost:8000/api/user", {
      withCredentials: true,
    });

    store.CurrentUser = response.data;
    localStorage.setItem("CurrentUser", JSON.stringify(response.data));

    console.log("Utente loggato:", store.CurrentUser);
  } catch (error) {
    console.error(error);
  }
}
