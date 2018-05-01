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
 * @version $Id: [ZC INSTALLATION]/includes/modules/sideboxes/bookx_filters.php 2016-02-02 philou $
 */

/**
 * bookx_filters sidebox - displays list of available bookx attributes to filter
 *
 * Which filters popups are show is set on the product_bookx layout options
 *
 */

$show_author_filter = false;
$show_author_type_filter = false;
$show_genre_filter = false;
$show_imprint_filter = false;
$show_publisher_filter = false;
$show_series_filter = false;

$show_link_author_list = false;
$show_link_author_types_list = false;
$show_link_genres_list = false;
$show_link_imprint_list = false;
$show_link_publisher_list = false;
$show_link_series_list = false;

$author_filter_select_disabled = ' disabled';
$author_type_filter_select_disabled = ' disabled';
$genre_filter_select_disabled = ' disabled';
$imprint_filter_select_disabled = ' disabled';
$publisher_filter_select_disabled = ' disabled';
$series_filter_select_disabled = ' disabled';

$show_link_author_types_list = false;
$show_link_genres_list = false;
$show_link_imprint_list = false;
$show_link_publisher_list = false;
$show_link_series_list = false;

$active_bx_filter_ids = bookx_get_active_filter_ids();

$extra_filter_query_parts = bookx_get_active_filter_query_parts($active_bx_filter_ids);


if(!defined('BOOKX_MAX_DISPLAY_FILTER_DROPDOWN_LEN')) {
	//@todo: remove this once db installation is finalised
	define('BOOKX_MAX_DISPLAY_FILTER_DROPDOWN_LEN', '30');
}

if(!defined('BOOKX_MAX_SIZE_FILTER_LIST')) {
	//@todo: remove this once db installation is finalised
	define('BOOKX_MAX_SIZE_FILTER_LIST', '0');
}


if (bookx_get_show_product_switch ( 'author_type', 'SHOW_', '_FILTER' )) {
    $show_author_type_filter = true;
    
    //$where_clause = implode( ' AND ', array_filter(array($extra_where_author, $extra_where_genre,$extra_where_series,$extra_where_imprint,$extra_where_publisher)));

    $bookx_filter_values_query = 'SELECT DISTINCT bat.bookx_author_type_id, batd.type_description
		                          FROM ' . TABLE_PRODUCT_BOOKX_AUTHOR_TYPES . ' bat
		                          LEFT JOIN ' . TABLE_PRODUCT_BOOKX_AUTHOR_TYPES_DESCRIPTION . ' batd ON batd.bookx_author_type_id = bat.bookx_author_type_id AND batd.languages_id = "' . (int)$_SESSION['languages_id'] . '"'
		                        . (!empty($extra_filter_query_parts['join_multi_filter']) ? ' LEFT JOIN ' . TABLE_PRODUCT_BOOKX_AUTHORS_TO_PRODUCTS . ' batp ON batp.bookx_author_type_id = bat.bookx_author_type_id ' . $extra_filter_query_parts['join_multi_filter'] . ' ON be.products_id = batp.products_id ' : '')
		                        . bookx_assemble_filter_extra_join($extra_filter_query_parts['join'], array('author_type'))
                                . ' WHERE 1 ' . bookx_assemble_filter_extra_where($extra_filter_query_parts['where'], array('author_type'))
    		                   .' ORDER by bat.type_sort_order, batd.type_description';

    $bookx_author_types = $db->Execute ( $bookx_filter_values_query );

    if ($bookx_author_types->RecordCount () > 0) {
        $author_type_filter_select_disabled = '';
        $number_of_rows = $bookx_author_types->RecordCount () + 1;

        // Display a list
        $bookx_author_types_array = array ();
        if (!$active_bx_filter_ids['author_type_id']) {
            $bookx_author_types_array [] = array (
                'id' => '',
                'text' => PULL_DOWN_ALL
            );
        } else {
            $bookx_author_types_array [] = array (
                'id' => '',
                'text' => PULL_DOWN_BOOKX_RESET
            );
        }

        while ( ! $bookx_author_types->EOF ) {
            $bookx_author_type_name = ((strlen ( $bookx_author_types->fields ['type_description'] ) > ( int ) BOOKX_MAX_DISPLAY_FILTER_DROPDOWN_LEN) ? substr ( $bookx_author_types->fields ['type_description'], 0, ( int ) BOOKX_MAX_DISPLAY_FILTER_DROPDOWN_LEN ) . '..' : $bookx_author_types->fields ['type_description']);
            $bookx_author_types_array [] = array (
                'id' => $bookx_author_types->fields ['bookx_author_type_id'],
                'text' => $bookx_author_type_name
            );

            $bookx_author_types->MoveNext ();
        }
    } else {
		$bookx_author_types_array = array(array ('id' => '', 'text' => PULL_DOWN_TEXT_NO_AUTHOR_TYPES_TO_DISPLAY));
		$show_link_author_types_list = false;
    }
}


