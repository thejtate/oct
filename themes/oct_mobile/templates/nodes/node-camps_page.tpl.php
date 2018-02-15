<?php
// $Id: node.tpl.php,v 1.4 2008/01/25 21:21:44 goba Exp $

/**
 * @file node-camps_page.tpl.php
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
<div id="node-<?php print $node->nid; ?>" class="node<?php if ($sticky) { print ' sticky'; } ?><?php if (!$status) { print ' node-unpublished'; } ?>">
  <?php if(!empty($mobile_summer_camps_menu)): ?>
    <?php print $mobile_summer_camps_menu; ?>
  <?php endif; ?>
  <div class="middle-title">
    <div class="first"></div>
    <div class="middle"></div>
    <div class="last"></div>
    <h1><?php print $title; ?></h1>
  </div>
  <div class="middle-content">
    <div class="middle-item">
      <?php print $node->content['body']['#value']; ?>
    </div>
    <div class="middle-item last">
      <?php print $camp_list; ?>
  <!--    <h2>Young Company</h2>
      <p><strong>Saturdays</strong></p>
      <p><strong>01/28/2012 - 04/28/2012</strong>
        <br />
        <strong> 10:00 am - 12:00 pm </strong></p>
      <p><strong>from 8 years old to 14 • $350</strong></p>

      <p>Designed for children 8 and above, this program focuses on broadening our student’s understanding of theatre arts through educative, hands-on participation in the production process. Through a variety of intensive workshops, activities, and lessons we concentrate not only on advancing general acting skills, but introducing our students to the varied aspects within the theatre, both on and off stage.  Young Company members will perform “ Peter and The Wolf “ with the Oklahoma City Philharmonic on March 04th at the Civic Center Music Hall and then  “Cinderella Outgrows the Glass Slipper” at OCT’s annual fundraising event , Fairy tale Ball, April 14th.</p>-->
    </div>
  </div>
</div>