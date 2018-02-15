<!DOCTYPE HTML>
<html lang="en-US">
<head>
  <?php include 'src/com/meta.inc'; ?>
  <?php include 'src/com/styles.inc'; ?>
  <?php include 'src/com/scripts.inc'; ?>
</head>
<body>
<?php include 'src/com/structs/header/header.inc'; ?>
<?php include 'src/com/structs/footer/footer.inc'; ?>
<div class="button-go-page">
  <a href="#">Psst! Sneak &amp; check out our KIDS ONLY
    page!</a>
</div>
<div class="outer-wrapper">
  <div class="main">
    <div class="main-content">
      <?php include 'src/com/blocks/logout/logout.inc'; ?>
      <div class="item-name-wrapp">
        <div class="title-images-wrapp">
          <span class="title-images">
            <img src="images/img/title-p.png" alt="img">
          </span>
        </div>
        <ul>
          <li class="item-name">
            <div class="item-name-content">
              <div class="images"><img src="images/tmp/item-1.jpg" alt="img"></div>
              <div class="content-item">
                <h3>Project Name</h3>

                <p>A brief description of the project or link will go here. A brief description of the project or link
                  will go here.</p>
                <a class="button button-download" href=""><span>Download</span></a>
              </div>
            </div>
          </li>
          <li class="item-name">
            <div class="item-name-content">
              <div class="images"><img src="images/tmp/item-2.jpg" alt="img"></div>
              <div class="content-item">
                <h3>Link Name</h3>

                <p>A brief description of the project or link will go here. A brief description of the project or link
                  will go here.</p>
                <a class="button button-visit" href=""><span>Visit</span></a>
              </div>
            </div>
          </li>
          <li class="item-name">
            <div class="item-name-content">
              <div class="images"><img src="images/tmp/item-3.jpg" alt="img"></div>
              <div class="content-item">
                <h3>Project Name</h3>

                <p>A brief description of the project or link will go here. A brief description of the project or link
                  will go here.</p>
                <a class="button button-download" href=""><span>Download</span></a>
              </div>
            </div>
          </li>
          <li class="item-name last-item">
            <div class="item-name-content">
              <div class="images"><img src="images/tmp/item-1.jpg" alt="img"></div>
              <div class="content-item">
                <h3>Link Name</h3>

                <p>A brief description of the project or link will go here. A brief description of the project or link
                  will go here.</p>
                <a class="button button-visit" href=""><span>Visit</span></a>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
    <div class="sidebar">
      <?php include 'src/com/blocks/sidebars/sidebar-message.inc'; ?>
      <?php include 'src/com/blocks/sidebars/sidebar-calendar.inc'; ?>
      <?php include 'src/com/blocks/sidebars/sidebar-suggestion.inc'; ?>
    </div>
  </div>
</div>
</body>
</html>