<?php
include 'connection.php';

if (empty($session_login))
    header('location: home.php');

$video_namaE ="";
$video_kategoriE ="";
$video_deskripsiE ="";
$tingkat_kesulitanE="";
$video_playE="";

if (isset($_POST['save'])) {
  $video_nama = $_POST['video_nama'];
  $video_kategori = $_POST['video_kategori'];
  $video_deskripsi = $_POST['video_deskripsi'];
  $tingkat_kesulitan = $_POST['tingkat_kesulitan'];
  $video_play = $_POST['video_play'];
  if (!empty($_FILES["video_image"]["name"])) {
    // Get file info 
    $image = $_FILES['video_image']['tmp_name'];
    $imgContent = addslashes(file_get_contents($image));
  }

$sql = "INSERT INTO video_list (video_name, video_category, video_deskripsi, tingkat_kesulitan, video_play, video_image) VALUES ('$video_nama','$video_kategori','$video_deskripsi','$tingkat_kesulitan','$video_play','$imgContent')";
if (mysqli_query($connMysqli, $sql)) {
  echo '<script>alert("berhasil insert");</script>';
  } else {
    echo '<script>alert("gagal insert");</script>';
  }
}

if (isset($_POST['save_video1'])) {
  $video_nama = $_POST['video1_nama'];
  $video_play = $_POST['video1_play'];

$sql = "INSERT INTO video1 (video1_name, video1_play) VALUES ('$video_nama','$video_play')";
if (mysqli_query($connMysqli, $sql)) {
  echo '<script>alert("berhasil insert");</script>';
  } else {
    echo '<script>alert("gagal insert");</script>';
  }
}

if (isset($_POST['delete'])) {
  $video_id = $_POST['video_id'];
  $sql = "DELETE FROM video_list WHERE video_id='$video_id'";
  if (mysqli_query($connMysqli, $sql)) {
    echo '<script>alert("berhasil hapus");</script>';
  } else {
    echo '<script>alert("gagal hapus");</script>';
  }

}

if (isset($_POST['delete_video1'])) {
  $video_id = $_POST['video1_id'];
  $sql = "DELETE FROM video1 WHERE video1_id='$video_id'";
  if (mysqli_query($connMysqli, $sql)) {
    echo '<script>alert("berhasil hapus");</script>';
  } else {
    echo '<script>alert("gagal hapus");</script>';
  }

}

if (isset($_POST['edit'])){
  $id = $_POST['video_id'];
  $sql = "SELECT * FROM video_list WHERE video_id = '$id'";
  $result = mysqli_query($connMysqli, $sql);
  $row = mysqli_fetch_assoc($result);
  $video_namaE = $row['video_nama'];
  $video_kategoriE = $row['video_kategori'];
  $video_deskripsiE = $row['video_deskripsi'];
  $tingkat_kesulitanE = $row['tingkat_kesulitan'];
  $video_playE = $row['video_play'];
  echo "<script>alert('$video_namaE dan $video_kategoriE, $video_deskripsiE, $tingkat_kesulitanE, $video_playE')</script>";
}
?>

<!DOCTYPE html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="admin.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
  <script type="text/javascript" charset="utf8"
    src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
</head>

