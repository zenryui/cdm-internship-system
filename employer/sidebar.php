<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employer Sidebar</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/sidebar.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="shortcut icon" href="../assets/img/nvidia.png">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            font-size: 12px;
            color: #7d8da1;
            background-color: #f8f9fa;
            font-weight: 600;
        }
        .dashboard-card {
            background-color: white;
            box-shadow: 0px 15px 20px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            text-align: center;
            font-size: 12px;
        }

        .section-divider-top {
            border-bottom: 2px solid #e9ecef;
            margin: 5px 0;
        }

        .dashboard-card-info {
            background-color: white;
            box-shadow: 0px 15px 20px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            text-align: left;
            font-size: 12px;
            max-width: 20rem;
        }

        .dashboard-table {
            font-size: 12px;
        }

        .modern-table {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0px 15px 20px rgba(0, 0, 0, 0.2);
        }

        .modern-table thead {
            background-color: white;
            box-shadow: 0px 15px 20px rgba(0, 0, 0, 0.2);
        }

        .modern-table th, .modern-table td {
            padding: 12px 15px;
        }

        .modern-table th {
            text-align: left;
            font-weight: bold;
        }

        .modern-table tbody tr:nth-of-type(even) {
            background-color: #f3f3f3;
        }

        .modern-table tbody tr:hover {
            background-color: #e9ecef;
            box-shadow: 0px 15px 20px rgba(0, 0, 0, 0.2);
        }

        .pending-status {
            color: #FF7F3E;
            font-weight: 400;
        }

        .text-top {
            color: #75A47F;
        }

        .float-right {
            float: right;
            margin: 20px;
            color: #75A47F;
        }
        .float-right:hover {
            text-decoration: none;
            color: #75A47F;
        }

        h1, h2, h3 {
            font-size: 12px;
        }

        .float-right-table {
            float: right;
            margin: 8px;
            color: #75A47F;
            font-size: 12px;
        }
    </style>
</head>
<body>
<div class="sidebar">
    <div class="brand"><span>CDM Internship</span></div>
    <div class="toggle-btn" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </div>
    <div class="section-divider"></div>
    <a href="log.php"><i class="fas fa-columns"></i><span>Dashboard</span></a>
    <a href="profile.php"><i class="fas fa-user"></i><span>Profile</span></a>
    <a href="post_internship.php"><i class="fas fa-briefcase"></i><span>Post Internship</span></a>
    <a href="application_list.php"><i class="fas fa-list"></i><span>See Application</span></a>
    <a href="change_pass.php"><i class="fas fa-lock"></i><span>Change Password</span></a>
    <a href="logout.php" id="logout-btn"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        const content = document.querySelector('.content');
        sidebar.classList.toggle('collapsed');
        content.classList.toggle('collapsed');
    }

    document.getElementById('logout-btn').addEventListener('click', function (e) {
        e.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: "You will be logged out!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, logout!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'logout.php';
            }
        });
    });
</script>
</body>
</html>
