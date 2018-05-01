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
 * @version $Id: [ZC INSTALLATION]/[ADMIN]/bookx_tools.php 2016-02-02 philou $
 */


  require_once('includes/application_top.php');

  $action = (isset($_GET['action']) ? $_GET['action'] : '');

?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script language="javascript" src="includes/menu.js"></script>



</head>
<body onLoad="init()">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
      <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
        <tr>
        <td class="pageHeading"><?php echo HEADING_TITLE_BOOKX; ?></td>
        <td class="pageHeading" align="right"><?php echo zen_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
        <td class="main">
        </td>
      </tr>
      </table></td>
    </tr>
    <tr>
      <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
         	<tr><td>
         	<?php
         	$sql = 'SELECT * FROM ' . TABLE_PRODUCT_TYPES . ' WHERE type_handler = "product_bookx"';

         	$result = $db->Execute($sql); /* @var $result queryFactoryResult */
         	$bookx_installed = false;
         	$bookx_installed_version = null;
         	$bookx_type_id = null;

         	if ( 0 < $result->RecordCount()) {
				while (!$result->EOF) {
					$bookx_type_id = $result->fields['type_id'];
					$result->MoveNext();
				}
				$bookx_installed = true;

				$sql = 'SELECT configuration_value AS version FROM ' . TABLE_CONFIGURATION . ' WHERE configuration_key = "BOOKX_VERSION"';
				$result = $db->Execute($sql); /* @var $result queryFactoryResult */

			    if (!$result->EOF) {
			    	$installed_version = $result->fields['version'];
			    }

			    echo TEXT_BOOKX_STATUS_INSTALLED .' v' . $installed_version .  '<br />';


			} else {
				echo TEXT_BOOKX_STATUS_NOT_INSTALLED . '<br />';
			}

			echo '<li><a href="' . zen_href_link(FILENAME_BOOKX_TOOLS, 'action=bookx_reset_to_defaults') . '">' . BOOKX_LINK_RESET . '</a></li>';
			echo '<li><a href="' . zen_href_link(FILENAME_BOOKX_TOOLS, 'action=bookx_install') . '">' . BOOKX_LINK_INSTALL . '</a></li>';
			echo '<li><a href="' . zen_href_link(FILENAME_BOOKX_TOOLS, 'action=bookx_update') . '">' . BOOKX_LINK_UPDATE . '</a></li>';


         	if ($action == 'bookx_confirm_remove') {
			  echo zen_draw_form('remove_form', 'index.php', '', 'get');
			  echo zen_draw_hidden_field('action', 'bookx_remove');
			  echo zen_draw_radio_field('convert_bookx_products', '1', '1') . '&nbsp;' . TEXT_CONVERT_BOOKX_PRODUCTS . '&nbsp;&nbsp;' . zen_draw_radio_field('convert_bookx_products', '0', '0') . '&nbsp;' . TEXT_DELETE_BOOKX_PRODUCTS;

			  echo BOOKX_CONFIRM_REMOVE . '&nbsp;';
			  echo zen_image_submit('button_delete.gif', IMAGE_DELETE);
			  echo '</form><br />';
			}
			echo '<li><a href="' . zen_href_link(FILENAME_BOOKX_TOOLS, 'action=bookx_confirm_remove') . '">' . BOOKX_LINK_REMOVE . '</a></li>';

			if ($bookx_installed) {
				echo '<li><a href="' . zen_href_link(FILENAME_BOOKX_TOOLS, 'action=bookx_manage_product_migration') . '">' . BOOKX_LINK_MANAGE_PRODUCT_MIGRATION . '</a></li>';
			}
			?>

		</td>
          	</tr>
