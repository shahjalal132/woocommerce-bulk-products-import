<?php

/**
 * File loader file
 * all files in this folder will be loaded
 */

// load db tables create file
require_once BULK_PRODUCT_IMPORT_PLUGIN_PATH . '/inc/files/file-db-table-create.php';
require_once BULK_PRODUCT_IMPORT_PLUGIN_PATH . '/inc/files/file-import-products-woo.php';
require_once BULK_PRODUCT_IMPORT_PLUGIN_PATH . '/inc/files/file-api-endpoints.php';