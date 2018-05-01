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
 * @version $Id: update_product.php 2016-02-02 philou $
 */


  if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
  }
  if (isset($_GET['pID'])) $products_id = zen_db_prepare_input($_GET['pID']);

  if (isset($_POST['edit_x']) || isset($_POST['edit_y'])) {
    $action = 'new_product';
  } elseif ($_POST['isbn'] . $_POST['products_model'] . $_POST['products_url'] . $_POST['products_name'] . $_POST['products_description'] != '') {
    $products_date_available = zen_db_prepare_input($_POST['products_date_available']);

    $products_date_available = (date('Y-m-d') < $products_date_available) ? $products_date_available : 'null';


    // Data-cleaning to prevent MySQL5 data-type mismatch errors:
    $tmp_value = zen_db_prepare_input($_POST['products_quantity']);
    $products_quantity = (!zen_not_null($tmp_value) || $tmp_value=='' || $tmp_value === 0) ? 0 : $tmp_value;
    $tmp_value = zen_db_prepare_input($_POST['products_price']);
    $products_price = (!zen_not_null($tmp_value) || $tmp_value=='' || $tmp_value === 0) ? 0 : $tmp_value;
    $tmp_value = zen_db_prepare_input($_POST['products_weight']);
    $products_weight = (!zen_not_null($tmp_value) || $tmp_value=='' || $tmp_value === 0) ? 0 : $tmp_value;
    $tmp_value = (isset($_POST['manufacturers_id']) ? zen_db_prepare_input($_POST['manufacturers_id']) : null);
    $manufacturers_id = (!zen_not_null($tmp_value) || $tmp_value=='' || $tmp_value === 0) ? 0 : $tmp_value;

    $sql_data_array = array('products_quantity' => $products_quantity,
                            'products_type' => zen_db_prepare_input($_GET['product_type']),
                            'products_model' => zen_db_prepare_input($_POST['products_model']),
                            'products_price' => $products_price,
                            'products_date_available' => $products_date_available,
                            'products_weight' => $products_weight,
                            'products_status' => zen_db_prepare_input((int)$_POST['products_status']),
                            'products_virtual' => zen_db_prepare_input((int)$_POST['products_virtual']),
                            'products_tax_class_id' => zen_db_prepare_input((int)$_POST['products_tax_class_id']),
                            'manufacturers_id' => $manufacturers_id,
                            'products_quantity_order_min' => zen_db_prepare_input($_POST['products_quantity_order_min']),
                            'products_quantity_order_units' => zen_db_prepare_input($_POST['products_quantity_order_units']),
                            'products_priced_by_attribute' => zen_db_prepare_input($_POST['products_priced_by_attribute']),
                            'product_is_free' => zen_db_prepare_input((int)$_POST['product_is_free']),
                            'product_is_call' => zen_db_prepare_input((int)$_POST['product_is_call']),
                            'products_quantity_mixed' => zen_db_prepare_input($_POST['products_quantity_mixed']),
                            'product_is_always_free_shipping' => zen_db_prepare_input((int)$_POST['product_is_always_free_shipping']),
                            'products_qty_box_status' => zen_db_prepare_input($_POST['products_qty_box_status']),
                            'products_quantity_order_max' => zen_db_prepare_input($_POST['products_quantity_order_max']),
                            'products_sort_order' => (int)zen_db_prepare_input($_POST['products_sort_order']),
                            'products_discount_type' => zen_db_prepare_input($_POST['products_discount_type']),
                            'products_discount_type_from' => zen_db_prepare_input($_POST['products_discount_type_from']),
                            'products_price_sorter' => zen_db_prepare_input($_POST['products_price_sorter'])
                            );

    // when set to none remove from database
    // is out dated for browsers use radio only
      $sql_data_array['products_image'] = zen_db_prepare_input($_POST['products_image']);
      $new_image= 'true';

    if ($_POST['image_delete'] == 1) {
      $sql_data_array['products_image'] = '';
      $new_image= 'false';
    }

    if ($action == 'insert_product') {
      $insert_sql_data = array( 'products_date_added' => 'now()',
                                'master_categories_id' => (int)$current_category_id);

      $sql_data_array = array_merge($sql_data_array, $insert_sql_data);

      zen_db_perform(TABLE_PRODUCTS, $sql_data_array);
      $products_id = zen_db_insert_id();

      // reset products_price_sorter for searches etc.
      zen_update_products_price_sorter($products_id);

      $db->Execute("insert into " . TABLE_PRODUCTS_TO_CATEGORIES . "
                    (products_id, categories_id)
                    values ('" . (int)$products_id . "', '" . (int)$current_category_id . "')");

      ///////////////////////////////////////////////////////
      //// INSERT PRODUCT-TYPE-SPECIFIC *INSERTS* HERE //////
      $tmp_value = (isset($_POST['bookx_publisher_id']) ? zen_db_prepare_input($_POST['bookx_publisher_id']) : null);
      $bookx_publisher_id = (!zen_not_null($tmp_value) || $tmp_value=='' || $tmp_value === 0) ? null : $tmp_value;

      $tmp_value = (isset($_POST['bookx_publisher_id']) ? zen_db_prepare_input($_POST['bookx_series_id']) : null);
      $bookx_series_id = (!zen_not_null($tmp_value) || $tmp_value=='' || $tmp_value === 0) ? null : (int)$tmp_value;

      $tmp_value = (isset($_POST['bookx_publisher_id']) ? zen_db_prepare_input($_POST['bookx_imprint_id']) : null);
      $bookx_imprint_id = (!zen_not_null($tmp_value) || $tmp_value=='' || $tmp_value === 0) ? null : (int)$tmp_value;

      $tmp_value = (isset($_POST['bookx_publisher_id']) ? zen_db_prepare_input($_POST['bookx_binding_id']) : null);
      $bookx_binding_id = (!zen_not_null($tmp_value) || $tmp_value=='' || $tmp_value === 0) ? null : (int)$tmp_value;

      $tmp_value = (isset($_POST['bookx_publisher_id']) ? zen_db_prepare_input($_POST['bookx_printing_id']) : null);
      $bookx_printing_id = (!zen_not_null($tmp_value) || $tmp_value=='' || $tmp_value === 0) ? null : (int)$tmp_value;

      $tmp_value = (isset($_POST['bookx_publisher_id']) ? zen_db_prepare_input($_POST['bookx_condition_id']) : null);
      $bookx_condition_id = (!zen_not_null($tmp_value) || $tmp_value=='' || $tmp_value === 0) ? null : (int)$tmp_value;

      $tmp_value = zen_db_prepare_input($_POST['publishing_date']);
      $publishing_date = (!zen_not_null($tmp_value) || $tmp_value=='' || $tmp_value === 0) ? 'null' : $tmp_value;

      if ($_POST['pub_date_use_only_month'] && $publishing_date && 10 == strlen($publishing_date)) {
		$publishing_date = substr($publishing_date, 0, 8) . '00';
      }

      $tmp_value = zen_db_prepare_input($_POST['pages']);
      $pages = (!zen_not_null($tmp_value) || $tmp_value=='' || $tmp_value === 0) ? null : $tmp_value;

      $tmp_value = zen_db_prepare_input($_POST['volume']);
      $volume = (!zen_not_null($tmp_value) || $tmp_value=='' || $tmp_value === 0) ? null : $tmp_value;

      $tmp_value = zen_db_prepare_input($_POST['size']);
	  $size = (!zen_not_null($tmp_value) || $tmp_value=='' || $tmp_value === 0) ? null : $tmp_value;

	  $tmp_value = zen_db_prepare_input($_POST['isbn']);
	  $isbn = (!zen_not_null($tmp_value) || $tmp_value=='' || $tmp_value === 0) ? null : $isbn = preg_replace( '/[^0-9]/', '', $tmp_value );



      $sql_data_array = array('products_id' => (int)$products_id,
                              'bookx_publisher_id' => $bookx_publisher_id,
                              'bookx_series_id' => $bookx_series_id,
                              'bookx_imprint_id' => $bookx_imprint_id,
                              'bookx_binding_id' => $bookx_binding_id,
                              'bookx_printing_id' => $bookx_printing_id,
                              'bookx_condition_id' => $bookx_condition_id,
                              'publishing_date' => $publishing_date,
                              'pages' => $pages,
                              'volume' => $volume,
                              'size' => $size,
                              'isbn' => $isbn );

      zen_db_perform(TABLE_PRODUCT_BOOKX_EXTRA, $sql_data_array);

      if (isset($_POST['bookx_genre_id']) && is_array($_POST['bookx_genre_id'])) {
      	foreach ($_POST['bookx_genre_id'] as $array_key => $array_value) {
      		$tmp_value = zen_db_prepare_input($array_value);
      		$bookx_genre_id = (!zen_not_null($tmp_value) || $tmp_value=='' || $tmp_value === 0) ? null : $tmp_value;

      		if ($bookx_genre_id) {
	      		$sql_data_array = array('products_id' => (int)$products_id,
	      								'bookx_genre_id' => (int)$bookx_genre_id);
	      		zen_db_perform(TABLE_PRODUCT_BOOKX_GENRES_TO_PRODUCTS, $sql_data_array);
      		}
      	}
      }

      if (isset($_POST['bookx_author_id']) && is_array($_POST['bookx_author_id'])) {
      	foreach ($_POST['bookx_author_id'] as $array_key => $array_value) {
      		$tmp_value = zen_db_prepare_input($array_value);
      		$bookx_author_id = (!zen_not_null($tmp_value) || $tmp_value=='' || $tmp_value === 0) ? null : $tmp_value;

      		$bookx_author_type_id = null;
      		if (is_array($_POST['bookx_author_type_id']) && array_key_exists($array_key, $_POST['bookx_author_type_id'])) {
      			$tmp_value = zen_db_prepare_input($_POST['bookx_author_type_id'][$array_key]);
      			$bookx_author_type_id = (!zen_not_null($tmp_value) || $tmp_value=='' || $tmp_value === 0) ? null : (int)$tmp_value;
      		}
      		if ($bookx_author_id) {
	      		$sql_data_array = array('products_id' => (int)$products_id,
	      								'bookx_author_id' => (int)$bookx_author_id,
	                              		'bookx_author_type_id' => $bookx_author_type_id);
	      		zen_db_perform(TABLE_PRODUCT_BOOKX_AUTHORS_TO_PRODUCTS, $sql_data_array);
      		}
      	}
      }

      $languages = zen_get_languages();
      for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
      	$language_id = $languages[$i]['id'];

      	$sql_data_array = array('products_subtitle' => zen_db_prepare_input($_POST['products_subtitle'][$language_id])
      	);

      	if ($action == 'insert_product') {
      		$insert_sql_data = array('products_id' => (int)$products_id,
      				'languages_id' => (int)$language_id);

      		$sql_data_array = array_merge($sql_data_array, $insert_sql_data);

      		zen_db_perform(TABLE_PRODUCT_BOOKX_EXTRA_DESCRIPTION, $sql_data_array);
      	}
      }

      ////    *END OF PRODUCT-TYPE-SPECIFIC INSERTS* ////////
      ///////////////////////////////////////////////////////
    } elseif ($action == 'update_product') {
      $update_sql_data = array( 'products_last_modified' => 'now()',
                                'master_categories_id' => ($_POST['master_category'] > 0 ? zen_db_prepare_input($_POST['master_category']) : zen_db_prepare_input($_POST['master_categories_id'])));

      $sql_data_array = array_merge($sql_data_array, $update_sql_data);

      zen_db_perform(TABLE_PRODUCTS, $sql_data_array, 'update', "products_id = '" . (int)$products_id . "'");

      // reset products_price_sorter for searches etc.
      zen_update_products_price_sorter((int)$products_id);

      ///////////////////////////////////////////////////////
      //// INSERT PRODUCT-TYPE-SPECIFIC *UPDATES* HERE //////

      $tmp_value = (isset($_POST['bookx_publisher_id']) ? zen_db_prepare_input($_POST['bookx_publisher_id']) : NULL);
      $bookx_publisher_id = (!zen_not_null($tmp_value) || $tmp_value=='' || $tmp_value === 0) ? null : (int)$tmp_value;

      $tmp_value = (isset($_POST['bookx_series_id']) ? zen_db_prepare_input($_POST['bookx_series_id']) : NULL);
      $bookx_series_id = (!zen_not_null($tmp_value) || $tmp_value=='' || $tmp_value === 0) ? null : (int)$tmp_value;

      $tmp_value = (isset($_POST['bookx_imprint_id']) ? zen_db_prepare_input($_POST['bookx_imprint_id']) : NULL);
      $bookx_imprint_id = (!zen_not_null($tmp_value) || $tmp_value=='' || $tmp_value === 0) ? null : (int)$tmp_value;

      $tmp_value = (isset($_POST['bookx_binding_id']) ? zen_db_prepare_input($_POST['bookx_binding_id']) : NULL);
      $bookx_binding_id = (!zen_not_null($tmp_value) || $tmp_value=='' || $tmp_value === 0) ? null : (int)$tmp_value;

      $tmp_value = (isset($_POST['bookx_printing_id']) ? zen_db_prepare_input($_POST['bookx_printing_id']) : NULL);
      $bookx_printing_id = (!zen_not_null($tmp_value) || $tmp_value=='' || $tmp_value === 0) ? null : (int)$tmp_value;

      $tmp_value = (isset($_POST['bookx_condition_id']) ? zen_db_prepare_input($_POST['bookx_condition_id']) : NULL);
      $bookx_condition_id = (!zen_not_null($tmp_value) || $tmp_value=='' || $tmp_value === 0) ? null : (int)$tmp_value;

      $tmp_value = zen_db_prepare_input($_POST['publishing_date']);
      $publishing_date = (!zen_not_null($tmp_value) || $tmp_value=='' || $tmp_value === 0) ? 'null' : $tmp_value;

      if ($_POST['pub_date_use_only_month'] && $publishing_date && 10 == strlen($publishing_date)) {
      	$publishing_date = substr($publishing_date, 0, 8) . '00';
      }

      $tmp_value = zen_db_prepare_input($_POST['pages']);
      $pages = (!zen_not_null($tmp_value) || $tmp_value=='' || $tmp_value === 0) ? null : $tmp_value;

      $tmp_value = zen_db_prepare_input($_POST['volume']);     
      $volume = (!zen_not_null($tmp_value) || $tmp_value=='' || $tmp_value === 0) ? null : $tmp_value;

      $tmp_value = zen_db_prepare_input($_POST['size']);
      $size = (!zen_not_null($tmp_value) || $tmp_value=='' || $tmp_value === 0) ? null : $tmp_value;

      $tmp_value = zen_db_prepare_input($_POST['isbn']);
      $isbn = (!zen_not_null($tmp_value) || $tmp_value=='' || $tmp_value === 0) ? null : $tmp_value;

      $sql_data_array = array('products_id' => (int)$products_id,
                              'bookx_publisher_id' => $bookx_publisher_id,
                              'bookx_series_id' => $bookx_series_id,
                              'bookx_imprint_id' => $bookx_imprint_id,
                              'bookx_binding_id' => $bookx_binding_id,
                              'bookx_printing_id' => $bookx_printing_id,
                              'bookx_condition_id' => $bookx_condition_id,
                              'publishing_date' => $publishing_date,
                              'pages' => $pages,
                              'volume' => $volume,
                              'size' => $size,
                              'isbn' => $isbn );

      zen_db_perform(TABLE_PRODUCT_BOOKX_EXTRA, $sql_data_array, 'update', "products_id = '" . (int)$products_id . "'");

      if (isset($_POST['bookx_genre_id']) && is_array($_POST['bookx_genre_id'])) {
      	foreach ($_POST['bookx_genre_id'] as $array_key => $array_value) {
      		$tmp_value = zen_db_prepare_input($array_value);
      		$bookx_genre_id = (!zen_not_null($tmp_value) || $tmp_value=='' || $tmp_value === 0) ? null : $tmp_value;

      		$primary_id = null;
      		if (isset($_POST['assigned_genre_db_id']) && is_array($_POST['assigned_genre_db_id']) && array_key_exists($array_key, $_POST['assigned_genre_db_id'])) {
      			$tmp_value = zen_db_prepare_input($_POST['assigned_genre_db_id'][$array_key]);
      			$primary_id = (!zen_not_null($tmp_value) || $tmp_value=='' || $tmp_value === 0) ? null : $tmp_value;
      		}

      		$gtp_action = 'insert';
      		$where_clause ='';
      		switch (true) {
      			case (null != $primary_id && null == $bookx_genre_id):
      				//this is an update to an existing genre_to_product table entry, but NO existing genre is assigned -> DELETE table entry
      				$db->Execute('DELETE FROM ' . TABLE_PRODUCT_BOOKX_GENRES_TO_PRODUCTS . ' WHERE primary_id = "' . (int)$primary_id . '" LIMIT 1');
      				break;

      			case (null != $primary_id && null != $bookx_genre_id):
      				//this is an update to an existing genre_to_product table entry and an existing genre is assigned -> UPDATE table entry
      				$gtp_action = 'update';
      				$where_clause = 'primary_id = "' . (int)$primary_id . '"';

      				// we don't break here!

      			case (null == $primary_id && null != $bookx_genre_id):
      				//this is a new genre_to_product table entry and an existing genre is assigned -> INSERT table entry
      				$sql_data_array = array('products_id' => (int)$products_id,
      										'bookx_genre_id' => $bookx_genre_id);

      				zen_db_perform(TABLE_PRODUCT_BOOKX_GENRES_TO_PRODUCTS, $sql_data_array, $gtp_action, $where_clause);
      				break;

      		}


      	}
      }

      if (isset($_POST['bookx_author_id']) && is_array($_POST['bookx_author_id'])) {
      	foreach ($_POST['bookx_author_id'] as $array_key => $array_value) {
      		$tmp_value = zen_db_prepare_input($array_value);
      		$bookx_author_id = (!zen_not_null($tmp_value) || $tmp_value=='' || $tmp_value === 0) ? null : (int)$tmp_value;

      		$bookx_author_type_id = null;
      		if (isset($_POST['bookx_author_type_id']) && is_array($_POST['bookx_author_type_id']) && array_key_exists($array_key, $_POST['bookx_author_type_id'])) {
      			$tmp_value = zen_db_prepare_input($_POST['bookx_author_type_id'][$array_key]);
      			$bookx_author_type_id = (!zen_not_null($tmp_value) || $tmp_value=='' || $tmp_value === 0) ? null : (int)$tmp_value;
      		}

      		$primary_id = null;
      		if (isset($_POST['assigned_author_db_id']) && is_array($_POST['assigned_author_db_id']) && array_key_exists($array_key, $_POST['assigned_author_db_id'])) {
      			$tmp_value = zen_db_prepare_input($_POST['assigned_author_db_id'][$array_key]);
      			$primary_id = (!zen_not_null($tmp_value) || $tmp_value=='' || $tmp_value === 0) ? null : $tmp_value;
      		}

      		$atp_action = 'insert';
      		$where_clause ='';
      		switch (true) {
      			case (null != $primary_id && null == $bookx_author_id):
      				//this is an update to an existing author_to_product table entry, but NO existing author is assigned -> DELETE table entry
      				$db->Execute('DELETE FROM ' . TABLE_PRODUCT_BOOKX_AUTHORS_TO_PRODUCTS . ' WHERE primary_id = "' . (int)$primary_id . '" LIMIT 1');
      				break;

      			case (null != $primary_id && null != $bookx_author_id):
      				//this is an update to an existing author_to_product table entry and an existing author is assigned -> UPDATE table entry
      				$atp_action = 'update';
      				$where_clause = 'primary_id = "' . (int)$primary_id . '"';

      				// we don't break here!

      			case (null == $primary_id && null != $bookx_author_id):
      				//this is a new author_to_product table entry and an existing author is assigned -> INSERT table entry
      				$sql_data_array = array('products_id' => (int)$products_id,
      										'bookx_author_id' => $bookx_author_id,
      										'bookx_author_type_id' => $bookx_author_type_id);

      				zen_db_perform(TABLE_PRODUCT_BOOKX_AUTHORS_TO_PRODUCTS, $sql_data_array, $atp_action, $where_clause);
      				break;

      		}
      	}
      }

      $languages = zen_get_languages();
      for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
      	$language_id = $languages[$i]['id'];

      	$sql_data_array = array('products_subtitle' => zen_db_prepare_input($_POST['products_subtitle'][$language_id])
      							);

      	if ($action == 'insert_product' ||
          	  ($action == 'update_product' && null === bookx_get_products_subtitle($products_id, $language_id))) {
      		$insert_sql_data = array('products_id' => (int)$products_id,
      								 'languages_id' => (int)$language_id);

      		$sql_data_array = array_merge($sql_data_array, $insert_sql_data);

      		zen_db_perform(TABLE_PRODUCT_BOOKX_EXTRA_DESCRIPTION, $sql_data_array);
      	} elseif ($action == 'update_product') {
      		zen_db_perform(TABLE_PRODUCT_BOOKX_EXTRA_DESCRIPTION, $sql_data_array, 'update', "products_id = '" . (int)$products_id . "' and languages_id = '" . (int)$language_id . "'");
      	}
      }


      ////    *END OF PRODUCT-TYPE-SPECIFIC UPDATES* ////////
      ///////////////////////////////////////////////////////
    }

    //** look for additional update_product*.php files and include now **//
    $incl_dir = @dir(DIR_FS_ADMIN . '/includes/modules/product_bookx');
    while ($file = $incl_dir->read()) {
    	if ('update_product_' == substr($file, 0, 15)) {
    		include_once DIR_FS_ADMIN . '/includes/modules/product_bookx/' . $file; // This should handle any extra values collected in collect_info*.php
    	}
    }
    $incl_dir->close();

    $languages = zen_get_languages();
    for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
      $language_id = $languages[$i]['id'];

      $sql_data_array = array('products_name' => zen_db_prepare_input($_POST['products_name'][$language_id]),
                              'products_description' => zen_db_prepare_input($_POST['products_description'][$language_id]),
                              'products_url' => zen_db_prepare_input($_POST['products_url'][$language_id]));

      if ($action == 'insert_product') {
        $insert_sql_data = array('products_id' => (int)$products_id,
                                 'language_id' => (int)$language_id);

        $sql_data_array = array_merge($sql_data_array, $insert_sql_data);

        zen_db_perform(TABLE_PRODUCTS_DESCRIPTION, $sql_data_array);
      } elseif ($action == 'update_product') {
        zen_db_perform(TABLE_PRODUCTS_DESCRIPTION, $sql_data_array, 'update', "products_id = '" . (int)$products_id . "' and language_id = '" . (int)$language_id . "'");
      }
    }

    // add meta tags
    $languages = zen_get_languages();
    for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
      $language_id = $languages[$i]['id'];

      $sql_data_array = array('metatags_title' => zen_db_prepare_input($_POST['metatags_title'][$language_id]),
                              'metatags_keywords' => zen_db_prepare_input($_POST['metatags_keywords'][$language_id]),
                              'metatags_description' => zen_db_prepare_input($_POST['metatags_description'][$language_id]));

      if ($action == 'insert_product_meta_tags') {

        $insert_sql_data = array('products_id' => (int)$products_id,
                                 'language_id' => (int)$language_id);

        $sql_data_array = array_merge($sql_data_array, $insert_sql_data);

        zen_db_perform(TABLE_META_TAGS_PRODUCTS_DESCRIPTION, $sql_data_array);
      } elseif ($action == 'update_product_meta_tags') {
        zen_db_perform(TABLE_META_TAGS_PRODUCTS_DESCRIPTION, $sql_data_array, 'update', "products_id = '" . (int)$products_id . "' and language_id = '" . (int)$language_id . "'");
      }
    }


    // future image handler code
    define('IMAGE_MANAGER_HANDLER', 0);
    define('DIR_IMAGEMAGICK', '');
    if ($new_image == 'true' and IMAGE_MANAGER_HANDLER >= 1) {
      $src= DIR_FS_CATALOG . DIR_WS_IMAGES . zen_get_products_image((int)$products_id);
      $filename_small= $src;
      preg_match("/.*\/(.*)\.(\w*)$/", $src, $fname);
      list($oiwidth, $oiheight, $oitype) = getimagesize($src);

      $small_width= SMALL_IMAGE_WIDTH;
      $small_height= SMALL_IMAGE_HEIGHT;
      $medium_width= MEDIUM_IMAGE_WIDTH;
      $medium_height= MEDIUM_IMAGE_HEIGHT;
      $large_width= LARGE_IMAGE_WIDTH;
      $large_height= LARGE_IMAGE_HEIGHT;

      $k = max($oiheight / $small_height, $oiwidth / $small_width); //use smallest size
      $small_width = round($oiwidth / $k);
      $small_height = round($oiheight / $k);

      $k = max($oiheight / $medium_height, $oiwidth / $medium_width); //use smallest size
      $medium_width = round($oiwidth / $k);
      $medium_height = round($oiheight / $k);

      $large_width= $oiwidth;
      $large_height= $oiheight;

      $products_image = zen_get_products_image((int)$products_id);
      $products_image_extension = substr($products_image, strrpos($products_image, '.'));
      $products_image_base = preg_replace('/'.$products_image_extension.'/', '', $products_image);

      $filename_medium = DIR_FS_CATALOG . DIR_WS_IMAGES . 'medium/' . $products_image_base . IMAGE_SUFFIX_MEDIUM . '.' . $fname[2];
      $filename_large = DIR_FS_CATALOG . DIR_WS_IMAGES . 'large/' . $products_image_base . IMAGE_SUFFIX_LARGE . '.' . $fname[2];

      // ImageMagick
      if (IMAGE_MANAGER_HANDLER == '1') {
        copy($src, $filename_large);
        copy($src, $filename_medium);
        exec(DIR_IMAGEMAGICK . "mogrify -geometry " . $large_width . " " . $filename_large);
        exec(DIR_IMAGEMAGICK . "mogrify -geometry " . $medium_width . " " . $filename_medium);
        exec(DIR_IMAGEMAGICK . "mogrify -geometry " . $small_width . " " . $filename_small);
      }
    }

    zen_redirect(zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $products_id . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '') . (isset($_POST['search']) ? '&search=' . $_POST['search'] : '') ));
  } else {
    $messageStack->add_session(ERROR_NO_DATA_TO_SAVE, 'error');
    zen_redirect(zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $products_id . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '') . (isset($_POST['search']) ? '&search=' . $_POST['search'] : '') ));
  }