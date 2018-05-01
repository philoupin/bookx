#!/bin/bash

# version BookX 0.9.5 BETA

src_dir="/c/xampp/htdocs/vhosts/zenbookx.local/bookx-zc155f/ZC_INSTALLATION"
dst_dir="/c/xampp/htdocs/vhosts/zenbookx.local"
admin_dir_name="zenadmin"
tpl_dir_name="responsive_classic"

#create folders first
umask 000
mkdir -p ${dst_dir}/${admin_dir_name}/includes/classes/observers
mkdir -p ${dst_dir}/${admin_dir_name}/includes/modules/product_bookx
mkdir -p ${dst_dir}/includes/classes/observers
mkdir -p ${dst_dir}/includes/modules/pages/bookx_authors_list
mkdir -p ${dst_dir}/includes/modules/pages/bookx_genres_list
mkdir -p ${dst_dir}/includes/modules/pages/bookx_imprints_list
mkdir -p ${dst_dir}/includes/modules/pages/bookx_publishers_list
mkdir -p ${dst_dir}/includes/modules/pages/bookx_series_list
mkdir -p ${dst_dir}/includes/modules/pages/product_bookx_info

mkdir -p ${dst_dir}/includes/templates/${tpl_dir_name}/css

umask 022

# files in admin
ln -sf ${src_dir}/\[RENAME_TO_YOUR_ADMIN_FOLDER\]/bookx_author_types.php ${dst_dir}/${admin_dir_name}/bookx_author_types.php
ln -sf ${src_dir}/\[RENAME_TO_YOUR_ADMIN_FOLDER\]/bookx_authors.php ${dst_dir}/${admin_dir_name}/bookx_authors.php
ln -sf ${src_dir}/\[RENAME_TO_YOUR_ADMIN_FOLDER\]/bookx_binding.php ${dst_dir}/${admin_dir_name}/bookx_binding.php
ln -sf ${src_dir}/\[RENAME_TO_YOUR_ADMIN_FOLDER\]/bookx_conditions.php ${dst_dir}/${admin_dir_name}/bookx_conditions.php
ln -sf ${src_dir}/\[RENAME_TO_YOUR_ADMIN_FOLDER\]/bookx_genres.php ${dst_dir}/${admin_dir_name}/bookx_genres.php
ln -sf ${src_dir}/\[RENAME_TO_YOUR_ADMIN_FOLDER\]/bookx_imprints.php ${dst_dir}/${admin_dir_name}/bookx_imprints.php
ln -sf ${src_dir}/\[RENAME_TO_YOUR_ADMIN_FOLDER\]/bookx_printing.php ${dst_dir}/${admin_dir_name}/bookx_printing.php
ln -sf ${src_dir}/\[RENAME_TO_YOUR_ADMIN_FOLDER\]/bookx_publishers.php ${dst_dir}/${admin_dir_name}/bookx_publishers.php
ln -sf ${src_dir}/\[RENAME_TO_YOUR_ADMIN_FOLDER\]/bookx_series.php ${dst_dir}/${admin_dir_name}/bookx_series.php
ln -sf ${src_dir}/\[RENAME_TO_YOUR_ADMIN_FOLDER\]/bookx_tools.php ${dst_dir}/${admin_dir_name}/bookx_tools.php
ln -sf ${src_dir}/\[RENAME_TO_YOUR_ADMIN_FOLDER\]/product_bookx.php ${dst_dir}/${admin_dir_name}/product_bookx.php

# files in admin/includes
ln -sf ${src_dir}/\[RENAME_TO_YOUR_ADMIN_FOLDER\]/includes/auto_loaders/config.product_type_bookx.php ${dst_dir}/${admin_dir_name}/includes/auto_loaders/config.product_type_bookx.php
ln -sf ${src_dir}/\[RENAME_TO_YOUR_ADMIN_FOLDER\]/includes/classes/observers/class.bookx_admin_observers.php ${dst_dir}/${admin_dir_name}/includes/classes/observers/class.bookx_admin_observers.php
ln -sf ${src_dir}/\[RENAME_TO_YOUR_ADMIN_FOLDER\]/includes/extra_datafiles/bookx_type_database_names.php ${dst_dir}/${admin_dir_name}/includes/extra_datafiles/bookx_type_database_names.php
ln -sf ${src_dir}/\[RENAME_TO_YOUR_ADMIN_FOLDER\]/includes/extra_datafiles/bookx_type_filenames.php ${dst_dir}/${admin_dir_name}/includes/extra_datafiles/bookx_type_filenames.php
ln -sf ${src_dir}/\[RENAME_TO_YOUR_ADMIN_FOLDER\]/includes/extra_datafiles/bookx_sanitizer_fields.php ${dst_dir}/${admin_dir_name}/includes/extra_datafiles/bookx_sanitizer_fields.php
ln -sf ${src_dir}/\[RENAME_TO_YOUR_ADMIN_FOLDER\]/includes/functions/extra_functions/product_bookx_functions.php ${dst_dir}/${admin_dir_name}/includes/functions/extra_functions/product_bookx_functions.php
ln -sf ${src_dir}/\[RENAME_TO_YOUR_ADMIN_FOLDER\]/includes/init_includes/init_product_type_bookx.php ${dst_dir}/${admin_dir_name}/includes/init_includes/init_product_type_bookx.php

