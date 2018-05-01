<?php
/**
 * This file is part of the ZenCart add-on Book X which
 * introduces a new product type for books to the Zen Cart
 * shop system. Tested for compatibility on ZC v. 1.5
 *
 * For latest version and support visit:
 * https://sourceforge.net/p/zencartbookx
 *
 * @package admin
 * @author  Philou
 * @copyright Copyright 2013
 * @copyright Portions Copyright 2003-2011 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.gnu.org/licenses/gpl.txt GNU General Public License V2.0
 *
 * @version BookX V 0.9.4-revision8 BETA
 * @version $Id: [ZC INSTALLATION]/[ADMIN]/includes/classes/observers/class.bookx_admin_observers.php 2016-02-02 philou $
 */


class bookxAdminObserver extends base {

	function bookxAdminObserver() {
	   	global $zco_notifier;

	   	$zco_notifier->attach($this, array('NOTIFY_MODULE_ADMIN_CATEGORY_LISTING_QUERY_BUILT'
	   									  /*,
	   									   'NOTIFIER_CART_ADD_CART_END'
	   									   */
	   									  )
	   						  );

   }

	function update(&$callingClass, $notifier, &$paramsArray) {
		switch ($notifier) {
			case 'NOTIFY_MODULE_ADMIN_CATEGORY_LISTING_QUERY_BUILT':
				$this->insert_bookx_into_category_listing_query($callingClass, $notifier, $paramsArray);
			break;


		}
	}

	/**
	 * Thsi will alter the category listing query so it lists some BookX-specific attributes, such as subtitle and ISBN
	 */

	function insert_bookx_into_category_listing_query(&$shoppinCartClass, $notifier, $paramsArray) {
		global $db, $products_query_raw;

		$product_type = $db->Execute('SELECT type_id FROM ' . TABLE_PRODUCT_TYPES . ' WHERE type_handler = "product_bookx"');

		$bookx_ptype_id = (0 < $product_type->RecordCount() ? $product_type->fields['type_id'] : null);
		if ($bookx_ptype_id){
			$product_name_query = ' IF(p.products_type = "' . $bookx_ptype_id . '"
									  ,CONCAT_WS(" – ", CONCAT_WS(" ", pd.products_name, be.volume), NULLIF(bed.products_subtitle, "") )
									  ,pd.products_name
	   								  ) AS products_name';

			$product_model_query = ' IF(p.products_type = "' . $bookx_ptype_id . '"
									  ,CONCAT_WS(" ", p.products_model, CONCAT_WS("", " / '. LABEL_BOOKX_ISBN . '", CONCAT_WS("-", SUBSTRING(be.isbn,1,3), SUBSTRING(be.isbn,4,1), SUBSTRING(be.isbn,5,6), SUBSTRING(be.isbn,11,2), SUBSTRING(be.isbn,13,1))) )
									  ,p.products_model
	   								  ) AS products_model';

			$additional_joins = ', ' . TABLE_PRODUCTS . ' pbxjoin
								   LEFT JOIN ' . TABLE_PRODUCT_BOOKX_EXTRA . ' be ON be.products_id = pbxjoin.products_id
								   LEFT JOIN ' . TABLE_PRODUCT_BOOKX_EXTRA_DESCRIPTION . ' bed ON bed.products_id = be.products_id AND bed.languages_id = "' . (int)$_SESSION['languages_id'] . '"';

			$additional_where = ' pbxjoin.products_id = p.products_id AND ';

			$products_query_raw = str_replace(', pd.products_name,', ', ' . $product_name_query . ',', $products_query_raw);
			$products_query_raw = str_replace(', p.products_model,', ', ' . $product_model_query . ',', $products_query_raw);
			$products_query_raw = str_replace('where ', $additional_joins . ' where ' . $additional_where , $products_query_raw);

		}
	}

 }