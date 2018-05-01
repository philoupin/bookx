<?php
/**
 * This file is part of the ZenCart add-on Book X which
 * introduces a new product type for books to the Zen Cart
 * shop system. Tested for compatibility on ZC v. 1.5
 *
 * For latest version and support visit:
 * https://sourceforge.net/p/zencartbookx
 *
 * @package functions
 * @author  Philou
 * @copyright Copyright 2013
 * @copyright Portions Copyright 2003-2011 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.gnu.org/licenses/gpl.txt GNU General Public License V2.0
 *
 * @version BookX V 0.9.4-revision8 BETA
 * @version $Id: [ZC INSTALLATION]/includes/functions/extra_functions/functions_product_type_bookx.php 2016-02-02 philou $
 */


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

////
// Switch buy now button based on call for price sold out etc.
function bookx_get_buy_now_button($product_id, $link, $additional_link = false) {
	global $db;

	// show case only superceeds all other settings
	if (STORE_STATUS != '0') {
		return '<a href="' . zen_href_link(FILENAME_CONTACT_US) . '">' .  TEXT_SHOWCASE_ONLY . '</a>';
	}

	// 0 = normal shopping
	// 1 = Login to shop
	// 2 = Can browse but no prices
	// verify display of prices
	switch (true) {
		case (CUSTOMERS_APPROVAL == '1' and $_SESSION['customer_id'] == ''):
			// customer must be logged in to browse
			$login_for_price = '<a href="' . zen_href_link(FILENAME_LOGIN, '', 'SSL') . '">' .  TEXT_LOGIN_FOR_PRICE_BUTTON_REPLACE . '</a>';
			return $login_for_price;
			break;
		case (CUSTOMERS_APPROVAL == '2' and $_SESSION['customer_id'] == ''):
			if (TEXT_LOGIN_FOR_PRICE_PRICE == '') {
				// show room only
				return TEXT_LOGIN_FOR_PRICE_BUTTON_REPLACE;
			} else {
				// customer may browse but no prices
				$login_for_price = '<a href="' . zen_href_link(FILENAME_LOGIN, '', 'SSL') . '">' .  TEXT_LOGIN_FOR_PRICE_BUTTON_REPLACE . '</a>';
			}
			return $login_for_price;
			break;
			// show room only
		case (CUSTOMERS_APPROVAL == '3'):
			$login_for_price = TEXT_LOGIN_FOR_PRICE_BUTTON_REPLACE_SHOWROOM;
			return $login_for_price;
			break;
		case ((CUSTOMERS_APPROVAL_AUTHORIZATION != '0' and CUSTOMERS_APPROVAL_AUTHORIZATION != '3') and $_SESSION['customer_id'] == ''):
			// customer must be logged in to browse
			$login_for_price = TEXT_AUTHORIZATION_PENDING_BUTTON_REPLACE;
			return $login_for_price;
			break;
		case ((CUSTOMERS_APPROVAL_AUTHORIZATION == '3') and $_SESSION['customer_id'] == ''):
			// customer must be logged in and approved to add to cart
			$login_for_price = '<a href="' . zen_href_link(FILENAME_LOGIN, '', 'SSL') . '">' .  TEXT_LOGIN_TO_SHOP_BUTTON_REPLACE . '</a>';
			return $login_for_price;
			break;
		case (CUSTOMERS_APPROVAL_AUTHORIZATION != '0' and $_SESSION['customers_authorization'] > '0'):
			// customer must be logged in to browse
			$login_for_price = TEXT_AUTHORIZATION_PENDING_BUTTON_REPLACE;
			return $login_for_price;
			break;
		default:
			// proceed normally
			break;
	}

	$sql = 'SELECT p.product_is_call, p.products_quantity, p.products_date_available, be.publishing_date,
				   DATEDIFF("' . date('Y-m-d') . '",
						  CONCAT_WS("-",
							        SUBSTRING(be.publishing_date, 1,4 ),
							        IF(SUBSTRING(be.publishing_date, 6,2 ) = "00", "01", SUBSTRING(be.publishing_date, 6,2 ) ),
							        IF(SUBSTRING(be.publishing_date, 9,2 )  = "00", "01", SUBSTRING(be.publishing_date, 9,2 )))) AS datediff
			FROM ' . TABLE_PRODUCTS . ' p
			LEFT JOIN ' . TABLE_PRODUCT_BOOKX_EXTRA . ' be ON be.products_id = p.products_id
			WHERE p.products_id = "' . (int)$product_id . '"';

	$button_check = $db->Execute($sql);
	switch (true) {
		// cannot be added to the cart
		case (zen_get_products_allow_add_to_cart($product_id) == 'N'):
			return $additional_link;
			break;

		case ($button_check->fields['product_is_call'] == '1'):
			$return_button = '<a href="' . zen_href_link(FILENAME_CONTACT_US) . '">' . TEXT_CALL_FOR_PRICE . '</a>';
			break;
			
		case (0 < $button_check->fields['products_quantity'] && !empty($button_check->fields['publishing_date']) && !empty($button_check->fields['datediff']) && 0 < $button_check->fields['datediff'] && $button_check->fields['datediff'] < BOOKX_NEW_PRODUCTS_LOOK_BACK_NUMBER_OF_DAYS):
		    /* Product has a set Publishing Date and that date is in the past but within the range of a "new book". It also has available stock, so we treat as "new" */		    
		    $return_button = zen_image_submit(BUTTON_IMAGE_BOOKX_NEW, BUTTON_IMAGE_BOOKX_NEW_ALT, 'class="new_product"');
		    break;

	    case (0 == $button_check->fields['products_quantity'] && !empty($button_check->fields['publishing_date']) && !empty($button_check->fields['datediff']) && $button_check->fields['datediff'] > BOOKX_NEW_PRODUCTS_LOOK_BACK_NUMBER_OF_DAYS):
			/* There's no available stock and Product has a set Publishing Date and that date is in the past within the range of a "new book" */
	        if (!empty($button_check->fields['products_date_available']) && $button_check->fields['products_date_available'] > date('Y-m-d')) {
	            /* Product has a "Date Available" which is in the future, so we show it as coming soon */
	            $return_button = zen_image_submit(BUTTON_IMAGE_BOOKX_TEMPORARILY_UNAVAILABLE, BUTTON_IMAGE_BOOKX_TEMPORARILY_UNAVAILABLE_ALT, 'class="new_product"');	             
	        } else {
				/* We treat this book as still upcoming, since it is in the "new" range, but not yet in stock */
				$return_button = zen_image_button(BUTTON_IMAGE_BOOKX_UPCOMING, BUTTON_IMAGE_BOOKX_UPCOMING_ALT, 'class="upcoming_product"');
	        }
	        break;
		    
        case (0 == $button_check->fields['products_quantity'] && (empty($button_check->fields['publishing_date']) || (!empty($button_check->fields['publishing_date']) && !empty($button_check->fields['datediff']) && $button_check->fields['datediff'] > BOOKX_NEW_PRODUCTS_LOOK_BACK_NUMBER_OF_DAYS))):
		/* There's no available stock and Publishing Date is not set or older than range for "new" books  */
            if (SHOW_PRODUCTS_SOLD_OUT_IMAGE == '0' || (!empty($button_check->fields['products_date_available']) && $button_check->fields['products_date_available'] > date('Y-m-d'))) {
                /* Product has a "Date Available" which is in the future, so we show it as coming soon */
                $return_button = zen_image_submit(BUTTON_IMAGE_BOOKX_TEMPORARILY_UNAVAILABLE, BUTTON_IMAGE_BOOKX_TEMPORARILY_UNAVAILABLE_ALT, 'class="new_product"');
            } else {
			/* We treat this book as permanently out of stock */
                if ($_GET['main_page'] == zen_get_info_page($product_id)) {
                    $return_button = zen_image_button(BUTTON_IMAGE_SOLD_OUT, BUTTON_SOLD_OUT_ALT, 'class="outofstock_product"');
                } else {
                    $return_button = zen_image_button(BUTTON_IMAGE_SOLD_OUT_SMALL, BUTTON_SOLD_OUT_SMALL_ALT, 'class="outofstock_product"');
                }
            }
            break;

	        case (0 < $button_check->fields['products_quantity'] && (empty($button_check->fields['publishing_date']) || (!empty($button_check->fields['publishing_date']) && !empty($button_check->fields['datediff']) && $button_check->fields['datediff'] > BOOKX_NEW_PRODUCTS_LOOK_BACK_NUMBER_OF_DAYS))):
			     /* This book is in stock and Publishing Date is not set or older than range for "new" books, so we treat it as "available"  */
			     $return_button = $link;
	            break;
	            
            case (!empty($button_check->fields['publishing_date']) && !empty($button_check->fields['datediff']) && 0 > $button_check->fields['datediff'] && BOOKX_UPCOMING_PRODUCTS_LOOK_AHEAD_NUMBER_OF_DAYS >= $button_check->fields['datediff']):
			     /* Product has a set Publishing Date and that date is in the future but within the range of an "upcoming book", so we treat it as upcoming */
                if (0 < $button_check->fields['products_quantity']) {
                    /* This book also has available stock, so it can be (pre-)ordered */
                    $return_button = zen_image_submit(BUTTON_IMAGE_BOOKX_UPCOMING_PREORDER, BUTTON_IMAGE_BOOKX_UPCOMING_PREORDER_ALT, 'class="upcoming_product"');                   
                } else {
				    $return_button = zen_image_button(BUTTON_IMAGE_BOOKX_UPCOMING, BUTTON_IMAGE_BOOKX_UPCOMING_ALT, 'class="upcoming_product"');
                }
                break;
	                 
	                
		default:
			$return_button = $link;
			break;
	}
	if ($return_button != $link and $additional_link != false) {
		return $additional_link . '<br />' . $return_button;
	} else {
		return $return_button;
	}
}