if (bookx_get_show_product_switch ( 'author_list', 'SHOW_', '_LINK' )) {
    $show_link_author_list = true;
}

if (bookx_get_show_product_switch ( 'author', 'SHOW_', '_FILTER' )) {
	$show_author_filter = true;
	//$author_type_filter_extra_join = '';
	$author_type_filter_extra_where = '';
	
	if($active_bx_filter_ids['author_type_id']) {
	    //*** we only need to add a WHERE clause here, since the AUTHORS_TO_PRODUCTS table is already joined
	    //$author_type_filter_extra_join = ' AND batp.bookx_author_type_id ="' . $active_bx_filter_ids['author_type_id'] . '" ';
	    $author_type_filter_extra_where = ' AND batp.bookx_author_type_id ="' . $active_bx_filter_ids['author_type_id'] . '" '; 
	}
	
	$bookx_filter_values_query = 'SELECT DISTINCT ba.bookx_author_id, ba.author_name
		                          FROM ' . TABLE_PRODUCT_BOOKX_AUTHORS . ' ba 
		                          LEFT JOIN ' . TABLE_PRODUCT_BOOKX_AUTHORS_TO_PRODUCTS . ' batp ON batp.bookx_author_id = ba.bookx_author_id '	                           
		                        . (!empty($extra_filter_query_parts['join_multi_filter']) ? $extra_filter_query_parts['join_multi_filter'] . ' ON be.products_id = batp.products_id ' : '')
		                        . bookx_assemble_filter_extra_join($extra_filter_query_parts['join'], array('author', 'author_type'))
                                . ' WHERE 1 ' . $author_type_filter_extra_where . bookx_assemble_filter_extra_where($extra_filter_query_parts['where'], array('author', 'author_type'))
		                       .' ORDER by ba.author_sort_order, ba.author_name';

	$bookx_authors = $db->Execute ( $bookx_filter_values_query );

	if ($bookx_authors->RecordCount () > 0) {
	    $author_filter_select_disabled = '';
		$number_of_rows = $bookx_authors->RecordCount () + 1;

		// Display a list
		$bookx_authors_array = array ();
		if (!$active_bx_filter_ids['author_id']) {
			$bookx_authors_array [] = array (
					'id' => '',
					'text' => PULL_DOWN_ALL
			);
		} else {
			$bookx_authors_array [] = array (
					'id' => '',
					'text' => PULL_DOWN_BOOKX_RESET
			);
		}

		if ($show_link_author_list) {
			$bookx_authors_array[] =  array(
											'id' => 'all',
											'text' => LABEL_LIST_ALL_AUTHORS
											);
		}

		while ( ! $bookx_authors->EOF ) {
			$bookx_author_name = ((strlen ( $bookx_authors->fields ['author_name'] ) > ( int ) BOOKX_MAX_DISPLAY_FILTER_DROPDOWN_LEN) ? substr ( $bookx_authors->fields ['author_name'], 0, ( int ) BOOKX_MAX_DISPLAY_FILTER_DROPDOWN_LEN ) . '..' : $bookx_authors->fields ['author_name']);
			$bookx_authors_array [] = array (
					'id' => $bookx_authors->fields ['bookx_author_id'],
					'text' => $bookx_author_name
			);

			$bookx_authors->MoveNext ();
		}
	} else {
		$bookx_authors_array = array(array ('id' => '', 'text' => PULL_DOWN_TEXT_NO_AUTHORS_TO_DISPLAY));
		$show_link_author_list = false;
	}
}



