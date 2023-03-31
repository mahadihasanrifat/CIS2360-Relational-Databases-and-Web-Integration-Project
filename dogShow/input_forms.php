<?php
// Associative map: Part of form => Option => Value
$form_info = ["action" => ["search" => "index.php", "insert" => "insert.php", "update" => "update.php"],
    "method" => ["search" => "GET", "insert" => "POST", "update" => "POST"],
    "submitValue" => ["search" => "Search", "insert" => "Add", "update" => "Update"]];
?>
<form action="<?php echo $form_info['action'][$option]; ?>"
      method="<?php echo $form_info['method'][$option]; ?>">
    <?php
    // $prevPK used in update
    $prevPK = (!empty($_GET['prevPK'])) ? $_GET['prevPK'] : "prevPK";
    input_fields($page, $option, $prevPK);
    ?>
    <input type="hidden" id="page" name="page" value="<?php echo $page; ?>"/>
    <input type="hidden" id="option" name="option" value="<?php echo $option; ?>"/><br/>
    <?php
    if ($option == "update") {
        ?>
        <input type="hidden" id="prevPK" name="prevPK" value="<?php echo $prevPK; ?>"/><br/>
        <?php
    }
    ?>
    <input type="submit" value="<?php echo $form_info['submitValue'][$option]; ?>"/>
</form>

<?php
// A function that retrieves a row for a given table based on an existing primary key
function get_prev_row($page, $prevPK)
{
    // A separate file to hide login details
    include './connection.php';

    switch ($page) {
        case "dogs": $query = "SELECT * FROM dogs WHERE id = '$prevPK';"; break;
        case "owners": $query = "SELECT * FROM owners WHERE id = '$prevPK';"; break;
        case "judges": $query = "SELECT * FROM judges WHERE id = '$prevPK';"; break;
        case "competitions": $query = "SELECT * FROM competitions WHERE id = '$prevPK';"; break;
    }

    // Run Select SQL query
    $results = $conn->query($query);

    $prev_row = [];
    // Translate results if only one result returned
    if ($results->num_rows == 1) {
        // Retrieve column names to generate headers for
        // any given SQL query
        $table_info = $results->fetch_fields();
        while ($row = $results->fetch_assoc()) {
            // Iterate over columns
            foreach ($table_info as $column) {
                $prev_row[$column->name] = htmlspecialchars($row[$column->name]);
            }
        }
    }

    // Close connection after executing the query
    $conn->close();

    return $prev_row;
}

