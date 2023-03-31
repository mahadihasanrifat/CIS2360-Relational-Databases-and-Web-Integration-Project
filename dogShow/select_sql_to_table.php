<?php

// Run Select SQL query
$results = $conn->query($query);

// Translate results (if any) into a table
if ($results->num_rows >= 0) {
    echo "<table>" . PHP_EOL;
    // Retrieve column names to generate headers for
    // any given SQL query
    $table_info = $results->fetch_fields();
    // Iterate over header row
    echo "<tr> " . PHP_EOL;
    if ($option == "delete" and $results->num_rows > 0) {
        echo "<th></th>" . PHP_EOL;
    }
    foreach ($table_info as $column) {
        echo "<th>" . $column->name . "</th>" . PHP_EOL;
    }
    // Iterate over data rows
    echo "</tr> " . PHP_EOL;
    while ($row = $results->fetch_assoc()) {
        echo "<tr > " . PHP_EOL;
        if ($option == "delete") {
            switch ($page) {
                case "dogs": echo " <td><input type = \"checkbox\" id=\"id[]\" name=\"id[]\" value=\"" . htmlspecialchars($row['id']) . "\"> </td>" . PHP_EOL; break;
                case "owners": echo "<td><input type=\"checkbox\" id=\"clientNo[]\" name=\"id[]\" value=\"" . htmlspecialchars($row['id']) . "\"> </td>" . PHP_EOL; break;
                case "judges": echo "<td><input type=\"checkbox\" id=\"ownerNo[]\" name=\"id[]\" value=\"" . htmlspecialchars($row['id']) . "\"> </td>" . PHP_EOL; break;
                case "competitions": echo "<td><input type=\"checkbox\" id=\"clientNo~propertyNo[]\" name=\"id[]\" value=\"" . htmlspecialchars($row['id'] . "~" . $row['propertyNo']) . "\"> </td>" . PHP_EOL; break;
                default: echo "Error: page $page not allowed, checkbox not defined!" . "<br />"; break;
            }
        }
        // Iterate over columns
        foreach ($table_info as $column) {
            echo "<td>" . htmlspecialchars($row[$column->name]) . "</td>" . PHP_EOL;
        }
        echo "</tr>" . PHP_EOL;
    }
    echo "</table>" . PHP_EOL;
}
?>
