<?php

    session_start();
    $_SESSION["tab"] = "rank";
//    unset($_SESSION["rank"]);
?>

<script type="text/javascript">
    parent.title.location="title.php";
    parent.rank.location="tag.php";
</script>
