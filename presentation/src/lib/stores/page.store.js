import { writable } from "svelte/store"
import {notifications} from "./notifications.js";

//Constant
export const LOGIN_BTN = "Login";
export const ADMIN_TOOL_BTN = "Admin Tool";
export const API_TEST_BTN = "Api Test";

//Writeables


function createStore() {
    const { subscribe, set, update } = writable(LOGIN_BTN);
    
    return {
        subscribe,
        loginPage: () => {
            return set(LOGIN_BTN);
        },
        adminPage: () => {
            const jwt = localStorage.getItem("jwt");
            if (jwt) {
                return set(ADMIN_TOOL_BTN);
            } else {
                return set(LOGIN_BTN);
            }
        },
        apiTestPage: () => set(API_TEST_BTN),
        logout: () => { 
            localStorage.removeItem("jwt");
            notifications.info("Logged out", 1000);
            return set(LOGIN_BTN);
        },
        reset: () => set(LOGIN_BTN),
    };
    
}
export const pageStore = createStore();

export const loggedIn = writable(false);

setInterval(() => { 
    const jwt = localStorage.getItem("jwt") ? true : false
    loggedIn.set(jwt)
}, 300);