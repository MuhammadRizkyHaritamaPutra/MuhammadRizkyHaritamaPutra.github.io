<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>posttest7</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <style>
    .bordered-button {
        border: 2px solid red; 
        padding: 10px 20px; 
        margin: 10px;  
        border-radius: 2rem; 
        transition: background-color 0.3s, color 0.3s; 
        color: red; 
        background-color: red; 
    }

    .bordered-button:hover {
        background-color: red;
        color: white;
    }
    </style>
</head>
<body>
    <header>
        <h2><?php echo 'TOBAT'; ?></h2>
        <div class="bx bx-menu" id="menu-icon"></div>

        <ul class="navbar">
            <li><a href="#home">Home</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="#shop">Product</a></li>
            <li><a href="login.php" class="button bordered-button"> Login </a></li>
            <li><a href="registrasi.php" class="button bordered-button"> Registrasi </a></li>
            <li>
                <div class="bx bx-moon" id="dark-mode-toggle"></div>
            </li>
        </ul>
    </header>

    <section class="home" id="home">
        <div class="home-text">
            <span><?php echo 'Selamat Datang Di'; ?></span>
            <h1><?php echo 'TOBAT'; ?></h1>
            <h2><?php echo 'Beli obat disini langsung <br> sembuh'; ?></h2>
            <a href="pesan.php" class="btn"><?php echo 'Buy now'; ?></a>
        </div>
        <div class="home-img">
            <img src="assets/obat_baru.jpeg" alt="ini foto obat">
        </div>
    </section>

    <section class="shop" id="shop">
        <div class="heading">
            <span><?php echo 'Beli Sekarang'; ?></span>
            <h1><?php echo 'Product'; ?></h1>
        </div>
        <div class="shop-container">
            <div class="box">
                <div class="box-img">
                    <img src="assets/obat1.webp" alt="obat panadol">
                </div>
                <h2><?php echo 'Panadol'; ?></h2>
                <span><?php echo 'RP.10.000'; ?></span>
                <a href="#" class="btn"><?php echo 'Buy now'; ?></a>
            </div>

            <div class="box">
                <div class="box-img">
                    <img src="assets/obat2.webp" alt="obat polycrol">
                </div>
                <h2><?php echo 'Polycrol'; ?></h2>
                <span><?php echo 'RP.10.000'; ?></span>
                <a href="#" class="btn"><?php echo 'Buy now'; ?></a>
            </div>

            <div class="box">
                <div class="box-img">
                    <img src="assets/obat3.webp" alt="obat alpara">
                </div>
                <h2><?php echo 'Alpara'; ?></h2>
                <span><?php echo 'RP.10.000'; ?></span>
                <a href="#" class="btn"><?php echo 'Buy now'; ?></a>
            </div>
        </div>
    </section>

    <footer>
        <h2><?php echo 'Copyright © 2024 TOBAT'; ?></h2>
        <h2><?php echo 'Muhammad Rizky Haritama Putra'; ?></h2>
    </footer>
    <script src="script.js"></script>
</body>
</html>
