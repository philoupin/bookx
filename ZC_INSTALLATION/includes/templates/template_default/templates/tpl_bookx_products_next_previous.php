<?php
/**
 * Page Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2016 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart-pro.at/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_products_next_previous.php 2 2016-04-06 11:33:58Z webchills $
 * @author Linda McGrath osCommerce@WebMakers.com
 * @author Thanks to Nirvana, Yoja and Joachim de Boer
 */
?>
<div class="navNextPrevWrapperRenamed centeredContent">
	<?php
	// only display when more than 1
	if ($products_found_count > 1) { ?>

        <p class="navNextPrevCounter"><?php
            switch (true) {
                case $filtered_for_upcoming:
                    echo PREV_NEXT_UPCOMING_PRODUCT;
                break;
                case $filtered_for_new:
                   echo PREV_NEXT_NEW_PRODUCT;
                   break;
                default:
                    echo PREV_NEXT_PRODUCT;
                break;
            }
            ?><?php echo ($position+1 . "/" . $counter); ?></p>
        <div class="navNextPrevList">
            <a href="<?php echo zen_href_link(zen_get_info_page($previous), $active_boox_get_filters . "&products_id=$previous"); ?>">
                <?php if ( $detect->isMobile() && !$detect->isTablet() || $_SESSION['layoutType'] == 'mobile' or  $detect->isTablet() || $_SESSION['layoutType'] == 'tablet' )
                        {
                            echo '<i class="fa fa-chevron-circle-left" title="' . BUTTON_PREVIOUS_ALT . '"></i>';
                        } else {
                             echo $previous_image . $previous_button;
                        } ?>
            </a>
        </div>

        <div class="navNextPrevList">
            <a href="<?php echo zen_href_link(FILENAME_DEFAULT, $active_boox_get_filters); ?>">
                <?php if ( $detect->isMobile() && !$detect->isTablet() || $_SESSION['layoutType'] == 'mobile' or  $detect->isTablet() || $_SESSION['layoutType'] == 'tablet' )
                        {
                            echo '<i class="fa fa-list" title="' . BUTTON_VIEW_ALL_ALT . '"></i>';
                        } else {
                            echo zen_image_button(BUTTON_IMAGE_RETURN_TO_PROD_LIST, BUTTON_RETURN_TO_PROD_LIST_ALT);
                        } ?>
            </a>
        </div>

        <div class="navNextPrevList">
            <a href="<?php echo zen_href_link(zen_get_info_page($next_item), $active_boox_get_filters . "&products_id=$next_item"); ?>">
                <?php if ( $detect->isMobile() && !$detect->isTablet() || $_SESSION['layoutType'] == 'mobile' or  $detect->isTablet() || $_SESSION['layoutType'] == 'tablet' )
                        {
                            echo '<i class="fa fa-chevron-circle-right" title="' . BUTTON_NEXT_ALT . '"></i>';
                        } else {
                            echo  $next_item_button . $next_item_image;
                        } ?>
            </a>
        </div>

        <?php } ?>
</div>
<div style="clear: both"></div>