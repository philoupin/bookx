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
 * @version $Id: delete_product_confirm.php 2016-02-02 philou $
 */

  if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
  }
  // NOTE: Debug code left in to help with creating additional product type delete-scripts

  // test if demo mode active
  if (zen_admin_demo()) {
    $_GET['action']= '';
    $messageStack->add_session(ERROR_ADMIN_DEMO, 'caution');
    zen_redirect(zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $_GET['cPath'] . '&pID=' . $_GET['pID'] . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '')));
  }

  $do_delete_flag = false;
  //echo 'products_id=' . $_POST['products_id'] . '<br />';
  if (isset($_POST['products_id']) && isset($_POST['product_categories']) && is_array($_POST['product_categories'])) {
    $product_id = zen_db_prepare_input($_POST['products_id']);
    $product_categories = $_POST['product_categories'];
    $do_delete_flag = true;
    if (!isset($delete_linked)) $delete_linked = 'true';
  }

  if (zen_not_null($cascaded_prod_id_for_delete) && zen_not_null($cascaded_prod_cat_for_delete) ) {
    $product_id = $cascaded_prod_id_for_delete;
    $product_categories = $cascaded_prod_cat_for_delete;
    $do_delete_flag = true;
    // no check for $delete_linked here, because it should already be passed from categories.php
  }

  if ($do_delete_flag) {
    //--------------PRODUCT_TYPE_SPECIFIC_INSTRUCTIONS_GO__BELOW_HERE--------------------------------------------------------

  	bookx_delete_bookx_specific_product_entries($product_id);
  	
  	// addition for extra product fields
  	if (defined('TABLE_PRODUCT_EXTRA_FIELDS')) {
  	      $db->Execute("delete from " . TABLE_PRODUCT_EXTRA_FIELDS . "
                    where products_id = '" . (int)$product_id . "'");
      }
        	// eof addition for extra product fields


    //--------------PRODUCT_TYPE_SPECIFIC_INSTRUCTIONS_GO__ABOVE__HERE--------------------------------------------------------


    // now do regular non-type-specific delete:

    // remove product from all its categories:
    for ($k=0, $m=sizeof($product_categories); $k<$m; $k++) {
      $db->Execute("delete from " . TABLE_PRODUCTS_TO_CATEGORIES . "
                    where products_id = '" . (int)$product_id . "'
                    and categories_id = '" . (int)$product_categories[$k] . "'");
    }

    // confirm that product is no longer linked to any categories
    $count_categories = $db->Execute("select count(categories_id) as total
                                      from " . TABLE_PRODUCTS_TO_CATEGORIES . "
                                      where products_id = '" . (int)$product_id . "'");
    // echo 'count of category links for this product=' . $count_categories->fields['total'] . '<br />';

    // if not linked to any categories, do delete:
    if ($count_categories->fields['total'] == '0') {
      zen_remove_product($product_id, $delete_linked);
    }

  } // endif $do_delete_flag

  // if this is a single-product delete, redirect to categories page
  // if not, then this file was called by the cascading delete initiated by the category-delete process
  if ($action == 'delete_product_confirm') zen_redirect(zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath));