if (bookx_get_show_product_switch ( 'publisher_list', 'SHOW_', '_LINK' )) {
    $show_link_publisher_list = true;
}

if (bookx_get_show_product_switch ( 'publisher', 'SHOW_', '_FILTER' )) {
	$show_publisher_filter = true;

	$bookx_filter_values_query = 'SELECT DISTINCT bp.bookx_publisher_id, bp.publisher_name
		                          FROM ' . TABLE_PRODUCT_BOOKX_PUBLISHERS . ' bp '
		                        . (!empty($extra_filter_query_parts['join_multi_filter']) ? $extra_filter_query_parts['join_multi_filter'] . ' ON be.bookx_publisher_id = bp.bookx_publisher_id ' : '')
		                        . bookx_assemble_filter_extra_join($extra_filter_query_parts['join'], array('publisher'))
                              . ' WHERE 1 ' . bookx_assemble_filter_extra_where($extra_filter_query_parts['where'], array('publisher'))
		                      . ' ORDER by bp.publisher_sort_order, bp.publisher_name';

	$bookx_publishers = $db->Execute ( $bookx_filter_values_query );

	if ($bookx_publishers->RecordCount () > 0) {
	    $publisher_filter_select_disabled = '';
		$number_of_rows = $bookx_publishers->RecordCount () + 1;

		// Display a list
		$bookx_publishers_array = array ();
		if (! $active_bx_filter_ids['publisher_id']) {
			$bookx_publishers_array [] = array (
					'id' => '',
					'text' => PULL_DOWN_ALL
			);
		} else {
			$bookx_publishers_array [] = array (
					'id' => '',
					'text' => PULL_DOWN_BOOKX_RESET
			);
		}
		
		if ($show_link_publisher_list) {
		    $bookx_publishers_array[] =  array(
		        'id' => 'all',
		        'text' => LABEL_LIST_ALL_PUBLISHERS
		    );
		}

		while ( ! $bookx_publishers->EOF ) {
			$bookx_publisher_name = ((strlen ( $bookx_publishers->fields ['publisher_name'] ) > ( int ) BOOKX_MAX_DISPLAY_FILTER_DROPDOWN_LEN) ? substr ( $bookx_publishers->fields ['publisher_name'], 0, ( int ) BOOKX_MAX_DISPLAY_FILTER_DROPDOWN_LEN ) . '..' : $bookx_publishers->fields ['publisher_name']);
			$bookx_publishers_array [] = array (
					'id' => $bookx_publishers->fields ['bookx_publisher_id'],
					'text' => $bookx_publisher_name
			);

			$bookx_publishers->MoveNext ();
		}
	} else {
		$bookx_publishers_array = array(array ('id' => '', 'text' => PULL_DOWN_TEXT_NO_PUBLISHERS_TO_DISPLAY));
	    $show_link_publisher_list = false;
	}
}


if (bookx_get_show_product_switch ( 'imprint_list', 'SHOW_', '_LINK' )) {
    $show_link_imprint_list = true;
}

