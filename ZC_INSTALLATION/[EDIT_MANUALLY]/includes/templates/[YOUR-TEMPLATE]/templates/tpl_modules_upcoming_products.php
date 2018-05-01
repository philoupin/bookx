<?php
/**
 * Module Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2014 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart-pro.at/license/2_0.txt GNU Public License V2.0
 *
 * @version BookX V 0.9.4-revision8 BETA
 * @version $Id: [ZC INSTALLATION]/includes/templates/[CURRENT_TEMPLATE]/templates/tpl_modules_upcoming_products.php 2016-02-02 philou $
 *
 */
?>
<!-- bof: upcoming_products -->
<h3 class="bookxUpcomingProduct"><label><?php echo TABLE_HEADING_UPCOMING_PRODUCTS; ?></label></h3>

<fieldset>
<div id="bookxUpcomingProductsWrapper">
<div id="bookxUpcomingProductsHeading"><?php echo CAPTION_UPCOMING_PRODUCTS; ?></div>
  <div id="bookxUpcomingProductsFirstRow">
  	<?php
  	if (BOOKX_UPCOMING_PRODUCTS_SHOW_PRODUCT_IMAGE) {
		echo '<div id="upImageHeading">' . TABLE_HEADING_BOOKX_UPCOMING_IMAGE . "</div>\n";
	}

    echo '<div id="upProductsHeading">' . TABLE_HEADING_PRODUCTS . "</div>\n";

    if (BOOKX_UPCOMING_PRODUCTS_SHOW_PRODUCT_DESCRIPTION_NUMOFCHARS) {
    	echo '<div id="upDescriptionHeading">' . TABLE_HEADING_BOOKX_UPCOMING_DESCRIPTION . "</div>\n";
    }

    echo '<div id="upPublishingDateHeading">' . TABLE_HEADING_BOOKX_DATE_PUBLISHED. "</div>\n";
    echo '<div id="upDateExpectedHeading">' . TABLE_HEADING_DATE_EXPECTED. "</div>\n";
    //echo '  <div class="clearBoth">&nbsp;</div>' . "\n";

    ?>
  </div>
<?php
    for($i=0, $row=0; $i < sizeof($expectedItems); $i++, $row++) {
    	$product_detail_url = zen_href_link(zen_get_info_page($expectedItems[$i]['products_id']), 'cPath=' . $productsInCategory[$expectedItems[$i]['products_id']] . '&products_id=' . $expectedItems[$i]['products_id'] . '&bookx_publishing_status=upcoming');

      $rowClass = (($row / 2) == floor($row / 2)) ? "rowEven" : "rowOdd";
      echo '  <div class="' . $rowClass . '">' . "\n";
      if (BOOKX_UPCOMING_PRODUCTS_SHOW_PRODUCT_IMAGE) {
      	echo '    <div class="upImageCell"><a href="' . $product_detail_url . '">' . zen_image(DIR_WS_IMAGES . $expectedItems[$i]['products_image'], $expectedItems[$i]['products_name'], BOOKX_UPCOMING_PRODUCT_IMAGE_MAX_WIDTH, BOOKX_UPCOMING_PRODUCT_IMAGE_MAX_HEIGHT) . "</a></div>\n";
      }
      echo '    <div class="upProductsCell"><a href="' . $product_detail_url . '">' . $expectedItems[$i]['products_name'] . "</a>\n";

      if (isset($expectedItems[$i]['authors'])) {
      	echo '      <h2 class="bookxAuthors">' . $expectedItems[$i]['authors'] . '</h2>';
      }

      $bookx_extra_attributes = array();
      if (isset($expectedItems[$i]['pages']) && !empty($expectedItems[$i]['pages'])) $bookx_extra_attributes[] = sprintf(LABEL_BOOKX_PAGES, $expectedItems[$i]['pages']);
      if (isset($expectedItems[$i]['binding_description']) && !empty($expectedItems[$i]['binding_description'])) $bookx_extra_attributes[] = $expectedItems[$i]['binding_description'];
      if (isset($expectedItems[$i]['printing_description']) && !empty($expectedItems[$i]['printing_description'])) $bookx_extra_attributes[] = $expectedItems[$i]['printing_description'];
      if (isset($expectedItems[$i]['size']) && !empty($expectedItems[$i]['size'])) $bookx_extra_attributes[] = $expectedItems[$i]['size'];

      if (0 < count($bookx_extra_attributes)) {
      	echo '    <span class="bookxExtraAttributes">' . implode(' | ', $bookx_extra_attributes) . '</span>';
      }
      if (isset($expectedItems[$i]['isbn_display']) && !empty($expectedItems[$i]['isbn_display'])) echo '        <span class="bookxISBN"><span class="bookxLabel">' . LABEL_BOOKX_ISBN . ' </span>' . $expectedItems[$i]['isbn_display'] . '</span>';
      if (isset($expectedItems[$i]['products_model']) && !empty($expectedItems[$i]['products_model'])) echo '        <span class="bookxModel"><span class="bookxLabel">' . LABEL_BOOKX_MODEL . ' </span>' . $expectedItems[$i]['products_model'] . '</span>';

      if (isset($expectedItems[$i]['condition_description']) && !empty($expectedItems[$i]['condition_description'])) echo '        <span class="bookxCondition"><span class="bookxLabel">' . LABEL_BOOKX_CONDITION . ':</span> ' . $expectedItems[$i]['condition_description'] . '</span>';

      echo "    </div>\n";

      if ('-1' == BOOKX_UPCOMING_PRODUCTS_SHOW_PRODUCT_DESCRIPTION_NUMOFCHARS || '0' < BOOKX_UPCOMING_PRODUCTS_SHOW_PRODUCT_DESCRIPTION_NUMOFCHARS) {
      	echo '    <div class="upDescriptionCell">' . ( '-1' == BOOKX_UPCOMING_PRODUCTS_SHOW_PRODUCT_DESCRIPTION_NUMOFCHARS ? $expectedItems[$i]['products_description'] : zen_trunc_string($expectedItems[$i]['products_description'], BOOKX_UPCOMING_PRODUCTS_SHOW_PRODUCT_DESCRIPTION_NUMOFCHARS, '... <a href="' . $product_detail_url . '">' . TEXT_BOOKX_MORE_PRODUCT_INFO . '</a></p>')) . '</div>';
      }
      echo '    <div class="upPublishingDateCell">' . (!empty($expectedItems[$i]['formatted_publishing_date']) ? sprintf( TEXT_BOOKX_WRAPPER_PUBLISHING_DATE ,$expectedItems[$i]['formatted_publishing_date']) : '') . "</div>\n";
      echo '    <div class="upDateExpectedCell">' . zen_date_short($expectedItems[$i]['date_expected']) . "</div>\n";
      //echo '    <div class="clearBoth">&nbsp;</div>' . "\n";
      echo "  </div>\n";
    }
?>
</div>
</fieldset>
<!-- eof: upcoming_products -->
