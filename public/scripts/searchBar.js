"use strinct";

const searchContent = document.querySelector("#searchContent");
const searchInput = document.querySelector(".searchBar");
const liveSearch = document.querySelector("#livesearch");
const liveSearchUl = liveSearch.querySelector("ul");

searchInput.addEventListener("focusin", () => {
    liveSearch.style.display = "block";
    liveSearchUl.style.display = "block";
});

searchInput.addEventListener("keyup", () => {
    const searchValue = searchInput.value;
    if (searchValue.length > 0) {
        fetch("/api/search.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                searchValue
            })
        })
            .then(response => {
                if (!response.ok) throw new Error("Network NOK");
                return response;
            })
            .then(response => {
                return response.json();
            })
            .then(data => {
                if (!Object.keys(data).length) throw new Error("No result");
                return data;
            })
            .then(data => {
                liveSearchUl.innerHTML = "";
                if (data.categories.length) {
                    const li = document.createElement("li");
                    li.innerHTML = `<span class="small">Categories :</span>`;
                    liveSearchUl.appendChild(li);

                    data.categories.forEach(category => {
                        const li = document.createElement("li");
                        li.innerHTML = `<a href="/category.php?id=${category.id}">${category.title}</a>`;
                        liveSearchUl.appendChild(li);
                    });
                }
                if (data.tasks.length) {
                    const li = document.createElement("li");
                    li.innerHTML = `<span class="small">Tasks :</span>`;
                    liveSearchUl.appendChild(li);

                    data.tasks.forEach(todo => {
                        const li = document.createElement("li");
                        li.innerHTML = `<a href="/todo.php?id=${todo.id}">${todo.title}</a>`;
                        liveSearchUl.appendChild(li);
                    });
                }
            })
            .catch(error => {
                switch (error.message) {
                    case "Network NOK":
                        console.error("Network error");
                        break;
                    case "No result":
                        liveSearchUl.innerHTML = `<span class='noResult'>No results for your search</span>`;
                        break;
                    default:
                        console.error(error);
                        break;
                }
            });
    } else {
        liveSearchUl.innerHTML = "<span class='noResult'>Search for a todo</span>";
    }
});
searchInput.addEventListener("focusout", () => {
    liveSearch.style.display = "none";
    liveSearchUl.style.display = "none";
});