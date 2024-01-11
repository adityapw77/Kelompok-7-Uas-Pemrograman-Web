<?php

session_start();
include 'koneksi.php';

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="style.css" />
  </head>
  <body class="body-login">
    <div class="parent-login d-flex mt-5">
      <div class="mx-auto mt-5 login shadow-lg">
        <h3 class="mt-4 text-center">Login</h3>
        <form method="POST" action="proses-login.php" class="mt-4 mx-4">
          <?php if (isset($_SESSION['error'])) : ?>
            <div class="alert alert-danger text-center" role="alert" id="errorModal">
              Username atau Password Salah
            </div>
            <?php
            unset($_SESSION['error']);
            endif; ?>
          <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">User Name</label>
            <input
              type="text"
              class="form-control"
              id="exampleInputEmail1"
              aria-describedby="emailHelp"
              name="username"
            />
          </div>
          <div class="mb-4">
            <label for="exampleInputPassword1" class="form-label"
              >Password</label
            >
            <input
              type="password"
              class="form-control"
              id="exampleInputPassword1"
              name="password"
            />
          </div>
          <div class="d-flex justify-content-center align-items-center">
            <button type="submit" class="btn btn-primary rounded-5 px-4">
              Login
            </button>
          </div>
        </form>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
