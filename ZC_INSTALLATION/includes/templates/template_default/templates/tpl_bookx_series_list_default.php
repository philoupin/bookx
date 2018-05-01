<?php
/**
 * This file is part of the ZenCart add-on Book X which
 * introduces a new product type for books to the Zen Cart
 * shop system. Tested for compatibility on ZC v. 1.5
 *
 * For latest version and support visit:
 * https://sourceforge.net/p/zencartbookx
 *
 * @package templateSystem
 * @author  Philou
 * @copyright Copyright 2013
 * @copyright Portions Copyright 2003-2011 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.gnu.org/licenses/gpl.txt GNU General Public License V2.0
 *
 * @version BookX V 0.9.4-revision8 BETA
 * @version $Id: [ZC INSTALLATION]/includes/templates/[CURRENT_TEMPLATE]/templates/tpl_bookx_series_list_default.php 2016-02-02 philou $
 */

/**
 * Loaded automatically by index.php?main_page=bookx_series_list
 */
?>

<div id="bookxSeriesListing">

<?php if ( $bookx_series_listing_split->number_of_rows > 0 && ( (PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3') ) ) { ?>
	<div id="seriesListingTopNumber" class="navSplitPagesResult back"><?php echo $bookx_series_listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_SERIES); ?></div>
	<div id="seriesListingListingTopLinks" class="navSplitPagesLinks forward"><?php echo TEXT_RESULT_PAGE . ' ' . $bookx_series_listing_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page'))); ?></div>
	<br class="clearBoth" />
<?php }

	if (BOOKX_SERIES_LISTING_SHOW_ONLY_STOCKED) { ?>
		<script type="text/javascript">
		<!--
		function handleStockOnlyCheckbox() {
			var n = window.location.href.indexOf('&bookx_series_list_all=');
			var listOutOfStock = seriesListOnlyStockedCheckbox.checked;
			var newGetParameter = (listOutOfStock ? '&bookx_series_list_all=true' : '');
			if (0 > n) {
				window.location.href = window.location.href + newGetParameter;
			} else {
				window.location.href = window.location.href.replace('&bookx_series_list_all=true', newGetParameter);
			}
		}
		-->
		</script>
		<div id="seriesListOnlyStockedCheckboxContainer">
			<label><input id="seriesListOnlyStockedCheckbox" type="checkbox" <?php echo ( isset($_GET['bookx_series_list_all']) && $_GET['bookx_series_list_all'] ? 'checked' : ''); ?> onClick="handleStockOnlyCheckbox()" /> <?php echo TEXT_BOOKX_SERIES_LIST_STOCKCHECKBOX_LABEL; ?></label>
		</div>
<?php } ?>

<h1 id="authorListHeading"><?php echo TEXT_BOOKX_SERIES_LIST_TITLE; ?></h1>
<table id="bookxSeriesListingTable">

<?php
	foreach ($bookx_series_listing_split_array as $series) {
		echo '<tr>';
		echo '<td class="bookxSeriesListingImageCell">' . zen_image($series['series_image'], '', BOOKX_SERIES_LISTING_IMAGE_MAX_WIDTH, BOOKX_SERIES_LISTING_IMAGE_MAX_HEIGHT) . '</td>';
		echo '<td class="bookxSeriesListingInfoCell"><span class="bookxSeriesName">' . $series['series_name'] . '</span>'
		     . (!empty($series['series_description']) ? '<div class="bookxSeriesDescription">' . $series['series_description'] . '</div>' : '')
		     . '<a href="' .  zen_href_link(FILENAME_DEFAULT, '&typefilter=bookx&bookx_series_id=' . $series['bookx_series_id']) . '" class="bookx_searchlink">' . sprintf(TEXT_BOOKX_LIST_PRODUCTS_OF_SERIES, $series['series_name']) . '</a>';
		echo '</td></tr>';

	}
?>

</table>

<?php if ( ($bookx_series_listing_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3')) ) {
?>
<div id="seriesListingBottomNumber" class="navSplitPagesResult back"><?php echo $bookx_series_listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_SERIES); ?></div>
<div  id="seriesListingListingBottomLinks" class="navSplitPagesLinks forward"><?php echo TEXT_RESULT_PAGE . ' ' . $bookx_series_listing_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></div>
<br class="clearBoth" />
<?php
  }
?>
</div>