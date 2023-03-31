<!-- Begin Right Column -->
<div id="rightcolumn">
    <div class="clear">
        <?php
        // Check if error occurred
        if (!empty($_GET['error'])) {
            echo $_GET['error'];
            die();
        }

        // Check if parameter 'page' is set
        if (!empty($_GET['page'])) {
            $page = $_GET['page'];

            // Check if parameter 'option' is set
            if (!empty($_GET['option'])) {
                $option = $_GET['option'];

                if ($option == "view") {
                    // A separate file to hide login details
                    include './connection.php';

                    include './select_all_query.php';

                    include './select_sql_to_table.php';

                    // Close connection after executing the query
                    $conn->close();
                } elseif ($option == "insert") {
                    // Insert a new row
                    include './input_forms.php';
                } elseif ($option == "update") {
                    // Additional parameters besides 'page' and 'option'
                    if (count($_GET) > 2 || $page == "viewing") {
                        // Update an existing row
                        include './input_forms.php';
                    } else { // Only 'page' and 'option' provided
                        include './update_forms.php';
                    }
                } elseif ($option == "delete") {
                    ?>
                    <form action="delete.php" method="POST">
                        <?php
                        // A separate file to hide login details
                        include './connection.php';

                        include './select_all_query.php';

                        include './select_sql_to_table.php';
                        ?>
                        <input type="hidden" id="page" name="page" value="<?php echo $page; ?>"/>
                        <input type="hidden" id="option" name="option" value="<?php echo $option; ?>"/><br/>
                        <?php
                        if ($results->num_rows > 0) {
                            echo "<input type=\"submit\" value=\"Remove\" />";
                        }
                        // Close connection after executing the query
                        $conn->close();
                        ?>
                    </form>
                    <?php
                }
            }

            if($page == "Welcome")
            {
                include "./Welcome.php";
            }
        }
        ?>
    </div>
</div>
<!-- End Right Column -->
