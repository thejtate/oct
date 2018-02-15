<?php
// $Id: node.tpl.php,v 1.4 2008/01/25 21:21:44 goba Exp $

/**
 * @file node.tpl.php
 *
 * Theme implementation to display a node.
 *
 * Available variables:
 * - $title: the (sanitized) title of the node.
 * - $content: Node body or teaser depending on $teaser flag.
 * - $picture: The authors picture of the node output from
 *   theme_user_picture().
 * - $date: Formatted creation date (use $created to reformat with
 *   format_date()).
 * - $links: Themed links like "Read more", "Add new comment", etc. output
 *   from theme_links().
 * - $name: Themed username of node author output from theme_user().
 * - $node_url: Direct url of the current node.
 * - $terms: the themed list of taxonomy term links output from theme_links().
 * - $submitted: themed submission information output from
 *   theme_node_submitted().
 *
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type, i.e. story, page, blog, etc.
 * - $comment_count: Number of comments attached to the node.
 * - $uid: User ID of the node author.
 * - $created: Time the node was published formatted in Unix timestamp.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the node. Increments each time it's output.
 *
 * Node status variables:
 * - $teaser: Flag for the teaser state.
 * - $page: Flag for the full page state.
 * - $promote: Flag for front page promotion state.
 * - $sticky: Flags for sticky post setting.
 * - $status: Flag for published status.
 * - $comment: State of comment settings for the node.
 * - $readmore: Flags true if the teaser content of the node cannot hold the
 *   main body content.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 */
?>
<h1><span><?php print t('Camps'); ?></span></h1>
<div id="content-inner">
  <div id="content-bot">
    <div id="content-area">
      <?php if(!empty($node->field_camps_page_image[0]['view'])): ?>
        <div class="camps-top-image">
          <?php print $node->field_camps_page_image[0]['view'];?>
        </div>
      <?php endif; ?>
      <h2 class="season"><span> <?php print $node->title; ?></span></h2>
      <div class="camp-decsription top-text">
      <?php print $node->content['body']['#value']; ?>
      </div> 
      <div class="clear-both dotted"></div>
        <?php print $summer_camp_list; ?>
      <div class="clear-both dotted"></div>
        <!--<h2 class="season"><span><?php //print t('Camps'); ?></span></h2>-->
        <?php //print $camp_list; ?>

      <div class="b-register-camps">
        <h2><?php print $node->field_camp_tp_title[0]['value']; ?></h2>
        <?php print $node->field_camp_tp_description[0]['value']; ?>
        <div class="b-type-register clr">
          <div class="b-col">
            <div class="b-online">
              <img src="<?php print base_path().drupal_get_path('theme','oct');?>/images/icon-register-classes.png" alt="Register Classes" align="right" />
              <b><?php print t('ONLINE');?></b> <?php print $node->field_camp_tp_online[0]['value']; ?>
            </div>
            <div class="b-phone">
              <b><?php print t('BY PHONE');?></b> <?php print $node->field_camp_tp_by_phone[0]['value']; ?>
            </div>
          </div>
          <div class="b-col">
            <div class="b-fax">
              <b><?php print t('FAX');?></b> <?php print $node->field_camp_tp_fax[0]['value']; ?>
            </div>
            <div class="b-mail">
              <b><?php print t('MAIL');?></b> <?php print $node->field_camp_tp_mail[0]['value']; ?>
            </div>
          </div>
        </div>
        <div class="b-register-links clr">
          <ul>
            <?php foreach($node->field_camp_tp_links as $item): ?>
            <li><?php print $item['view']; ?></li>
            <?php endforeach; ?>
            <?php foreach($node->field_camp_tp_pdfs as $item): ?>
            <li><?php print $item['view']; ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>

      <div class="camp-decsription">
        <?php print $node->field_camps_bottom_description[0]['view']; ?>
      </div>

    </div>
  </div>
</div>
