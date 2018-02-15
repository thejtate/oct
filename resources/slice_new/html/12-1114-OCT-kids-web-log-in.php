<!DOCTYPE HTML>
<html lang="en-US">
<head>
  <?php include 'src/com/meta.inc'; ?>
  <?php include 'src/com/styles.inc'; ?>
  <?php include 'src/com/scripts.inc'; ?>
</head>
<body>

<?php include 'src/com/structs/footer/footer.inc'; ?>
<div class="outer-wrapper-login">
  <div class="main">

    <div class="login-form-wrapper">
      <div class="for-wrapp">
        <form>
          <div class="title-form-login">
            <h1>Sign In</h1>
          </div>
          <div class="form-item">
            <label>User name</label>
            <input class="form-text" type="text">
          </div>
          <div class="form-item">
            <label>Password</label>
            <input class="form-text" type="password">
          </div>
          <div class="button-submit">
            <div class="form-item">
              <input class="form-submit" type="submit" value="Enter">
            </div>
          </div>
        </form>
        <div class="block-reg">
          <span class="reg-label">
            New here?
          </span>
          <span class="reg-title">
            Register
          </span>
          <a class="button-go" href="#">Go!</a>
        </div>
      </div>

    </div>
    <div class="decor-login-line">

    </div>
  </div>
</div>
</body>
</html>