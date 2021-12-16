<?php

if (isset($_POST["tipo"]) == 1) {
    include("../Parcial/Add.php");
} else if (isset($_POST["tipo"]) == 2) {
    include("../Parcial/Update.php");
}