/*
 * This function checks for active Bookx filters and stores their IDs in an array. 
 * 
 */
	function bookx_get_active_filter_ids() {

	    
	    $active_bx_filter_ids = array();
	    
	    $active_bx_filter_ids['author_type_id'] = false;
	    $active_bx_filter_ids['author_id'] = false;
	    $active_bx_filter_ids['genre_id'] = false;
	    $active_bx_filter_ids['series_id'] = false;
	    $active_bx_filter_ids['imprint_id'] = false;
	    $active_bx_filter_ids['publisher_id'] = false;
	    
	    $active_bx_filter_ids['active_filter_count'] = 0;

        if (isset($_GET['bookx_author_type_id']) && zen_not_null($_GET['bookx_author_type_id'])) {
            $active_bx_filter_ids['author_type_id'] = (int)$_GET['bookx_author_type_id'];
            $active_bx_filter_ids['active_filter_count']++;
        } 

        if (isset($_GET['bookx_author_id']) && zen_not_null($_GET['bookx_author_id'])) {
            $active_bx_filter_ids['author_id'] = (int)$_GET['bookx_author_id'];
            $active_bx_filter_ids['active_filter_count']++;
        } 
        
        if (isset($_GET['bookx_genre_id']) && zen_not_null($_GET['bookx_genre_id'])) {
            $active_bx_filter_ids['genre_id'] = (int)$_GET['bookx_genre_id'];
            $active_bx_filter_ids['active_filter_count']++;
        } 
        
        if (isset($_GET['bookx_series_id']) && zen_not_null($_GET['bookx_series_id'])) {
            $active_bx_filter_ids['series_id'] = (int)$_GET['bookx_series_id'];
            $active_bx_filter_ids['active_filter_count']++;
        } 
        
        if (isset($_GET['bookx_imprint_id']) && zen_not_null($_GET['bookx_imprint_id'])) {
            $active_bx_filter_ids['imprint_id'] = (int)$_GET['bookx_imprint_id'];
            $active_bx_filter_ids['active_filter_count']++;
        } 
        
        if (isset($_GET['bookx_publisher_id']) && zen_not_null($_GET['bookx_publisher_id'])) {
            $active_bx_filter_ids['publisher_id'] = (int)$_GET['bookx_publisher_id'];
            $active_bx_filter_ids['active_filter_count']++;
        } 
                
        return $active_bx_filter_ids;
	}
	
	/*
	 * This function checks for active Bookx filters and stores extra JOIN and WHERE
	 * parts in an array.
	 *
	 */
	function bookx_get_active_filter_query_parts($active_bx_filter_ids = array()) {
	    $extra_filter_query_parts = array('join_multi_filter' => '', 'join' => array(), 'where' => array());
	    	    
	    $extra_filter_query_parts['join']['author'] = '';
	    $extra_filter_query_parts['join']['author_type'] = '';
	    $extra_filter_query_parts['join']['genre'] = '';
	    $extra_filter_query_parts['join']['series'] = '';
	    $extra_filter_query_parts['join']['imprint'] = '';
	    $extra_filter_query_parts['join']['publisher'] = '';
	    
	    $extra_filter_query_parts['where']['author'] = '';
	    $extra_filter_query_parts['where']['author_type'] = '';
	    $extra_filter_query_parts['where']['genre'] = '';
	    $extra_filter_query_parts['where']['series'] = '';
	    $extra_filter_query_parts['where']['imprint'] = '';
	    $extra_filter_query_parts['where']['publisher'] = '';
	    
	    if (ALLOW_PRODUCT_BOOKX_FILTER_MULTIPLE) {
	        if ($active_bx_filter_ids['active_filter_count'] > 0) {
	            $extra_filter_query_parts['join_multi_filter'] = ' LEFT JOIN ' . TABLE_PRODUCT_BOOKX_EXTRA . ' be ';
	        }
	    
	        if ($active_bx_filter_ids['author_id']) {
	            $extra_filter_query_parts['join']['author'] = ' LEFT JOIN ' . TABLE_PRODUCT_BOOKX_AUTHORS_TO_PRODUCTS . ' batp1 ON batp1.products_id = be.products_id ';
	            $extra_filter_query_parts['where']['author'] = ' batp1.bookx_author_id = "' . $active_bx_filter_ids['author_id'] . '" ';
	        }
	    
	        if ($active_bx_filter_ids['author_type_id'] && $active_bx_filter_ids['author_id']) { ///*** we filter only the combination author & author_type
	            $extra_filter_query_parts['join']['author_type'] = ' LEFT JOIN ' . TABLE_PRODUCT_BOOKX_AUTHORS_TO_PRODUCTS . ' batp2 ON batp2.products_id = be.products_id ';
	            $extra_filter_query_parts['where']['author_type'] = ' batp2.bookx_author_type_id = "' . $active_bx_filter_ids['author_type_id'] . '" ';
	        }
	    
	        if ($active_bx_filter_ids['genre_id']) {
	            $extra_filter_query_parts['join']['genre'] = ' LEFT JOIN ' . TABLE_PRODUCT_BOOKX_GENRES_TO_PRODUCTS . ' gtp ON gtp.products_id = be.products_id
                               LEFT JOIN ' . TABLE_PRODUCT_BOOKX_GENRES . ' bg ON gtp.bookx_genre_id = bg.bookx_genre_id ';
	            $extra_filter_query_parts['where']['genre'] = ' bg.bookx_genre_id = "' . $active_bx_filter_ids['genre_id'] . '" ';
	        }
	    
	        if ($active_bx_filter_ids['series_id']) {
	            $extra_filter_query_parts['join']['series'] = ' LEFT JOIN ' . TABLE_PRODUCT_BOOKX_SERIES . ' bs ON bs.bookx_series_id = be.bookx_series_id ';
	            $extra_filter_query_parts['where']['series'] = ' bs.bookx_series_id = "' . $active_bx_filter_ids['series_id'] . '" ';
	        }
	    
	        if ($active_bx_filter_ids['imprint_id']) {
	            $extra_filter_query_parts['join']['imprint'] = ' LEFT JOIN ' . TABLE_PRODUCT_BOOKX_IMPRINTS . ' bi ON bi.bookx_imprint_id = be.bookx_imprint_id ';
	            $extra_filter_query_parts['where']['imprint'] = ' bi.bookx_imprint_id = "' . $active_bx_filter_ids['imprint_id'] . '" ';
	        }
	    
	        if ($active_bx_filter_ids['publisher_id']) {
	            $extra_filter_query_parts['join']['publisher'] = ' LEFT JOIN ' . TABLE_PRODUCT_BOOKX_PUBLISHERS . ' bpub ON bpub.bookx_publisher_id = be.bookx_publisher_id ';
	            $extra_filter_query_parts['where']['publisher'] = ' bpub.bookx_publisher_id = "' . $active_bx_filter_ids['publisher_id'] . '" ';
	        }
	    }
	    
	    return $extra_filter_query_parts;
	}
	
	
	/*
	 * This function assembles the JOIN parts for a multiple filter query, omitting any specified parts
	 */	
	function bookx_assemble_filter_extra_join($extra_filter_join_parts = array(), $omit_parts = array()) {
	   $extra_filter_join_parts = array_filter($extra_filter_join_parts);
	   
	   foreach ($extra_filter_join_parts as $key => $join_clause) {
	       if (in_array($key, $omit_parts)) {
	           unset($extra_filter_join_parts[$key]);
	       }
	   }    
	   return implode( ' ', $extra_filter_join_parts);	   
	}
	
	
	/*
	 * This function assembles the WHERE parts for a multiple filter query, omitting any specified parts
	 */
	function bookx_assemble_filter_extra_where($extra_filter_where_parts = array(), $omit_parts = array()) {
	    $extra_filter_where_parts = array_filter($extra_filter_where_parts);
	
	    foreach ($extra_filter_where_parts as $key => $where_clause) {
	        if (in_array($key, $omit_parts)) {
	            unset($extra_filter_where_parts[$key]);
	        }
	    }
	    if (!empty($extra_filter_where_parts)) {
	       return ' AND ' . implode( ' AND ', $extra_filter_where_parts);
	    } else {
	        return '';
	    }
	}
	
	/*
	 * This function will try to truncate a paragraph after a period, rather than just anywhere inbetween two words
	 * taken from http://alanwhipple.com/2011/05/25/php-truncate-string-preserving-html-tags-words/
	 */
	/**
	 * truncateHtml can truncate a string up to a number of characters while preserving whole words and HTML tags
	 *
	 * @param string $text String to truncate.
	 * @param integer $length Length of returned string, including ellipsis.
	 * @param string $ending Ending to be appended to the trimmed string.
	 * @param boolean $exact If false, $text will not be cut mid-word
	 * @param boolean $considerHtml If true, HTML tags would be handled correctly
	 * @param boolean $endWithSentence If true, $text will be truncated afetr last occurence of a period with limits of $length
	 *
	 * @return string Trimmed string.
	 */
	function bookx_truncate_paragraph($text, $length = 100, $ending = '...', $exact = false, $considerHtml = true, $endWithSentence = true) {
	    if ($considerHtml) {
	        // if the plain text is shorter than the maximum length, return the whole text
	        if (strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
	            return $text;
	        }
	        // splits all html-tags to scanable lines
	        preg_match_all('/(<.+?>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER);
	        $total_length = strlen($ending);
	        $open_tags = array();
	        $truncate = '';
	        foreach ($lines as $line_matchings) {
	            // if there is any html-tag in this line, handle it and add it (uncounted) to the output
	            if (!empty($line_matchings[1])) {
	                // if it's an "empty element" with or without xhtml-conform closing slash
	                if (preg_match('/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is', $line_matchings[1])) {
	                    // do nothing
	                    // if tag is a closing tag
	                } else if (preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $line_matchings[1], $tag_matchings)) {
	                    // delete tag from $open_tags list
	                    $pos = array_search($tag_matchings[1], $open_tags);
	                    if ($pos !== false) {
	                        unset($open_tags[$pos]);
	                    }
	                    // if tag is an opening tag
	                } else if (preg_match('/^<\s*([^\s>!]+).*?>$/s', $line_matchings[1], $tag_matchings)) {
	                    // add tag to the beginning of $open_tags list
	                    array_unshift($open_tags, strtolower($tag_matchings[1]));
	                }
	                // add html-tag to $truncate'd text
	                $truncate .= $line_matchings[1];
	            }
	            // calculate the length of the plain text part of the line; handle entities as one character
	            $content_length = strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', ' ', $line_matchings[2]));
	            if ($total_length+$content_length> $length) {
	                // the number of characters which are left
	                $left = $length - $total_length;
	                $entities_length = 0;
	                // search for html entities
	                if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', $line_matchings[2], $entities, PREG_OFFSET_CAPTURE)) {
	                    // calculate the real length of all entities in the legal range
	                    foreach ($entities[0] as $entity) {
	                        if ($entity[1]+1-$entities_length <= $left) {
	                            $left--;
	                            $entities_length += strlen($entity[0]);
	                        } else {
	                            // no more characters left
	                            break;
	                        }
	                    }
	                }
	                $truncate .= substr($line_matchings[2], 0, $left+$entities_length);
	                // maximum lenght is reached, so get off the loop
	                break;
	            } else {
	                $truncate .= $line_matchings[2];
	                $total_length += $content_length;
	            }
	            // if the maximum length is reached, get off the loop
	            if($total_length>= $length) {
	                break;
	            }
	        }
	    } else {
	        if (strlen($text) <= $length) {
	            return $text;
	        } else {
	            $truncate = substr($text, 0, $length - strlen($ending));
	        }
	    }
	    // if the words shouldn't be cut in the middle...
	    if (!$exact) {
	        if ($endWithSentence) {
	            // ... search the last occurrence with a period
	            preg_match_all('/(\? )|(! )|(\. )/', $truncate, $matches, PREG_OFFSET_CAPTURE);
	            for ($i = count($matches[0])-1; $i >= 0; $i--) {
	                if ($matches[0][$i][1] > 0) {
	                    $spacepos = $matches[0][$i][1];
	                    $ending = '..' . substr($matches[0][$i][0], 0, 1);
	                    break;
	                }
	            }
	            //$spacepos = strrpos($truncate, '. ');
	            if (0 > $spacepos) {
	                // ...search the last occurence of a space...
	                $spacepos = strrpos($truncate, ' ');
	            }
	        } else {
    	        // ...search the last occurence of a space...
    	        $spacepos = strrpos($truncate, ' ');
	        }
	        if (isset($spacepos)) {
	            // ...and cut the text in this position
	            $truncate = substr($truncate, 0, $spacepos);
	        }
	    }
	    // add the defined ending to the text
	    $truncate .= $ending;
	    if($considerHtml) {
	        // close all unclosed html-tags
	        foreach ($open_tags as $tag) {
	            $truncate .= '</' . $tag . '>';
	        }
	    }
	    return $truncate;
	}
	/*function bookx_truncate_paragraph($paragraph, $max_num_of_chars = 100, $word = ' ') {
	    $zv_paragraph = "";
	    $word = explode(" ", $paragraph);
	    $zv_total = count($word);
	    if ($zv_total > $maxsize) {
	        $x=$maxsize;
	        for ($x; $x > 0; $x--) {
	           if ('.' == substr( $word[$x], -1)) break;
	        }
	        for ($x; $x > 0; $x--) {
	            $zv_paragraph = $word[$x] . " " . $zv_paragraph;
	        }
	        $zv_paragraph = trim($zv_paragraph);
	    } else {
	        $zv_paragraph = trim($paragraph);
	    }
	    return $zv_paragraph;
	}*/

	function bookx_highlight_search_terms($keywords = array(), $content = '', $span_class = 'search-term-hi') {
	    if (!empty($keywords) && is_array($keywords) && !empty($content)) {
            foreach ($keywords as $keyword) {
                //$content = str_replace($keyword, '<span class="' . $span_class . '">' . $keyword . '</span>', $content);
                $content = preg_replace("/".preg_quote($keyword, "/")."/i", "<span class='{$span_class}'>$0</span>", $content);
            }
        }
        return $content;
    }
	
	
