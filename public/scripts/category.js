"use strict";

import { $, $$ } from "./modules/selectors.js";
import { categoryInteraction } from "./modules/category.js";

$("input[name='showLateTask']").addEventListener("change", (e) => {
    $(".lateTaskContainer").style.display = (e.target.checked) ? "block" : "none";
});

$("input[name='showDoneTask']").addEventListener("change", (e) => {
    $(".doneTaskContainer").style.display = (e.target.checked) ? "block" : "none";
});

$("main").addEventListener("click", (e) => {
    categoryInteraction(e);
});