# files in admin/includes/modules/product_bookx
ln -sf ${src_dir}/\[RENAME_TO_YOUR_ADMIN_FOLDER\]/includes/modules/product_bookx/collect_info_metatags.php ${dst_dir}/${admin_dir_name}/includes/modules/product_bookx/collect_info_metatags.php
ln -sf ${src_dir}/\[RENAME_TO_YOUR_ADMIN_FOLDER\]/includes/modules/product_bookx/collect_info.php ${dst_dir}/${admin_dir_name}/includes/modules/product_bookx/collect_info.php
ln -sf ${src_dir}/\[RENAME_TO_YOUR_ADMIN_FOLDER\]/includes/modules/product_bookx/copy_to_confirm.php ${dst_dir}/${admin_dir_name}/includes/modules/product_bookx/copy_to_confirm.php
ln -sf ${src_dir}/\[RENAME_TO_YOUR_ADMIN_FOLDER\]/includes/modules/product_bookx/delete_product_confirm.php ${dst_dir}/${admin_dir_name}/includes/modules/product_bookx/delete_product_confirm.php
ln -sf ${src_dir}/\[RENAME_TO_YOUR_ADMIN_FOLDER\]/includes/modules/product_bookx/preview_info.php ${dst_dir}/${admin_dir_name}/includes/modules/product_bookx/preview_info.php
ln -sf ${src_dir}/\[RENAME_TO_YOUR_ADMIN_FOLDER\]/includes/modules/product_bookx/update_product.php ${dst_dir}/${admin_dir_name}/includes/modules/product_bookx/update_product.php


# files in admin/includes/languages/english
ln -sf ${src_dir}/\[RENAME_TO_YOUR_ADMIN_FOLDER\]/includes/languages/english/bookx_author_types.php ${dst_dir}/${admin_dir_name}/includes/languages/english/bookx_author_types.php
ln -sf ${src_dir}/\[RENAME_TO_YOUR_ADMIN_FOLDER\]/includes/languages/english/bookx_authors.php ${dst_dir}/${admin_dir_name}/includes/languages/english/bookx_authors.php
ln -sf ${src_dir}/\[RENAME_TO_YOUR_ADMIN_FOLDER\]/includes/languages/english/bookx_binding.php ${dst_dir}/${admin_dir_name}/includes/languages/english/bookx_binding.php
ln -sf ${src_dir}/\[RENAME_TO_YOUR_ADMIN_FOLDER\]/includes/languages/english/bookx_conditions.php ${dst_dir}/${admin_dir_name}/includes/languages/english/bookx_conditions.php
ln -sf ${src_dir}/\[RENAME_TO_YOUR_ADMIN_FOLDER\]/includes/languages/english/bookx_genres.php ${dst_dir}/${admin_dir_name}/includes/languages/english/bookx_genres.php
ln -sf ${src_dir}/\[RENAME_TO_YOUR_ADMIN_FOLDER\]/includes/languages/english/bookx_imprints.php ${dst_dir}/${admin_dir_name}/includes/languages/english/bookx_imprints.php
ln -sf ${src_dir}/\[RENAME_TO_YOUR_ADMIN_FOLDER\]/includes/languages/english/bookx_printing.php ${dst_dir}/${admin_dir_name}/includes/languages/english/bookx_printing.php
ln -sf ${src_dir}/\[RENAME_TO_YOUR_ADMIN_FOLDER\]/includes/languages/english/bookx_publishers.php ${dst_dir}/${admin_dir_name}/includes/languages/english/bookx_publishers.php
ln -sf ${src_dir}/\[RENAME_TO_YOUR_ADMIN_FOLDER\]/includes/languages/english/bookx_series.php ${dst_dir}/${admin_dir_name}/includes/languages/english/bookx_series.php
ln -sf ${src_dir}/\[RENAME_TO_YOUR_ADMIN_FOLDER\]/includes/languages/english/product_bookx.php ${dst_dir}/${admin_dir_name}/includes/languages/english/product_bookx.php
ln -sf ${src_dir}/\[RENAME_TO_YOUR_ADMIN_FOLDER\]/includes/languages/english/extra_definitions/product_bookx.php ${dst_dir}/${admin_dir_name}/includes/languages/english/extra_definitions/product_bookx.php

