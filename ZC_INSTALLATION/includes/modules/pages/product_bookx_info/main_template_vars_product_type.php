<?php
/**
 * This file is part of the ZenCart add-on Book X which
 * introduces a new product type for books to the Zen Cart
 * shop system. Tested for compatibility on ZC v. 1.5
 *
 * For latest version and support visit:
 * https://sourceforge.net/p/zencartbookx
 *
 * @package productTypes
 * @author  Philou
 * @copyright Copyright 2013
 * @copyright Portions Copyright 2003-2011 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.gnu.org/licenses/gpl.txt GNU General Public License V2.0
 *
 * @version BookX V 0.9.4-revision8 BETA
 * @version $Id: [ZC INSTALLATION]/includes/modules/pages/product_bookx_info/main_template_vars_product_type.php 2016-02-02 philou $
 */

/*
 * This file contains all the logic to prepare $vars for use in the product-type-specific template
 * It pulls data from all the related tables which collectively store the info related only to this product type.
 */

  // This should be first line of the script:
  $zco_notifier->notify('NOTIFY_PRODUCT_TYPE_VARS_START_PRODUCT_BOOKX_INFO');


  // Bookx specific flags
  $flag_show_product_bookx_info_authors = (int)zen_get_show_product_switch($products_id_current, 'authors');
  $flag_show_product_bookx_info_authors_as_link = (int)zen_get_show_product_switch($products_id_current, 'authors_as_link');

  $flag_show_product_bookx_info_authors_image = (int)zen_get_show_product_switch($products_id_current, 'authors_image');
  $flag_show_product_bookx_info_authors_url = (int)zen_get_show_product_switch($products_id_current, 'authors_url');
  $flag_show_product_bookx_info_authors_description = (int)zen_get_show_product_switch($products_id_current, 'authors_description');
  $flag_show_product_bookx_info_authors_related_products = (int)zen_get_show_product_switch($products_id_current, 'authors_related_products');
  $flag_show_product_bookx_info_authors_team_related_products = 1; //(int)zen_get_show_product_switch($products_id_current, 'authors_team_related_products');
  $flag_show_product_bookx_info_author_type = (int)zen_get_show_product_switch($products_id_current, 'author_type');
  $flag_show_product_bookx_info_author_type_image = (int)zen_get_show_product_switch($products_id_current, 'author_type_image');
  $flag_order_product_bookx_info_authors_by = zen_get_show_product_switch($products_id_current, 'authors', 'ORDER_');


  $flag_show_product_bookx_info_binding = (int)zen_get_show_product_switch($products_id_current, 'binding');
  $flag_show_product_bookx_info_condition = (int)zen_get_show_product_switch($products_id_current, 'condition');

  $flag_show_product_bookx_info_genres = (int)zen_get_show_product_switch($products_id_current, 'genres');
  $flag_show_product_bookx_info_genres_as_link = (int)zen_get_show_product_switch($products_id_current, 'genres_as_link');
  $flag_show_product_bookx_info_genre_images = (int)zen_get_show_product_switch($products_id_current, 'genre_images');
  $flag_order_product_bookx_info_genres_by = zen_get_show_product_switch($products_id_current, 'genres', 'ORDER_');


  $flag_show_product_bookx_info_imprint = (int)zen_get_show_product_switch($products_id_current, 'imprint');
  $flag_show_product_bookx_info_imprint_as_link = (int)zen_get_show_product_switch($products_id_current, 'imprint_as_link');
  $flag_show_product_bookx_info_imprint_image = (int)zen_get_show_product_switch($products_id_current, 'imprint_image');
  $flag_show_product_bookx_info_imprint_description = (int)zen_get_show_product_switch($products_id_current, 'imprint_description');

  $flag_show_product_bookx_info_pages = (int)zen_get_show_product_switch($products_id_current, 'pages');
  $flag_show_product_bookx_info_printing = (int)zen_get_show_product_switch($products_id_current, 'printing');
  $flag_show_product_bookx_info_publish_date = (int)zen_get_show_product_switch($products_id_current, 'publish_date');
  $flag_show_product_bookx_info_publisher = (int)zen_get_show_product_switch($products_id_current, 'publisher');
  $flag_show_product_bookx_info_publisher_as_link = (int)zen_get_show_product_switch($products_id_current, 'publisher_as_link');
  $flag_show_product_bookx_info_publisher_image = (int)zen_get_show_product_switch($products_id_current, 'publisher_image');
  $flag_show_product_bookx_info_publisher_url = (int)zen_get_show_product_switch($products_id_current, 'publisher_url');
  $flag_show_product_bookx_info_publisher_description = (int)zen_get_show_product_switch($products_id_current, 'publisher_description');
  $flag_show_product_bookx_info_series = (int)zen_get_show_product_switch($products_id_current, 'series');
  $flag_show_product_bookx_info_series_as_link = (int)zen_get_show_product_switch($products_id_current, 'series_as_link');
  $flag_show_product_bookx_info_series_image = (int)zen_get_show_product_switch($products_id_current, 'series_image');
  $flag_show_product_bookx_info_series_description = (int)zen_get_show_product_switch($products_id_current, 'series_description');
  $flag_show_product_bookx_info_size = (int)zen_get_show_product_switch($products_id_current, 'size');
  $flag_show_product_bookx_info_isbn = (int)zen_get_show_product_switch($products_id_current, 'isbn');
  $flag_show_product_bookx_info_subtitle = (int)zen_get_show_product_switch($products_id_current, 'subtitle');
  $flag_show_product_bookx_info_volume = (int)zen_get_show_product_switch($products_id_current, 'volume');


