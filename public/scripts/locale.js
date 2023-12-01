"use strict";

import { $, $$ } from "./modules/selectors.js";
import { setCookie, getCookie, checkCookie } from "./modules/cookies.js";

$("#languageSelect")?.addEventListener("change", (e) => {
    let lang = e.currentTarget.value;
    setCookie("locale", lang, 365);
    location.reload();
});