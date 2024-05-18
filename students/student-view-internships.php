<!-- student-view-internships.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Internships</title>
</head>
<body>
    <h2>Available Internships</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Requirements</th>
                <th>Duration</th>
                <th>Apply</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require_once("../connection/connection.php");
            $sql = "SELECT * FROM internship";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['Title'] . "</td>";
                    echo "<td>" . $row['Description'] . "</td>";
                    echo "<td>" . $row['Requirements'] . "</td>";
                    echo "<td>" . $row['Duration'] . "</td>";
                    echo "<td><a href='apply-for-internship.php?id=" . $row['Internship_ID'] . "'>Apply</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No internships available</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
