"use strict";

import { $, $$ } from "./modules/selectors.js";
import { categoryInteraction } from "./modules/category.js";

$("main").addEventListener("click", (e) => {
    categoryInteraction(e);
});