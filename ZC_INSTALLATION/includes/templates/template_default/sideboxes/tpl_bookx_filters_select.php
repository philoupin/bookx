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
 * @version $Id: [ZC INSTALLATION]/includes/templates/[CURRENT_TEMPLATE]/sideboxes/tpl_bookx_filters_select.php 2016-02-02 philou $
 */

/**
 * Side Box Template
 *
 */

    if ($active_bx_filter_ids['author_id'] && ALLOW_PRODUCT_BOOKX_FILTER_MULTIPLE) {
        $hidden_author_id_field = zen_draw_hidden_field('bookx_author_id', $active_bx_filter_ids['author_id']);
    } else {
        $hidden_author_id_field = '';
    }
    
    if ($active_bx_filter_ids['author_type_id'] && ALLOW_PRODUCT_BOOKX_FILTER_MULTIPLE) {
        $hidden_author_type_id_field = zen_draw_hidden_field('bookx_author_type_id', $active_bx_filter_ids['author_type_id']);
    } else {
        $hidden_author_type_id_field = '';
    }
            
    if ($active_bx_filter_ids['publisher_id'] && ALLOW_PRODUCT_BOOKX_FILTER_MULTIPLE) {
        $hidden_publisher_id_field = zen_draw_hidden_field('bookx_publisher_id', $active_bx_filter_ids['publisher_id']);
    } else {
        $hidden_publisher_id_field = '';
    }
            
    if ($active_bx_filter_ids['imprint_id'] && ALLOW_PRODUCT_BOOKX_FILTER_MULTIPLE) {
        $hidden_imprint_id_field = zen_draw_hidden_field('bookx_imprint_id', $active_bx_filter_ids['imprint_id']);
    } else {
        $hidden_imprint_id_field = '';
    }
            
    if ($active_bx_filter_ids['series_id'] && ALLOW_PRODUCT_BOOKX_FILTER_MULTIPLE) {
        $hidden_series_id_field = zen_draw_hidden_field('bookx_series_id', $active_bx_filter_ids['series_id']);
    } else {
        $hidden_series_id_field = '';
    }
            
    if ($active_bx_filter_ids['genre_id'] && ALLOW_PRODUCT_BOOKX_FILTER_MULTIPLE) {
        $hidden_genre_id_field = zen_draw_hidden_field('bookx_genre_id', $active_bx_filter_ids['genre_id']);
    } else {
        $hidden_genre_id_field = '';
    }
    
