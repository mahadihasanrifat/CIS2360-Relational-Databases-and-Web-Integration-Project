<?php
switch ($page) {
    case "dogs": $query = "SELECT * FROM dogs;"; break;
    case "owners": $query = "SELECT * FROM owners;"; break;
    case "judges": $query = "SELECT * FROM judges;"; break;
    case "competitions": $query = "SELECT * FROM competitions;"; break;
    default: echo "Error: page $page not allowed, query not defined!" . "<br />"; break;
}
?>