<body>
<nav class="navbar navbar-expand-lg bg-success navbar-custom">
        <div class="container-fluid">
            <img src="assets/logo.png" width="40px" height="40px" class="logo">
            <a class="navbar-brand">Ardian Collection (Admin)</a>

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

  <!-- button modal -->
  <div class="container p-3">
    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#ModalAdd">Add Tutorial</button>
    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#ModalAddVideo">Add Video</button>
  </div>

  <div class="container">
    <div class="section">
      <br>
      <div class="table-responsive">
        <table class="table table-danger table-hover table-bordered  display" id="tableVideo">
          <thead class="table-dark">
            <tr>
              <th>Video ID</th>
              <th>Video Name</th>
              <th>Video Kategori</th>
              <th>Video Deskripsi</th>
              <th>Tingkat Kesulitan</th>
              <th>Video Play</th>
              <th>Video Image</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $sql = "SELECT * FROM video_list";
            $result = mysqli_query($connMysqli, $sql);
            if (!$result){
              die("Failed : " . mysqli_error($connMysqli));
            }
            $no = 1;
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                //
                echo '
                   <tr>
                      <td>' . $row["video_id"] . '</td>
                      <td>' . $row["video_name"] . '</td>
                      <td>' . $row["video_category"] . '</td>
                      <td>' . $row["video_deskripsi"] . '</td>
                      <td>' . $row["tingkat_kesulitan"] . '</td>
                      <td>' . $row['video_play'] . '</td>
                      <td style="width :25%;"><img src="data:image/jpeg;base64,' . base64_encode($row['video_image']) . '" width="25%"/></td>
                      <td>
                      <form method="post" action="">
                      <input type="hidden" id="video_id" name="video_id" value="' . $row["video_id"] . '">
                        <button   class="btn btn-danger" name="delete"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                        </svg>
                        
                        </button>
        
                        </form>
                   
                    </td>
                   </tr>
                  ';
                $no = $no + 1;
              }
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="section">
      <br>
      <div class="table-responsive">
        <table class="table table-danger table-hover table-bordered  display" id="tableVideo">
          <thead class="table-dark">
            <tr>
              <th>Video ID</th>
              <th>Video Name</th>
              <th>Video Play</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $sql = "SELECT * FROM video1";
            $result = mysqli_query($connMysqli, $sql);
            if (!$result){
              die("Failed : " . mysqli_error($connMysqli));
            }
            $no = 1;
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                //
                echo '
                   <tr>
                      <td>' . $row["video1_id"] . '</td>
                      <td>' . $row["video1_name"] . '</td>
                      <td>' . $row['video1_play'] . '</td>
                      <td>
                      <form method="post" action="">
                      <input type="hidden" id="video1_id" name="video1_id" value="' . $row["video1_id"] . '">
                        <button   class="btn btn-danger" name="delete_video1"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                        </svg>
                        
                        </button>
        
                        </form>
                   
                    </td>
                   </tr>
                  ';
                $no = $no + 1;
              }
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Tutorial</h5>
          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
          </button>
        </div>
        <form method="post" action="" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="mb-3 mt-3">
              <label for="video_nama" class="form-label">Nama Tutorial</label>
              <input class="form-control" type="text" placeholder="Masukkan nama video" name="video_nama"
                id="video_nama">
              <br>
              <label for="video_kategori" class="form-label">Kategori Video</label>
              <select class="form-select" name="video_kategori">
                <option value="-">-</option>
                <option value="Mahar">Mahar</option>
                <option value="Hantaran">Hantaran</option>
                <option value="Bouquet">Bouquet</option>
                <option value="Backdrop">Backdrop</option>
              </select>
              <br>
              <label for="video_deskripsi" class="form-label">Deskripsi Video</label>
              <br>
              <textarea name="video_deskripsi" id="video_deskripsi" cols="50" rows="10"></textarea>
              <br>
              <label for="tingkat_kesulitan" class="form-label">Tingkat Kesulitan</label>
              <select class="form-select" name="tingkat_kesulitan">
                <option value="Mudah">Mudah</option>
                <option value="Sedang">Sedang</option>
                <option value="Sulit">Sulit</option>
              </select>
              <br>
              <label for="video_play" class ="form-label">Video Play</label>
              <input type="text" class = "form-control" placeholder ="Masukkan link video" name="video_play" id="video_play" value="">
              <br>  
              <label for="video_image" class="form-label">Video Image</label>
              <input class="form-control" type="file" placeholder="Your Produk Image" name="video_image" id="video_image"
                value="">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button name="save" id="save" class="btn btn-primary">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="ModalAddVideo" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Video</h5>
          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
          </button>
        </div>
        <form method="post" action="" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="mb-3 mt-3">
              <label for="video1_nama" class="form-label">Nama Video </label>
              <input class="form-control" type="text" placeholder="Masukkan nama video" name="video1_nama"
                id="video1_nama">
              <br>
              <label for="video1_play" class ="form-label">Video Play</label>
              <input type="text" class = "form-control" placeholder ="Masukkan link video" name="video1_play" id="video1_play" value="">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button name="save_video1" id="save_video1" class="btn btn-primary">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>


  <script>

    $(document).ready(function () {
      $('#tableVideo').DataTable();
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>
</body>

</html>