<?php
/**
 * create the breadcrumb trail
 * see {@link  http://www.zen-cart.com/wiki/index.php/Developers_API_Tutorials#InitSystem wikitutorials} for more details.
 *
 * @package initSystem
 * @copyright Copyright 2003-2016 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart-pro.at/license/2_0.txt GNU Public License V2.0
 * @version $Id: init_add_crumbs.php 729 2011-08-09 15:49:16Z hugo13 $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
$breadcrumb->add(HEADER_TITLE_CATALOG, zen_href_link(FILENAME_DEFAULT));

// BOF BookX addition 1 of 2

$bookx_get_filter = '';

//**** if we have filters set, then we want the breadcrumb path populated by filter(s)

if (isset($_GET['typefilter'])) {
    if ('bookx' == $_GET['typefilter']) {
        $bookx_get_filter.= '&typefilter=bookx';
    }

    //***  add get terms (e.g manufacturer, music genre, record company or other user defined selector) to breadcrumb
    
    $sql = 'SELECT * FROM ' . TABLE_GET_TERMS_TO_FILTER;
    $get_terms = $db->execute($sql);
    
    while (!$get_terms->EOF) {
        if (isset($_GET[$get_terms->fields['get_term_name']])) {
            $sql = 'SELECT ' . $get_terms->fields['get_term_name_field'] . '
        		    FROM ' . constant($get_terms->fields['get_term_table']) . '
        		    WHERE ' . $get_terms->fields['get_term_name'] . ' =  "' . (int)$_GET[$get_terms->fields['get_term_name']] . '"';
            switch ($get_terms->fields['get_term_table']) {
                case 'TABLE_PRODUCT_BOOKX_BINDING_DESCRIPTION':
                case 'TABLE_PRODUCT_BOOKX_CONDITIONS_DESCRIPTION':
                case 'TABLE_PRODUCT_BOOKX_GENRES_DESCRIPTION':
                case 'TABLE_PRODUCT_BOOKX_PRINTING_DESCRIPTION':
                case 'TABLE_PRODUCT_BOOKX_SERIES_DESCRIPTION':
                case 'TABLE_PRODUCT_BOOKX_AUTHOR_TYPES_DESCRIPTION':
                    $sql .= ' AND languages_id = "' . $_SESSION['languages_id'] . '"';
                    break;               
            }
            
            $get_term_breadcrumb = $db->execute($sql);
            
            $bookx_filter_description = '';
            
            if ($get_term_breadcrumb->RecordCount() > 0) {
                
                if ('bookx' == substr($get_terms->fields['get_term_name'], 0, 5)) {
                    $bookx_filter_description = '<span class="bookxFilterBreadcrumbLabel">' . constant('FILTER_LABEL_'.strtoupper($get_terms->fields['get_term_name'])) . '</span>';
                }
                $breadcrumb->add($bookx_filter_description . $get_term_breadcrumb->fields[$get_terms->fields['get_term_name_field']], zen_href_link(FILENAME_DEFAULT, $get_terms->fields['get_term_name'] . "=" . $_GET[$get_terms->fields['get_term_name']]. $bookx_get_filter));
            }
        }
        $get_terms->movenext();
    }
    
} 

//***** check if we are on product info page and add product name and possibly fill in crumb path if not already filled by filters above

if (isset($_GET['products_id'])) {
  
    //*** find product name & type for any product (BookX or Default)
    
    $productname_query = 'SELECT pt.type_handler AS type, pd.products_name, be.volume, bed.products_subtitle
                          FROM ' . TABLE_PRODUCTS . ' p
                          LEFT JOIN ' . TABLE_PRODUCT_TYPES . ' pt ON p.products_type = pt.type_id
                          LEFT JOIN ' . TABLE_PRODUCTS_DESCRIPTION . ' pd ON pd.products_id = p.products_id AND pd.language_id = "' . $_SESSION['languages_id'] . '"
                          LEFT JOIN ' . TABLE_PRODUCT_BOOKX_EXTRA . ' be ON be.products_id = p.products_id 
                          LEFT JOIN ' . TABLE_PRODUCT_BOOKX_EXTRA_DESCRIPTION . ' bed ON bed.products_id = p.products_id AND bed.languages_id = "' . $_SESSION['languages_id'] . '"
                          WHERE p.products_id = "' . (int)$_GET['products_id'] . '"';
    
    $productname = $db->Execute($productname_query);
    
    if (empty($bookx_get_filter) && 'product_bookx' == $productname->fields['type'] && BOOKX_BREAD_USE_BOOKX_NO_CATEGORIES) {
        $bookx_breadcrumb_info_select = '';
        $bookx_breadcrumb_info_joins = '';
        $bookx_breadcrumb_info_group_by = '';
        $bookx_breadcrumb_path_items = array();
        
        if (BOOKX_BREAD_ADD_PUBLISHER) {
            $bookx_breadcrumb_path_items[BOOKX_BREAD_ADD_PUBLISHER] = 'publisher';
            $bookx_breadcrumb_info_select .= ' bpub.publisher_name, bpub.bookx_publisher_id,';
            $bookx_breadcrumb_info_joins .= ' LEFT JOIN ' . TABLE_PRODUCT_BOOKX_PUBLISHERS . ' bpub ON bpub.bookx_publisher_id = be.bookx_publisher_id ';
        }
        
        if (BOOKX_BREAD_ADD_IMPRINT) {
            $bookx_breadcrumb_path_items[BOOKX_BREAD_ADD_IMPRINT] = 'imprint';
            $bookx_breadcrumb_info_select .= ' bi.imprint_name, bi.bookx_imprint_id, ';
            $bookx_breadcrumb_info_joins .= ' LEFT JOIN ' . TABLE_PRODUCT_BOOKX_IMPRINTS . ' bi ON bi.bookx_imprint_id = be.bookx_imprint_id ';
        }
        
        if (BOOKX_BREAD_ADD_SERIES) {
            $bookx_breadcrumb_path_items[BOOKX_BREAD_ADD_SERIES] = 'series';
            $bookx_breadcrumb_info_select .= ' bsd.series_name, bsd.bookx_series_id, ';
            $bookx_breadcrumb_info_joins .= ' LEFT JOIN ' . TABLE_PRODUCT_BOOKX_SERIES_DESCRIPTION . ' bsd ON bsd.bookx_series_id = be.bookx_series_id AND bsd.languages_id = "' . $_SESSION['languages_id'] . '"';
        }
        
        if (BOOKX_BREAD_ADD_GENRE) {
            $bookx_breadcrumb_path_items[BOOKX_BREAD_ADD_GENRE] = 'genre';
            $bookx_breadcrumb_info_select .= ' bgd.genre_description, bgd.bookx_genre_id, ';
            $bookx_breadcrumb_info_joins .= ' LEFT JOIN ' . TABLE_PRODUCT_BOOKX_GENRES_TO_PRODUCTS . ' bgtp ON bgtp.products_id = be.products_id '
                                          . ' LEFT JOIN ' . TABLE_PRODUCT_BOOKX_GENRES_DESCRIPTION . ' bgd ON bgd.bookx_genre_id = bgtp.bookx_genre_id AND bgd.languages_id = "' . $_SESSION['languages_id'] . '"';
            $bookx_breadcrumb_info_group_by = ' GROUP BY be.products_id';
        }
        
        if (BOOKX_BREAD_ADD_AUTHOR) {
            $bookx_breadcrumb_path_items[BOOKX_BREAD_ADD_AUTHOR] = 'author';
            $bookx_breadcrumb_info_select .= ' ba.author_name, ba.bookx_author_id, ';
            $bookx_breadcrumb_info_joins .= ' LEFT JOIN ' . TABLE_PRODUCT_BOOKX_AUTHORS_TO_PRODUCTS . ' batp ON batp.products_id = be.products_id '
                                          . ' LEFT JOIN ' . TABLE_PRODUCT_BOOKX_AUTHORS . ' ba ON ba.bookx_author_id = batp.bookx_author_id ';       
            $bookx_breadcrumb_info_group_by = ' GROUP BY be.products_id';
        }
        
        
        if (!empty($bookx_breadcrumb_info_select)) {
            $bookx_breadcrumb_info_query = 'SELECT ' . $bookx_breadcrumb_info_select . ' be.products_id '
                                        . ' FROM ' . TABLE_PRODUCT_BOOKX_EXTRA . ' be ' 
                                         . $bookx_breadcrumb_info_joins 
                                        . ' WHERE be.products_id = "' . (int)$_GET['products_id'] . '" '
                                        . $bookx_breadcrumb_info_group_by;          
        }
        
        $bookx_breadcrumb_info = $db->Execute($bookx_breadcrumb_info_query);
        
        ksort($bookx_breadcrumb_path_items);
        
        foreach ($bookx_breadcrumb_path_items as $sort_order => $path_item ) {
            switch (true) {
                case 'publisher' == $path_item && !empty($bookx_breadcrumb_info->fields['bookx_publisher_id']):
                    if ('bookx' == substr($get_terms->fields['get_term_name'], 0, 5)) {
                        $bookx_filter_description = '<span class="bookxFilterBreadcrumbLabel">' . constant('FILTER_LABEL_'.strtoupper($get_terms->fields['get_term_name'])) . '</span>';
                    }
                    $breadcrumb->add('<span class="bookxFilterBreadcrumbLabel">' . FILTER_LABEL_BOOKX_PUBLISHER_ID . '</span>' . $bookx_breadcrumb_info->fields['publisher_name'], zen_href_link(FILENAME_DEFAULT, 'typefilter=bookx&bookx_publisher_id=' . $bookx_breadcrumb_info->fields['bookx_publisher_id']));
                    break;
                    
                case 'imprint' == $path_item && !empty($bookx_breadcrumb_info->fields['bookx_imprint_id']):
                    $breadcrumb->add('<span class="bookxFilterBreadcrumbLabel">' . FILTER_LABEL_BOOKX_IMPRINT_ID . '</span>' . $bookx_breadcrumb_info->fields['imprint_name'], zen_href_link(FILENAME_DEFAULT, 'typefilter=bookx&bookx_imprint_id=' . $bookx_breadcrumb_info->fields['bookx_imprint_id']));
                    break;

                case 'series' == $path_item && !empty($bookx_breadcrumb_info->fields['bookx_series_id']):
                    $breadcrumb->add('<span class="bookxFilterBreadcrumbLabel">' . FILTER_LABEL_BOOKX_SERIES_ID . '</span>' . $bookx_breadcrumb_info->fields['series_name'], zen_href_link(FILENAME_DEFAULT, 'typefilter=bookx&bookx_series_id=' . $bookx_breadcrumb_info->fields['bookx_series_id']));
                    break;

                case 'genre' == $path_item && !empty($bookx_breadcrumb_info->fields['bookx_genre_id']):
                    $breadcrumb->add('<span class="bookxFilterBreadcrumbLabel">' . FILTER_LABEL_BOOKX_GENRE_ID . '</span>' . $bookx_breadcrumb_info->fields['genre_description'], zen_href_link(FILENAME_DEFAULT, 'typefilter=bookx&bookx_genre_id=' . $bookx_breadcrumb_info->fields['bookx_genre_id']));
                    break;

                case 'author' == $path_item && !empty($bookx_breadcrumb_info->fields['bookx_author_id']):
                    $breadcrumb->add('<span class="bookxFilterBreadcrumbLabel">' . FILTER_LABEL_BOOKX_AUTHOR_ID . '</span>' . $bookx_breadcrumb_info->fields['author_name'], zen_href_link(FILENAME_DEFAULT, 'typefilter=bookx&bookx_author_id=' . $bookx_breadcrumb_info->fields['bookx_author_id']));
                    break;
            }
        }
    }
    } elseif(!isset($_GET['typefilter']) || 
            (isset($_GET['typefilter']) && empty($_GET['typefilter']) )
            ) {
// EOF BookX addition 1 of 2


	/**
	 * add category names or the manufacturer name to the breadcrumb trail
	 */
	if (!isset($robotsNoIndex)) $robotsNoIndex = false;
