<?php
/**
 * This file is part of the ZenCart add-on Book X which
 * introduces a new product type for books to the Zen Cart
 * shop system. Tested for compatibility on ZC v. 1.5
 *
 * For latest version and support visit:
 * https://sourceforge.net/p/zencartbookx
 *
 * @package initSystem
 * @author  Philou
 * @copyright Copyright 2013
 * @copyright Portions Copyright 2003-2011 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.gnu.org/licenses/gpl.txt GNU General Public License V2.0
 *
 * @version BookX V 0.9.4-revision8 BETA
 * @version $Id: [ZC INSTALLATION]/includes/index_filters/bookx_filter.php 2016-02-02 philou $
 */

/**
 * index filter for the book x product type
 * show the products of a specified bookx attribute
 */

if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
$zc_filter_id = (isset($_GET['filter_id']) ? $_GET['filter_id'] : null);
$filtered_author_id = (isset($_GET['bookx_author_id']) ? $_GET['bookx_author_id'] : null);
$filtered_author_type_id = (isset($_GET['bookx_author_type_id']) ? $_GET['bookx_author_type_id'] : null);
$filtered_publisher_id = (isset($_GET['bookx_publisher_id']) ? $_GET['bookx_publisher_id'] : null);
$filtered_imprint_id = (isset($_GET['bookx_imprint_id']) ? $_GET['bookx_imprint_id'] : null);
$filtered_series_id = (isset($_GET['bookx_series_id']) ? $_GET['bookx_series_id'] : null);
$filtered_genre_id = (isset($_GET['bookx_genre_id']) ? $_GET['bookx_genre_id'] : null);


//*** Check for requests to show special BookX listing page
switch (true) {
	case ('all' == $filtered_author_id):
		zen_redirect(zen_href_link(FILENAME_BOOKX_AUTHORS_LIST, (ALLOW_PRODUCT_BOOKX_FILTER_MULTIPLE ? zen_get_all_get_params() : '') ));
		break;

	case ('all' == $filtered_publisher_id):
		zen_redirect(zen_href_link(FILENAME_BOOKX_PUBLISHERS_LIST, (ALLOW_PRODUCT_BOOKX_FILTER_MULTIPLE ? zen_get_all_get_params() : '') ));
		break;

	case ('all' == $filtered_imprint_id):
		zen_redirect(zen_href_link(FILENAME_BOOKX_IMPRINTS_LIST, (ALLOW_PRODUCT_BOOKX_FILTER_MULTIPLE ? zen_get_all_get_params() : '') ));
		break;

	case ('all' == $filtered_series_id):
		zen_redirect(zen_href_link(FILENAME_BOOKX_SERIES_LIST, (ALLOW_PRODUCT_BOOKX_FILTER_MULTIPLE ? zen_get_all_get_params() : '') ));
		break;

	case ('all' == $filtered_genre_id):
		zen_redirect(zen_href_link(FILENAME_BOOKX_GENRES_LIST, (ALLOW_PRODUCT_BOOKX_FILTER_MULTIPLE ? zen_get_all_get_params() : '') ));
		break;
}

//**** Check for empty Bookx filters and possibly redirect to homepage when all empty
$all_filters_empty = true;
switch (true) {
    case (null !== $zc_filter_id && !empty($zc_filter_id)):  // not null means the filter is set in URL, and not empty means we have an ID to filter for
        $all_filters_empty = false;
        break;

    case (null !== $filtered_author_id && !empty($filtered_author_id)):
        $all_filters_empty = false;
        break;

    case (null !== $filtered_author_type_id && !empty($filtered_author_type_id)):
        $all_filters_empty = false;
        break;
        
    case (null !== $filtered_publisher_id && !empty($filtered_publisher_id)):
        $all_filters_empty = false;
        break;

    case (null !== $filtered_imprint_id && !empty($filtered_imprint_id)):
        $all_filters_empty = false;
        break;

    case (null !== $filtered_series_id && !empty($filtered_series_id)):
        $all_filters_empty = false;
        break;

    case (null !== $filtered_genre_id && !empty($filtered_genre_id)):
        $all_filters_empty = false;
        break;
}

if ($all_filters_empty) {
    zen_redirect(zen_href_link(FILENAME_DEFAULT));
}


