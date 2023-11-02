"use strict";

const myListsDisplay = document.querySelector(".myListsDisplay");

myListsDisplay.addEventListener("click", (e) => {
    if (e.target.closest(".myListsItem")) {
        const listId = e.target.closest(".myListsItem").dataset.id;
        window.location.href = `/category.php?id=${listId}`;
    }

});