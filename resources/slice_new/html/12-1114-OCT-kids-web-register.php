<!DOCTYPE HTML>
<html lang="en-US">
<head>
  <?php include 'src/com/meta.inc'; ?>
  <?php include 'src/com/styles.inc'; ?>
  <?php include 'src/com/scripts.inc'; ?>
</head>
<body>
<div class="outer-wrapper">
  <div class="main form-register-outer">
    <div class="form-register-wrapper">
      <div class="title-form">
        Oklahoma Children’s Theatre
      </div>
      <div class="register-wrapper">
        <div class="messages error">
          <ul>
            <li>Pick a Username field is required.</li>
            <li>Email field is required.</li>
            <li>Password field is required.</li>
          </ul>
        </div>
        <form action="">
          <div class="parrent-wrapp">
            <div class="form-item">
              <label>Parent or Guardian’s Name: </label>
              <input class="form-text" type="text" value=""></div>
            <div class="form-item">
              <label>Child’s Name:</label>
              <input class="form-text" type="text" value=""></div>
          </div>
          <div class="email-wrapp">
            <div class="form-item">
              <label>Email:</label>
              <input class="form-text" type="text">
            </div>
            <div class="form-item">
              <label>Confirm Email:</label>
              <input class="form-text" type="text">
            </div>
          </div>
          <div class="form-item">
            <label>Pick a Username:</label>
            <input class="form-text" type="text">

            <div class="description">
              <span>Letters and numbers only No spaces or special characters</span>
            </div>
          </div>
          <div class="form-item">
            <label>Create a Password:</label>
            <input class="form-text" type="password">

            <div class="description">
              <span>Must be at least 8 characters</span>
            </div>
          </div>
          <div class="form-item">
            <label>Confirm Password:</label>
            <input class="form-text" type="password">

            <div class="description">
              <span>Passwords match</span>
            </div>
          </div>
          <div class="password-description error" style="display: block;">It is recommended to choose a password that contains at least six characters. It should include numbers, punctuation, and both upper and lowercase letters.</div>
          <div class="form-textarea-wrapp">
            <div class="form-item">
              <label>User Agreement</label>
              <textarea class="form-textarea" cols="30" rows="10"></textarea>
            </div>
            <div class="description">
              By clicking “submit” you agree to the terms and conditions of this website.
            </div>
          </div>
          <div class="button-submit">
            <div class="form-item">
              <input class="form-submit" type="submit" value="Submit">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</body>
</html>