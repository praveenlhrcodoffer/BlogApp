<?php

include 'handleData.php';

?>

<div id="blogs-list-container">

    <div id="list-scroll-container">

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            getPostsList();
        }
        ?>

    </div>

</div>

</div>