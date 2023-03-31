<!-- Begin Navigation -->
<div id="nav">
    <?php
    // Check in parameter 'page' is set
    $page = (!empty($_GET['page']) ? $_GET['page'] : "branch");

    // Associative map: Option => Output Message
    $menu = ["dogs" => "Dogs",
            "owners" => "Owners",
            "judges" => "Judges",
            "competitions" => "Competitions",
        "Welcome" => "Welcome"];
    ?>
    <ul>
        <?php
        foreach ($menu as $p => $message) {
            echo "<li class=\"menu\"><a href=\"index.php?page=$p\"" .
                (($page == $p) ? " class=\"active\"" : "") . ">$message</a></li>";
        }
        ?>
        <li class="logout"><a href="logout.php">Logout</a></li>
        <li><p>Hello, <?php echo htmlspecialchars($_SESSION["username"]) ?>!</p></li>
    </ul>
</div>
<!-- End Navigation -->
