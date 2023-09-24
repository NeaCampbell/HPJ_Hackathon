<?php
include 'connection.php';

$sql = "SELECT video1_name, video1_play FROM video1 LIMIT 2";
$result = mysqli_query($connMysqli, $sql);

$videoData = array();

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $videoData[] = array(
            'src' => $row['video1_play'],
            'title' => $row['video1_name']
        );
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Tutorial 1</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="video1_free.css">
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
    
    <h3 class="heading">Membuat Mahar Bunga Dari Uang</h3>
    
    <div class="container">
        <div class="main-video">
            <div class="video">
                <?php if (!empty($videoData)): ?>
                    <video id="mainVideo" src="<?php echo $videoData[0]['src']; ?>" controls muted autoplay></video>
                <?php else: ?>
                    <video src="assets/video1.mp4"></video>
                    <div class="overlay">
                        <h2>Video khusus member</h2>
                    </div>
                <?php endif; ?>
                <h3 class="title"><?php echo (!empty($videoData)) ? $videoData[0]['title'] : 'Video khusus member'; ?></h3>
            </div>
        </div>

        <div class="video-button">
            <div class="video-list">
                <?php if (!empty($videoData)): ?>
                    <?php foreach ($videoData as $key => $video): ?>
                        <div class="vid <?php echo ($key === 0) ? 'active' : ''; ?>">
                            <video src="<?php echo $video['src']; ?>" muted></video>
                            <h3 class="title"><?php echo $video['title']; ?></h3>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div class="d-grid gap-2">
                <?php if (empty($session_login)): ?>
                    <a href="login.php" class="d-grid">
                        <img src="assets/membership.jpg">
                    </a>
                <?php else: ?>
                    <a href="membership.php" class="d-grid">
                        <img src="assets/membership.jpg">
                    </a>
                <?php endif ?>
            </div>
        </div>  
    </div>

<script>
    let listVideo = document.querySelectorAll('.video-list .vid');
    let mainVideo = document.querySelector('#mainVideo');
    let title = document.querySelector('.main-video .title');

    listVideo.forEach(video => {
        video.onclick = () => {
            listVideo.forEach(vid => vid.classList.remove('active'));
            video.classList.add('active');
            if (video.classList.contains('active')) {
                let src = video.children[0].getAttribute('src');
                mainVideo.src = src;
                let text = video.children[1].innerHTML;
                title.innerHTML = text;
            };
        };
    });
</script>
</body>
</html>