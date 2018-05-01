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
 * @version $Id: preview_info.php 2016-02-02 philou $
 */

if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}


    if (zen_not_null($_POST)) {
      $pInfo = new objectInfo($_POST);
      $products_name = $_POST['products_name'];
      $products_descriptions = $_POST['products_description'];
      $products_url = $_POST['products_url'];

      //**** BookX data which is not language specific
      $tmp_value = (isset($_POST['bookx_publisher_id']) ? zen_db_prepare_input($_POST['bookx_publisher_id']) : null);
      $pInfo->publisher = (!zen_not_null($tmp_value) || $tmp_value=='' || $tmp_value == 0) ? null : bookx_get_publisher_name($tmp_value);

      $tmp_value = (isset($_POST['bookx_imprint_id']) ? zen_db_prepare_input($_POST['bookx_imprint_id']) : null);
      $pInfo->imprint = (!zen_not_null($tmp_value) || $tmp_value=='' || $tmp_value == 0) ? null : bookx_get_imprint_name($tmp_value);

      $tmp_value = zen_db_prepare_input($_POST['publishing_date']);
      $pInfo->publishing_date = (!zen_not_null($tmp_value) || $tmp_value=='' || $tmp_value == 0) ? null : $tmp_value;

      $tmp_value = zen_db_prepare_input($_POST['pages']);
      $pInfo->pages = (!zen_not_null($tmp_value) || $tmp_value=='' || $tmp_value == 0) ? null : $tmp_value;

      $tmp_value = zen_db_prepare_input($_POST['volume']);
      $pInfo->volume = (!zen_not_null($tmp_value) || $tmp_value=='' || $tmp_value == 0) ? null : $tmp_value;

      $tmp_value = zen_db_prepare_input($_POST['size']);
      $pInfo->size = (!zen_not_null($tmp_value) || $tmp_value=='' || $tmp_value == 0) ? null : $tmp_value;

      $tmp_value = zen_db_prepare_input($_POST['isbn']);
      $pInfo->isbn_display = (!zen_not_null($tmp_value) || $tmp_value=='' || $tmp_value == 0) ? null : bookx_format_isbn_for_display($tmp_value);


      //**** BookX data which has language sepcific names / descriptions to display
      $tmp_value = (isset($_POST['bookx_binding_id']) ? zen_db_prepare_input($_POST['bookx_binding_id']) : null);
      $pInfo->bookx_binding_id = (!zen_not_null($tmp_value) || $tmp_value=='' || $tmp_value == 0) ? null : $tmp_value;

      $tmp_value = (isset($_POST['bookx_printing_id']) ? zen_db_prepare_input($_POST['bookx_printing_id']) : null);
      $pInfo->bookx_printing_id = (!zen_not_null($tmp_value) || $tmp_value=='' || $tmp_value == 0) ? null : $tmp_value;

      $tmp_value = (isset($_POST['bookx_condition_id']) ? zen_db_prepare_input($_POST['bookx_condition_id']) : null);
      $pInfo->bookx_condition_id = (!zen_not_null($tmp_value) || $tmp_value=='' || $tmp_value == 0) ? null : $tmp_value;

      $tmp_value = (isset($_POST['bookx_series_id']) ? zen_db_prepare_input($_POST['bookx_series_id']) : null);
      $pInfo->bookx_series_id = (!zen_not_null($tmp_value) || $tmp_value=='' || $tmp_value == 0) ? null : $tmp_value;

      $products_subtitle = $_POST['products_subtitle'];


      $pInfo->genres_display = '';
      if (isset($_POST['bookx_genre_id']) && is_array($_POST['bookx_genre_id'])) {
      	$bookx_genre_ids = $_POST['bookx_genre_id'];
      	foreach ($bookx_genre_ids as $genre) {
      		$pInfo->genres_display .= (!empty($pInfo->genres_display) ? ' | ' : '') . bookx_get_genre_description($genre, (int)$_SESSION['languages_id']);
      	}
      }

      $pInfo->authors_display = '';
      if (isset($_POST['bookx_author_id']) && is_array($_POST['bookx_author_id'])) {
      	$bookx_author_ids = $_POST['bookx_author_id'];
      	$bookx_author_type_ids = (isset($_POST['bookx_author_type_id']) && is_array($_POST['bookx_author_type_id']) ? $_POST['bookx_author_type_id'] : null);

      	foreach ($bookx_author_ids as $key => $author_id) {
      		$pInfo->authors_display .= (!empty($pInfo->authors_display) ? ' | ' : '') . ($bookx_author_type_ids ? bookx_get_author_type_description($bookx_author_type_ids[$key], (int)$_SESSION['languages_id']) . ': ' : '') . bookx_get_author_name($author_id);
      	}
      }

    } else {
      $product = $db->Execute('SELECT p.products_id, pd.language_id, pd.products_name,
                                      pd.products_description, pd.products_url, p.products_quantity,
                                      p.products_model, p.products_image, p.products_price, p.products_virtual,
                                      p.products_weight, p.products_date_added, p.products_last_modified,
                                      p.products_date_available, p.products_status, p.manufacturers_id,
                                      p.products_quantity_order_min, p.products_quantity_order_units, p.products_priced_by_attribute,
                                      p.product_is_free, p.product_is_call, p.products_quantity_mixed,
                                      p.product_is_always_free_shipping, p.products_qty_box_status, p.products_quantity_order_max,
                   					  p.products_sort_order,

      		  						  be.bookx_publisher_id, be.bookx_series_id, be.bookx_imprint_id,
      								  be.bookx_binding_id, be.bookx_printing_id, be.bookx_condition_id, be.publishing_date, be.pages, be.volume, be.size,
      								  CONCAT_WS("-", SUBSTRING(be.isbn,1,3), SUBSTRING(be.isbn,4,1), SUBSTRING(be.isbn,5,6), SUBSTRING(be.isbn,11,2), SUBSTRING(be.isbn,13,1)) AS isbn_display,
      								  bp.publisher_name AS publisher, bi.imprint_name AS imprint

                               FROM ' . TABLE_PRODUCTS . ' p
      		 				   LEFT JOIN ' . TABLE_PRODUCTS_DESCRIPTION . ' pd ON p.products_id = pd.products_id
      						   LEFT JOIN ' . TABLE_PRODUCT_BOOKX_EXTRA . ' be ON be.products_id = p.products_id
      						   LEFT JOIN ' . TABLE_PRODUCT_BOOKX_EXTRA_DESCRIPTION . ' bed ON bed.products_id = p.products_id AND bed.languages_id = pd.language_id
					      	   LEFT JOIN ' . TABLE_PRODUCT_BOOKX_PUBLISHERS . ' bp ON bp.bookx_publisher_id = be.bookx_publisher_id
					      	   LEFT JOIN ' . TABLE_PRODUCT_BOOKX_IMPRINTS . ' bi ON bi.bookx_imprint_id = be.bookx_imprint_id
                               WHERE p.products_id = "' . (int)$_GET['pID'] . '"');

      $pInfo = new objectInfo($product->fields);
      $products_image_name = $pInfo->products_image;

      $authors = $db->Execute('SELECT ba.author_name, batd.type_description
                             FROM ' . TABLE_PRODUCT_BOOKX_AUTHORS_TO_PRODUCTS . ' bpta
    						 LEFT JOIN ' . TABLE_PRODUCT_BOOKX_AUTHORS . ' ba ON ba.bookx_author_id = bpta.bookx_author_id
    						 LEFT JOIN ' . TABLE_PRODUCT_BOOKX_AUTHOR_TYPES_DESCRIPTION . ' batd ON bpta.bookx_author_type_id = batd.bookx_author_type_id AND batd.languages_id = "' . (int)$_SESSION['languages_id'] . '"
    						 WHERE bpta.products_id = "' . (int)$_GET['pID'] . '"
    						 ORDER BY ba.author_sort_order, ba.author_name');

      $pInfo->authors_display = '';
      while (!$authors->EOF) {
      	$pInfo->authors_display .= (!empty($pInfo->authors_display) ? ' | ' : '') . $authors->fields['type_description'] . ': ' . $authors->fields['author_name'];
      	$authors->MoveNext();
      }


      $genres = $db->Execute('SELECT gd.genre_description
                           FROM ' . TABLE_PRODUCT_BOOKX_GENRES_TO_PRODUCTS . ' gtp
    					   LEFT JOIN ' . TABLE_PRODUCT_BOOKX_GENRES_DESCRIPTION . ' gd ON gtp.bookx_genre_id = gd.bookx_genre_id AND gd.languages_id = "' . $_SESSION['languages_id'] . '"
    					   WHERE gtp.products_id = "' . (int)$_GET['pID'] . '"
    					   ORDER BY gd.genre_description');

      $pInfo->genres_display = '';
      while (!$genres->EOF) {
      	$pInfo->genres_display .= (!empty($pInfo->genres_display) ? ' | ' : '') . $genres->fields['genre_description'];
      	$genres->MoveNext();
      }

    }

    //** look for additional preview_info*.php files and include now **//
    $incl_dir = @dir(DIR_FS_ADMIN . '/includes/modules/product_bookx');
    while ($file = $incl_dir->read()) {
    	if ('preview_info_' == substr($file, 0, 13)) {
    		include_once DIR_FS_ADMIN . '/includes/modules/product_bookx/' . $file; // This should handle any extra values collected in collect_info*.php
    	}
    }
    $incl_dir->close();

    $form_action = (isset($_GET['pID'])) ? 'update_product' : 'insert_product';

    echo zen_draw_form($form_action, $type_admin_handler, 'cPath=' . $cPath . (isset($_GET['product_type']) ? '&product_type=' . $_GET['product_type'] : '') . (isset($_GET['pID']) ? '&pID=' . $_GET['pID'] : '') . '&action=' . $form_action . (isset($_GET['page']) ? '&page=' . $_GET['page'] : ''), 'post', 'enctype="multipart/form-data"');

	//(int)$_SESSION['languages_id']
    include_once DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/product_bookx_info.php';
    include_once DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/extra_definitions/product_bookx.php';

    $languages = zen_get_languages();
    for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
      if (isset($_GET['read']) && ($_GET['read'] == 'only')) {
        $pInfo->products_name = zen_get_products_name($pInfo->products_id, $languages[$i]['id']);
        $pInfo->products_description = zen_get_products_description($pInfo->products_id, $languages[$i]['id']);
        $pInfo->products_url = zen_get_products_url($pInfo->products_id, $languages[$i]['id']);

        $pInfo->products_subtitle = bookx_get_products_subtitle($pInfo->products_id, $languages[$i]['id']);
        $pInfo->series = bookx_get_series_name($pInfo->bookx_series_id, $languages[$i]['id']);
        $pInfo->binding = bookx_get_binding_description($pInfo->bookx_binding_id, $languages[$i]['id']);
        $pInfo->printing = bookx_get_printing_description($pInfo->bookx_printing_id, $languages[$i]['id']);
        $pInfo->condition = bookx_get_condition_description($pInfo->bookx_condition_id, $languages[$i]['id']);

        $bookx_extra_attributes = (!empty($pInfo->pages) ? sprintf(LABEL_BOOKX_PAGES, $pInfo->pages) : '');
        $bookx_extra_attributes .= (!empty($pInfo->binding) ? (!empty($bookx_extra_attributes) ? ' | ' : '') . $pInfo->binding : '');
        $bookx_extra_attributes .= (!empty($pInfo->printing) ? (!empty($bookx_extra_attributes) ? ' | ' : '') . $pInfo->printing : '');
        $bookx_extra_attributes .= (!empty($pInfo->size) ? (!empty($bookx_extra_attributes) ? ' | ' : '') . $pInfo->size : '');
        $bookx_extra_attributes .= (!empty($pInfo->condition) ? (!empty($bookx_extra_attributes) ? ' | ' : '') . $pInfo->condition : '');

        $pInfo->genres = '';
        if (!empty($bookx_genre_ids) && is_array($bookx_genre_ids)) {
        	$pInfo->genres = array();
        	foreach ($bookx_genre_ids as $genre_id) {
        		$pInfo->genres[] = bookx_get_genre_description($genre_id, $languages[$i]['id']);
        	}
        }

        $pInfo->authors = '';
        if (!empty($bookx_author_ids) && is_array($bookx_author_ids)) {
        	$pInfo->authors = array();

        	foreach ($bookx_author_ids as $key => $author_id) {
        		$pInfo->authors[] = array(bookx_get_genre_description($author_id, $languages[$i]['id']),
        								  bookx_get_author_type_description($bookx_author_type_ids[$key], $languages[$i]['id'])
        								  );
        	}
        }
      } else {
        $pInfo->products_name = zen_db_prepare_input($products_name[$languages[$i]['id']]);
        $pInfo->products_description = zen_db_prepare_input($products_descriptions[$languages[$i]['id']]);
        $pInfo->products_url = zen_db_prepare_input($products_url[$languages[$i]['id']]);

        $pInfo->products_subtitle = zen_db_prepare_input($products_subtitle[$languages[$i]['id']]);
      }

      $specials_price = zen_get_products_special_price((int)$_GET['pID']);
?>
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading">
            	<?php
            		echo zen_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) .
            			 '&nbsp;' . zen_output_string_protected($pInfo->products_name) . (!empty($pInfo->volume) ? ' ' . $pInfo->volume : '') .
            			 (!empty($pInfo->products_subtitle) ? ' &ndash; ' . $pInfo->products_subtitle : '');
            	?>
            </td>
            <td class="pageHeading" align="right"><?php echo $currencies->format($pInfo->products_price) . ($pInfo->products_virtual == 1 ? '<span class="errorText">' . '<br />' . TEXT_VIRTUAL_PREVIEW . '</span>' : '') . ($pInfo->product_is_always_free_shipping == 1 ? '<span class="errorText">' . '<br />' . TEXT_FREE_SHIPPING_PREVIEW . '</span>' : '') . ($pInfo->products_priced_by_attribute == 1 ? '<span class="errorText">' . '<br />' . TEXT_PRODUCTS_PRICED_BY_ATTRIBUTES_PREVIEW . '</span>' : '') . ($pInfo->product_is_free == 1 ? '<span class="errorText">' . '<br />' . TEXT_PRODUCTS_IS_FREE_PREVIEW . '</span>' : '') . ($pInfo->product_is_call == 1 ? '<span class="errorText">' . '<br />' . TEXT_PRODUCTS_IS_CALL_PREVIEW . '</span>' : '') . ($pInfo->products_qty_box_status == 0 ? '<span class="errorText">' . '<br />' . TEXT_PRODUCTS_QTY_BOX_STATUS_PREVIEW . '</span>' : '') . ($pInfo->products_priced_by_attribute == 1 ? '<br />' . zen_get_products_display_price($_GET['pID']) : ''); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="main">
          <?php
          	echo (!empty($pInfo->authors_display) ? LABEL_AUTHORS . $pInfo->authors_display . '<br />' : '') .
          	     (!empty($pInfo->genres_display) ? LABEL_BOOKX_GENRE . ': ' . $pInfo->genres_display . '<br />' : '') .
          	     $bookx_extra_attributes .
            	 (!empty($pInfo->isbn_display) ? '<br />' . LABEL_BOOKX_ISBN . ': ' . $pInfo->isbn_display : '') .
            	 (!empty($pInfo->series) ? '<br />' . LABEL_SERIES . ' ' . $pInfo->series : '') .
            	 (!empty($pInfo->publisher) ? '<br />' . LABEL_PUBLISHER . ' ' . $pInfo->publisher : '') .
            	 (!empty($pInfo->imprint) ? '<br />' . LABEL_IMPRINT . ' ' . $pInfo->imprint : '');

			//auto replace with defined missing image
            if ($_POST['products_image_manual'] != '') {
              $products_image_name = $_POST['img_dir'] . $_POST['products_image_manual'];
              $pInfo->products_name = $products_image_name;
            }
            if ($_POST['image_delete'] == 1 || $products_image_name == '' and PRODUCTS_IMAGE_NO_IMAGE_STATUS == '1') {
              echo zen_image(DIR_WS_CATALOG_IMAGES . PRODUCTS_IMAGE_NO_IMAGE, $pInfo->products_name, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'align="right" hspace="5" vspace="5"') . $pInfo->products_description;
            } else {
              echo zen_image(DIR_WS_CATALOG_IMAGES . $products_image_name, $pInfo->products_name, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'align="right" hspace="5" vspace="5"') . $pInfo->products_description;
            }
          ?>
        </td>
      </tr>
<?php
      if ($pInfo->products_url) {
?>
      <tr>
        <td><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="main"><?php echo sprintf(TEXT_PRODUCT_MORE_INFORMATION, $pInfo->products_url); ?></td>
      </tr>
<?php
      }
?>
      <tr>
        <td><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
<?php
      if ($pInfo->products_date_available > date('Y-m-d')) {
?>
      <tr>
        <td align="center" class="smallText"><?php echo sprintf(TEXT_PRODUCT_DATE_AVAILABLE, zen_date_long($pInfo->products_date_available)); ?></td>
      </tr>
<?php
      } else {
?>
      <tr>
        <td align="center" class="smallText"><?php echo sprintf(TEXT_PRODUCT_DATE_ADDED, zen_date_long($pInfo->products_date_added)); ?></td>
      </tr>
<?php
      }
?>
      <tr>
        <td><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
<?php
    }

    if (isset($_GET['read']) && ($_GET['read'] == 'only')) {
      if (isset($_GET['origin'])) {
        $pos_params = strpos($_GET['origin'], '?', 0);
        if ($pos_params != false) {
          $back_url = substr($_GET['origin'], 0, $pos_params);
          $back_url_params = substr($_GET['origin'], $pos_params + 1);
        } else {
          $back_url = $_GET['origin'];
          $back_url_params = '';
        }
      } else {
        $back_url = FILENAME_CATEGORIES;
        $back_url_params = 'cPath=' . $cPath . '&pID=' . $pInfo->products_id;
      }
?>
      <tr>
        <td align="right"><?php echo '<a href="' . zen_href_link($back_url, $back_url_params . (isset($_POST['search']) ? '&search=' . $_POST['search'] : ''), 'NONSSL') . '">' . zen_image_button('button_back.gif', IMAGE_BACK) . '</a>'; ?></td>
      </tr>
<?php
    } else {
?>
      <tr>
        <td align="right" class="smallText">
<?php
/* Re-Post all POST'ed variables */
      reset($_POST);
      while (list($key, $value) = each($_POST)) {
        if (!is_array($_POST[$key])) {
          echo zen_draw_hidden_field($key, htmlspecialchars(stripslashes($value)));
        } else {
			foreach ($_POST[$key] as $array_key => $array_value) {
				echo zen_draw_hidden_field($key.'[' . $array_key . ']', htmlspecialchars(stripslashes($array_value)));
			}
		}
      }

     if (isset($extra_html_end)) echo $extra_html_end; // this was possibly filled by an included file above

      $languages = zen_get_languages();
      /*for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
        echo zen_draw_hidden_field('products_name[' . $languages[$i]['id'] . ']', htmlspecialchars(stripslashes($products_name[$languages[$i]['id']])));
        echo zen_draw_hidden_field('products_description[' . $languages[$i]['id'] . ']', htmlspecialchars(stripslashes($products_description[$languages[$i]['id']])));
        echo zen_draw_hidden_field('products_url[' . $languages[$i]['id'] . ']', htmlspecialchars(stripslashes($products_url[$languages[$i]['id']])));
      }*/
      echo zen_draw_hidden_field('products_image', stripslashes($products_image_name));
      echo ( (isset($_GET['search']) && !empty($_GET['search'])) ? zen_draw_hidden_field('search', $_GET['search']) : '') . ( (isset($_POST['search']) && !empty($_POST['search']) && empty($_GET['search'])) ? zen_draw_hidden_field('search', $_POST['search']) : '');
      echo zen_image_submit('button_back.gif', IMAGE_BACK, 'name="edit"') . '&nbsp;&nbsp;';

      if (isset($_GET['pID'])) {
        echo zen_image_submit('button_update.gif', IMAGE_UPDATE);
      } else {
        echo zen_image_submit('button_insert.gif', IMAGE_INSERT);
      }
     echo '&nbsp;&nbsp;<a href="' . zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . (isset($_GET['pID']) ? '&pID=' . $_GET['pID'] : '') . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '') . (isset($_GET['search']) ? '&search=' . $_GET['search'] : '')) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>';
?>
        </td>
      </tr>
    </table></form>
<?php
    }
?>