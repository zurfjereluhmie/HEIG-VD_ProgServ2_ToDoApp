<nav class="navbar navbar-dark sticky-top bg-white flex-md-nowrap p-0">
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
                    Resultat #1
                </li>
                <li>
                    Resultat #2
                </li>
                <li>
                    Resultat #3
                </li>
            </ul>
        </div>
    </div>
    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            <div class="d-flex flex-row justify-content-end align-items-center">
                <p class="navUserDisplayName"><?= $_SESSION["user"]["firstName"] . " " . $_SESSION["user"]["lastName"] ?></p>
            </div>
        </li>
    </ul>
</nav>