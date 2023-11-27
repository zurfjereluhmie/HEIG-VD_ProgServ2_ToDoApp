"use strict";

import { setCookie, getCookie, checkCookie } from "./cookies.js";

const $ = (selector) => document.querySelector(selector);

// TODO: Implement this function on the language selection page
$("#lang")?.addEventListener("submit", (e) => {
    let lang = e.detail;
    setCookie("lang", lang, 365);
    location.reload();
});