# files in admin/includes/languages/german
ln -sf ${src_dir}/\[RENAME_TO_YOUR_ADMIN_FOLDER\]/includes/languages/german/bookx_author_types.php ${dst_dir}/${admin_dir_name}/includes/languages/german/bookx_author_types.php
ln -sf ${src_dir}/\[RENAME_TO_YOUR_ADMIN_FOLDER\]/includes/languages/german/bookx_authors.php ${dst_dir}/${admin_dir_name}/includes/languages/german/bookx_authors.php
ln -sf ${src_dir}/\[RENAME_TO_YOUR_ADMIN_FOLDER\]/includes/languages/german/bookx_binding.php ${dst_dir}/${admin_dir_name}/includes/languages/german/bookx_binding.php
ln -sf ${src_dir}/\[RENAME_TO_YOUR_ADMIN_FOLDER\]/includes/languages/german/bookx_conditions.php ${dst_dir}/${admin_dir_name}/includes/languages/german/bookx_conditions.php
ln -sf ${src_dir}/\[RENAME_TO_YOUR_ADMIN_FOLDER\]/includes/languages/german/bookx_genres.php ${dst_dir}/${admin_dir_name}/includes/languages/german/bookx_genres.php
ln -sf ${src_dir}/\[RENAME_TO_YOUR_ADMIN_FOLDER\]/includes/languages/german/bookx_imprints.php ${dst_dir}/${admin_dir_name}/includes/languages/german/bookx_imprints.php
ln -sf ${src_dir}/\[RENAME_TO_YOUR_ADMIN_FOLDER\]/includes/languages/german/bookx_printing.php ${dst_dir}/${admin_dir_name}/includes/languages/german/bookx_printing.php
ln -sf ${src_dir}/\[RENAME_TO_YOUR_ADMIN_FOLDER\]/includes/languages/german/bookx_publishers.php ${dst_dir}/${admin_dir_name}/includes/languages/german/bookx_publishers.php
ln -sf ${src_dir}/\[RENAME_TO_YOUR_ADMIN_FOLDER\]/includes/languages/german/bookx_series.php ${dst_dir}/${admin_dir_name}/includes/languages/german/bookx_series.php
ln -sf ${src_dir}/\[RENAME_TO_YOUR_ADMIN_FOLDER\]/includes/languages/german/product_bookx.php ${dst_dir}/${admin_dir_name}/includes/languages/german/product_bookx.php
ln -sf ${src_dir}/\[RENAME_TO_YOUR_ADMIN_FOLDER\]/includes/languages/german/extra_definitions/product_bookx.php ${dst_dir}/${admin_dir_name}/includes/languages/german/extra_definitions/product_bookx.php


#files in catalog
ln -sf ${src_dir}/includes/auto_loaders/config.bookx.php ${dst_dir}/includes/auto_loaders/config.bookx.php
ln -sf ${src_dir}/includes/classes/observers/class.bookx_observers.php ${dst_dir}/includes/classes/observers/class.bookx_observers.php
ln -sf ${src_dir}/includes/extra_configures/bookx_defines_and_configures.php ${dst_dir}/includes/extra_configures/bookx_defines_and_configures.php
ln -sf ${src_dir}/includes/extra_datafiles/bookx_type_database_names.php ${dst_dir}/includes/extra_datafiles/bookx_type_database_names.php
ln -sf ${src_dir}/includes/functions/extra_functions/functions_product_type_bookx.php ${dst_dir}/includes/functions/extra_functions/functions_product_type_bookx.php
ln -sf ${src_dir}/includes/index_filters/bookx_filter.php ${dst_dir}/includes/index_filters/bookx_filter.php

#files in includes/languages/english
ln -sf ${src_dir}/includes/languages/english/product_bookx_info.php ${dst_dir}/includes/languages/english/product_bookx_info.php
ln -sf ${src_dir}/includes/languages/english/extra_definitions/product_bookx.php  ${dst_dir}/includes/languages/english/extra_definitions/product_bookx.php 

