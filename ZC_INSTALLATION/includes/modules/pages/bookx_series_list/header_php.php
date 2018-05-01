<?php
/**
 * This file is part of the ZenCart add-on Book X which
 * introduces a new product type for books to the Zen Cart
 * shop system. Tested for compatibility on ZC v. 1.5
 *
 * For latest version and support visit:
 * https://sourceforge.net/p/zencartbookx
 *
 * @package page
 * @author  Philou
 * @copyright Copyright 2013
 * @copyright Portions Copyright 2003-2011 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.gnu.org/licenses/gpl.txt GNU General Public License V2.0
 *
 * @version BookX V 0.9.4-revision8 BETA
 * @version $Id: [ZC INSTALLATION]/includes/modules/pages/bookx_series_list/header_php.php 2016-02-02 philou $
 */

require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));

if (!defined('MAX_DISPLAY_BOOKX_SERIES_LISTING')) {
	define('MAX_DISPLAY_BOOKX_SERIES_LISTING', '20');
}

$extra_fields = '';
$extra_in_stock_join_clause = '';
$extra_having_clause = '';

$active_bx_filter_ids = bookx_get_active_filter_ids();

$extra_filter_query_parts = bookx_get_active_filter_query_parts($active_bx_filter_ids);

if (BOOKX_SERIES_LISTING_SHOW_ONLY_STOCKED && !(isset($_GET['bookx_series_list_all']) && $_GET['bookx_series_list_all'])) {
	$extra_fields = ' , MAX(p.products_quantity) AS quantity,  MAX(p.products_date_available) AS date_available, COUNT(p.products_id) AS books_in_stock';
	$extra_in_stock_join_clause = ' LEFT JOIN ' . TABLE_PRODUCT_BOOKX_EXTRA . ' be ON be.bookx_series_id = bs.bookx_series_id
									LEFT JOIN ' . TABLE_PRODUCTS . ' p ON p.products_id = be.products_id AND p.products_status > 0';
	$extra_having_clause = ' HAVING (quantity > 0 OR date_available >= "' . date('Y-m-d H:i:s', time()- (86400*60)) . '")'; // 86400 * 60 = 60 days
}

$sort_order_clause = '';
switch ((int)BOOKX_SERIES_LISTING_ORDER_BY) {
	case 1: // order by Name first
		$sort_order_clause = ' ORDER BY bsd.series_name, bs.series_sort_order';
		break;

	case 2: // order by sort order first
		$sort_order_clause = ' ORDER BY bs.series_sort_order, bsd.series_name';
		break;

}

$sql = 'SELECT bs.bookx_series_id, bsd.series_name, bsd.series_image, bsd.series_description '
			. $extra_fields
            . ' FROM ' . TABLE_PRODUCT_BOOKX_SERIES . ' bs
		        LEFT JOIN ' . TABLE_PRODUCT_BOOKX_SERIES_DESCRIPTION . ' bsd ON bsd.bookx_series_id = bs.bookx_series_id AND bsd.languages_id = "' . (int)$_SESSION['languages_id'] . '" '
		    . $extra_in_stock_join_clause
		    . (!empty($extra_filter_query_parts['join_multi_filter'])  && empty($extra_in_stock_join_clause) ? $extra_filter_query_parts['join_multi_filter'] . ' ON be.bookx_series_id = bs.bookx_series_id ' : '')
		    . bookx_assemble_filter_extra_join($extra_filter_query_parts['join'], array('series'))
		  . ' WHERE 1 ' . bookx_assemble_filter_extra_where($extra_filter_query_parts['where'], array('series'))
		  . ' GROUP BY bs.bookx_series_id '
		    . $extra_having_clause
		    . $sort_order_clause;

$bookx_series_listing_split = new splitPageResults($sql, MAX_DISPLAY_BOOKX_SERIES_LISTING, 'bs.bookx_series_id', 'page');
$bookx_series_listing = $db->Execute($bookx_series_listing_split->sql_query);

$bookx_series_listing_split_array = array();
while ( ! $bookx_series_listing->EOF ) {

	$bookx_series_listing_split_array [] = array ('bookx_series_id' => $bookx_series_listing->fields ['bookx_series_id']
												   ,'series_name' => $bookx_series_listing->fields ['series_name']
												   ,'series_image' => (!empty($bookx_series_listing->fields ['series_image']) ? DIR_WS_IMAGES . $bookx_series_listing->fields ['series_image'] : '')
												   ,'series_description' => $bookx_series_listing->fields ['series_description']
												   );

	$bookx_series_listing->MoveNext ();
}