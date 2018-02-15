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
<div class="outer-wrapper">
  <div class="main">
    <div class="main-content">
      <?php include 'src/com/blocks/logout/logout.inc'; ?>
      <div class="item-messages-wrapp">
        <div class="title-images-wrapp">
          <span class="title-images">
            <img src="images/img/title-messeges.png" alt="img" />
          </span>
        </div>
        <div class="messages-new-wrapp">
          <form action="/message-board/" accept-charset="UTF-8" method="post" id="node-form" enctype="multipart/form-data" class="wysiwygcck-processed">
            <div>
              <div class="node-form">
                <div class="standard">
                  <div class="body-field-wrapper"><div class="teaser-checkbox"><div class="form-item" id="edit-teaser-include-wrapper">
                    <label class="option" for="edit-teaser-include"><input type="checkbox" name="teaser_include" id="edit-teaser-include" value="1" checked="checked" class="form-checkbox"> Show summary in full view</label>
                  </div>
                  </div><div class="form-item" id="edit-body-wrapper">
                    <label for="edit-body">Share something: </label>
                    <textarea cols="60" rows="3" name="body" id="edit-body" class="form-textarea"></textarea>
                  </div>
                  </div><input type="hidden" name="changed" id="edit-changed" value="">
                  <input type="hidden" name="form_build_id" id="form-612abb1c64c27e4dc8eb028f1a87c6c5" value="form-612abb1c64c27e4dc8eb028f1a87c6c5">
                  <input type="hidden" name="form_token" id="edit-message-node-form-form-token" value="3a45e8e9ec58759b37f033c52037f913">
                  <input type="hidden" name="form_id" id="edit-message-node-form" value="message_node_form">
                </div>
                <div class="admin">
                  <div class="authored">
                  </div>
                  <div class="options">
                  </div>
                </div>
                <div class="button-submit">
                  <div class="form-item">
                    <input type="submit" name="op" id="edit-submit-1" value="Post it" class="form-submit">
                  </div>
                </div>

              </div>

            </div></form>
        </div>
        <ul>
          <li class="item-messages">
            <ul class="primary manager-links edit-person-tab">
              <li class="ml_edit"><a href="/node/391/edit?destination=message-board%2Fusers%3Fpage%3D1">Edit</a></li>
              <li class="ml_delete"><a href="/node/391/delete?destination=message-board%2Fusers%3Fpage%3D1">Delete</a></li>
            </ul>
            <div class="content-item-messeges">
              <div class="title-item-messeges">
                <div class="user-name"><a href="#">Jenny391</a><span>said</span></div>
                <span class="date">AUG 13, 2012</span>
              </div>
              <div class="content-text">
                <p>OMG i had such an awesome time at SUMMER CAMP !!! i loved my teacher. Dave is sooooooo cool LOL
                  =^-^=</p>
              </div>
              <div class="rating-messages"><div class="vud-widget vud-widget-star" id="widget-node-391">
                <span class="vote-current-title">Bravo</span>

                <div class="up-score">
                  <a href="/vote/node/391/1/vote/star/3b31f16419a4808f79fc662e7deb9e3b" rel="nofollow" class="vud-link-up ctools-use-ajax ctools-use-ajax-processed" title="Vote up!">
                    <div class="vote-star up-inactive" title="Vote up!"></div>
                    <div class="element-invisible">Vote up!</div>
                  </a>
                </div>


                <span class="vote-current-score">0</span>
              </div>
              </div>
            </div>
          </li>
          <li class="item-messages">
            <div class="content-item-messeges">
              <div class="title-item-messeges">
                <div class="user-name"><a href="#">ryan_h</a><span>said</span></div>
                <span class="date">AUG 7, 2012</span>
              </div>

              <div class="content-text">
                <p>OMG i had such an awesome time at SUMMER CAMP !!! i loved my teacher. Dave is sooooooo cool LOL
                  =^-^=</p>
              </div>
              <div class="rating-messages"></div>
            </div>
          </li>
          <li class="item-messages">
            <div class="content-item-messeges">
              <div class="title-item-messeges">
                <div class="user-name"><a href="#">SweetThang</a><span>said</span></div>
                <span class="date">JUL 30, 2012</span>
              </div>

              <div class="content-text">
                <p>Can’t believe this is my LAST SEASON in young company! where did the time go ???? Angie, Dennis,
                  Greg--you had all better BEHAVE! lol ♥♥♥</p>
              </div>
              <div class="rating-messages"></div>
            </div>
          </li>
          <li class="item-messages">
            <div class="content-item-messeges">
              <div class="title-item-messeges">
                <div class="user-name"><a href="#">Jenny391</a><span>said</span></div>
                <span class="date">AUG 13, 2012</span>
              </div>

              <div class="content-text">
                <p>the video design class was the BEST!!! </p>
              </div>
              <div class="rating-messages"></div>
            </div>
          </li>
          <li class="item-messages">
            <div class="content-item-messeges">
              <div class="title-item-messeges">
                <div class="user-name"><a href="#">Jenny391</a><span>said</span></div>
                <span class="date">AUG 13, 2012</span>
              </div>

              <div class="content-text">
                <p>Can’t believe this is my LAST SEASON in young company! where did the time go ???? Angie, Dennis,
                  Greg--you had all better BEHAVE! lol ♥♥♥</p>
              </div>
              <div class="rating-messages"></div>
            </div>
          </li>
        </ul>
        <div class="item-list"><ul class="pager"><li class="pager-previous first"><a href="/message-board/users" class="active">‹‹</a></li>
          <li class="pager-current">2 of 10</li>
          <li class="pager-next last"><a href="/message-board/users?page=2" class="active">››</a></li>
        </ul></div>
      </div>

    </div>
    <div class="sidebar">
      <?php include 'src/com/blocks/sidebars/sidebar-prop.inc'; ?>
      <?php include 'src/com/blocks/sidebars/sidebar-calendar.inc'; ?>
      <?php include 'src/com/blocks/sidebars/sidebar-suggestion.inc'; ?>
    </div>
  </div>
</div>
</body>
</html>