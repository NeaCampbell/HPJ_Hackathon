<?php
include 'connection.php';

if (empty($session_login))
    header('location: home.php');

if (isset($_POST['member'])) {
    $member = 1;
    
    $user_id = $_SESSION['login'];

    $sql = "UPDATE user SET membership = '$member' WHERE user_id = '$user_id'";

    if (mysqli_query($connMysqli, $sql)) {
        echo '<script>alert("berhasil update");</script>';
    } else {
        echo '<script>alert("gagal update");</script>';
    }
}
    
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membership</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="home.css">
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
                    <li class="nav-item">
                        <a class="nav-link" href="video.php">Video Tutorial</a>
                    </li>

                    <?php if (empty($session_login)): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    <?php endif ?>
                </ul>
            </div>
        </div>
    </nav>
    
    <br>

    <h1 class="title"><center>Membership</center></h1>

    <div class="row mx-auto">
        <div class="col-sm-12 lh-sm">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title">Premium</h1>
                    <br>
                    <p class="card-text">dapatkan hanya <b>Rp 29.999</b> per bulan</p>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Premium" data-membership="Starter">
                        Buy Now
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="Premium" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pembayaran Anda</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p>Membership Premium</p>
                        </div>
                        <div class="col-md-6 text-end">
                            <p>Rp 29.999</p>
                        </div>
                    </div>
                    <hr>
                    <p>Metode Pembayaran</p>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                        <label class="form-check-label" for="flexRadioDefault1">
                            Add Ovo
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                        <label class="form-check-label" for="flexRadioDefault2">
                            Add ShopeePay
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                        <label class="form-check-label" for="flexRadioDefault1">
                            Add DANA
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                        <label class="form-check-label" for="flexRadioDefault1">
                            Add GoPay
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" name="member" value="BUY" id="member">                
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>