if (isset($_GET['sort']) && strlen($_GET['sort']) > 3) {
  $_GET['sort'] = substr($_GET['sort'], 0, 3);
}
if (isset($_GET['alpha_filter_id']) && (int)$_GET['alpha_filter_id'] > 0) {
  $alpha_sort = " AND pd.products_name LIKE '" . chr((int)$_GET['alpha_filter_id']) . "%' ";
  $do_filter_list = true;
} else {
  $alpha_sort = '';
}
if (!isset($select_column_list)) $select_column_list = "";

$flag_show_only_stocked = false;

if ((BOOKX_AUTHOR_LISTING_SHOW_ONLY_STOCKED ||
    BOOKX_GENRE_LISTING_SHOW_ONLY_STOCKED ||
    BOOKX_IMPRINT_LISTING_SHOW_ONLY_STOCKED ||
    BOOKX_PUBLISHER_LISTING_SHOW_ONLY_STOCKED || 
    BOOKX_SERIES_LISTING_SHOW_ONLY_STOCKED)
    && !(isset($_GET['bookx_include_out_of_stock']) && $_GET['bookx_include_out_of_stock'])) {
    $flag_show_only_stocked = true;
}


//*** show the products according to bookx filter

//*** add common fields to $select_column_list
$select_column_list .= ' p.products_id, p.products_type, p.master_categories_id, p.products_price, p.products_tax_class_id, pd.products_description,
								   IF(s.status = 1, s.specials_new_products_price, NULL) AS specials_new_products_price, IF(s.status = 1, s.specials_new_products_price, p.products_price) as final_price,
								   p.products_sort_order, p.product_is_call, p.product_is_always_free_shipping, p.products_qty_box_status, prodt.type_handler AS product_type_handler, be.publishing_date AS flag_date';

//*** add tables
$select_table_list = ' FROM '. TABLE_PRODUCTS . ' p
       				   LEFT JOIN ' . TABLE_PRODUCTS_DESCRIPTION . ' pd ON (pd.products_id = p.products_id AND pd.language_id = "' . (int)$_SESSION['languages_id'] . '")
       				   LEFT JOIN ' . TABLE_SPECIALS . ' s on p.products_id = s.products_id
       				   LEFT JOIN ' . TABLE_PRODUCT_TYPES . ' prodt ON prodt.type_id = p.products_type
        			   LEFT JOIN ' . TABLE_PRODUCT_BOOKX_EXTRA . ' be ON be.products_id = p.products_id
        			   LEFT JOIN ' . TABLE_MANUFACTURERS . ' m ON m.manufacturers_id = p.manufacturers_id ';

$select_where_conditions = ' p.products_status = 1 ';

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

$select_where_extra_filter_condition = ''; 
if ($zc_filter_id) {
    $select_table_list .= ' LEFT JOIN ' . TABLE_PRODUCTS_TO_CATEGORIES . ' p2c ON p2c.products_id = p.products_id ';
    if (isset($_GET['manufacturers_id']) && $_GET['manufacturers_id'] != '' ) {
	    $select_where_extra_filter_condition = ' AND m.manufacturers_id = "' . (int)$zc_filter_id . '" ';

    } else {
	    // We are asked to show only a specific category
	    $select_where_extra_filter_condition = ' AND p2c.categories_id = "' . (int)$zc_filter_id . '" ';
    }
}

if ($filtered_author_id) {
	// We are asked to show books by a specific author
	$select_table_list .= ' LEFT JOIN ' . TABLE_PRODUCT_BOOKX_AUTHORS_TO_PRODUCTS . ' batpfilt ON batpfilt.products_id = be.products_id ';
							/*LEFT JOIN ' . TABLE_PRODUCT_BOOKX_AUTHORS . ' ba ON ba.bookx_author_id = batp.bookx_author_id
							LEFT JOIN ' . TABLE_PRODUCT_BOOKX_AUTHORS_DESCRIPTION . ' bad ON bad.bookx_author_id = ba.bookx_author_id AND bad.languages_id = "' . (int)$_SESSION['languages_id'] . '"';*/
    $select_where_conditions .= ' AND batpfilt.bookx_author_id = "' . (int)$filtered_author_id . '" ';
}

