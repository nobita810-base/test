<?php
include_once 'hidden/set.php';
error_reporting(0);

?>
<!-- Code by SNH -->
<!doctype html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <link rel="icon" href="logo.jpg">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="theme-color" content="#000000">
    <meta name="title" content="<?php echo htmlspecialchars($title); ?>">
    <meta name="description" content="<?php echo htmlspecialchars($description); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($keywords); ?>">
    <meta name="author" content="<?php echo htmlspecialchars($author); ?>">

    <!-- Open Graph Meta Tags for Social Media -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo htmlspecialchars($DOMAIN); ?>">
    <meta property="og:title" content="<?php echo htmlspecialchars($title); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($description); ?>">
    <meta property="og:image" content="/cover.png">
    <meta property="og:image:alt" content="<?php echo htmlspecialchars($sv_name); ?>">


    <!-- Title -->
    <title><?php echo htmlspecialchars($sv_name); ?></title>

    <!-- External JavaScript and CSS -->
    <link rel="shortcut icon" type="img/fav.png" href="assets/images/logo.jpg" />
    <link rel="stylesheet" href="/assets/css/all.min.css" />
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet "href="/assets/css/bootstrap1.min.css">
    <link rel="stylesheet" href="/assets/css/styles.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <script src="/assets/js/jquery.js"></script>
    <script src="/assets/js/sweetalert2.js"></script>
    <!-- <script src="https://kit.fontawesome.com/c79383dd6c.js" crossorigin="anonymous"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" defer></script>
    <script src="snh/static/js/bootstrap.min.js" defer></script>
    <script src="snh/static/js/notiflix-aio.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12" defer></script>
    <script src="snh/static/js/TiMi_v%3D1.1.js" defer></script>

    <!-- External CSS -->
    <link href="snh/static/css/main.a238f600_v%3D1.1.css" rel="stylesheet">

    <!-- JavaScript to block copying -->
    <script>
    // Vô hiệu hóa chuột phải
    document.addEventListener('contextmenu', function(e) {
        e.preventDefault();
        alert('Bạn muốn làm gì);
    });

    // Vô hiệu hóa phím tắt Ctrl+U (xem nguồn trang)
    document.onkeydown = function(e) {
        if (e.ctrlKey && e.keyCode == 85) {
            alert('Bạn muốn làm gì);
            return false;
        }

        // Vô hiệu hóa phím tắt Ctrl+C (sao chép)
        if (e.ctrlKey && e.keyCode == 67) {
            alert('Bạn muốn làm gì);
            return false;
        }
    };
    </script>
</head>

<body>
    <div id="root" style="margin-top: 0; display: flex; flex-direction: column; height: 100vh;">
        <div class="background" style="transform: translate(0, 0);"></div>

        <div id="hello-container"></div>

        <div id="container" class="container" style="flex: 1; margin-top: 0;">
            <div class="main" style="flex: 1;">
                <!-- Card chính -->
                <div class="text-center card" style="margin-top: 0;">
                    <div class="card-body" style="padding-top: 0;">
                        <div>
                            <a href="/">
                                <br>
                                <img class="logo" alt="Logo" src="snh/images/bia.jpg"
                                    style="width: 100%; max-width: 900px; height: auto; display: block;">
                            </a>
                        </div>
                        <div class="mt-3">
                            <?php if ($_login == null) { ?>
                           
                            <?php } else { ?>
                            <a class="btn btn-success" href="/profile">
                                <span><?php echo $_username; ?> - <?php echo number_format($_vnd); ?> VND</span>
                            </a>
                            <?php } ?>
                        </div>
                         <div class="mt-3">
                            <a class="download-link"
                                href="https://www.tiktok.com/@fb8106486/"
                                target="_blank">
                                <img class="m-2" height="70" src="assets/images/download/TikTok.png" alt="TikTok">
                            </a>
                            <a class="download-link" 
                                href="https://zalo.me/0369590428/" 
                                target="_blank">
                                <img class="m-2" height="70" src="assets/images/download/Zalo.png" alt="Zalo">
                            </a>
                            <a class="download-link"
                                href="https://www.youtube.com/@doancongsinh8599/"
                                target="_blank">
                                <img class="m-2" height="70" src="assets/images/download/Youtube.png" alt="Youtube">
                            </a>
                            <a class="download-link"
                                href="https://www.facebook.com/congsinh488106/"
                                target="_blank">
                                <img class="m-2" height="70" src="assets/images/download/Facebook.png" alt="Facebook">
                            </a> 
                            <a class="download-link"
                                href="https://www.facebook.com/congsinh488106/"
                                target="_blank">
                                <img class="m-2" height="70" src="assets/images/download/Instagram.png" alt="Instagram">
                            </a>
                        </div>
                    </div>
                </div>

                <div class="mb-2">
                    <div class="row text-center justify-content-center row-cols-2 row-cols-lg-6 g-2 g-lg-2 mt-1">
                        <div class="col">
                            <div class="px-2">
                                <a class="btn btn-menu btn-success w-100 fw-semibold false"
                                    href="https://www.youtube.com/playlist?list=PL8zfhjKavmzesnH-eAeUuWDrDQXITbEnr">Nghe Nhạc Remix</a>

                                <?php if ($_login == null) { ?>

                                <?php } else { ?>
                            </div>
                        </div>

                        <div class="col">
                            <div class="px-2">
                                <a class="btn btn-menu btn-success w-100 fw-semibold false" href="/nap-tien">Nạp
                                    Tiền</a>
                                <?php } ?>


                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body"></div>