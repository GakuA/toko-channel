<?php

    session_start();
    unset($_SESSION["tab"]);
//    unset($_SESSION["rank"]);

?>

<script type="text/javascript">
    parent.title.location="title.php";
    parent.rank.location="rank.php";
</script>