<?php
		$product_selection_submitted = false;
		$choose_products_to_convert_from = false;
		$choose_products_to_convert_to = false;
		if (isset($_POST['choose_products_to_convert_from'])) {
			if ('1' == $_POST['choose_products_to_convert_from']) {
				$choose_products_to_convert_from = true;
				if (isset($_POST['products_to_convert_from']) && is_array($_POST['products_to_convert_from']) && 0 < count($_POST['products_to_convert_from'])) {
					$product_selection_submitted = true;
				}
			}
		}

		if (isset($_POST['choose_products_to_convert_to'])) {
			if ('1' == $_POST['choose_products_to_convert_to']) {
				$choose_products_to_convert_to = true;
				if (isset($_POST['products_to_convert_to']) && is_array($_POST['products_to_convert_to']) && 0 < count($_POST['products_to_convert_to'])) {
					$product_selection_submitted = true;
				}
			}
		}


		if ('bookx_manage_product_migration' == $action ||
			('bookx_confirm_product_migration' == $action && ($choose_products_to_convert_from || $choose_products_to_convert_to) && !$product_selection_submitted)) {
			global $currencies;

			$sql = "select type_id, type_name from " . TABLE_PRODUCT_TYPES;
			$product_types = $db->Execute($sql);
			while (!$product_types->EOF) {
				$type_array[] = array('id' => $product_types->fields['type_id'], 'text' => $product_types->fields['type_name']);
				$type_names[(int)$product_types->fields['type_id']] = $product_types->fields['type_name'];
				$product_types->MoveNext();
			}

			$select_string_from = false;
			if ($choose_products_to_convert_from && isset($_POST['convert_from_type']) && '' != $_POST['convert_from_type'] && null != $bookx_type_id) {
				$select_string_from = '<br /><br /><select name="products_to_convert_from[]" size="10" multiple="multiple">';

				$products = $db->Execute("select p.products_id, products_name, p.products_price, p.products_model
				                                from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd
				                                where p.products_id = pd.products_id
				                                and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
				                                and p.products_type = '" . (int)$_POST['convert_from_type'] . "'
				                                order by products_name");

				$product_array = array();

				while (!$products->EOF) {
					$display_price = $products->fields['products_price']; // zen_get_products_display_price($product['products_id']);
					$select_string_from .= '<option value="' . $products->fields['products_id'] . '">';
					$select_string_from .= $products->fields['products_name'] . ' [' . $products->fields['products_model'] . '] (' . $display_price . ') - ID# ' . $products->fields['products_id'] . '</option>';

					$products->MoveNext();
				}

				$select_string_from .= '</select>';
			}

			$select_string_to = false;
			if ($choose_products_to_convert_to && isset($_POST['convert_to_type']) && '' != $_POST['convert_to_type'] && null != $bookx_type_id) {
				$select_string_to = '<br /><br /><select name="products_to_convert_to[]" size="10" multiple="multiple">';

				$products = $db->Execute("select p.products_id, products_name, p.products_price, p.products_model
				                                from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd
				                                where p.products_id = pd.products_id
				                                and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
				                                and p.products_type = '" . (int)$bookx_type_id . "'
				                                order by products_name");

				$product_array = array();

				while (!$products->EOF) {
					$display_price = $products->fields['products_price']; // zen_get_products_display_price($product['products_id']);
					$select_string_to .= '<option value="' . $products->fields['products_id'] . '">';
					$select_string_to .= $products->fields['products_name'] . ' [' . $products->fields['products_model'] . '] (' . $display_price . ') - ID# ' . $products->fields['products_id'] . '</option>';

					$products->MoveNext();
				}


				$select_string_to .= '</select>';
			}
?>
        <tr>
        	<td><?php
        		echo zen_draw_form('migration_to_bookx', FILENAME_BOOKX_TOOLS, 'action=bookx_confirm_product_migration', 'post', 'enctype="multipart/form-data"');
				echo BOOKX_OPTION_IMPORT . '<br />';
        		echo BOOKX_SELECT_PRODUCT_TYPE_SOURCE_FOR_MIGRATION . ' ' . (isset($_POST['convert_from_type']) && '' != $_POST['convert_from_type'] ? ' <strong>' . $type_names[(int)$_POST['convert_from_type']] . '</strong>' . zen_draw_hidden_field('convert_from_type', (int)$_POST['convert_from_type']) : zen_draw_pull_down_menu('convert_from_type', $type_array )) . '<br />';
        		echo zen_draw_radio_field('choose_products_to_convert_from', '0', ($choose_products_to_convert_from ? '0' : '1')) . '&nbsp;' . BOOKX_OPTION_CONVERT_ALL_PRODUCTS . '&nbsp;&nbsp;' . zen_draw_radio_field('choose_products_to_convert_from', '1', ($choose_products_to_convert_from ? '1' : '0')) . '&nbsp;' . BOOKX_OPTION_SELECT_PRODUCTS_TO_CONVERT;
        		echo ('' != $select_string_from ?  $select_string_from : '');
        		echo '<br /><br />' . zen_image_submit('button_confirm.gif', IMAGE_CONFIRM);
        		echo '</form><!-- eof form migration_to_bookx -->'; ?>
        		</td>
     	</tr>
        <tr>
        	<td colspan="2"><?php echo zen_draw_separator('pixel_black.gif', '300', '5'); ?></td>
        </tr>
        <tr>
        	<td><?php
        		echo zen_draw_form('migration_from_bookx', FILENAME_BOOKX_TOOLS, 'action=bookx_confirm_product_migration', 'post', 'enctype="multipart/form-data"');
        		echo BOOKX_OPTION_EXPORT . '<br />';
        		echo BOOKX_SELECT_PRODUCT_TYPE_DESTINATION_FOR_MIGRATION . ' ' . (isset($_POST['convert_to_type']) && '' != $_POST['convert_to_type'] ? ' <strong>' . $type_names[(int)$_POST['convert_to_type']] . '</strong>' . zen_draw_hidden_field('convert_to_type', (int)$_POST['convert_to_type']) : zen_draw_pull_down_menu('convert_to_type', $type_array)) . '<br />';
        		echo zen_draw_radio_field('choose_products_to_convert_to', '0', ($choose_products_to_convert_to ? '0' : '1')) . '&nbsp;' . BOOKX_OPTION_CONVERT_ALL_PRODUCTS . '&nbsp;&nbsp;' . zen_draw_radio_field('choose_products_to_convert_to', '1', ($choose_products_to_convert_to ? '1' : '0')) . '&nbsp;' . BOOKX_OPTION_SELECT_PRODUCTS_TO_CONVERT;
        		echo ('' != $select_string_to ?  $select_string_to : '');
        		echo '<br /><br />' . zen_image_submit('button_confirm.gif', IMAGE_CONFIRM);
        		echo '</form><!-- eof form migration_to_bookx -->';
        	?>
        	</td>
          </tr>
<?php } elseif ('bookx_confirm_product_migration' == $action) {
		switch (true) {
			case ($choose_products_to_convert_from && $product_selection_submitted && null != $bookx_type_id): // convert some selected products from another article type to bookx
				$selected_products = implode(',', $_POST['products_to_convert_from']);
				$products_to_convert = $db->Execute('SELECT products_id FROM ' . TABLE_PRODUCTS . ' WHERE products_id IN (' . $selected_products . ') AND products_type = "' . (int)$_POST['convert_from_type'] . '"');
				while (!$products_to_convert->EOF) {
					bookx_convert_product_to_bookx_type($products_to_convert->fields['products_id']);
					$products_to_convert->MoveNext();
				}
			break;

			case ($choose_products_to_convert_to && $product_selection_submitted && isset($_POST['convert_to_type']) && '' != $_POST['convert_to_type'] && null != $bookx_type_id): // convert some selected products from bookx to another article type
				$selected_products = implode(',', $_POST['products_to_convert_to']);
				$products_to_convert = $db->Execute('SELECT products_id FROM ' . TABLE_PRODUCTS . ' WHERE products_id IN (' . $selected_products . ') AND products_type = "' . (int)$bookx_type_id . '"');
				while (!$products_to_convert->EOF) {
					bookx_convert_product_from_bookx_to_type($products_to_convert->fields['products_id'], (int)$_POST['convert_to_type']);
					$products_to_convert->MoveNext();
				}
			break;

			case (!$choose_products_to_convert_from && isset($_POST['convert_from_type']) && '' != $_POST['convert_from_type'] && null != $bookx_type_id): // convert all products from another article type to bookx
				$products_to_convert = $db->Execute('SELECT products_id FROM ' . TABLE_PRODUCTS . ' WHERE products_type = "' . (int)$_POST['convert_from_type'] . '"');
				while (!$products_to_convert->EOF) {
					bookx_convert_product_to_bookx_type($products_to_convert->fields['products_id']);
					$products_to_convert->MoveNext();
				};
			break;

			case (!$choose_products_to_convert_to && isset($_POST['convert_to_type']) && '' != $_POST['convert_to_type'] && null != $bookx_type_id): // convert some products from another article type to bookx
				$products_to_convert = $db->Execute('SELECT products_id FROM ' . TABLE_PRODUCTS . ' WHERE products_type = "' . (int)$bookx_type_id . '"');
				while (!$products_to_convert->EOF) {
					bookx_convert_product_from_bookx_to_type($products_to_convert->fields['products_id'], (int)$_POST['convert_to_type']);
					$products_to_convert->MoveNext();
				};
			break;
		}
	} ?>
<!-- body_text_eof //-->
      </table></td>
    </tr>
  </table></td>
</tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br />
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>