<?php

function loadScript(array $scripts = null): void
{
?>
    <!-- Lib -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom common-->
    <!-- <script src="js/navScript.js"></script>
    <script src="js/profilePicture.js"></script>
    <script src="js/searchBar.js"></script>
    <script src="js/modal.js"></script>
    <script src="js/taskScript.js"></script> -->


    <!-- Custom specific-->
    <?php foreach ($scripts as $script) : ?>
        <script src="./scripts/<?= $script ?>.js"></script>
    <?php endforeach; ?>
<?php
}
