<?php 
include 'connection.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video List</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="video.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-success navbar-custom">
        <div class="container-fluid">
            <img src="assets/logo.png" width="40px" height="40px" class="logo">
            <a class="navbar-brand">Ardian Collection</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="home.php">Home</a>
                    </li>

                    <?php if (empty($session_login)): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="membership.php">Membership</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    <?php endif ?>
                </ul>
            </div>
        </div>
    </nav>
    
    <br>
    
    <h3 class="heading">Video Gallery</h3>
</body>
</html>

<div class="row mx-auto">
    <?php
    $sql = "SELECT * FROM video_list";
    $result = mysqli_query($connMysqli, $sql);

    if ($result->num_rows > 0) {
        $counter = 0;

        while ($row = $result->fetch_assoc()) {
            $counter++;

            // Determine whether to add an offset class
            $offsetClass = ($counter % 3 == 1) ? '' : 'offset-sm-0';

            $videoUrl = ($membership == 1) ? $row['video_play_member'] : $row['video_play'];

            echo '
                <div class="col-sm-4 py-2 lh-sm ' . $offsetClass . '">
                    <div class="card mx-auto">
                        <img src="data:image/jpeg;base64,' . base64_encode($row['video_image']) . '" class="card-img-top" alt="Video Image">
                        <div class="card-body">
                            <h5 class="card-title">' . $row['video_name'] . '</h5>
                            <p class="card-text">' . $row['tingkat_kesulitan'] . '</p>
                            <a href="' . $videoUrl . '" class="btn btn-primary">Learn Now</a>
                        </div>
                    </div>
                </div>
            ';

            // If the counter is divisible by 3, close the current row and start a new one
            if ($counter % 3 == 0) {
                echo '</div><div class="row mx-auto">';
            }
        }
    } else {
        echo "No videos found.";
    }
    ?>
</div>