if (bookx_get_show_product_switch ( 'imprint', 'SHOW_', '_FILTER' )) {
	$show_imprint_filter = true;
	
	$bookx_filter_values_query = 'SELECT DISTINCT bi.bookx_imprint_id, bi.imprint_name
		                          FROM ' . TABLE_PRODUCT_BOOKX_IMPRINTS . ' bi '
		                        . (!empty($extra_filter_query_parts['join_multi_filter']) ? $extra_filter_query_parts['join_multi_filter'] . ' ON be.bookx_imprint_id = bi.bookx_imprint_id ' : '')
		                        . bookx_assemble_filter_extra_join($extra_filter_query_parts['join'], array('imprint'))
                                . ' WHERE 1 ' . bookx_assemble_filter_extra_where($extra_filter_query_parts['where'], array('imprint'))
		                       .' ORDER by bi.imprint_sort_order, bi.imprint_name ';

	$bookx_imprint = $db->Execute ( $bookx_filter_values_query );

	if ($bookx_imprint->RecordCount () > 0) {
	    $imprint_filter_select_disabled = '';
		$number_of_rows = $bookx_imprint->RecordCount () + 1;

		// Display a list
		$bookx_imprints_array = array ();
		if (! $active_bx_filter_ids['imprint_id']) {
			$bookx_imprints_array [] = array (
					'id' => '',
					'text' => PULL_DOWN_ALL
			);
		} else {
			$bookx_imprints_array [] = array (
					'id' => '',
					'text' => PULL_DOWN_BOOKX_RESET
			);
		}
		
		if ($show_link_imprint_list) {
		    $bookx_imprints_array[] =  array(
		        'id' => 'all',
		        'text' => LABEL_LIST_ALL_IMPRINTS
		    );
		}

		while ( ! $bookx_imprint->EOF ) {
			$bookx_imprint_name = ((strlen ( $bookx_imprint->fields ['imprint_name'] ) > ( int ) BOOKX_MAX_DISPLAY_FILTER_DROPDOWN_LEN) ? substr ( $bookx_imprint->fields ['imprint_name'], 0, ( int ) BOOKX_MAX_DISPLAY_FILTER_DROPDOWN_LEN ) . '..' : $bookx_imprint->fields ['imprint_name']);
			$bookx_imprints_array [] = array (
					'id' => $bookx_imprint->fields ['bookx_imprint_id'],
					'text' => $bookx_imprint_name
			);

			$bookx_imprint->MoveNext ();
		}
	} else {
		$bookx_imprints_array = array(array ('id' => '', 'text' => PULL_DOWN_TEXT_NO_IMPRINTS_TO_DISPLAY));
	    $show_link_imprint_list = false;
	}
}


if (bookx_get_show_product_switch ( 'series_list', 'SHOW_', '_LINK' )) {
    $show_link_series_list = true;
}

if (bookx_get_show_product_switch ( 'series', 'SHOW_', '_FILTER' )) {
	$show_series_filter = true;
	
	$bookx_filter_values_query = 'SELECT DISTINCT bs.bookx_series_id, bsd.series_name
		                          FROM ' . TABLE_PRODUCT_BOOKX_SERIES . ' bs
		                          LEFT JOIN ' . TABLE_PRODUCT_BOOKX_SERIES_DESCRIPTION . ' bsd ON bs.bookx_series_id = bsd.bookx_series_id AND bsd.languages_id = "' . (int)$_SESSION['languages_id'] . '"'
		                        . (!empty($extra_filter_query_parts['join_multi_filter']) ? $extra_filter_query_parts['join_multi_filter'] . ' ON be.bookx_series_id = bs.bookx_series_id ' : '')
		                        . bookx_assemble_filter_extra_join($extra_filter_query_parts['join'], array('series'))
                              . ' WHERE 1 ' . bookx_assemble_filter_extra_where($extra_filter_query_parts['where'], array('series'))
		                      . ' ORDER by bs.series_sort_order, bsd.series_name';

	$bookx_series = $db->Execute ( $bookx_filter_values_query );

	if ($bookx_series->RecordCount () > 0) {
	    $series_filter_select_disabled = '';
		$number_of_rows = $bookx_series->RecordCount () + 1;

		// Display a list
		$bookx_series_array = array ();
		if (! $active_bx_filter_ids['series_id']) {
			$bookx_series_array [] = array (
					'id' => '',
					'text' => PULL_DOWN_ALL
			);
		} else {
			$bookx_series_array [] = array (
					'id' => '',
					'text' => PULL_DOWN_BOOKX_RESET
			);
		}

		if ($show_link_series_list) {
			$bookx_series_array[] =  array(
					'id' => 'all',
					'text' => LABEL_LIST_ALL_SERIES
			);
		}

		while ( ! $bookx_series->EOF ) {
			$bookx_series_name = ((strlen ( $bookx_series->fields ['series_name'] ) > ( int ) BOOKX_MAX_DISPLAY_FILTER_DROPDOWN_LEN) ? substr ( $bookx_series->fields ['series_name'], 0, ( int ) BOOKX_MAX_DISPLAY_FILTER_DROPDOWN_LEN ) . '..' : $bookx_series->fields ['series_name']);
			$bookx_series_array [] = array (
					'id' => $bookx_series->fields ['bookx_series_id'],
					'text' => $bookx_series_name
			);

			$bookx_series->MoveNext ();
		}
	} else {
		$bookx_series_array = array(array ('id' => '', 'text' => PULL_DOWN_TEXT_NO_SERIES_TO_DISPLAY));
		$show_link_series_list = false;
	}
}


