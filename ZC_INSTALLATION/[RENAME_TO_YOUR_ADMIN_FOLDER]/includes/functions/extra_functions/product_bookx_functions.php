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
 * @version $Id: [admin]/includes/functions/extra_functions/product_type_bookx_functions.php 2016-02-02 philou $
 */


function bookx_get_products_subtitle($products_id, $language_id) {
	global $db;
	$product = $db->Execute("select products_subtitle
                                  from " . TABLE_PRODUCT_BOOKX_EXTRA_DESCRIPTION . "
                                  where products_id = '" . (int)$products_id . "'
                                  and languages_id = '" . (int)$language_id . "'");
	if(!$product->EOF) {
		return ($product->fields['products_subtitle'] ? $product->fields['products_subtitle'] : '');
	} else {
		return null;
	}
}

// Return the Authors URL
  function bookx_get_author_url($bookx_author_id) {
    global $db;
    $author = $db->Execute("select author_url
                                  from " . TABLE_PRODUCT_BOOKX_AUTHORS . "
                                  where bookx_author_id = '" . (int)$bookx_author_id . "'");
    if(!$author->EOF) {
    	return $author->fields['author_url'];
	} else {
		return null;
	}
  }

  function bookx_get_author_name($bookx_author_id) {
  	global $db;
  	$author = $db->Execute('SELECT author_name
                                  FROM ' . TABLE_PRODUCT_BOOKX_AUTHORS . '
                                  WHERE bookx_author_id = "' . (int)$bookx_author_id . '"');

  	if(!$author->EOF) {
  		return ($author->fields['author_name'] ? $author->fields['author_name'] : '');
  	} else {
  		return null;
  	}
  }

  function bookx_get_author_description($bookx_author_id, $language_id) {
  	global $db;
  	$author = $db->Execute("select author_description
                                  from " . TABLE_PRODUCT_BOOKX_AUTHORS_DESCRIPTION . "
                                  where bookx_author_id = '" . (int)$bookx_author_id . "'
                                  and languages_id = '" . (int)$language_id . "'");

	if(!$author->EOF) {
  		return ($author->fields['author_description'] ? $author->fields['author_description'] : '');
	} else {
		return null;
	}
  }

  function bookx_get_author_type_description($bookx_author_type_id, $language_id) {
  	global $db;
  	$author_type = $db->Execute('SELECT type_description
                                  FROM ' . TABLE_PRODUCT_BOOKX_AUTHOR_TYPES_DESCRIPTION . '
                                  WHERE bookx_author_type_id = "' . (int)$bookx_author_type_id . '"
                                  AND languages_id = "' . (int)$language_id . '"');

	if(!$author_type->EOF) {
  		return ($author_type->fields['type_description'] ? $author_type->fields['type_description'] : '');
	} else {
		return null;
	}
  }

  function bookx_get_author_type_image_url($bookx_author_type_id, $language_id) {
  	global $db;
  	$author_type = $db->Execute("select type_image
                                  from " . TABLE_PRODUCT_BOOKX_AUTHOR_TYPES_DESCRIPTION . "
                                  where bookx_author_type_id = '" . (int)$bookx_author_type_id . "'
                                  and languages_id = '" . (int)$language_id . "'");

	if(!$author_type->EOF) {
  		return ($author_type->fields['type_image'] ? $author_type->fields['type_image'] : '');
	} else {
		return null;
	}
  }

  function bookx_get_publisher_name($bookx_publisher_id) {
  	global $db;
  	$publisher = $db->Execute('select publisher_name
                                  from ' . TABLE_PRODUCT_BOOKX_PUBLISHERS . '
                                  where bookx_publisher_id = "' . (int)$bookx_publisher_id . '"');

  	if(!$publisher->EOF) {
  		return ($publisher->fields['publisher_name'] ? $publisher->fields['publisher_name'] : '');
  	} else {
  		return null;
  	}
  }


  /*
   * Return the Publisher URL in the needed language
   *
   */
  function bookx_get_publisher_url($bookx_publisher_id, $language_id) {
    global $db;
    $publisher = $db->Execute("select publisher_url
                                  from " . TABLE_PRODUCT_BOOKX_PUBLISHERS_DESCRIPTION . "
                                  where bookx_publisher_id = '" . (int)$bookx_publisher_id . "'
                                  and languages_id = '" . (int)$language_id . "'");

	if(!$publisher->EOF) {
    	return ($publisher->fields['publisher_url'] ? $publisher->fields['publisher_url'] : '');
	} else {
		return null;
	}
  }

  function bookx_get_publisher_description($bookx_publisher_id, $language_id) {
  	global $db;
  	$publisher = $db->Execute("select publisher_description
                                  from " . TABLE_PRODUCT_BOOKX_PUBLISHERS_DESCRIPTION . "
                                  where bookx_publisher_id = '" . (int)$bookx_publisher_id . "'
                                  and languages_id = '" . (int)$language_id . "'");

	if(!$publisher->EOF) {
  		return ($publisher->fields['publisher_description'] ? $publisher->fields['publisher_description'] : '');
	} else {
		return null;
	}
  }

  function bookx_get_imprint_name($bookx_imprint_id) {
  	global $db;
  	$imprint = $db->Execute("select imprint_name
                                  from " . TABLE_PRODUCT_BOOKX_IMPRINTS . "
                                  where bookx_imprint_id = '" . (int)$bookx_imprint_id . "'");

  	if(!$imprint->EOF) {
  		return ($imprint->fields['imprint_name'] ? $imprint->fields['imprint_name'] : '');
  	} else {
  		return null;
  	}
  }

  function bookx_get_imprint_description($bookx_imprint_id, $language_id) {
  	global $db;
  	$imprint = $db->Execute("select imprint_description
                                  from " . TABLE_PRODUCT_BOOKX_IMPRINTS_DESCRIPTION . "
                                  where bookx_imprint_id = '" . (int)$bookx_imprint_id . "'
                                  and languages_id = '" . (int)$language_id . "'");

	if(!$imprint->EOF) {
  		return ($imprint->fields['imprint_description'] ? $imprint->fields['imprint_description'] : '');
	} else {
		return null;
	}
  }

  function bookx_get_genre_description($bookx_genre_id, $language_id) {
  	global $db;
  	$genre = $db->Execute("select genre_description
                                  from " . TABLE_PRODUCT_BOOKX_GENRES_DESCRIPTION . "
                                  where bookx_genre_id = '" . (int)$bookx_genre_id . "'
                                  and languages_id = '" . (int)$language_id . "'");

	if(!$genre->EOF) {
  		return ($genre->fields['genre_description'] ? $genre->fields['genre_description'] : '');
	} else {
		return null;
	}
  }

  function bookx_get_genre_image_url($bookx_genre_id, $language_id) {
  	global $db;
  	$genre = $db->Execute("select genre_image
                                  from " . TABLE_PRODUCT_BOOKX_GENRES_DESCRIPTION . "
                                  where bookx_genre_id = '" . (int)$bookx_genre_id . "'
                                  and languages_id = '" . (int)$language_id . "'");

	if(!$genre->EOF) {
  		return ($genre->fields['genre_image'] ? $genre->fields['genre_image'] : '');
	} else {
		return null;
	}
  }

  function bookx_get_series_image_url($bookx_series_id, $language_id) {
  	global $db;
  	$series = $db->Execute("select series_image
                                  from " . TABLE_PRODUCT_BOOKX_SERIES_DESCRIPTION . "
                                  where bookx_series_id = '" . (int)$bookx_series_id . "'
                                  and languages_id = '" . (int)$language_id . "'");

	if(!$series->EOF) {
  		return ($series->fields['series_image'] ? $series->fields['series_image'] : '');
	} else {
		return null;
	}
  }

  function bookx_get_series_name($bookx_series_id, $language_id) {
  	global $db;
  	$series = $db->Execute("select series_name
                                  from " . TABLE_PRODUCT_BOOKX_SERIES_DESCRIPTION . "
                                  where bookx_series_id = '" . (int)$bookx_series_id . "'
                                  and languages_id = '" . (int)$language_id . "'");

	if(!$series->EOF) {
  		return ($series->fields['series_name'] ? $series->fields['series_name'] : '');
	} else {
		return null;
	}
  }

  function bookx_get_series_description($bookx_series_id, $language_id) {
  	global $db;
  	$series = $db->Execute("select series_description
                                  from " . TABLE_PRODUCT_BOOKX_SERIES_DESCRIPTION . "
                                  where bookx_series_id = '" . (int)$bookx_series_id . "'
                                  and languages_id = '" . (int)$language_id . "'");

	if(!$series->EOF) {
  		return ($series->fields['series_description'] ? $series->fields['series_description'] : '');
	} else {
		return null;
	}
  }

  function bookx_get_printing_description($bookx_printing_id, $language_id) {
  	global $db;
  	$printing = $db->Execute("select printing_description
                                  from " . TABLE_PRODUCT_BOOKX_PRINTING_DESCRIPTION . "
                                  where bookx_printing_id = '" . (int)$bookx_printing_id . "'
                                  and languages_id = '" . (int)$language_id . "'");

	if(!$printing->EOF) {
  		return ($printing->fields['printing_description'] ? $printing->fields['printing_description'] : '');
	} else {
		return null;
	}
  }

  function bookx_get_binding_description($bookx_binding_id, $language_id) {
  	global $db;
  	$binding = $db->Execute("select binding_description
                                  from " . TABLE_PRODUCT_BOOKX_BINDING_DESCRIPTION . "
                                  where bookx_binding_id = '" . (int)$bookx_binding_id . "'
                                  and languages_id = '" . (int)$language_id . "'");

	if(!$binding->EOF) {
  		return ($binding->fields['binding_description'] ? $binding->fields['binding_description'] : '');
	} else {
		return null;
	}
  }

  function bookx_get_condition_description($bookx_condition_id, $language_id) {
  	global $db;
  	$condition = $db->Execute("select condition_description
                                  from " . TABLE_PRODUCT_BOOKX_CONDITIONS_DESCRIPTION . "
                                  where bookx_condition_id = '" . (int)$bookx_condition_id . "'
                                  and languages_id = '" . (int)$language_id . "'");

	if(!$condition->EOF) {
  		return ($condition->fields['condition_description'] ? $condition->fields['condition_description'] : '');
	} else {
		return null;
	}
  }

  function bookx_delete_product($product_id = null, $delete_linked = true) {
  	global $db;
  	if (null != $product_id) {
		bookx_delete_bookx_specific_product_entries($product_id);

        zen_remove_product($product_id, $delete_linked);
  	}
  }

  function bookx_delete_bookx_specific_product_entries($product_id = null, $delete_linked = true) {
  	global $db;
  	if (null != $product_id) {
  		$db->Execute('DELETE FROM ' . TABLE_PRODUCT_BOOKX_EXTRA . '
                      WHERE products_id = "' . (int)$product_id . '"');

  		$db->Execute('DELETE FROM ' . TABLE_PRODUCT_BOOKX_GENRES_TO_PRODUCTS . '
                      WHERE products_id = "' . (int)$product_id . '"');

  		$db->Execute('DELETE FROM ' . TABLE_PRODUCT_BOOKX_AUTHORS_TO_PRODUCTS . '
                      WHERE products_id = "' . (int)$product_id . '"');
  	}
  }

  function bookx_convert_product_to_bookx_type($product_id = null) {
  	global $db;

  	$sql = 'SELECT * FROM ' . TABLE_PRODUCT_TYPES . ' WHERE type_handler = "product_bookx"';

  	$result = $db->Execute($sql); /* @var $result queryFactoryResult */
  	while (!$result->EOF) {
  		$bookx_type_id = $result->fields['type_id'];
  		$result->MoveNext();
  	}

  	if (null != $product_id) {
  		$db->Execute('UPDATE ' . TABLE_PRODUCTS . ' SET products_type = "' . $bookx_type_id . '"
                      WHERE products_id = "' . (int)$product_id . '"');

  		$db->Execute('REPLACE INTO ' . TABLE_PRODUCT_BOOKX_EXTRA . ' (products_id) VALUES ("' . (int)$product_id . '")');
  	}
  }

  function bookx_convert_product_from_bookx_to_type($product_id = null, $destination_type = null) {
  	global $db;

  	if (null != $product_id && null != $destination_type) {
  		bookx_delete_bookx_specific_product_entries($product_id);
  		$db->Execute('UPDATE ' . TABLE_PRODUCTS . ' SET products_type = "' . $destination_type . '"
                      WHERE products_id = "' . (int)$product_id . '"');

  	}
  }

  function bookx_format_isbn_for_display($isbn = null) {
  	$isbn = preg_replace( '/[^0-9]/', '', $isbn );
	if(!empty($isbn) && 13 == strlen($isbn)) {
		$isbn = substr($isbn, 0, 3) . '-' . substr($isbn, 3, 1) . '-' . substr($isbn, 4, 6) . '-' . substr($isbn, 10, 2) . '-' . substr($isbn, 12);
	}
	return $isbn;
  }

  /*
   * Look up SHOW_XXX_INFO switch for product type bookx
  */
  function bookx_get_show_product_switch($field, $suffix= 'SHOW_', $prefix= '_INFO', $field_prefix= '_', $field_suffix='') {
  	global $db;

  	$zv_key = strtoupper($suffix . 'PRODUCT_BOOKX' . $prefix . $field_prefix . $field . $field_suffix);

  	$sql = "select configuration_key, configuration_value from " . TABLE_PRODUCT_TYPE_LAYOUT . " where configuration_key='" . $zv_key . "'";
  	$zv_key_value = $db->Execute($sql);
  	if ($zv_key_value->RecordCount() > 0) {
  		return $zv_key_value->fields['configuration_value'];
  	} else {
  		$sql = "select configuration_key, configuration_value from " . TABLE_CONFIGURATION . " where configuration_key='" . $zv_key . "'";
  		$zv_key_value = $db->Execute($sql);
  		if ($zv_key_value->RecordCount() > 0) {
  			return $zv_key_value->fields['configuration_value'];
  		} else {
  			return false;
  		}
  	}
  }


  /*
   * This is just a slightly modified copy of zen_image_OLD in the CATALOG
   * since the ADMIN Zen Image does not scale with maintaining proportions
  */
  function bookx_image($src, $alt = '', $width = '', $height = '', $parameters = '') {

  	if ( (empty($src) || ($src == DIR_WS_IMAGES))) {
  		return false;
  	}

  	// Convert width/height to int for proper validation.
  	$width = empty($width) ? $width : intval($width);
  	$height = empty($height) ? $height : intval($height);

  	// alt is added to the img tag even if it is null to prevent browsers from outputting
  	// the image filename as default
  	$image = '<img src="' . zen_output_string($src) . '" alt="' . zen_output_string($alt) . '"';

  	if (zen_not_null($alt)) {
  		$image .= ' title=" ' . zen_output_string($alt) . ' "';
  	}

  	if ( (CONFIG_CALCULATE_IMAGE_SIZE == 'true') && (empty($width) || empty($height)) ) {
  		if ($image_size = @getimagesize($src)) {
  			if (empty($width) && zen_not_null($height)) {
  				$ratio = $height / $image_size[1];
  				$width = $image_size[0] * $ratio;
  			} elseif (zen_not_null($width) && empty($height)) {
  				$ratio = $width / $image_size[0];
  				$height = $image_size[1] * $ratio;
  			} elseif (empty($width) && empty($height)) {
  				$width = $image_size[0];
  				$height = $image_size[1];
  			}
  		}
  	}

      if (zen_not_null($width) && zen_not_null($height)) {
//      $image .= ' width="' . zen_output_string($width) . '" height="' . zen_output_string($height) . '"';
// proportional images
      $image_size = @getimagesize($src);
      // fix division by zero error
      $ratio = ($image_size[0] != 0 ? $width / $image_size[0] : 1);
      if ($image_size[1]*$ratio > $height) {
        $ratio = $height / $image_size[1];
        $width = $image_size[0] * $ratio;
      } else {
        $height = $image_size[1] * $ratio;
      }
// only use proportional image when image is larger than proportional size
      if ($image_size[0] < $width and $image_size[1] < $height) {
        $image .= ' width="' . $image_size[0] . '" height="' . intval($image_size[1]) . '"';
      } else {
        $image .= ' width="' . round($width) . '" height="' . round($height) . '"';
      }
    } else {
       // override on missing image to allow for proportional and required/not required
      if (IMAGE_REQUIRED == 'false') {
        return false;
      } else if (substr($src, 0, 4) != 'http') {
        $image .= ' width="' . intval(SMALL_IMAGE_WIDTH) . '" height="' . intval(SMALL_IMAGE_HEIGHT) . '"';
      }
    }

  	if (zen_not_null($parameters)) $image .= ' ' . $parameters;

  	$image .= ' />';

  	return $image;
  }