// A function that generates input fields for each type of form
// according to current 'page' and 'option'
function input_fields($page, $option, $prevPK)
{
    if ($page == "dogs") {
        if ($option == "update") {
            $prev_row = get_prev_row($page, $prevPK);
        }
    
        ?>
        <label for="id">
            ID<?php echo ($option == "update") ? " (existing branch number retained if empty)" : "" ?>:</label><br/>
        <input type="text" id="branchNo" name="branchNo"
               placeholder="dog id" <?php echo ($option == "update") ? "value=\"" . $prev_row['id'] . "\"" : "" ?>/>
        <br/>
        <label for="street">Name:</label><br/>
        <input type="text" id="street" name="name"
               placeholder="name" <?php echo ($option == "update") ? "value=\"" . $prev_row['name'] . "\"" : "" ?>/>
        <br/>
        <label for="city">breed_id:</label><br/>
        <input type="text" id="city" name="breed_id"
               placeholder="breed_id" <?php echo ($option == "update") ? "value=\"" . $prev_row['breed_id'] . "\"" : "" ?>/>
        <br/>
        <label for="postcode">owner_id:</label><br/>
        <input type="text" id="postcode" name="owner_id"
               placeholder="owner_id" <?php echo ($option == "update") ? "value=\"" . $prev_row['owner_id'] . "\"" : "" ?>/>
        <br/>
        <?php
    } elseif ($page == "client") {
        if ($option == "update") {
            $prev_row = get_prev_row($page, $prevPK);
        }
        ?>
        <label for="clientNo">Client
            number<?php echo ($option == "update") ? " (existing client number retained if empty)" : "" ?>:</label><br/>
        <input type="text" id="clientNo" name="clientNo" placeholder="client number" <?php echo ($option == "update") ? "value=\"" . $prev_row['clientNo'] . "\"" : "" ?>/><br/>
        <label for="fname">First name:</label><br/>
        <input type="text" id="fname" name="fname" placeholder="first name" <?php echo ($option == "update") ? "value=\"" . $prev_row['fname'] . "\"" : "" ?>/><br/>
        <label for="lname">Last name:</label><br/>
        <input type="text" id="lname" name="lname" placeholder="last name" <?php echo ($option == "update") ? "value=\"" . $prev_row['lname'] . "\"" : "" ?>/><br/>
        <label for="telNo">Telephone number:</label><br/>
        <input type="text" id="telNo" name="telNo" placeholder="telephone number" <?php echo ($option == "update") ? "value=\"" . $prev_row['telNo'] . "\"" : "" ?>/><br/>
        <label for="prefType">Property type:</label><br/>
        <select name="prefType" id="prefType">
            <option disabled <?php echo ($option == "update" && $prev_row['prefType'] != "") ? "" : "selected" ?> value> -- select an option --</option>
            <option <?php echo ($option == "update" && $prev_row['prefType'] == "House") ? "selected" : "" ?> value="House">House</option>
            <option <?php echo ($option == "update" && $prev_row['prefType'] == "Flat") ? "selected" : "" ?> value="Flat">Flat</option>
        </select><br/>
        <label for="maxRent">Maximum rent:</label><br/>
        <input type="number" id="maxRent" name="maxRent" placeholder="maximum rent" min="0" <?php echo ($option == "update") ? "value=\"" . $prev_row['maxRent'] . "\"" : "" ?>/><br/>
        <label for="email">Email:</label><br/>
        <input type="email" id="email" name="email" placeholder="email" <?php echo ($option == "update") ? "value=\"" . $prev_row['email'] . "\"" : "" ?>/><br/>
        <?php
    } elseif ($page == "privateowner") {
        if ($option == "update") {
            $prev_row = get_prev_row($page, $prevPK);
        }
        ?>
        <label for="ownerNo">Owner
            number<?php echo ($option == "update") ? " (existing owner number retained if empty)" : "" ?>:</label><br/>
        <input type="text" id="ownerNo" name="ownerNo" placeholder="owner number" <?php echo ($option == "update") ? "value=\"" . $prev_row['ownerNo'] . "\"" : "" ?>/><br/>
        <label for="fname">First name:</label><br/>
        <input type="text" id="fname" name="fname" placeholder="first name" <?php echo ($option == "update") ? "value=\"" . $prev_row['fname'] . "\"" : "" ?>/><br/>
        <label for="lname">Last name:</label><br/>
        <input type="text" id="lname" name="lname" placeholder="last name" <?php echo ($option == "update") ? "value=\"" . $prev_row['lname'] . "\"" : "" ?>/><br/>
        <label for="address">Address:</label><br/>
        <input type="text" id="address" name="address" placeholder="address" <?php echo ($option == "update") ? "value=\"" . $prev_row['address'] . "\"" : "" ?>/><br/>
        <label for="telNo">Telephone number:</label><br/>
        <input type="text" id="telNo" name="telNo" placeholder="telephone number" <?php echo ($option == "update") ? "value=\"" . $prev_row['telNo'] . "\"" : "" ?>/><br/>
        <?php
    } elseif ($page == "property") {
        include './select_sql_to_html.php';

        if ($option == "update") {
            $prev_row = get_prev_row($page, $prevPK);
        }
        ?>
        <label for="propertyNo">Property
            number<?php echo ($option == "update") ? " (existing property number retained if empty)" : "" ?>:</label>
        <br/>
        <input type="text" id="propertyNo" name="propertyNo" placeholder="property number" <?php echo ($option == "update") ? "value=\"" . $prev_row['propertyNo'] . "\"" : "" ?>/><br/>
        <label for="street">Street:</label><br/>
        <input type="text" id="street" name="street" placeholder="street" <?php echo ($option == "update") ? "value=\"" . $prev_row['street'] . "\"" : "" ?>/><br/>
        <label for="city">City:</label><br/>
        <input type="text" id="city" name="city" placeholder="city" <?php echo ($option == "update") ? "value=\"" . $prev_row['city'] . "\"" : "" ?>/><br/>
        <label for="postcode">Postcode:</label><br/>
        <input type="text" id="postcode" name="postcode" placeholder="postcode" <?php echo ($option == "update") ? "value=\"" . $prev_row['postcode'] . "\"" : "" ?>/><br/>
        <label for="type">Property type:</label><br/>
        <select name="type" id="type">
            <option disabled <?php echo ($option == "update" && $prev_row['type'] != "") ? "" : "selected" ?> value> -- select an option --</option>
            <option <?php echo ($option == "update" && $prev_row['type'] == "House") ? "selected" : "" ?> value="House">House</option>
            <option <?php echo ($option == "update" && $prev_row['type'] == "Flat") ? "selected" : "" ?> value="Flat">Flat</option>
        </select><br/>
        <label for="rooms"><?php echo ($option == "search") ? "Maximum rooms" : "Rooms" ?>:</label><br/>
        <input type="number" id="rooms" name="rooms" placeholder="Maximum rooms" min="0" <?php echo ($option == "update") ? "value=\"" . $prev_row['rooms'] . "\"" : "" ?>/><br/>
        <label for="rent"><?php echo ($option == "search") ? "Maximum rent" : "Rent" ?>:</label><br/>
        <input type="number" id="rent" name="rent" placeholder="maximum rent" min="0" <?php echo ($option == "update") ? "value=\"" . $prev_row['rent'] . "\"" : "" ?>/><br/>
        <?php

        // ownerNo
        $html_id = $sql_id = "ownerNo";
        $query = "SELECT $sql_id
                    FROM ea_PrivateOwner;
                ";
        $message = "Owner number:";
        if ($option == "update") {
            existing_select_sql_to_drop_down($html_id, $sql_id, $query, $message, $prev_row);
        } else {
            select_sql_to_drop_down($html_id, $sql_id, $query, $message);
        }

        // staffNo
        $html_id = $sql_id = "staffNo";
        $query = "SELECT $sql_id
                    FROM ea_Staff;
                ";
        $message = "Staff number:";
        if ($option == "update") {
            existing_select_sql_to_drop_down($html_id, $sql_id, $query, $message, $prev_row);
        } else {
            select_sql_to_drop_down($html_id, $sql_id, $query, $message);
        }

        // branchNo
        $html_id = $sql_id = "branchNo";
        $query = "SELECT $sql_id
                    FROM ea_Branch;
                ";
        $message = "Branch number:";
        if ($option == "update") {
            existing_select_sql_to_drop_down($html_id, $sql_id, $query, $message, $prev_row);
        } else {
            select_sql_to_drop_down($html_id, $sql_id, $query, $message);
        }
    } elseif ($page == "staff") {
        include './select_sql_to_html.php';

        if ($option == "update") {
            $prev_row = get_prev_row($page, $prevPK);

        }
        ?>
        <label for="staffNo">Staff
            number<?php echo ($option == "update") ? " (existing staff number retained if empty)" : "" ?>:</label><br/>
        <input type="text" id="staffNo" name="staffNo" placeholder="staff number" <?php echo ($option == "update") ? "value=\"" . $prev_row['staffNo'] . "\"" : "" ?>/><br/>
        <label for="fname">First name:</label><br/>
        <input type="text" id="fname" name="fname" placeholder="first name" <?php echo ($option == "update") ? "value=\"" . $prev_row['fname'] . "\"" : "" ?>/><br/>
        <label for="lname">Last name:</label><br/>
        <input type="text" id="lname" name="lname" placeholder="last name" <?php echo ($option == "update") ? "value=\"" . $prev_row['lname'] . "\"" : "" ?>/><br/>
        <label for="position">Position:</label><br/>
        <select name="position" id="position">
            <option disabled <?php echo ($option == "update" && $prev_row['position'] != "") ? "" : "selected" ?> value> -- select an option --</option>
            <option <?php echo ($option == "update" && $prev_row['position'] == "Assistant") ? "selected" : "" ?> value="Assistant">Assistant</option>
            <option <?php echo ($option == "update" && $prev_row['position'] == "Supervisor") ? "selected" : "" ?> value="Supervisor">Supervisor</option>
            <option <?php echo ($option == "update" && $prev_row['position'] == "Manager") ? "selected" : "" ?> value="Manager">Manager</option>
        </select><br/>
        <label for="dob">Date of birth<?php echo ($option == "search") ? " (on or before)" : "" ?>:</label><br/>
        <input type="date" id="dob" name="dob" placeholder="date of birth" <?php echo ($option == "update") ? "value=\"" . $prev_row['dob'] . "\"" : "" ?>/><br/>
        <label for="salary"><?php echo ($option == "search") ? "Maximum salary" : "Salary" ?>:</label><br/>
        <input type="number" id="salary" name="salary" placeholder="maximum salary" min="0" <?php echo ($option == "update") ? "value=\"" . $prev_row['salary'] . "\"" : "" ?>/><br/>
        <?php

        // branchNo
        $html_id = $sql_id = "branchNo";
        $query = "SELECT $sql_id
                    FROM ea_Branch;
                ";
        $message = "Branch number:";
        if ($option == "update") {
            existing_select_sql_to_drop_down($html_id, $sql_id, $query, $message, $prev_row);
        } else {
            select_sql_to_drop_down($html_id, $sql_id, $query, $message);
        }
    } elseif ($page == "viewing") {
        include './select_sql_to_html.php';

        // clientNo
        $html_id = $sql_id = "clientNo";
        $query = "SELECT $sql_id
                    FROM ea_Client;
                ";
        $message = "Client number:";
        select_sql_to_drop_down($html_id, $sql_id, $query, $message);

        // propertyNo
        $html_id = $sql_id = "propertyNo";
        $query = "SELECT $sql_id
                    FROM ea_PropertyForRent;
                ";
        $message = "Property number:";
        select_sql_to_drop_down($html_id, $sql_id, $query, $message);
        ?>
        <label for="viewDate">View date<?php echo ($option == "search") ? " (on or before)" : "" ?>:</label><br/>
        <input type="date" id="viewDate" name="viewDate" placeholder="view date"/><br/>
        <label for="comment">Comment:</label><br/>
        <input type="text" id="comment" name="comment" placeholder="comment"/><br/>
        <?php
    } else {
        echo "Error: Incorrect page, $page";
    }
}
?>