if (bookx_get_show_product_switch ( 'genres_list', 'SHOW_', '_LINK' )) {
    $show_link_genres_list = true;
}

if (bookx_get_show_product_switch ( 'genre', 'SHOW_', '_FILTER' )) {
	$show_genre_filter = true;
	
	$bookx_filter_values_query = 'SELECT DISTINCT bg.bookx_genre_id, bgd.genre_description AS genre_name
		                          FROM ' . TABLE_PRODUCT_BOOKX_GENRES . ' bg
		                          LEFT JOIN ' . TABLE_PRODUCT_BOOKX_GENRES_DESCRIPTION . ' bgd ON bg.bookx_genre_id = bgd.bookx_genre_id AND bgd.languages_id = "' . (int)$_SESSION['languages_id'] . '"'
		                        . (!empty($extra_filter_query_parts['join_multi_filter']) ? ' LEFT JOIN ' . TABLE_PRODUCT_BOOKX_GENRES_TO_PRODUCTS . ' bgtp ON bgtp.bookx_genre_id = bg.bookx_genre_id ' . $extra_filter_query_parts['join_multi_filter'] . ' ON be.products_id = bgtp.products_id ' : '')
		                        . bookx_assemble_filter_extra_join($extra_filter_query_parts['join'], array('genre'))
                                . ' WHERE 1 ' . bookx_assemble_filter_extra_where($extra_filter_query_parts['where'], array('genre'))
		                       .' ORDER by bg.genre_sort_order, bgd.genre_description';

	$bookx_genres = $db->Execute ( $bookx_filter_values_query );

	if ($bookx_genres->RecordCount () > 0) {
	    $genre_filter_select_disabled = '';
		$number_of_rows = $bookx_genres->RecordCount () + 1;

		// Display a list
		$bookx_genres_array = array ();
		if (! $active_bx_filter_ids['genre_id']) {
			$bookx_genres_array [] = array (
					'id' => '',
					'text' => PULL_DOWN_ALL
			);
		} else {
			$bookx_genres_array [] = array (
					'id' => '',
					'text' => PULL_DOWN_BOOKX_RESET
			);
		}
		
		if ($show_link_genres_list) {
		    $bookx_genres_array[] =  array(
		        'id' => 'all',
		        'text' => LABEL_LIST_ALL_GENRES
		    );
		}

		while ( ! $bookx_genres->EOF ) {
			$bookx_genre_name = ((strlen ( $bookx_genres->fields ['genre_name'] ) > ( int ) BOOKX_MAX_DISPLAY_FILTER_DROPDOWN_LEN) ? substr ( $bookx_genres->fields ['genre_name'], 0, ( int ) BOOKX_MAX_DISPLAY_FILTER_DROPDOWN_LEN ) . '..' : $bookx_genres->fields ['genre_name']);
			$bookx_genres_array [] = array (
					'id' => $bookx_genres->fields ['bookx_genre_id'],
					'text' => $bookx_genre_name
			);

			$bookx_genres->MoveNext ();
		}
	} else {
		$bookx_genres_array = array(array ('id' => '', 'text' => PULL_DOWN_TEXT_NO_GENRES_TO_DISPLAY));
		$show_link_genres_list = false;
	}
}

require($template->get_template_dir('tpl_bookx_filters_select.php',DIR_WS_TEMPLATE, $current_page_base,'sideboxes'). '/tpl_bookx_filters_select.php');

$title = '<label>' . BOX_HEADING_BOOKX_FILTERS . '</label>';
$title_link = false;
require($template->get_template_dir($column_box_default, DIR_WS_TEMPLATE, $current_page_base,'common') . '/' . $column_box_default);
