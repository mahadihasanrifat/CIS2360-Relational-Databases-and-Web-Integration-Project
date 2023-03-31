<style>
    .owner-details {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .owner-details li {
        margin: 10px 0;
        font-size: 18px;
        animation: fadeIn 0.5s ease-in;
    }
    .highlight {
        color: #fd5f00;
    }
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
    .btn {
        background-color: #fd5f00;
        border: none;
        color: white;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
        border-radius: 5px;
        transition: background-color 0.2s ease-in;
    }
    .btn:hover {
        background-color: #ff7e33;
    }
</style>
<?php

// Display errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection file
include_once('connection.php');

// Check if the 'name' parameter is set and not empty
if(isset($_REQUEST['name']) && !empty($_REQUEST['name'])) {
    $details = $_REQUEST['name'];
} else {
    die('Owner not found');
}

// Select the owner with the specified name from the database
$query = "SELECT * FROM owners WHERE name = '$details'";
$output = $conn->query($query);

// Check if the query was successful
if (!$output) {
    die("Error running query: " . $conn->error);
}

// Check if the owner was found
if ($output->num_rows == 0) {
    die("Owner not found");
}

// Fetch the owner data as an associative array
$data = mysqli_fetch_array($output, MYSQLI_ASSOC);

// Display the owner details

echo "<h1>Owner Details</h1>";
echo "<hr>";
echo "<ul class='owner-details'>";
echo "  <li>Name: <span class='highlight'>" . $data['name'] . "</span></li>";
echo "  <li>Email: <span class='highlight'>" . $data['email'] . "</span></li>";
echo "  <li>Phone: <span class='highlight'>" . $data['phone'] . "</span></li>";
echo "  <li>Address: <span>" . $data['address'] . "</span></li>";
echo "</ul>";
echo "<div style='text-align: center; margin-top: 20px;'>";
echo "  <button onclick='history.go(-1)' class='btn'>Back to Search</button>";
echo "</div>";




// Close the database connection
$conn->close();

?>