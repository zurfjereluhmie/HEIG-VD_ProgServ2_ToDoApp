"use strict";

import { setCookie, getCookie, checkCookie } from "./modules/cookies.js";

const $ = (selector) => document.querySelector(selector);

$("#languageSelect")?.addEventListener("change", (e) => {
    let lang = e.currentTarget.value;
    setCookie("locale", lang, 365);
    location.reload();
});