/*** Override Previous Next behaviour if desired */
if (BOOKX_NEXT_PREVIOUS_BASED_ON_FILTER && isset($_GET['typefilter']) && 'bookx' == $_GET['typefilter'])
{
	require(DIR_WS_MODULES . zen_get_module_directory('product_bookx_prev_next.php'));
}


/**
 * Retrieve relevant data from relational tables for the current products_id:
 */
    $tpl_page_body = '/tpl_product_bookx_info_display.php';

    $sql = 'SELECT be.*, bed.products_subtitle,
    		CASE WHEN DAYOFMONTH(be.publishing_date) THEN DATE_FORMAT(be.publishing_date, "' . DATE_FORMAT_SHORT . '")
										  WHEN MONTH(be.publishing_date) THEN DATE_FORMAT(be.publishing_date, "' . DATE_FORMAT_MONTH_AND_YEAR . '")
										  ELSE YEAR(be.publishing_date)
									 END AS formatted_publishing_date,
    		CONCAT_WS("-", SUBSTRING(be.isbn,1,3), SUBSTRING(be.isbn,4,1), SUBSTRING(be.isbn,5,6), SUBSTRING(be.isbn,11,2), SUBSTRING(be.isbn,13,1)) AS isbn_display FROM ' . TABLE_PRODUCT_BOOKX_EXTRA . ' be
    		LEFT JOIN ' . TABLE_PRODUCT_BOOKX_EXTRA_DESCRIPTION . ' bed ON bed.products_id = be.products_id AND bed.languages_id = "' . (int)$_SESSION['languages_id'] . '"
            WHERE be.products_id = "' . (int)$products_id_current . '"';

    // IF(DAYOFMONTH(be.publishing_date), DATE_FORMAT(be.publishing_date, "' . DATE_FORMAT_SHORT . '"), DATE_FORMAT(be.publishing_date, "' . DATE_FORMAT_MONTH_AND_YEAR . '")) AS formatted_publishing_date

    $bookx_extras = $db->Execute($sql);

   /* if ((int)$flag_show_product_bookx_info_authors_related_products) {
    	$related_products_field = ', relp.'
    }*/
    $bookx_upcoming_products_look_ahead_number_of_days = BOOKX_UPCOMING_PRODUCTS_LOOK_AHEAD_NUMBER_OF_DAYS;
    $bookx_new_products_look_back_number_of_days = BOOKX_NEW_PRODUCTS_LOOK_BACK_NUMBER_OF_DAYS;
    if (!empty($bookx_upcoming_products_look_ahead_number_of_days)) {
    	//*** WHERE condition: publishing_date is set and with maximum days into the future and past as set by Admin values "look ahead" and "look back"
    	$extra_where_condition = ' OR ((be.publishing_date IS NOT NULL) AND (DATEDIFF("' . date('Y-m-d') . '",
																						  CONCAT_WS("-",
																							        SUBSTRING(be.publishing_date, 1,4 ),
																							        IF(SUBSTRING(be.publishing_date, 6,2 ) = "00", "01", SUBSTRING(be.publishing_date, 6,2 ) ),
																							        IF(SUBSTRING(be.publishing_date, 9,2 )  = "00", "01", SUBSTRING(be.publishing_date, 9,2 ))))
																				 BETWEEN -' . intval($bookx_upcoming_products_look_ahead_number_of_days) . ' AND ' . intval($bookx_new_products_look_back_number_of_days);
    }

    /* WHEN relp.products_quantity = 0 AND (relbe.publishing_date IS NOT NULL) AND DATEDIFF("' . date('Y-m-d', time() - 604800) . '",
																						  CONCAT_WS("-",
																							        SUBSTRING(relbe.publishing_date, 1,4 ),
																							        IF(SUBSTRING(relbe.publishing_date, 6,2 ) = "00", "01", SUBSTRING(relbe.publishing_date, 6,2 ) ),
																							        IF(SUBSTRING(relbe.publishing_date, 9,2 )  = "00", "01", SUBSTRING(relbe.publishing_date, 9,2 ))))
																				 BETWEEN -' . intval($bookx_upcoming_products_look_ahead_number_of_days). ' AND 0 THEN "upcoming_product"
	*/

    $sql = 'SELECT a.*, a.author_url, ad.author_description, at.type_sort_order, atd.type_description, atd.type_image,
    			   COUNT(DISTINCT relatedatd.type_description) AS related_books_as_author_type_count, COUNT(DISTINCT relbe.bookx_series_id) AS related_series_count,
    			   GROUP_CONCAT(DISTINCT CONCAT_WS("$§$",
    									  COALESCE(relp.products_id, ""),
    									  COALESCE(relpd.products_name, ""),
    									  COALESCE(relbe.volume, ""),
    									  COALESCE(relbe.bookx_series_id, ""),
    									  COALESCE(relbed.products_subtitle, ""),
       									  COALESCE(relatedatp.bookx_author_type_id, ""),
    									  COALESCE(relatedatd.type_description, ""),
										  CASE WHEN relp.products_quantity = 0 AND (relp.products_date_available IS NULL) AND (relbe.publishing_date IS NULL OR relbe.publishing_date <= "' . date('Y-m-d 00:00:00', time()) . '") THEN "out_of_print"
										       WHEN relp.products_quantity = 0 AND (relp.products_date_available IS NOT NULL) AND (relbe.publishing_date IS NULL OR relbe.publishing_date < "' . date('Y-m-d 00:00:00', time()) . '") 
										                                       AND (relp.products_date_available >= "' . date('Y-m-d 00:00:00', time()) . '") THEN "temporarily_unavailable"
    										   WHEN (relbe.publishing_date IS NOT NULL) AND relbe.publishing_date >= "' . date('Y-m-d 00:00:00', time()) . '"
    																		   AND relbe.publishing_date <= "' . date('Y-m-d 00:00:00', time() + 86400 * intval($bookx_upcoming_products_look_ahead_number_of_days)) . '"
													THEN "upcoming_product"
    										   WHEN relp.products_quantity > 0 AND (relbe.publishing_date IS NOT NULL) AND relbe.publishing_date <= "' . date('Y-m-d 00:00:00', time()) . '"
    																		   AND relbe.publishing_date >= "' . date('Y-m-d 00:00:00', time() - 86400 * intval($bookx_new_products_look_back_number_of_days)) . '"
													THEN "new_product"

											  ELSE "in_stock"
										  END)
    							ORDER BY relpd.products_name ASC, CAST(relbe.volume AS UNSIGNED) ASC SEPARATOR "#§#")
    				AS related_products

    		FROM ' . TABLE_PRODUCT_BOOKX_AUTHORS . ' a
    		LEFT JOIN ' . TABLE_PRODUCT_BOOKX_AUTHORS_DESCRIPTION . ' ad ON ad.bookx_author_id = a.bookx_author_id AND ad.languages_id = "' . (int)$_SESSION['languages_id'] . '"
    		LEFT JOIN ' . TABLE_PRODUCT_BOOKX_AUTHORS_TO_PRODUCTS . ' atp ON atp.bookx_author_id = a.bookx_author_id
    		LEFT JOIN ' . TABLE_PRODUCT_BOOKX_AUTHOR_TYPES . ' at ON at.bookx_author_type_id = atp.bookx_author_type_id
    		LEFT JOIN ' . TABLE_PRODUCT_BOOKX_AUTHOR_TYPES_DESCRIPTION . ' atd ON atd.bookx_author_type_id = at.bookx_author_type_id AND atd.languages_id = "' . (int)$_SESSION['languages_id'] . '"
    		LEFT JOIN ' . TABLE_PRODUCT_BOOKX_AUTHORS_TO_PRODUCTS . ' relatedatp ON relatedatp.bookx_author_id = a.bookx_author_id AND relatedatp.products_id != "' . (int)$products_id_current . '"
    		LEFT JOIN ' . TABLE_PRODUCT_BOOKX_AUTHOR_TYPES_DESCRIPTION . ' relatedatd ON relatedatd.bookx_author_type_id = relatedatp.bookx_author_type_id AND relatedatd.languages_id = "' . (int)$_SESSION['languages_id'] . '"

    		LEFT JOIN ' . TABLE_PRODUCTS . ' relp ON relp.products_id = relatedatp.products_id AND relp.products_status = 1
    		LEFT JOIN ' . TABLE_PRODUCTS_DESCRIPTION . ' relpd ON relpd.products_id = relp.products_id AND relpd.language_id = "' . (int)$_SESSION['languages_id'] . '"
    		LEFT JOIN ' . TABLE_PRODUCT_BOOKX_EXTRA . ' relbe ON relbe.products_id = relp.products_id
    		LEFT JOIN ' . TABLE_PRODUCT_BOOKX_EXTRA_DESCRIPTION . ' relbed ON relbed.products_id = relp.products_id AND relbed.languages_id = "' . (int)$_SESSION['languages_id'] . '"

            WHERE atp.products_id = "' . (int)$products_id_current . '" AND (relbe.publishing_date IS NULL OR relbe.publishing_date <= "' . date('Y-m-d 00:00:00', time() + 86400 * intval($bookx_upcoming_products_look_ahead_number_of_days)) . '")
            GROUP BY a.bookx_author_id';

    switch ((int)$flag_order_product_bookx_info_authors_by) {
    	case 1:
    		$sql .= ' ORDER BY a.author_name ASC';
    	break;

    	case 2:
    		$sql .= ' ORDER BY a.author_sort_order ASC, a.author_name ASC';
    	break;

    	case 3:
    		$sql .= ' ORDER BY atd.type_description ASC, a.author_name ASC';
    	break;

    	case 4:
    		$sql .= ' ORDER BY at.type_sort_order ASC, a.author_name ASC';
    		break;
    }
    $db->Execute('SET SESSION group_concat_max_len = 4096');
    $authors = $db->Execute($sql);

    $products_by_same_team = array();
    $products_by_same_team_matched = array();

    if ($flag_show_product_bookx_info_authors_team_related_products && 1 < $authors->RecordCount() ) {
		$sql = '';
		$where = '';
		$team_names_display = '';
		$last_author = '';
    	while (!$authors->EOF) {
    		//**** Build a string of team names for display on product info page
    		if (empty($team_names_display)) {
    			$team_names_display = (!empty($authors->fields['author_name']) ? $authors->fields['author_name'] : '');
    		} elseif (!empty($last_author)) {
    			$team_names_display .= ', ' . $last_author;
    			$last_author = (!empty($authors->fields['author_name']) ? $authors->fields['author_name'] : '');
    		} else {
    			$last_author = (!empty($authors->fields['author_name']) ? $authors->fields['author_name'] : '');
    		}

    		if (empty($sql)) { // first iteration of loop
    			$sql = 'SELECT atp.products_id FROM ' . TABLE_PRODUCT_BOOKX_AUTHORS_TO_PRODUCTS . ' atp ';
    			$where = ' WHERE atp.bookx_author_id = "' . $authors->fields['bookx_author_id'] . '"';
    		} else {
    			$sql .= ' , ' . TABLE_PRODUCT_BOOKX_AUTHORS_TO_PRODUCTS . ' atp'.$authors->fields['bookx_author_id'];
    			$where .= ' AND atp'.$authors->fields['bookx_author_id'] . '.products_id = atp.products_id AND atp'.$authors->fields['bookx_author_id'] . '.bookx_author_id = "' . $authors->fields['bookx_author_id'] . '"';
    		}
    		$authors->MoveNext();
    	}
    	$authors->Move(0);

    	// This seemed to be necessary in ZC Versions up to 1.5.3, but not anymore in 1.5.5
		if (1 <= intval(PROJECT_VERSION_MAJOR) && '5.5' < floatval(PROJECT_VERSION_MINOR)) {
    	   $authors->cursor = 0;    	    	
    	   $authors->MoveNext(); // There must be a better way to reset the result, but I can't seem to find a way....   	        
    	}

    	if (!empty($last_author)) {
    		$team_names_display .= ' ' . TEXT_AUTHOR_TEAM_AND . ' ' . $last_author;
    	}

    	$where .= ' GROUP BY atp.products_id';
    	$sql .= $where;
    	$result = $db->Execute($sql);
    	while (!$result->EOF) {
    		$products_by_same_team[] = $result->fields['products_id'];
    		$result->MoveNext();
    	}

    }

    $sql = 'SELECT g.bookx_genre_id, g.genre_sort_order, gd.genre_description, gd.genre_image FROM ' . TABLE_PRODUCT_BOOKX_GENRES . ' g
    		LEFT JOIN ' . TABLE_PRODUCT_BOOKX_GENRES_DESCRIPTION . ' gd ON gd.bookx_genre_id = g.bookx_genre_id AND gd.languages_id = "' . (int)$_SESSION['languages_id'] . '"
    		LEFT JOIN ' . TABLE_PRODUCT_BOOKX_GENRES_TO_PRODUCTS . ' gtp ON gtp.bookx_genre_id = g.bookx_genre_id

    		WHERE gtp.products_id = "' . (int)$products_id_current . '" ';

    switch ((int)$flag_order_product_bookx_info_genres_by) {
    	case 1:
    		$sql .= 'ORDER BY gd.genre_description ASC';
    		break;

    	case 2:
    		$sql .= 'ORDER BY g.genre_sort_order ASC, gd.genre_description ASC';
    		break;
        }

    $genres = $db->Execute($sql);

    $sql = 'SELECT *  FROM ' . TABLE_PRODUCT_BOOKX_PUBLISHERS . ' p
    		LEFT JOIN ' . TABLE_PRODUCT_BOOKX_PUBLISHERS_DESCRIPTION . ' pd ON pd.bookx_publisher_id = p.bookx_publisher_id AND pd.languages_id = "' . (int)$_SESSION['languages_id'] . '"
    		WHERE p.bookx_publisher_id = "' . (int)$bookx_extras->fields['bookx_publisher_id'] . '"';

    $publisher = $db->Execute($sql);

    $sql = 'SELECT *  FROM ' . TABLE_PRODUCT_BOOKX_SERIES . ' s
    		LEFT JOIN ' . TABLE_PRODUCT_BOOKX_SERIES_DESCRIPTION . ' sd ON sd.bookx_series_id = s.bookx_series_id AND sd.languages_id = "' . (int)$_SESSION['languages_id'] . '"
    		WHERE s.bookx_series_id = "' . (int)$bookx_extras->fields['bookx_series_id'] . '"';

    $series = $db->Execute($sql);

    $sql = 'SELECT *  FROM ' . TABLE_PRODUCT_BOOKX_IMPRINTS . ' i
    		LEFT JOIN ' . TABLE_PRODUCT_BOOKX_IMPRINTS_DESCRIPTION . ' id ON id.bookx_imprint_id = i.bookx_imprint_id AND id.languages_id = "' . (int)$_SESSION['languages_id'] . '"
    		WHERE i.bookx_imprint_id = "' . (int)$bookx_extras->fields['bookx_imprint_id'] . '"';

    $imprint = $db->Execute($sql);

    $sql = 'SELECT bd.binding_description  FROM ' . TABLE_PRODUCT_BOOKX_BINDING . ' b
    		LEFT JOIN ' . TABLE_PRODUCT_BOOKX_BINDING_DESCRIPTION . ' bd ON bd.bookx_binding_id = b.bookx_binding_id AND bd.languages_id = "' . (int)$_SESSION['languages_id'] . '"
    		WHERE b.bookx_binding_id = "' . (int)$bookx_extras->fields['bookx_binding_id'] . '"';

    $binding = $db->Execute($sql);

    $sql = 'SELECT pd.printing_description  FROM ' . TABLE_PRODUCT_BOOKX_PRINTING . ' p
    		LEFT JOIN ' . TABLE_PRODUCT_BOOKX_PRINTING_DESCRIPTION . ' pd ON pd.bookx_printing_id = p.bookx_printing_id AND pd.languages_id = "' . (int)$_SESSION['languages_id'] . '"
    		WHERE p.bookx_printing_id = "' . (int)$bookx_extras->fields['bookx_printing_id'] . '"';

    $printing = $db->Execute($sql);

    $sql = 'SELECT cd.condition_description  FROM ' . TABLE_PRODUCT_BOOKX_CONDITIONS . ' c
    		LEFT JOIN ' . TABLE_PRODUCT_BOOKX_CONDITIONS_DESCRIPTION . ' cd ON cd.bookx_condition_id = c.bookx_condition_id AND cd.languages_id = "' . (int)$_SESSION['languages_id'] . '"
    		WHERE c.bookx_condition_id = "' . (int)$bookx_extras->fields['bookx_condition_id'] . '"';

    $condition = $db->Execute($sql);



