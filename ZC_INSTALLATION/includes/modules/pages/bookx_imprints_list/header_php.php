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
 * @version $Id: [ZC INSTALLATION]/includes/modules/pages/bookx_imprints_list/header_php.php 2016-02-02 philou $
 */

require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));

if (!defined('MAX_DISPLAY_BOOKX_IMPRINT_LISTING')) {
	define('MAX_DISPLAY_BOOKX_IMPRINT_LISTING', '20');
}

$extra_fields = '';
$extra_in_stock_join_clause = '';
$extra_having_clause = '';

$active_bx_filter_ids = bookx_get_active_filter_ids();

$extra_filter_query_parts = bookx_get_active_filter_query_parts($active_bx_filter_ids);

if (BOOKX_IMPRINT_LISTING_SHOW_ONLY_STOCKED && !(isset($_GET['bookx_imprints_list_all']) && $_GET['bookx_imprints_list_all'])) {
	$extra_fields = ' , MAX(p.products_quantity) AS quantity,  MAX(p.products_date_available) AS date_available, COUNT(p.products_id) AS books_in_stock';
	$extra_in_stock_join_clause = ' LEFT JOIN ' . TABLE_PRODUCT_BOOKX_EXTRA . ' be ON be.bookx_imprint_id = bi.bookx_imprint_id
	                                LEFT JOIN ' . TABLE_PRODUCTS . ' p ON p.products_id = be.products_id AND p.products_status > 0';
	$extra_having_clause = ' HAVING (quantity > 0 OR date_available >= "' . date('Y-m-d H:i:s', time()- (86400*60)) . '")'; // 86400 * 60 = 60 days
}

$sort_order_clause = '';
switch ((int)BOOKX_IMPRINT_LISTING_ORDER_BY) {
	case 1: // order by Name first
		$sort_order_clause = ' ORDER BY bi.imprint_name, bi.imprint_sort_order';
		break;

	case 2: // order by sort order first
		$sort_order_clause = ' ORDER BY bi.imprint_sort_order, bi.imprint_name';
		break;

}

$sql = 'SELECT bi.bookx_imprint_id, bi.imprint_name, bi.imprint_image, bid.imprint_description '
		  . $extra_fields
		  . ' FROM ' . TABLE_PRODUCT_BOOKX_IMPRINTS . ' bi
		    LEFT JOIN ' . TABLE_PRODUCT_BOOKX_IMPRINTS_DESCRIPTION . ' bid ON bid.bookx_imprint_id = bi.bookx_imprint_id AND bid.languages_id = "' . (int)$_SESSION['languages_id'] . '" '
		  . $extra_in_stock_join_clause
		  . (!empty($extra_filter_query_parts['join_multi_filter']) && empty($extra_in_stock_join_clause) ? $extra_filter_query_parts['join_multi_filter'] . ' ON be.bookx_imprint_id = bi.bookx_imprint_id ' : '')
		  . bookx_assemble_filter_extra_join($extra_filter_query_parts['join'], array('imprint'))
		  . ' WHERE 1 ' . bookx_assemble_filter_extra_where($extra_filter_query_parts['where'], array('imprint'))
		  . ' GROUP BY bi.bookx_imprint_id '
		  . $extra_having_clause
		  . $sort_order_clause;

$bookx_imprints_listing_split = new splitPageResults($sql, MAX_DISPLAY_BOOKX_IMPRINT_LISTING, 'bi.bookx_imprint_id', 'page');
$bookx_imprints_listing = $db->Execute($bookx_imprints_listing_split->sql_query);

$bookx_imprints_listing_split_array = array();
while ( ! $bookx_imprints_listing->EOF ) {

	$bookx_imprints_listing_split_array [] = array ('bookx_imprint_id' => $bookx_imprints_listing->fields ['bookx_imprint_id']
												   ,'imprint_name' => $bookx_imprints_listing->fields ['imprint_name']
												   ,'imprint_image' => (!empty($bookx_imprints_listing->fields ['imprint_image']) ? DIR_WS_IMAGES . $bookx_imprints_listing->fields ['imprint_image'] : '')
												   ,'imprint_description' => $bookx_imprints_listing->fields ['imprint_description']
												   );

	$bookx_imprints_listing->MoveNext ();
}