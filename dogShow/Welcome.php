<!DOCTYPE html>
<html>
    <head>
      <style>
      td {
        border: 1px solid black;
        padding: 8px;
        transition: all 0.5s;
      }
      td:hover {
        background-color: #f2f2f2;
      }
        a {
          color: blue;
          transition: color 0.5s;
        }
        a:hover {
          color: #0077ff;
        }
      </style>
      <script>
      function highlightRow() {
        this.style.backgroundColor = "#ffff00";
      }
      function unhighlightRow() {
        this.style.backgroundColor = "";
      }
      </script>
    </head>
  <body>

<?php

include_once('connection.php');

// Define SQL statement to retrieve the necessary data
$sql = "
  SELECT COUNT(DISTINCT o.id) AS 'num_owners',
         COUNT(DISTINCT d.id) AS 'num_dogs',
         COUNT(DISTINCT e.id) AS 'num_events'
  FROM owners o
  INNER JOIN dogs d ON o.id = d.owner_id
  INNER JOIN entries en ON d.id = en.dog_id
  INNER JOIN competitions c ON en.competition_id = c.id
  INNER JOIN events e ON c.event_id = e.id
";

// Execute the SELECT statement
$result = $conn->query($sql);

// Check if there are any rows returned
if ($result->num_rows > 0) {
  // Fetch the row data
  $row = $result->fetch_assoc();
  
  // Extract the data into variables
  $numOwners = $row["num_owners"];
  $numDogs = $row["num_dogs"];
  $numEvents = $row["num_events"];
} else {
  // If no rows are returned, set the variables to 0
  $numOwners = 0;
  $numDogs = 0;
  $numEvents = 0;
}

// Output the welcome message
echo "<h1>Welcome to Poppleton Dogs Show!</h1>";

// Output the summary
echo "<h1> This year $numOwners owners entered $numDogs dogs in $numEvents events! </h1>";


// Start the table
echo "<table class='dog-table'>";

// Add the table headings
echo "
  <tr class='table-heading'>
    <th class='table-cell'>Number</th>
    <th class='table-cell'>Dogs Name</th>
    <th class='table-cell'>Breed</th>
    <th class='table-cell'>Average Score</th>
    <th class='table-cell'>Owner Name</th>
    <th class='table-cell'>Owner Email</th>
  </tr>
";

// Retrieve the top 10 dogs with the highest average score
$query4 = "
    SELECT dog_id, AVG(score) 
    FROM entries 
    GROUP BY dog_id 
    HAVING COUNT(competition_id) > 1 
    ORDER BY AVG(score) DESC 
    LIMIT 10
";
// Execute the SELECT statement
$output3 = $conn->query($query4);

// Initialize the counter for the number column
$number = 1;

// Loop through the results
while ($row = mysqli_fetch_assoc($output3)) {
    // Retrieve the dog data
    $dog = $row["dog_id"];


    $query5 = "SELECT * FROM dogs WHERE id = $dog"; 
    $output4 = mysqli_fetch_assoc($conn->query($query5));

    // Retrieve breed data for the current dog
    $breed = $output4["breed_id"];
    $query6 = "SELECT * FROM breeds WHERE id = $breed";
    $output5 = mysqli_fetch_assoc($conn->query($query6));

    // Retrieve owner data for the current dog
    $owners = $output4["owner_id"];
    $query7 = "SELECT * FROM owners WHERE id = $owners";
    $output6 = mysqli_fetch_assoc($conn->query($query7));

    // Print dog data in a table row
    echo "<tr onmouseover='highlightRow.call(this)' onmouseout='unhighlightRow.call(this)'>";
    echo "<td>" . $number . "</td>";
    echo "<td>" . $output4['name'] . "</td>";
    echo "<td>" . $output5['name'] . "</td>";
    echo "<td>" . $row['AVG(score)'] . "</td>";
    echo "<td><a href='ownerprofile.php?name=" . $output6['name'] . "'>" . $output6['name'] . "</a></td>";
    echo "<td><a href=mailto:" . $output6['email'] . ">" . $output6['email'] . "</a></td>";
    echo "</tr>";
    
    $number++;
  }


echo "</table>";
?>

  </body>
</html>