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
<?php if ($node->view->name == 'classes'): ?>
    <div class="b-article clr">
        <?php if (user_access('manager access')): ?>
            <?php print theme('manager_links', $node->nid, 'edit-products'); ?>
        <?php endif; ?>

        <div class="b-info">
            <div class="b-buts-panel"><?php print l('', 'enrollment/' . $node->nid, array('attributes' => array('class' => 'enroll'))); ?></div>
            <h2><?php print l($node->title, 'enrollment/' . $node->nid, array('attributes' => array('name' => 'class-'.$node->nid))); ?></h2>
            <p><b>
            <?php foreach ($node->field_class_date_from as $k => $dateFrom): ?>  
                <?php if (!empty($dateFrom['view'])): ?>
                    <?php
                    $weekdays = array();
                    if ($node->field_product_wd_sunday[$k]['value']) {
                        $weekdays[] = 'Sunday';
                    }
                    if ($node->field_product_wd_monday[$k]['value']) {
                        $weekdays[] = 'Monday';
                    }
                    if ($node->field_product_wd_tuesday[$k]['value']) {
                        $weekdays[] = 'Tuesday';
                    }
                    if ($node->field_product_wd_wednesday[$k]['value']) {
                        $weekdays[] = 'Wednesday';
                    }
                    if ($node->field_product_wd_thursday[$k]['value']) {
                        $weekdays[] = 'Thursday';
                    }
                    if ($node->field_product_wd_friday[$k]['value']) {
                        $weekdays[] = 'Friday';
                    }
                    if ($node->field_product_wd_saturday[$k]['value']) {
                        $weekdays[] = 'Saturday';
                    }

                    $weekdays = implode(', ', $weekdays);
                    ?>
                    
                        <?php print $weekdays; ?><br>
                            <?php print $dateFrom['view']; ?> - <?php print $node->field_class_date_to[$k]['view']; ?> &bull;
                             <?php print $node->field_class_time_from[$k]['view']; ?> - <?php print $node->field_class_time_to[$k]['view']; ?>  <br>
                        <?php endif; ?>      
                    <?php endforeach; ?>
                            </b></p>        
                    <p><b>
                    <?php print t('from '); ?>
                    <?php print $node->field_min_class_age[0]['value']; ?>
                    <?php print t('years old '); ?>
                    <?php if ($node->field_max_class_age[0]['value'] != 40):?>
                        <?php print t('to ') . $node->field_max_class_age[0]['value']; ?>
                    <?php else: ?>
                        <?php print t('and up'); ?>
                    <?php endif; ?>
                    &bull; $<?php print $node->field_class_price[0]['value']; ?></b></p>
                  <?php print $node->content['body']['#value']?>
        </div>
    </div>

<?php else: ?>

    <div id="content-inner">
        <div id="content-bot">
            <div id="content-area">
                <div id="node-<?php print $node->nid; ?>" class="node
                <?php if ($sticky) { print ' sticky'; }?>
                <?php if (!$status){ print ' node-unpublished'; }?>
                 node-<?php print $node->type; ?>
                 clear-block">
                    <?php print $node->title; ?>
                    <?php //kpr($node);  ?>
                    <?php t('Description:'); ?>
                    <?php print $node->content['body']['#value']; ?>
                    <?php print $node->content['add_to_cart']['#value']; ?>
                </div>
            </div>
        </div>
    </div>

<?php endif; ?>