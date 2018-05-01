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
 * @version $Id: [ZC INSTALLATION]/includes/modules/pages/bookx_authors_list/header_php.php 2016-02-02 philou $
 */

require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));

if (!defined('MAX_DISPLAY_BOOKX_AUTHOR_LISTING')) {
	define('MAX_DISPLAY_BOOKX_AUTHOR_LISTING', '20');
}

$extra_fields = '';
$extra_in_stock_join_clause = '';
$extra_having_clause = '';

$active_bx_filter_ids = bookx_get_active_filter_ids();

$extra_filter_query_parts = bookx_get_active_filter_query_parts($active_bx_filter_ids);

if (BOOKX_AUTHOR_LISTING_SHOW_ONLY_STOCKED && !(isset($_GET['bookx_authors_list_all']) && $_GET['bookx_authors_list_all'])) {
	$extra_fields = ' , MAX(p.products_quantity) AS quantity,  MAX(p.products_date_available) AS date_available, COUNT(p.products_id) AS books_in_stock';
	$extra_in_stock_join_clause = ' LEFT JOIN ' . TABLE_PRODUCTS . ' p ON p.products_id = batp.products_id AND p.products_status > 0';
	$extra_having_clause = ' HAVING (quantity > 0 OR date_available >= "' . date('Y-m-d H:i:s', time()- (86400*60)) . '")'; // 86400 * 60 = 60 days
}

$sort_order_clause = '';
switch ((int)BOOKX_AUTHOR_LISTING_ORDER_BY) {
	case 1: // order by Name first
		$sort_order_clause = ' ORDER BY ba.author_name, ba.author_sort_order';
		break;

	case 2: // order by sort order first
		$sort_order_clause = ' ORDER BY ba.author_sort_order, ba.author_name';
		break;

}

if($active_bx_filter_ids['author_type_id']) {
    $author_type_filter_extra_where = ' AND batp.bookx_author_type_id ="' . $active_bx_filter_ids['author_type_id'] . '" ';
}

$sql = 'SELECT ba.bookx_author_id, ba.author_name, ba.author_image, ba.author_url, bad.author_description,
			GROUP_CONCAT(DISTINCT batd.type_description ORDER BY batd.type_description ASC SEPARATOR ", ") AS author_types '
		  . $extra_fields
		  . ' FROM ' . TABLE_PRODUCT_BOOKX_AUTHORS . ' ba
		    LEFT JOIN ' . TABLE_PRODUCT_BOOKX_AUTHORS_DESCRIPTION . ' bad ON bad.bookx_author_id = ba.bookx_author_id AND bad.languages_id = "' . (int)$_SESSION['languages_id'] . '"
		    LEFT JOIN ' . TABLE_PRODUCT_BOOKX_AUTHORS_TO_PRODUCTS . ' batp ON batp.bookx_author_id = ba.bookx_author_id
		    LEFT JOIN ' . TABLE_PRODUCT_BOOKX_AUTHOR_TYPES_DESCRIPTION . ' batd ON batd.bookx_author_type_id = batp.bookx_author_type_id AND batd.languages_id = "' . (int)$_SESSION['languages_id'] . '" '
		  . (!empty($extra_filter_query_parts['join_multi_filter']) ? $extra_filter_query_parts['join_multi_filter'] . ' ON be.products_id = batp.products_id ' : '')
		  . $extra_in_stock_join_clause
		  . bookx_assemble_filter_extra_join($extra_filter_query_parts['join'], array('author', 'author_type'))
		  . ' WHERE 1 ' . $author_type_filter_extra_where .  bookx_assemble_filter_extra_where($extra_filter_query_parts['where'], array('author', 'author_type'))
		  . ' GROUP BY ba.bookx_author_id '
		  . $extra_having_clause
		  . $sort_order_clause;

$bookx_authors_listing_split = new splitPageResults($sql, MAX_DISPLAY_BOOKX_AUTHOR_LISTING, 'ba.bookx_author_id', 'page');
$bookx_authors_listing = $db->Execute($bookx_authors_listing_split->sql_query);

$bookx_authors_listing_split_array = array();
while ( ! $bookx_authors_listing->EOF ) {
	//$temp_author_types_array = explode('#§#', $bookx_authors_listing_split->fields['author_types']);

	$bookx_authors_listing_split_array [] = array ('bookx_author_id' => $bookx_authors_listing->fields ['bookx_author_id']
												   ,'author_name' => $bookx_authors_listing->fields ['author_name']
												   ,'author_types' => (!empty($bookx_authors_listing->fields ['author_types']) ? '(' . $bookx_authors_listing->fields ['author_types'] . ')': '')
												   ,'author_image' => (!empty($bookx_authors_listing->fields ['author_image']) ? DIR_WS_IMAGES . $bookx_authors_listing->fields ['author_image'] : DIR_WS_IMAGES. 'bookx_authors/author_image_missing.jpg')
												   ,'author_description' => $bookx_authors_listing->fields ['author_description']
												   ,'author_url' => $bookx_authors_listing->fields ['author_url']
												   );

	$bookx_authors_listing->MoveNext ();
}