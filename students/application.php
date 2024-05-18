<?php
require_once("../employer/connection.php"); // Include the database connection file

// Fetch all internship postings from the database
$sql = "SELECT * FROM internship";
$result = $conn->query($sql);

// Check if there are any internship postings
if ($result->num_rows > 0) {
    // Output table header
    echo "<table border='1'>";
    echo "<tr><th>Internship ID</th><th>Title</th><th>Duration</th><th>Description</th></tr>";
    
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        // Display the internship details in a table row
        echo "<tr>";
        echo "<td>" . $row["Internship_ID"] . "</td>";
        echo "<td>" . $row["Title"] . "</td>";
        echo "<td>" . $row["Duration"] . "</td>";
        echo "<td>" . $row["Description"] . "</td>";
        echo "</tr>";
    }

    // Close the table
    echo "</table>";
} else {
    // If no internship postings are found, display a message
    echo "No internship postings available";
}

// Close the database connection
$conn->close();
?>
