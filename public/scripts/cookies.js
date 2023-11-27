"use strict";

/**
 * Sets a cookie with the specified name, value, and expiration days.
 * @param {string} cname - The name of the cookie.
 * @param {string} cvalue - The value of the cookie.
 * @param {number} exdays - The number of days until the cookie expires.
 */
const setCookie = (cname, cvalue, exdays) => {
    const d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    let expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

/**
 * Retrieves the value of a cookie by its name.
 * @param {string} cname - The name of the cookie.
 * @returns {string} - The value of the cookie, or an empty string if the cookie is not found.
 */
const getCookie = (cname) => {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

/**
 * Checks if a cookie with the specified name exists.
 * @param {string} cname - The name of the cookie.
 * @returns {boolean} - True if the cookie exists, false otherwise.
 */
const checkCookie = (cname) => { return getCookie(cname) != "" };

export { setCookie, getCookie, checkCookie };
