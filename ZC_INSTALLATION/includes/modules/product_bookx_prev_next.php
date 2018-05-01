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
 * @version $Id: [ZC INSTALLATION]/includes/modules/product_bookx_prev_next.php  2016-02-02 philou $
 */

if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
// bof: previous next
if (PRODUCT_INFO_PREVIOUS_NEXT != 0) {
	$active_boox_get_filters = 'typefilter=bookx';

	$zc_filter_id = (isset($_GET['filter_id']) ? $_GET['filter_id'] : null);
	$filtered_author_id = (isset($_GET['bookx_author_id']) && 'all' != $_GET['bookx_author_id'] ? $_GET['bookx_author_id'] : null);
	$filtered_author_type_id = (isset($_GET['bookx_author_type_id']) && 'all' != $_GET['bookx_author_type_id'] ? $_GET['bookx_author_type_id'] : null);
	$filtered_publisher_id = (isset($_GET['bookx_publisher_id']) && 'all' != $_GET['bookx_publisher_id'] ? $_GET['bookx_publisher_id'] : null);
	$filtered_imprint_id = (isset($_GET['bookx_imprint_id']) && 'all' != $_GET['bookx_imprint_id'] ? $_GET['bookx_imprint_id'] : null);
	$filtered_series_id = (isset($_GET['bookx_series_id']) && 'all' != $_GET['bookx_series_id'] ? $_GET['bookx_series_id'] : null);
	$filtered_genre_id = (isset($_GET['bookx_genre_id']) && 'all' != $_GET['bookx_genre_id'] ? $_GET['bookx_genre_id'] : null);
    $filtered_for_upcoming = (isset($_GET['bookx_publishing_status']) && 'upcoming' == $_GET['bookx_publishing_status'] ? true : null);
    $filtered_for_new = (isset($_GET['bookx_publishing_status']) && 'new' == $_GET['bookx_publishing_status'] ? true : null);

	$flag_show_only_stocked = false;

	if (!$filtered_for_upcoming && !$filtered_for_new
	    && (BOOKX_AUTHOR_LISTING_SHOW_ONLY_STOCKED ||
			BOOKX_GENRE_LISTING_SHOW_ONLY_STOCKED ||
			BOOKX_IMPRINT_LISTING_SHOW_ONLY_STOCKED ||
			BOOKX_PUBLISHER_LISTING_SHOW_ONLY_STOCKED ||
			BOOKX_SERIES_LISTING_SHOW_ONLY_STOCKED)
		&& !(isset($_GET['bookx_include_out_of_stock']) && $_GET['bookx_include_out_of_stock'])) {
		$flag_show_only_stocked = true;
	}

	$select_table_list = ' FROM '. TABLE_PRODUCTS . ' p
	                       LEFT JOIN ' . TABLE_PRODUCTS_DESCRIPTION . ' pd ON (pd.products_id = p.products_id AND pd.language_id = "' . (int)$_SESSION['languages_id'] . '")
	                       LEFT JOIN ' . TABLE_PRODUCT_BOOKX_EXTRA . ' be ON be.products_id = p.products_id 
						   LEFT JOIN ' . TABLE_PRODUCT_BOOKX_EXTRA_DESCRIPTION . ' bed ON bed.products_id = p.products_id ';


	$select_where_conditions = ' p.products_status = 1 ';
	$select_where_extra_filter_condition = '';
    $extra_having = '';
    $additional_bookx_fields = '';

	if($flag_show_only_stocked) {
		$extra_lookahead_clause = '';

		if (BOOKX_UPCOMING_PRODUCTS_LOOK_AHEAD_NUMBER_OF_DAYS) {
			$look_ahead_cutoff = date('Y-m-d H:i:s', time() + 86400 * intval(BOOKX_UPCOMING_PRODUCTS_LOOK_AHEAD_NUMBER_OF_DAYS));
			$extra_lookahead_clause = ' OR be.publishing_date <= "' . $look_ahead_cutoff . '"';
		} else {
			$look_ahead_cutoff = date('Y-m-d H:i:s', time()- (86400*60));
		}
		$select_where_conditions .= ' AND (p.products_quantity > 0 OR p.products_date_available >= "' . date('Y-m-d H:i:s', time()- (86400*60)) . '" ' . $extra_lookahead_clause . ')'; // 86400 * 60 = 60 days
	}

    if($filtered_for_upcoming) {
        $active_boox_get_filters .= '&bookx_publishing_status=upcoming';

        $bookx_upcoming_products_look_ahead_number_of_days = BOOKX_UPCOMING_PRODUCTS_LOOK_AHEAD_NUMBER_OF_DAYS;
        $bookx_new_products_look_back_number_of_days = BOOKX_NEW_PRODUCTS_LOOK_BACK_NUMBER_OF_DAYS;

        if (!empty($bookx_upcoming_products_look_ahead_number_of_days)) {
            //*** WHERE condition: publishing_date is set and with maximum days into the future and past as set by Admin values "look ahead" and "look back"

            $additional_bookx_fields .= ',p.products_quantity,be.publishing_date,p.products_date_available as date_expected,
    		                                 DATEDIFF("' . date('Y-m-d') . '",
													  CONCAT_WS("-",
														        SUBSTRING(be.publishing_date, 1,4 ),
														        IF(SUBSTRING(be.publishing_date, 6,2 ) = "00", "01", SUBSTRING(be.publishing_date, 6,2 ) ),
														        IF(SUBSTRING(be.publishing_date, 9,2 )  = "00", "01", SUBSTRING(be.publishing_date, 9,2 ))
                                                               )
                                                      ) AS pubdate_diff_today';

            //$extra_having = ' AND p.products_quantity < 1';
            $extra_having = ' HAVING (be.publishing_date IS NOT NULL)  /* we have a BookX publishing date entered */
    		                      AND (
    		                              /* pub date is less than "number of days to look AHEAD" into the future */
    		                             (pubdate_diff_today BETWEEN -' . intval($bookx_upcoming_products_look_ahead_number_of_days) . ' AND 0)
    		                           OR
    		                             /* pub date is less than "number of days to look BACK" into the past (i.e. a "new" product) but stock is still zero and no date expected is set or in the past*/
    		                             (( pubdate_diff_today BETWEEN 0 AND ' . intval($bookx_new_products_look_back_number_of_days) . ') AND p.products_quantity < 1 AND (date_expected IS NULL OR date_expected < "' . date('Y-m-d') . '"))
    		                          )';
        }

        //$select_where_conditions .= ' AND (p.products_quantity > 0 OR p.products_date_available >= "' . date('Y-m-d H:i:s', time()- (86400*60)) . '" ' . $extra_lookahead_clause . ')'; // 86400 * 60 = 60 days
    }

    if($filtered_for_new) {
        $active_boox_get_filters .= '&bookx_publishing_status=new';

        $bookx_new_products_look_back_number_of_days = BOOKX_NEW_PRODUCTS_LOOK_BACK_NUMBER_OF_DAYS;

        if (!empty($bookx_new_products_look_back_number_of_days)) {
            $additional_bookx_fields .= ',p.products_quantity, be.publishing_date,p.products_date_available,
    		                                 DATEDIFF("' . date('Y-m-d') . '",
													  CONCAT_WS("-",
														        SUBSTRING(be.publishing_date, 1,4 ),
														        IF(SUBSTRING(be.publishing_date, 6,2 ) = "00", "01", SUBSTRING(be.publishing_date, 6,2 ) ),
														        IF(SUBSTRING(be.publishing_date, 9,2 )  = "00", "01", SUBSTRING(be.publishing_date, 9,2 ))
                                                               )
                                                      ) AS pubdate_diff_today';
            $extra_having = ' HAVING (be.publishing_date IS NOT NULL)  /* we have a BookX publishing date enterd */
    		                      AND (   		                            
    		                             /* pub date is less than "number of days to look BACK" into the past (i.e. a "new" product) and stock is more than zero or date expected is set */
    		                             (( pubdate_diff_today BETWEEN 0 AND ' . intval($bookx_new_products_look_back_number_of_days) . ') AND (p.products_quantity > 0 OR (p.products_date_available IS NOT NULL AND p.products_date_available >= "' . date('Y-m-d') . '")))
    		                          )';
        }
	}

	if ($zc_filter_id) {
		$select_table_list .= ' LEFT JOIN ' . TABLE_PRODUCTS_TO_CATEGORIES . ' p2c ON p2c.products_id = p.products_id ';
		if (isset($_GET['manufacturers_id']) && $_GET['manufacturers_id'] != '' ) {
			$select_table_list .= 'LEFT JOIN ' . TABLE_MANUFACTURERS . ' m ON m.manufacturers_id = p.manufacturers_id ';
			$select_where_extra_filter_condition = ' AND m.manufacturers_id = "' . (int)$zc_filter_id . '" ';
		} else {
			// We are asked to show only a specific category
			$select_where_extra_filter_condition = ' AND p2c.categories_id = "' . (int)$zc_filter_id . '" ';
		}
	}

	if ($filtered_author_id) {
		$active_boox_get_filters .= '&bookx_author_id=' . $_GET['bookx_author_id'];

		// We are asked to show books by a specific author
		$select_table_list .= ' LEFT JOIN ' . TABLE_PRODUCT_BOOKX_AUTHORS_TO_PRODUCTS . ' batpfilt ON batpfilt.products_id = be.products_id ';
		/*LEFT JOIN ' . TABLE_PRODUCT_BOOKX_AUTHORS . ' ba ON ba.bookx_author_id = batp.bookx_author_id
		LEFT JOIN ' . TABLE_PRODUCT_BOOKX_AUTHORS_DESCRIPTION . ' bad ON bad.bookx_author_id = ba.bookx_author_id AND bad.languages_id = "' . (int)$_SESSION['languages_id'] . '"';*/
		$select_where_conditions .= ' AND batpfilt.bookx_author_id = "' . (int)$filtered_author_id . '" ';
	}

	if ($filtered_author_type_id && $filtered_author_id) {
		$active_boox_get_filters .= '&bookx_author_type_id=' . $_GET['bookx_author_type_id'];

		// We are asked to show books by a specific author type
		$select_table_list .= ' LEFT JOIN ' . TABLE_PRODUCT_BOOKX_AUTHOR_TYPES . ' batfilt ON batfilt.bookx_author_type_id = batpfilt.bookx_author_type_id';
		$select_where_conditions .= ' AND batfilt.bookx_author_type_id = "' . (int)$filtered_author_type_id . '" ';
	}

	if ($filtered_publisher_id) {
		$active_boox_get_filters .= '&bookx_publisher_id=' . $_GET['bookx_publisher_id'];

		// We are asked to show books by a specific publisher
		$select_table_list .= ' LEFT JOIN ' . TABLE_PRODUCT_BOOKX_PUBLISHERS . ' bp ON bp.bookx_publisher_id = be.bookx_publisher_id
    						LEFT JOIN ' . TABLE_PRODUCT_BOOKX_PUBLISHERS_DESCRIPTION . ' bpd ON bpd.bookx_publisher_id = be.bookx_publisher_id AND bpd.languages_id = "' . (int)$_SESSION['languages_id'] . '" ';
		$select_where_conditions .= ' AND bp.bookx_publisher_id = "' . (int)$filtered_publisher_id . '" ';
	}

	if ($filtered_imprint_id) {
		$active_boox_get_filters .= '&bookx_imprint_id=' . $_GET['bookx_imprint_id'];

		// We are asked to show books by a specific imprint
		$select_table_list .= ' LEFT JOIN ' . TABLE_PRODUCT_BOOKX_IMPRINTS . ' bi ON bi.bookx_imprint_id = be.bookx_imprint_id
    						LEFT JOIN ' . TABLE_PRODUCT_BOOKX_IMPRINTS_DESCRIPTION . ' bid ON bid.bookx_imprint_id = bi.bookx_imprint_id AND bid.languages_id = "' . (int)$_SESSION['languages_id'] . '" ';
		$select_where_conditions .= ' AND bi.bookx_imprint_id = "' . (int)$filtered_imprint_id . '" ';
	}

	if ($filtered_series_id) {
		$active_boox_get_filters .= '&bookx_series_id=' . $_GET['bookx_series_id'];

		// We are asked to show books by a specific series
		$select_table_list .= ' LEFT JOIN ' . TABLE_PRODUCT_BOOKX_SERIES_DESCRIPTION . ' bsd ON bsd.bookx_series_id = be.bookx_series_id AND bsd.languages_id = "' . (int)$_SESSION['languages_id'] . '" ';
		$select_where_conditions .= ' AND bsd.bookx_series_id = "' . (int)$filtered_series_id . '" ';
	}

	if ($filtered_genre_id) {
		$active_boox_get_filters .= '&bookx_genre_id=' . $_GET['bookx_genre_id'];

		// We are asked to show books by a specific genre
		$select_table_list .= ' LEFT JOIN ' . TABLE_PRODUCT_BOOKX_GENRES_TO_PRODUCTS . ' bgtp ON bgtp.products_id = be.products_id
							LEFT JOIN ' . TABLE_PRODUCT_BOOKX_GENRES . ' bg ON bgtp.bookx_genre_id = bg.bookx_genre_id
							LEFT JOIN ' . TABLE_PRODUCT_BOOKX_GENRES_DESCRIPTION . ' bgd ON bgd.bookx_genre_id = bgtp.bookx_genre_id AND bgd.languages_id = "' . (int)$_SESSION['languages_id'] . '" ';
		$select_where_conditions .= ' AND bg.bookx_genre_id = "' . (int)$filtered_genre_id . '" ';
	}

	if ($search_term_active) {
        $select_table_list .= ' LEFT JOIN ' . TABLE_PRODUCT_BOOKX_EXTRA . ' srchbe ON srchbe.products_id = p.products_id
				        LEFT JOIN ' . TABLE_PRODUCT_BOOKX_EXTRA_DESCRIPTION . ' srchbed ON srchbed.products_id = p.products_id AND srchbed.languages_id = "' . (int)$_SESSION['languages_id'] . '"
				        LEFT JOIN ' . TABLE_PRODUCT_BOOKX_AUTHORS_TO_PRODUCTS . ' srchbatp ON srchbatp.products_id = p.products_id
				        LEFT JOIN ' . TABLE_PRODUCT_BOOKX_AUTHORS . ' srchba ON srchba.bookx_author_id = srchbatp.bookx_author_id
				        LEFT JOIN ' . TABLE_PRODUCT_BOOKX_IMPRINTS . ' srchbi ON srchbi.bookx_imprint_id = srchbe.bookx_imprint_id
				        LEFT JOIN ' . TABLE_PRODUCT_BOOKX_PUBLISHERS . ' srchbpub ON srchbpub.bookx_publisher_id = srchbe.bookx_publisher_id
				        LEFT JOIN ' . TABLE_PRODUCT_BOOKX_SERIES_DESCRIPTION . ' srchbsd ON srchbsd.bookx_series_id = srchbe.bookx_series_id
				     	LEFT JOIN ' . TABLE_PRODUCT_BOOKX_GENRES_TO_PRODUCTS . ' srchbgtp ON srchbgtp.products_id = srchbe.products_id
				     	LEFT JOIN ' . TABLE_PRODUCT_BOOKX_GENRES_DESCRIPTION . ' srchbgd ON srchbgd.bookx_genre_id = srchbgtp.bookx_genre_id ';

        for ($i=0, $n=sizeof($search_keywords); $i<$n; $i++ ) {
            //$extra_where = '';
            switch ($search_keywords[$i]) {
            case '(':
            case ')':
            case 'and':
            case 'or':
                //$extra_where .= " " . $search_keywords[$i] . " ";
                break;
            default:

                $extra_where = " OR srchbed.products_subtitle LIKE '%:keywords%'
									  OR srchba.author_name LIKE '%:keywords%'
									  OR srchbpub.publisher_name LIKE '%:keywords%'
									  OR srchbsd.series_name LIKE '%:keywords%'
									  OR srchbgd.genre_description LIKE '%:keywords%'
									  OR srchbi.imprint_name LIKE '%:keywords%'";

                $isbn_test = str_replace('-', '', $search_keywords[$i]);
                if (ctype_digit($isbn_test)) {
                    $extra_where .= " OR srchbe.isbn LIKE '%" . $isbn_test . "%'";
                }

                $extra_where = $db->bindVars($extra_where, ':keywords', $search_keywords[$i], 'noquotestring');

                $where_str = str_replace("pd.products_name LIKE '%" . $search_keywords[$i] . "%'", "pd.products_name LIKE '%" . $search_keywords[$i] . "%'" . $extra_where, $where_str);
                break;
            }
        }
    }




	// sort order
	switch(PRODUCT_INFO_PREVIOUS_NEXT_SORT) {
		case (0):
		$prev_next_order= ' ORDER by LPAD(p.products_id,11,"0")';
		break;
		case (1):
		$prev_next_order= ' ORDER by pd.products_name, bed.products_subtitle';
		break;
		case (2):
		$prev_next_order= ' ORDER by be.isbn, p.products_model';
		break;
		case (3):
		$prev_next_order= ' ORDER by p.products_price_sorter, pd.products_name, bed.products_subtitle';
		break;
		case (4):
		$prev_next_order= ' ORDER by p.products_price_sorter, be.isbn, p.products_model';
		break;
		case (5):
		$prev_next_order= ' ORDER by pd.products_name, bed.products_subtitle, be.isbn, p.products_model';
		break;
		case (6):
		$prev_next_order= ' ORDER by LPAD(p.products_sort_order,11,"0"), pd.products_name, bed.products_subtitle';
		break;
		default:
		$prev_next_order= ' ORDER by pd.products_name, bed.products_subtitle';
		break;
	}

  $sql = 'SELECT p.products_id, p.products_model, p.products_price_sorter, pd.products_name, p.products_sort_order, p.products_image ' . $additional_bookx_fields
          . $select_table_list . ' WHERE ' . $select_where_conditions . $select_where_extra_filter_condition
          . ' GROUP BY p.products_id '
          . $extra_having
          . $prev_next_order; //. $alpha_sort

  $products_ids = $db->Execute($sql);
  $products_found_count = $products_ids->RecordCount();
  $id_array = array();

  while (!$products_ids->EOF) {
    $id_array[] = $products_ids->fields['products_id'];
    $products_ids->MoveNext();
  }

  // fix first & last items
  if (is_array($id_array)) {
    reset ($id_array);
    $counter = 0;
    foreach ($id_array as $key => $value) {
      if ($value == (int)$_GET['products_id']) {
        $position = $counter;
        if ($key == 0) {
          $previous = -1; // it was the first to be found
        } else {
          $previous = $id_array[$key - 1];
        }
        if (isset($id_array[$key + 1]) && $id_array[$key + 1]) {
          $next_item = $id_array[$key + 1];
        } else {
          $next_item = $id_array[0];
        }
      }
      $last = $value;
      $counter++;
    }

    if ($previous == -1) $previous = $last;
  } // if is_array

}
// eof: previous next