/*
 * extract info from queries for use as template-variables:
 */
    function sort_related($a,$b){
    	$a = $a['products_name'];
    	$b = $b['products_name'];

    	$diff_len = strlen($b)-strlen($a);

    	$cmp = strcasecmp(substr($a, 0, strlen($a)+$diff_len), substr($b, 0, strlen($a)+$diff_len));

    	if (0 == $cmp && $diff_len > 0) {
    		$cmp = 1;
    	}

    	return $cmp;
    }

  $products_authors = array();
  $related_products_by_author_team = null;

  while (!$authors->EOF) {
  	$current_author = array();
  	$current_author['name'] = (!empty($authors->fields['author_name']) ? $authors->fields['author_name'] : '');
  	$current_author['image'] = (!empty($authors->fields['author_image']) ? DIR_WS_IMAGES . $authors->fields['author_image'] : '');
  	$current_author['image_copyright'] = (!empty($authors->fields['author_image_copyright']) ? $authors->fields['author_image_copyright'] : '');
  	$current_author['sort_order'] = (!empty($authors->fields['author_sort_order']) ? $authors->fields['author_sort_order'] : '0');
  	$current_author['url'] = (!empty($authors->fields['author_url']) ? (strpos($authors->fields['author_url'], 'http') ? $authors->fields['author_url'] : 'http://' . $authors->fields['author_url']) : '');
  	$current_author['description'] = (!empty($authors->fields['author_description']) ? $authors->fields['author_description'] : '');
  	$current_author['type'] = (!empty($authors->fields['type_description']) ? $authors->fields['type_description'] : '');
  	$current_author['type_image'] = (!empty($authors->fields['type_image']) ? DIR_WS_IMAGES . $authors->fields['type_image'] : '');
  	$current_author['type_sort_order'] = (!empty($authors->fields['type_sort_order']) ? $authors->fields['type_sort_order'] : '0');
  	$current_author['searchlink'] = (!empty($authors->fields['bookx_author_id']) && !empty($authors->fields['author_name']) ? '<a href="' .  zen_href_link(FILENAME_DEFAULT, '&typefilter=bookx&bookx_author_id=' . $authors->fields['bookx_author_id']) . '" class="bookx_searchlink">' . $authors->fields['author_name'] . '</a>' : '');

  	switch ((int)$flag_show_product_bookx_info_authors_related_products) {
  		case 1:
  		case 2:
  			if (!empty($authors->fields['related_products'])) {
	  			$related_products = array();

	  			$temp_relp_array = explode('#§#', $authors->fields['related_products']); // split concatenated string from query into single product entries
	  			foreach ($temp_relp_array as $value) {
	  				$temp_relp_entry = explode('$§$', $value); // split single product entry into products_id and products_name
	  				if(!empty($temp_relp_entry[0])) { //*** if product_id is empty then we don't actually have a product
						$related_product = array('products_name' => $temp_relp_entry[1],
		  											'products_id' => $temp_relp_entry[0],
		  											'volume' => $temp_relp_entry[2],
		  											'products_link' => (!empty($temp_relp_entry[0]) ? zen_href_link(zen_get_info_page($temp_relp_entry[0]), 'products_id=' . $temp_relp_entry[0]) : 0),
		  											'bookx_series_id' => $temp_relp_entry[3],
		   											'products_subtitle' => $temp_relp_entry[4],
		  											'bookx_author_type_id' => $temp_relp_entry[5],
		  											'author_type_name' => $temp_relp_entry[6],
		  											'bookx_product_status' => $temp_relp_entry[7]);

		  				if ($flag_show_product_bookx_info_authors_team_related_products && !empty($products_by_same_team) ) {
		  					if (in_array($related_product['products_id'], $products_by_same_team)) {
		  						//**** this related product is by the same author team as current product
		  						if (!in_array($related_product['products_id'], $products_by_same_team_matched)) {
			  						$related_products_by_author_team[] = $related_product;
			  						$products_by_same_team_matched[] = $related_product['products_id'];
		  						}
		  					} else {
		  						$related_products[] = $related_product;
		  					}
		  				} else {
		  					$related_products[] = $related_product;
		  				}
					}
	  			}

	  			//usort($related_products,'sort_related');


	  			$current_author['related_products'] = $related_products;
	  			$current_author['related_books_as_author_type_count'] = $authors->fields['related_books_as_author_type_count'];
	  			$current_author['related_series_count'] = $authors->fields['related_series_count'];
  			} else {
  				$current_author['related_products'] = false;
  			}
  			break;

  		default:
  			$current_author['related_products'] = false;
  			break;
  	}
  	$products_authors[] = $current_author;
  	$authors->MoveNext();
  }

  $products_genres = array();
  while (!$genres->EOF) {
  	$products_genres[] = array('name' => (!empty($genres->fields['genre_description']) ? $genres->fields['genre_description'] : ''),
  							   'sort_order' => (!empty($genres->fields['genre_sort_order']) ? $genres->fields['genre_sort_order'] : '0'),
  							   'image' => (!empty($genres->fields['genre_image']) ? DIR_WS_IMAGES . $genres->fields['genre_image'] : ''),
  							   'searchlink' => (!empty($genres->fields['bookx_genre_id']) && !empty($genres->fields['genre_description']) ? '<a href="' .  zen_href_link(FILENAME_DEFAULT, '&typefilter=bookx&bookx_genre_id=' . $genres->fields['bookx_genre_id']) . '" class="bookx_searchlink">' . $genres->fields['genre_description'] . '</a>' : ''),
  							   'image_searchlink' => (!empty($genres->fields['bookx_genre_id']) && !empty($genres->fields['genre_image']) ? '<a href="' .  zen_href_link(FILENAME_DEFAULT, '&typefilter=bookx&bookx_genre_id=' . $genres->fields['bookx_genre_id']) . '" class="bookx_searchlink">' . zen_image(DIR_WS_IMAGES . $genres->fields['genre_image'], $genres->fields['genre_description'], BOOKX_ICONS_MAX_WIDTH, BOOKX_ICONS_MAX_HEIGHT). '</a>' : '')
 							 	);
  	$genres->MoveNext();
  }

  $products_subtitle = (!empty($bookx_extras->fields['products_subtitle']) ? $bookx_extras->fields['products_subtitle'] : '');
  $products_binding = (!empty($binding->fields['binding_description']) ? $binding->fields['binding_description'] : '');
  $products_printing = (!empty($printing->fields['printing_description']) ? $printing->fields['printing_description'] : '');
  $products_condition = (!empty($condition->fields['condition_description']) ? $condition->fields['condition_description'] : '');
  $products_pages = (!empty($bookx_extras->fields['pages']) ? $bookx_extras->fields['pages'] : '');
  $products_volume = (!empty($bookx_extras->fields['volume']) ? $bookx_extras->fields['volume'] : '');
  $products_size = (!empty($bookx_extras->fields['size']) ? $bookx_extras->fields['size'] : '');
  $products_isbn = (!empty($bookx_extras->fields['isbn_display']) ? $bookx_extras->fields['isbn_display'] : '');
  $products_publishing_date = (!empty($bookx_extras->fields['formatted_publishing_date']) ? $bookx_extras->fields['formatted_publishing_date'] : ''); //zen_date_short($bookx_extras->fields['publishing_date']) : '');

  $products_publisher_name = (!empty($publisher->fields['publisher_name']) ? $publisher->fields['publisher_name'] : '');
  $products_publisher_image = (!empty($publisher->fields['publisher_image']) ? DIR_WS_IMAGES . $publisher->fields['publisher_image'] : '');
  $products_publisher_description = (!empty($publisher->fields['publisher_description']) ? $publisher->fields['publisher_description'] : '');
  $products_publisher_url = (!empty($publisher->fields['publisher_url']) ? (strpos($publisher->fields['publisher_url'], 'http') ? $publisher->fields['publisher_url'] : 'http://' . $publisher->fields['publisher_url']) : '');
  $products_publisher_searchlink = (!empty($publisher->fields['bookx_publisher_id']) && !empty($publisher->fields['publisher_name']) ? '<a href="' .  zen_href_link(FILENAME_DEFAULT, '&typefilter=bookx&bookx_publisher_id=' . $publisher->fields['bookx_publisher_id']) . '" class="bookx_searchlink">' . $publisher->fields['publisher_name'] . '</a>' : '');

  if (!empty($products_publisher_image) && !empty($publisher->fields['bookx_publisher_id'])) {
  	$products_publisher_image_searchlink = '<a href="' .  zen_href_link(FILENAME_DEFAULT, '&typefilter=bookx&bookx_publisher_id=' . $publisher->fields['bookx_publisher_id']) . '" class="bookx_searchlink">' . zen_image($products_publisher_image, $products_publisher_name, BOOKX_ICONS_MAX_WIDTH, BOOKX_ICONS_MAX_HEIGHT) . '</a>';
  } else {
  	$products_publisher_image_searchlink = '';
  }

  $products_series_name = (!empty($series->fields['series_name']) ? $series->fields['series_name'] : '');
  $products_series_searchlink = (!empty($series->fields['bookx_series_id']) && !empty($series->fields['series_name']) ? '<a href="' .  zen_href_link(FILENAME_DEFAULT, '&typefilter=bookx&bookx_series_id=' . $series->fields['bookx_series_id']) . '" class="bookx_searchlink">' . $series->fields['series_name'] . '</a>' : '');
  $products_series_image = (!empty($series->fields['series_image']) ? DIR_WS_IMAGES . $series->fields['series_image'] : '');
  $products_series_description = (!empty($series->fields['series_description']) ? $series->fields['series_description'] : '');
  if (!empty($products_series_image) && !empty($series->fields['bookx_series_id'])) {
  	$products_series_image_searchlink = '<a href="' .  zen_href_link(FILENAME_DEFAULT, '&typefilter=bookx&bookx_series_id=' . $series->fields['bookx_series_id']) . '" class="bookx_searchlink">' . zen_image($products_series_image, $products_series_name, BOOKX_ICONS_MAX_WIDTH, BOOKX_ICONS_MAX_HEIGHT) . '</a>';
  } else {
  	$products_series_image_searchlink = '';
  }

  $products_imprint_name = (!empty($imprint->fields['imprint_name']) ? $imprint->fields['imprint_name'] : '');
  $products_imprint_searchlink = (!empty($imprint->fields['bookx_imprint_id']) && !empty($imprint->fields['imprint_name']) ? '<a href="' .  zen_href_link(FILENAME_DEFAULT, '&typefilter=bookx&bookx_bookx_imprint_id=' . $imprint->fields['bookx_imprint_id']) . '" class="bookx_searchlink">' . $imprint->fields['imprint_name'] . '</a>' : '');
  $products_imprint_image = (!empty($imprint->fields['imprint_image']) ? DIR_WS_IMAGES . $imprint->fields['imprint_image'] : '');
  $products_imprint_description = (!empty($imprint->fields['imprint_description']) ? $imprint->fields['imprint_description'] : '');

  if (!empty($products_imprint_image) && !empty($imprint->fields['bookx_imprint_id'])) {
  	$products_imprint_image_searchlink = '<a href="' .  zen_href_link(FILENAME_DEFAULT, '&typefilter=bookx&bookx_bookx_imprint_id=' . $imprint->fields['bookx_imprint_id']) . '" class="bookx_searchlink">' . zen_image($products_imprint_image, $products_imprint_name, BOOKX_ICONS_MAX_WIDTH, BOOKX_ICONS_MAX_HEIGHT) . '</a>';
  } else {
  	$products_imprint_image_searchlink = '';
  }
  // This should be last line of the script:
  $zco_notifier->notify('NOTIFY_PRODUCT_TYPE_VARS_END_PRODUCT_BOOKX_INFO');