<!-- employer-create-internship.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Internship Program</title>
</head>
<body>
    <h2>Create Internship Program</h2>
    <form action="process_internship.php" method="POST">
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title" required><br>
        <label for="description">Description:</label><br>
        <textarea id="description" name="description" rows="4" required></textarea><br>
        <label for="requirements">Requirements:</label><br>
        <textarea id="requirements" name="requirements" rows="4" required></textarea><br>
        <label for="duration">Duration:</label><br>
        <input type="text" id="duration" name="duration" required><br><br>
        <input type="submit" value="Create Program">
    </form>
</body>
</html>
