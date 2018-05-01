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
 * @version $Id: [ZC INSTALLATION]/includes/templates/[CURRENT_TEMPLATE]/templates/tpl_bookx_genres_list_default.php 2016-02-02 philou $
 */

/**
 * Loaded automatically by index.php?main_page=bookx_genres_list.
 */
?>

<div id="bookxGenreListing">

<?php if ( $bookx_genres_listing_split->number_of_rows > 0 && $bookx_genres_listing_split->number_of_pages > 1 && ( (PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3') ) ) { ?>
	<div id="genresListingTopNumber" class="navSplitPagesResult back"><?php echo $bookx_genres_listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_GENRES); ?></div>
	<div id="genresListingListingTopLinks" class="navSplitPagesLinks forward"><?php echo TEXT_RESULT_PAGE . ' ' . $bookx_genres_listing_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page'))); ?></div>
	<br class="clearBoth" />
<?php }

	if (BOOKX_GENRE_LISTING_SHOW_ONLY_STOCKED) { ?>
		<script type="text/javascript">
		<!--
		function handleInStockOnlyCheckbox() {
			var n = window.location.href.indexOf('&bookx_genres_list_all=');
			var listOutOfStock = genresListOnlyStockedCheckbox.checked;
			var newGetParameter = (listOutOfStock ? '&bookx_genres_list_all=true' : '');
			if (0 > n) {
				window.location.href = window.location.href + newGetParameter;
			} else {
				window.location.href = window.location.href.replace('&bookx_genres_list_all=true', newGetParameter);
			}
		}
		-->
		</script>
		<div id="genresListOnlyStockedCheckboxContainer">
			<label><input id="genresListOnlyStockedCheckbox" type="checkbox" <?php echo ( isset($_GET['bookx_genres_list_all']) && $_GET['bookx_genres_list_all'] ? 'checked' : ''); ?> onClick="handleInStockOnlyCheckbox()" /> <?php echo TEXT_BOOKX_GENRE_LIST_STOCKCHECKBOX_LABEL; ?></label>
		</div>
<?php } ?>

<h1 id="genreListHeading"><?php echo TEXT_BOOKX_GENRE_LIST_TITLE; ?></h1>
<table id="bookxGenreListingTable">

<?php
	foreach ($bookx_genres_listing_split_array as $genre) {
		echo '<tr>';
		echo '<td class="bookxGenreListingImageCell">' . zen_image($genre['genre_image'], '', BOOKX_GENRE_LISTING_IMAGE_MAX_WIDTH, BOOKX_GENRE_LISTING_IMAGE_MAX_HEIGHT) . '</td>';
		echo '<td class="bookxGenreListingInfoCell"><span class="bookxGenreDescription">' . $genre['genre_description'] . '</span>' 
		     . ' <a href="' .  zen_href_link(FILENAME_DEFAULT, '&typefilter=bookx&bookx_genre_id=' . $genre['bookx_genre_id']) . '" class="bookx_searchlink">' . sprintf(TEXT_BOOKX_LIST_PRODUCTS_BY_GENRE, $genre['genre_description']) . '</a>';
		echo '</td></tr>';

	}
?>

</table>

<?php if ( ($bookx_genres_listing_split->number_of_rows > 0) && $bookx_genres_listing_split->number_of_pages > 1 && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3')) ) {
?>
<div id="genresListingBottomNumber" class="navSplitPagesResult back"><?php echo $bookx_genres_listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_GENRES); ?></div>
<div  id="genresListingListingBottomLinks" class="navSplitPagesLinks forward"><?php echo TEXT_RESULT_PAGE . ' ' . $bookx_genres_listing_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></div>
<br class="clearBoth" />
<?php
  }
?>
</div>