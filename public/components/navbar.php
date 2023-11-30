<nav class="navbar navbar-light sticky-top bg-white flex-md-nowrap p-0">
    <a class="col-md-3 col-lg-2 mr-0 px-3" href="/">
        <img class="" src="assets/icons/logo.svg" alt="Logo">
    </a>
    <button id="displayMenu" class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div id="searchContent">
        <input class="mx-auto searchBar" type="search" placeholder="<?= TEXT['search']; ?>" aria-label="<?= TEXT['search']; ?>">
        <!-- Result of the search -->
        <div id="livesearch">
            <ul>
                <li>
                    <span class="noResult">Search for a todo</span>
                </li>
            </ul>
        </div>
    </div>
    <ul class="navbar-nav px-3 flex flex-row">
        <li class="nav-item mr-1 align-self-center">
            <?php $currentLang = $_COOKIE["locale"] ?? "en"; ?>
            <select class="custom-select" id="languageSelect">
                <?php foreach (AVAILABLE_LANGS as $lang) : ?>
                    <option value="<?= $lang ?>" <?= $lang == $currentLang ? "selected" : "" ?>><?= $lang ?></option>
                <?php endforeach ?>
            </select>
        </li>
        <li class="nav-item text-nowrap">
            <div class="d-flex flex-row justify-content-end align-items-center">
                <p class="navUserDisplayName"><?= $_SESSION["user"]["firstName"] . " " . $_SESSION["user"]["lastName"] ?></p>
            </div>
        </li>
    </ul>
</nav>