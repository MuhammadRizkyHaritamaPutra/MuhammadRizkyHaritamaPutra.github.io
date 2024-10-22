
<?php
require "koneksi.php";


if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); 
    $role = $_POST["role"];

    
    $checkQuery = "SELECT * FROM users WHERE username = '$username'";
    $checkResult = mysqli_query($koneksi, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
       
        echo "
        <script>
            alert('Username sudah digunakan! Silakan gunakan username lain.');
            document.location.href = 'registrasi.php';
        </script>
        ";
    } else {
        
        $query = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";

        if (mysqli_query($koneksi, $query)) {
            echo "
            <script>
                alert('Registrasi berhasil!');
                document.location.href = 'login.php';
            </script>
            ";
        } else {
            echo "
            <script>
                alert('Registrasi gagal!');
                document.location.href = 'index.php';
            </script>
            ";
        }
    }
  }
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login | Pendataan Mahasiswa Universitas Mulawarman</title>

  <style>
    body {
  font-family: 'Lato', sans-serif;
  margin: 0;
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  position: relative;
}

.bg-image {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  z-index: -1; 
}

.login-title {
  font-size: 32px;
  font-weight: 800;
  margin: 0;
  text-align: center;
  margin-bottom: 5px;
}

.login-description {
  font-size: 20px;
  text-align: center;
  margin: 0;
  margin-bottom: 25px;
}

.login-card {
  position: relative; 
  z-index: 1; 
  background-color: white;
  border: 1px solid rgb(220, 220, 220);
  padding: 40px 50px;
  border-radius: 20px;
  box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
}


.login-form-container {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.login-form-title {
  font-size: 20px;
  font-weight: 700;
}

.login-form-group {
  display: flex;
  flex-direction: column;
  gap: 5.5px;
}

.login-form-input {
  border: 1px solid grey;
  height: 35px;
  padding-left: 20px;
  padding-right: 20px;
  font-size: 18px;
  outline: none;
  border-radius: 20px;
}

.login-button {
  border: 0;
  font-size: 18px;
  font-weight: 700;
  padding-top: 8px;
  padding-bottom: 8px;
  border-radius: 25px;
  background-color: var(--hijau);
  color: white;
}


@import url("https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap");

:root {
  --kuning: #ffd53a;
  --hijau: #009b4c;
}

body {
  font-family: 'Lato', sans-serif;
  margin: 0;
}

a,
.button .navbar-item {
  text-decoration: none;
  color: unset;
}

  </style>

  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer" />
</head>

<body>
  <img src="assets/obat4.jpg" alt="background" class="bg-image">
  <section class="login-card">
    <hgroup>
      <h1 class="login-title">Form Registrasi</h1>
      <p class="login-description">Silakan masukkan data</p>
    </hgroup>

    <form action="" method="post" class="login-form-container">
      <div class="login-form-group">
        <label for="username" class="login-form-title">Username</label>
        <input
          type="text"
          placeholder="Username"
          name="username"
          id="username"
          class="login-form-input" />
      </div>

      <div class="login-form-group">
        <label for="password" class="login-form-title">Password</label>
        <input
          type="password"
          placeholder="Password"
          name="password"
          id="password"
          class="login-form-input" />
      </div>

      <div class="login-form-group">
        <label for="role" class="login-form-title">Role</label>
        <select name="role" id="prodi" class="login-form-input" required>
            <option name="role" value="Admin">Admin</option>
            <option name="role" value="User">User</option>
          </select>
      </div>

      <button type="submit" name="submit" class="login-button">LOGIN</button>
    </form>
  </section>

  <script src="/scripts/script.js"></script>
</body>

</html>