if ($filtered_author_type_id && $filtered_author_id) {
   // We are asked to show books by a specific author type
	/*  if (!(isset($_GET['bookx_author_id']) && zen_not_null($_GET['bookx_author_id']))) {
		 // table authors not yet added via join
		 $select_table_list .= ' LEFT JOIN ' . TABLE_PRODUCT_BOOKX_AUTHORS_TO_PRODUCTS . ' batpfilt ON batpfilt.products_id = be.products_id';
	 } */

     $select_table_list .= ' LEFT JOIN ' . TABLE_PRODUCT_BOOKX_AUTHOR_TYPES . ' batfilt ON batfilt.bookx_author_type_id = batpfilt.bookx_author_type_id';
     $select_where_conditions .= ' AND batfilt.bookx_author_type_id = "' . (int)$filtered_author_type_id . '" ';
}

if ($filtered_publisher_id) {
	// We are asked to show books by a specific publisher
	$select_table_list .= ' LEFT JOIN ' . TABLE_PRODUCT_BOOKX_PUBLISHERS . ' bp ON bp.bookx_publisher_id = be.bookx_publisher_id
    						LEFT JOIN ' . TABLE_PRODUCT_BOOKX_PUBLISHERS_DESCRIPTION . ' bpd ON bpd.bookx_publisher_id = be.bookx_publisher_id AND bpd.languages_id = "' . (int)$_SESSION['languages_id'] . '" ';
	$select_where_conditions .= ' AND bp.bookx_publisher_id = "' . (int)$filtered_publisher_id . '" ';
}

if ($filtered_imprint_id) {
	// We are asked to show books by a specific imprint
	$select_table_list .= ' LEFT JOIN ' . TABLE_PRODUCT_BOOKX_IMPRINTS . ' bi ON bi.bookx_imprint_id = be.bookx_imprint_id
    						LEFT JOIN ' . TABLE_PRODUCT_BOOKX_IMPRINTS_DESCRIPTION . ' bid ON bid.bookx_imprint_id = bi.bookx_imprint_id AND bid.languages_id = "' . (int)$_SESSION['languages_id'] . '" ';
	$select_where_conditions .= ' AND bi.bookx_imprint_id = "' . (int)$filtered_imprint_id . '" ';
}

if ($filtered_series_id) {
	// We are asked to show books by a specific series
	$select_table_list .= ' LEFT JOIN ' . TABLE_PRODUCT_BOOKX_SERIES_DESCRIPTION . ' bsd ON bsd.bookx_series_id = be.bookx_series_id AND bsd.languages_id = "' . (int)$_SESSION['languages_id'] . '" ';
	$select_where_conditions .= ' AND bsd.bookx_series_id = "' . (int)$filtered_series_id . '" ';
}

if ($filtered_genre_id) {
	// We are asked to show books by a specific genre
	$select_table_list .= ' LEFT JOIN ' . TABLE_PRODUCT_BOOKX_GENRES_TO_PRODUCTS . ' bgtp ON bgtp.products_id = be.products_id
							LEFT JOIN ' . TABLE_PRODUCT_BOOKX_GENRES . ' bg ON bgtp.bookx_genre_id = bg.bookx_genre_id
							LEFT JOIN ' . TABLE_PRODUCT_BOOKX_GENRES_DESCRIPTION . ' bgd ON bgd.bookx_genre_id = bgtp.bookx_genre_id AND bgd.languages_id = "' . (int)$_SESSION['languages_id'] . '" ';
	$select_where_conditions .= ' AND bg.bookx_genre_id = "' . (int)$filtered_genre_id . '" ';
}

