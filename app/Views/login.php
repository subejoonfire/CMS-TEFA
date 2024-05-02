<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <link rel="stylesheet" href="<?= base_url('/css/login.css') ?>" />
</head>

<body>
  <div class="container">
    <div class="banner-container">
      <div class="upbanner-container">
        <div class="header-container">
          <img src="<?= base_url('img/LogoTEFA.png') ?>" width="150" alt="" srcset="">
        </div>
        <div class="body-container">
          <h1>Welcome to Course Management System (CMS)</h1>
        </div>
        <div class="footer-container">
          <span>Politeknik Negeri Tanah Laut</span>
        </div>
      </div>
      <div class="downbanner-container">
        <img src="<?= base_url('img/footerBanner.png') ?>" width="400" alt="">
      </div>
    </div>
    <div class="login-container">
      <div class="login-forms-container">
        <div class="login-head-container">
          <h1>Sign In Course Management System (CMS) TEFA</h1>
        </div>
        <div class="login-body-container">
          <form action="<?= base_url('/loginAction') ?>" method="post">
            <div class="username-container">
              <span>Username</span>
              <input type="text" name="username" />
            </div>
            <div class="password-container">
              <span>Password</span>
              <input type="password" name="password" />
            </div>
            <div class="checkbox-container">
              <input type="checkbox" name="remember" value="yes">
              <span>Ingat saya</span>
            </div>
            <button>Login</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>

</html>