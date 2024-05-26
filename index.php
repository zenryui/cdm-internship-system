<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shortly</title>
    <link rel="stylesheet" href="cdm.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            color: #333;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 5px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .logo h1 {
            margin: 0;
            font-size: 24px;
            color: #75A47F;
            padding-left: 20px;
        }

        .nav, .dropdown {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .nav li {
            margin-right: 20px;
        }

        .nav a, .button {
            text-decoration: none;
            color: #333;
            font-weight: 500;
        }

        .button {
            background-color: #75A47F;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
        }

        .button:hover {
            background-color: #00bfa5;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #fff;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            padding: 10px;
            border-radius: 5px;
            top: 50px;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown-content a {
            display: block;
            padding: 10px;
            color: #333;
            text-decoration: none;
        }

        .dropdown-content a:hover {
            background-color: #f5f5f5;
        }

        .container {
            text-align: center;
            padding: 200px 20px;
        }

        .container h3 {
            font-size: 40px;
            margin-bottom: 20px;
        }

        .container p {
            font-size: 18px;
            color: #666;
            margin-bottom: 40px;
        }

        .get-started {
            display: inline-block;
            background-color: #75A47F;
            color: #fff;
            padding: 15px 30px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 18px;
            font-weight: 600;
        }

        .get-started:hover {
            background-color: #00bfa5;
        }

        .image {
            text-align: center;
            margin-top: 50px;
        }

        .image img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>

    <!-- HEADER START-->
    <div class="navbar">
        <div class="logo">
            <h1>CDM</h1>
        </div>
        
        <ul class="nav">
            <li><a href="#">Developers</a></li>
            <li><a href="#">Github Repository</a></li>
            <li><a href="#">Resources</a></li>
        </ul>
        <ul class="nav">
            <li><a href="./students/index.php">Login</a></li>
            <li><a href="./students/signup.php"><button class="button">Sign Up</button></a></li>
        </ul>
    </div>

    <!-- MAIN CONTENT START -->
    <div class="container">
        <h3>Welcome! to CDM Internship Registration System</h3>
        <p>Your gateway to professional growth and development.</p>
        <a href="#" class="get-started">Get Started</a>
    </div>


    <script src="scripts.js"></script>
</body>
</html>
