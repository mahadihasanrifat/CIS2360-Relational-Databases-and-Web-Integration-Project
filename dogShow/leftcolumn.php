<!-- Begin Left Column -->
<div id="leftcolumn">
    <?php
    // Check in parameters 'page' and 'option' are set
    $page = (!empty($_GET['page']) ? $_GET['page'] : "branch");
    $option = (!empty($_GET['option']) ? $_GET['option'] : "");

    // Associative map: Page => Option => Output Message
    $menu = ["dogs" => ["view" => "View dogs",  "insert" => "Add dogs", "update" => "Update dogs", "delete" => "Remove dogs"],
        "owners" => ["view" => "View owners",  "insert" => "Add owners", "update" => "Update owners", "delete" => "Remove owners"],
        "judges" => ["view" => "View judges",  "insert" => "Add judges", "update" => "Update judges", "delete" => "Remove judges"],
        "competitions" => ["view" => "View competitions", "insert" => "Add competitions", "update" => "Update competitions", "delete" => "Remove competitions"],
    ];

    // If page is not valid, redirect to home page
    //if (!array_key_exists($page, $menu)) {
   //     header("Location: index.php");
   //     die();
   // }
    ?>
    <ul>
        <?php
        foreach ($menu[$page] as $opt => $out_message) {
            echo "<li><a href=\"index.php?page=$page&option=$opt\"" .
                (($option == $opt) ? " class=\"active\"" : "") . ">$out_message</a></li>";
        }
        ?>
    </ul>
</div>
<!-- End Left Column -->