#files in includes/languages/german
ln -sf ${src_dir}/includes/languages/german/product_bookx_info.php ${dst_dir}/includes/languages/german/product_bookx_info.php
ln -sf ${src_dir}/includes/languages/german/extra_definitions/product_bookx.php  ${dst_dir}/includes/languages/german/extra_definitions/product_bookx.php 

#files in includes/modules
ln -sf ${src_dir}/includes/modules/product_bookx_prev_next.php ${dst_dir}/includes/modules/product_bookx_prev_next.php
ln -sf ${src_dir}/includes/modules/pages/bookx_authors_list/header_php.php ${dst_dir}/includes/modules/pages/bookx_authors_list/header_php.php
ln -sf ${src_dir}/includes/modules/pages/bookx_genres_list/header_php.php ${dst_dir}/includes/modules/pages/bookx_genres_list/header_php.php
ln -sf ${src_dir}/includes/modules/pages/bookx_imprints_list/header_php.php ${dst_dir}/includes/modules/pages/bookx_imprints_list/header_php.php
ln -sf ${src_dir}/includes/modules/pages/bookx_publishers_list/header_php.php ${dst_dir}/includes/modules/pages/bookx_publishers_list/header_php.php
ln -sf ${src_dir}/includes/modules/pages/bookx_series_list/header_php.php ${dst_dir}/includes/modules/pages/bookx_series_list/header_php.php

ln -sf ${src_dir}/includes/modules/pages/product_bookx_info/header_php.php ${dst_dir}/includes/modules/pages/product_bookx_info/header_php.php
ln -sf ${src_dir}/includes/modules/pages/product_bookx_info/jscript_main.php ${dst_dir}/includes/modules/pages/product_bookx_info/jscript_main.php
ln -sf ${src_dir}/includes/modules/pages/product_bookx_info/jscript_textarea_counter.js ${dst_dir}/includes/modules/pages/product_bookx_info/jscript_textarea_counter.js
ln -sf ${src_dir}/includes/modules/pages/product_bookx_info/main_template_vars_product_type.php ${dst_dir}/includes/modules/pages/product_bookx_info/main_template_vars_product_type.php
ln -sf ${src_dir}/includes/modules/pages/product_bookx_info/main_template_vars.php ${dst_dir}/includes/modules/pages/product_bookx_info/main_template_vars.php
ln -sf ${src_dir}/includes/modules/sideboxes/bookx_filters.php ${dst_dir}/includes/modules/sideboxes/bookx_filters.php

#files in includes/templates
ln -sf ${src_dir}/includes/templates/\[YOUR-TEMPLATE\]/css/stylesheet_bookx.css ${dst_dir}/includes/templates/${tpl_dir_name}/css/stylesheet_bookx.css 
ln -sf ${src_dir}/includes/templates/template_default/sideboxes/tpl_bookx_filters_select.php ${dst_dir}/includes/templates/template_default/sideboxes/tpl_bookx_filters_select.php
ln -sf ${src_dir}/includes/templates/template_default/templates/tpl_bookx_authors_list_default.php ${dst_dir}/includes/templates/template_default/templates/tpl_bookx_authors_list_default.php
ln -sf ${src_dir}/includes/templates/template_default/templates/tpl_bookx_genres_list_default.php ${dst_dir}/includes/templates/template_default/templates/tpl_bookx_genres_list_default.php
ln -sf ${src_dir}/includes/templates/template_default/templates/tpl_bookx_imprints_list_default.php ${dst_dir}/includes/templates/template_default/templates/tpl_bookx_imprints_list_default.php
ln -sf ${src_dir}/includes/templates/template_default/templates/tpl_bookx_publishers_list_default.php ${dst_dir}/includes/templates/template_default/templates/tpl_bookx_publishers_list_default.php
ln -sf ${src_dir}/includes/templates/template_default/templates/tpl_bookx_series_list_default.php ${dst_dir}/includes/templates/template_default/templates/tpl_bookx_series_list_default.php
ln -sf ${src_dir}/includes/templates/template_default/templates/tpl_product_bookx_info_display.php ${dst_dir}/includes/templates/template_default/templates/tpl_product_bookx_info_display.php
ln -sf ${src_dir}/includes/templates/template_default/templates/tpl_bookx_products_next_previous.php ${dst_dir}/includes/templates/template_default/templates/tpl_bookx_products_next_previous.php
