<?php
$sanitizer = AdminRequestSanitizer::getInstance();
$group = array('author_description', 'publisher_description', 'series_description', 'imprint_description');
$sanitizer->addSimpleSanitization('PRODUCT_DESC_REGEX', $group);