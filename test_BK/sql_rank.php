<?php

    session_start();
    
    if(isset($_REQUEST["rank"])){
        $_SESSION["rank"] = $_REQUEST["rank"];
    }
    $_SESSION["tab"] = "ranking";
?>

<script type="text/javascript">
    parent.title.location="title.php";
    parent.rank.location="rank.php";
</script>