$listing_sql = 'SELECT ' . $select_column_list . $select_table_list . ' WHERE ' . $select_where_conditions . $select_where_extra_filter_condition . $alpha_sort;

  // set the default sort order setting from the Admin when not defined by customer
  if (!isset($_GET['sort']) and PRODUCT_LISTING_DEFAULT_SORT_ORDER != '') {
    $_GET['sort'] = PRODUCT_LISTING_DEFAULT_SORT_ORDER;
  }

  //$listing_sql = str_replace('m.manufacturers_name', 'r.record_company_name as manufacturers_name', $listing_sql);

  if (isset($column_list)) {
    if ( (!isset($_GET['sort'])) || (isset($_GET['sort']) && !preg_match('/[1-8][ad]/', $_GET['sort'])) || (substr($_GET['sort'], 0, 1) > sizeof($column_list)) )
    {
      for ($i=0, $n=sizeof($column_list); $i<$n; $i++)
      {
        if ($column_list[$i] == 'PRODUCT_LIST_NAME')
        {
          $_GET['sort'] = $i+1 . 'a';
          $listing_sql .= " ORDER BY p.products_sort_order, pd.products_name";
          break;
        }
      }
      // if set to nothing use products_sort_order and PRODUCTS_LIST_NAME is off
      if (PRODUCT_LISTING_DEFAULT_SORT_ORDER == '') {
        $_GET['sort'] = '20a';
      }
    } else {
      $sort_col = substr($_GET['sort'], 0 , 1);
      $sort_order = substr($_GET['sort'], 1);
      switch ($column_list[$sort_col-1])
      {
        case 'PRODUCT_LIST_MODEL':
        $listing_sql .= " order by p.products_model " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
        break;
        case 'PRODUCT_LIST_NAME':
        $listing_sql .= " order by pd.products_name " . ($sort_order == 'd' ? 'desc' : '');
        break;
        /*case 'PRODUCT_LIST_MANUFACTURER':
        $listing_sql .= " order by r.record_company_name " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
        break;*/
        case 'PRODUCT_LIST_QUANTITY':
        $listing_sql .= " order by p.products_quantity " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
        break;
        case 'PRODUCT_LIST_IMAGE':
        $listing_sql .= " order by pd.products_name";
        break;
        case 'PRODUCT_LIST_WEIGHT':
        $listing_sql .= " order by p.products_weight " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
        break;
        case 'PRODUCT_LIST_PRICE':
        $listing_sql .= " order by p.products_price_sorter " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
        break;
      }
    }
  }
  
  // optional Product List Filter
  if (PRODUCT_LIST_FILTER > 0) {
      if (isset($_GET['manufacturers_id']) && $_GET['manufacturers_id'] != '') {

          if (isset($_GET['filter_id']) && zen_not_null($_GET['filter_id'])) {
              // We have already been asked bove to add the category filter, so no need to add it again
              $extra_filter_table_join = '';
          } else {
              $extra_filter_table_join = ' LEFT JOIN ' . TABLE_PRODUCTS_TO_CATEGORIES . ' p2c ON p2c.products_id = p.products_id';
          }
          $filterlist_sql = 'SELECT DISTINCT c.categories_id AS id, cd.categories_name AS name '
                             . $select_table_list . $extra_filter_table_join .
                          ' LEFT JOIN ' . TABLE_CATEGORIES . ' c ON p2c.categories_id = c.categories_id
                            LEFT JOIN ' . TABLE_CATEGORIES_DESCRIPTION . ' cd ON (p2c.categories_id = cd.categories_id AND cd.language_id = "' . (int)$_SESSION['languages_id'] . '")' .
                           ' WHERE ' . $select_where_conditions;
      } else {
          
          if (isset($_GET['filter_id']) && zen_not_null($_GET['filter_id'])) {
              // We have already been asked bove to add the filter, so no need to add it again
              $extra_filter_table_join = '';
          } else {
              $extra_filter_table_join = ' LEFT JOIN ' . TABLE_PRODUCTS_TO_CATEGORIES . ' p2c ON p2c.products_id = p.products_id';
          }
          $filterlist_sql = 'SELECT DISTINCT m.manufacturers_id AS id, m.manufacturers_name AS name ' 
                            . $select_table_list . $extra_filter_table_join . 
                            ' WHERE p.manufacturers_id IS NOT NULL AND p.manufacturers_id != 0 AND ' . $select_where_conditions;
      }
      $do_filter_list = false;
      $filterlist = $db->Execute($filterlist_sql);
      if ($filterlist->RecordCount() > 1) {
          $do_filter_list = true;
          if (isset($_GET['manufacturers_id'])) {
              $getoption_set =  true;
              $get_option_variable = 'manufacturers_id';
              $options = array(array('id' => '', 'text' => TEXT_ALL_CATEGORIES));
          } else {
              $options = array(array('id' => '', 'text' => TEXT_ALL_MANUFACTURERS));
          }
          while (!$filterlist->EOF) {
              $options[] = array('id' => $filterlist->fields['id'], 'text' => $filterlist->fields['name']);
              $filterlist->MoveNext();
          }
      }
  }
