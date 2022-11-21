import {writable} from "svelte/store"

//Constant
export const LOGIN_BTN = "Login";
export const ADMIN_TOOL_BTN = "Admin Tool";
export const API_TEST_BTN = "Api Test";

//Writeables
export const activeMenu = writable(LOGIN_BTN);

