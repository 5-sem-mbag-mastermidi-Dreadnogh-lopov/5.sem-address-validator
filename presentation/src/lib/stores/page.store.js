import { writable } from "svelte/store"
import { notifications } from "./notifications.js";

//Constant
export const LOGIN_BTN = "Login";
export const ADMIN_TOOL_BTN = "Admin Tool";
export const API_TEST_BTN = "Test";

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
            notifications.info("Logged out", 2000);
            return set(LOGIN_BTN);
        },
        reset: () => set(LOGIN_BTN),
    };
    
}
export const pageStore = createStore();

export const JWT = writable(null);

setInterval(() => { 
    const jwt = localStorage.getItem("jwt");
    if (!jwt) JWT.set(undefined);
    else JWT.set(isTokenExpired(jwt) ? jwt : undefined);
}, 300);

function parseJwt(token) {
    const base64Url = token.split('.')[1];
    const base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
    const jsonPayload = decodeURIComponent(window.atob(base64).split('').map(function(c) {
        return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
    }).join(''));

    return JSON.parse(jsonPayload);
}
//function to compare the expiration time of the token to the current time
function isTokenExpired(token) {
    const decoded = parseJwt(token);
    const expirationTime = decoded.exp;
    const currentTime = Date.now() / 1000;
    console.log(decoded, expirationTime - currentTime);
    
    if (currentTime < expirationTime) {
        return true;
    } else {
        pageStore.logout();
        return false;
    }
}