// might need isset($_GET['cPath']) later ... right now need $cPath or breaks breadcrumb from sidebox etc.
	if (isset($cPath_array) && isset($cPath)) {
		for ($i = 0, $n = sizeof($cPath_array); $i < $n; $i++) {
			$categories_query = "SELECT categories_name
                           FROM " . TABLE_CATEGORIES_DESCRIPTION . "
                           WHERE categories_id = '" . (int) $cPath_array[$i] . "'
                           AND language_id = '" . (int) $_SESSION['languages_id'] . "'";

			$categories = $db->Execute($categories_query);
//echo 'I SEE ' . (int)$cPath_array[$i] . '<br>';
			if ($categories->RecordCount() > 0) {
				$breadcrumb->add($categories->fields['categories_name'], zen_href_link(FILENAME_DEFAULT, 'cPath=' . implode('_', array_slice($cPath_array, 0, ($i + 1)))));
			}
			elseif (SHOW_CATEGORIES_ALWAYS == 0) {
				// if invalid, set the robots noindex/nofollow for this page
				$robotsNoIndex = true;
				break;
			}
		}
	}
	/**
	 * add get terms (e.g manufacturer, music genre, record company or other user defined selector) to breadcrumb
	 */
	$sql       = "SELECT *
        FROM " . TABLE_GET_TERMS_TO_FILTER;
	$get_terms = $db->execute($sql);
	while (!$get_terms->EOF) {
		if (isset($_GET[$get_terms->fields['get_term_name']])) {
			$sql                 = "select " . $get_terms->fields['get_term_name_field'] . "
		        from " . constant($get_terms->fields['get_term_table']) . "
		        where " . $get_terms->fields['get_term_name'] . " =  " . (int) $_GET[$get_terms->fields['get_term_name']];
			$get_term_breadcrumb = $db->execute($sql);
			if ($get_term_breadcrumb->RecordCount() > 0) {
				$breadcrumb->add($get_term_breadcrumb->fields[$get_terms->fields['get_term_name_field']], zen_href_link(FILENAME_DEFAULT, $get_terms->fields['get_term_name'] . "=" . $_GET[$get_terms->fields['get_term_name']]));
			}
		}
		$get_terms->movenext();
	}
	/**
	 * add the products model to the breadcrumb trail
	 */
	if (isset($_GET['products_id'])) {
		$productname_query = "SELECT products_name
                   FROM " . TABLE_PRODUCTS_DESCRIPTION . "
                   WHERE products_id = '" . (int) $_GET['products_id'] . "'
             AND language_id = '" . $_SESSION['languages_id'] . "'";

		$productname = $db->Execute($productname_query);

		if ($productname->RecordCount() > 0) {
			$breadcrumb->add($productname->fields['products_name'], zen_href_link(zen_get_info_page($_GET['products_id']), 'cPath=' . $cPath . '&products_id=' . $_GET['products_id']));
		}
	}
// BOF BookX addition 2 of 2
}
// EOF BookX addition 2 of 2