// if (!isset($content)) {
  	$content = "";
 // }
  $content .= '<div id="' . str_replace('_', '-', $box_id . 'Content') . '" class="sideBoxContent centeredContent">';

  if ($show_author_filter) {
      if ($show_author_type_filter) {
          $content .= '<div class="bookx_filter_sidebox_popup_label">' . LABEL_FILTER_AUTHOR_TYPES . '</div>';

          $destination_page = (isset($_GET['main_page']) && 'index' !=  $_GET['main_page'] && !$this_is_home_page ? $_GET['main_page'] : FILENAME_BOOKX_AUTHORS_LIST);

          $content .= zen_draw_form('bookx_author_types_form', zen_href_link($destination_page, '', $request_type, false), 'get', ($active_bx_filter_ids['author_type_id'] ? 'class="bxf_active"' : ''));
          if (isset($_GET['bookx_author_id']) && zen_not_null($_GET['bookx_author_id'])) {
              //*** author & author type can always be combined, so if an ATypeId is set, we keep it
              $content .= zen_draw_hidden_field('bookx_author_id', (int)$_GET['bookx_author_id']);
          }
          $content .= $hidden_publisher_id_field . $hidden_imprint_id_field . $hidden_series_id_field . $hidden_genre_id_field;
          $content .= zen_draw_hidden_field('main_page', FILENAME_DEFAULT) . zen_hide_session_id() . (isset($_GET['typefilter']) && 'bookx' == $_GET['typefilter'] ? zen_draw_hidden_field('typefilter', 'bookx') : '');
          $content .= zen_draw_pull_down_menu('bookx_author_type_id', $bookx_author_types_array, $active_bx_filter_ids['author_type_id'], $author_type_filter_select_disabled . ' onchange="this.form.submit();" size="' . BOOKX_MAX_SIZE_FILTER_LIST . '" style="width: 90%; margin: auto;"');
          $content .= '</form>';
      } else {
          $content .= '<div class="bookx_filter_sidebox_popup_label">' . LABEL_FILTER_AUTHOR . '</div>';
      }
      $content .= zen_draw_form('bookx_authors_form', zen_href_link(FILENAME_DEFAULT, '', $request_type, false), 'get', ($active_bx_filter_ids['author_id'] ? 'class="bxf_active"' : ''));
      if (isset($_GET['bookx_author_type_id']) && zen_not_null($_GET['bookx_author_type_id'])) {
          //*** author & author type can always be combined, so if an ATypeId is set, we keep it
          $content .= zen_draw_hidden_field('bookx_author_type_id', (int)$_GET['bookx_author_type_id']);
      }
	  $content .= $hidden_publisher_id_field . $hidden_imprint_id_field . $hidden_series_id_field . $hidden_genre_id_field;
	  $content .= zen_draw_hidden_field('main_page', FILENAME_DEFAULT) . zen_hide_session_id() . zen_draw_hidden_field('typefilter', 'bookx');
	  $content .= zen_draw_pull_down_menu('bookx_author_id', $bookx_authors_array, $active_bx_filter_ids['author_id'], $author_filter_select_disabled . ' onchange="this.form.submit();" size="' . BOOKX_MAX_SIZE_FILTER_LIST . '" style="width: 90%; margin: auto;"');
	  $content .= '</form>';
  }

  // if a popup input is shown for authors, then the "authors list" link is already part of that popup
  if ($show_link_author_list && !$show_author_filter) {
  	$content .= '<div class="bookx_filter_sidebox_link"><a href="' . zen_href_link(FILENAME_BOOKX_AUTHORS_LIST) . '">' . LABEL_LIST_ALL_AUTHORS . '</a></div>';
  }


  if ($show_publisher_filter) {
  	$content .= '<div class="bookx_filter_sidebox_popup_label">' . LABEL_FILTER_PUBLISHER . '</div>';
  	$content .= zen_draw_form('bookx_publishers_form', zen_href_link(FILENAME_DEFAULT, '', $request_type, false), 'get', ('' != $active_bx_filter_ids['publisher_id'] ? 'class="bxf_active"' : ''));
  	$content .= $hidden_author_id_field . $hidden_author_type_id_field . $hidden_imprint_id_field . $hidden_series_id_field . $hidden_genre_id_field;
  	$content .= zen_draw_hidden_field('main_page', FILENAME_DEFAULT) . zen_hide_session_id() . zen_draw_hidden_field('typefilter', 'bookx');
  	$content .= zen_draw_pull_down_menu('bookx_publisher_id', $bookx_publishers_array, $active_bx_filter_ids['publisher_id'], $publisher_filter_select_disabled . ' onchange="this.form.submit();" size="' . BOOKX_MAX_SIZE_FILTER_LIST . '" style="width: 90%; margin: auto;"');
  	$content .= '</form>';
  }
  
  // if a popup input is shown for publishers, then the "publishers list" link is already part of that popup
  if ($show_link_publisher_list && !$show_publisher_filter) {
      $content .= '<div class="bookx_filter_sidebox_link"><a href="' . zen_href_link(FILENAME_BOOKX_PUBLISHERS_LIST) . '">' . LABEL_LIST_ALL_PUBLISHERS . '</a></div>';
  }

  if ($show_imprint_filter) {
  	  $content .= '<div class="bookx_filter_sidebox_popup_label">' . LABEL_FILTER_IMPRINT . '</div>';
  	$content .= zen_draw_form('bookx_imprints_form', zen_href_link(FILENAME_DEFAULT, '', $request_type, false), 'get', ($active_bx_filter_ids['imprint_id'] ? 'class="bxf_active"' : ''));
  	$content .= $hidden_author_id_field . $hidden_author_type_id_field .  $hidden_publisher_id_field . $hidden_series_id_field . $hidden_genre_id_field;
  	$content .= zen_draw_hidden_field('main_page', FILENAME_DEFAULT) . zen_hide_session_id() . zen_draw_hidden_field('typefilter', 'bookx');
  	$content .= zen_draw_pull_down_menu('bookx_imprint_id', $bookx_imprints_array, $active_bx_filter_ids['imprint_id'], $imprint_filter_select_disabled . ' onchange="this.form.submit();" size="' . BOOKX_MAX_SIZE_FILTER_LIST . '" style="width: 90%; margin: auto;"');
  	$content .= '</form>';
  }
  
  // if a popup input is shown for imprints, then the "imprints list" link is already part of that popup
  if ($show_link_imprint_list && !$show_imprint_filter) {
      $content .= '<div class="bookx_filter_sidebox_link"><a href="' . zen_href_link(FILENAME_BOOKX_IMPRINTS_LIST) . '">' . LABEL_LIST_ALL_IMPRINTS . '</a></div>';
  }

  if ($show_series_filter) {
  	  $content .= '<div class="bookx_filter_sidebox_popup_label">' . LABEL_FILTER_SERIES . '</div>';
  	$content .= zen_draw_form('bookx_series_form', zen_href_link(FILENAME_DEFAULT, '', $request_type, false), 'get', ($active_bx_filter_ids['series_id'] ? 'class="bxf_active"' : ''));
  	$content .= $hidden_author_id_field . $hidden_author_type_id_field .  $hidden_publisher_id_field . $hidden_imprint_id_field . $hidden_genre_id_field;
  	$content .= zen_draw_hidden_field('main_page', FILENAME_DEFAULT) . zen_hide_session_id() . zen_draw_hidden_field('typefilter', 'bookx');
  	$content .= zen_draw_pull_down_menu('bookx_series_id', $bookx_series_array, $active_bx_filter_ids['series_id'], $series_filter_select_disabled . ' onchange="this.form.submit();" size="' . BOOKX_MAX_SIZE_FILTER_LIST . '" style="width: 90%; margin: auto;"');
  	$content .= '</form>';
  }

  // if a popup input is shown for series, then the "series list" link is already part of that popup
  if ($show_link_series_list && !$show_series_filter) {
  	$content .= '<div class="bookx_filter_sidebox_link"><a href="' . zen_href_link(FILENAME_BOOKX_SERIES_LIST) . '">' . LABEL_LIST_ALL_SERIES . '</a></div>';
  }

  if ($show_genre_filter) {
  	$content .= '<div class="bookx_filter_sidebox_popup_label">' . LABEL_FILTER_GENRE . '</div>';
  	$content .= zen_draw_form('bookx_genres_form', zen_href_link(FILENAME_DEFAULT, '', $request_type, false), 'get', ($active_bx_filter_ids['genre_id'] ? 'class="bxf_active"' : ''));
  	$content .= $hidden_author_id_field . $hidden_publisher_id_field . $hidden_imprint_id_field . $hidden_series_id_field;
  	$content .= zen_draw_hidden_field('main_page', FILENAME_DEFAULT) . zen_hide_session_id() . zen_draw_hidden_field('typefilter', 'bookx');
  	$content .= zen_draw_pull_down_menu('bookx_genre_id', $bookx_genres_array, $active_bx_filter_ids['genre_id'], $genre_filter_select_disabled . ' onchange="this.form.submit();" size="' . BOOKX_MAX_SIZE_FILTER_LIST . '" style="width: 90%; margin: auto;"');
  	$content .= '</form>';
  }
  
  // if a popup input is shown for genres, then the "genre list" link is already part of that popup
  if ($show_link_genres_list && !$show_genre_filter) {
      $content .= '<div class="bookx_filter_sidebox_link"><a href="' . zen_href_link(FILENAME_BOOKX_GENRES_LIST) . '">' . LABEL_LIST_ALL_GENRES . '</a></div>';
  }
  
  if (ALLOW_PRODUCT_BOOKX_FILTER_MULTIPLE && 1 < $active_bx_filter_ids['active_filter_count']) {
      $content .= '<div class="bookx_filter_sidebox_link"><a href="' . zen_href_link(FILENAME_DEFAULT) . '">' . BOOKX_LINK_TEXT_RESET_ALL_FILTERS . '</a></div>';
  }

  $content .= '</div>';
