<?php

namespace BULK_IMPORT\Inc;

defined( "ABSPATH" ) || exit( "Direct Access Not Allowed" );

use BULK_IMPORT\Inc\Traits\Singleton;

class Admin_Menu {

    use Singleton;

    public function __construct() {
        $this->setup_hooks();
    }

    public function setup_hooks() {
        add_action( 'admin_menu', [ $this, 'register_admin_menu' ] );
        add_action( 'admin_menu', [ $this, 'register_csv_import_menu' ] );
        add_action( 'admin_menu', [ $this, 'register_sheet_import_menu' ] );
        add_action( 'wp_ajax_save_client_credentials', [ $this, 'save_client_credentials' ] );
        add_action( 'wp_ajax_save_table_prefix', [ $this, 'save_table_prefix' ] );
    }

    public function register_admin_menu() {
        add_menu_page(
            __( 'Bulk Product Import', 'bulk-product-import' ),
            __( 'Bulk Product Import', 'bulk-product-import' ),
            'manage_options',
            'bulk_product_import',
            [ $this, 'bulk_product_import_page_html' ],
            'dashicons-cloud-upload',
            80
        );
    }

    public function register_csv_import_menu() {
        add_submenu_page(
            'bulk_product_import',
            'CSV Import',
            'CSV Import',
            'manage_options',
            'bulk_product_csv_import',
            [ $this, 'bulk_product_csv_import_page_html' ]
        );
    }

    public function register_sheet_import_menu() {
        add_submenu_page(
            'bulk_product_import',
            'Sheet Import',
            'Sheet Import',
            'manage_options',
            'bulk_product_sheet_import',
            [ $this, 'bulk_product_sheet_import_page_html' ]
        );
    }

    public function bulk_product_import_page_html() {
        ?>

        <div class="entry-header">
            <h1 class="entry-title text-center mt-3" style="color: #2271B1">
                <?php esc_html_e( 'WooCommerce Bulk Product Import', 'bulk-product-import' ); ?>
            </h1>
        </div>

        <div id="be-tabs" class="mt-3">
            <div id="tabs">

                <ul class="nav nav-pills">
                    <li class="nav-item"><a href="#api"
                            class="nav-link be-nav-links"><?php esc_html_e( 'API', 'bulk-product-import' ); ?></a></li>
                    <li class="nav-item"><a href="#tables"
                            class="nav-link be-nav-links"><?php esc_html_e( 'Tables', 'bulk-product-import' ); ?></a></li>
                    <li class="nav-item"><a href="#endpoints"
                            class="nav-link be-nav-links"><?php esc_html_e( 'Endpoints', 'bulk-product-import' ); ?></a></li>
                </ul>

                <div id="api">
                    <?php include BULK_PRODUCT_IMPORT_PLUGIN_PATH . '/inc/template-parts/template-api.php'; ?>
                </div>

                <div id="tables">
                    <?php include BULK_PRODUCT_IMPORT_PLUGIN_PATH . '/inc/template-parts/template-tables.php'; ?>
                </div>

                <div id="endpoints">
                    <div id="api-endpoints">
                        <div id="api-endpoints-table">
                            <?php include BULK_PRODUCT_IMPORT_PLUGIN_PATH . '/inc/template-parts/template-endpoints.php'; ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <?php
    }

    public function bulk_product_csv_import_page_html() {
        ?>

        <div class="entry-header">
            <h1 class="entry-title text-center mt-3" style="color: #2271B1">
                <?php esc_html_e( 'WooCommerce Bulk Product Import CSV', 'bulk-product-import' ); ?>
            </h1>
        </div>

        <div class="wrap">
            <?php include BULK_PRODUCT_IMPORT_PLUGIN_PATH . '/inc/template-parts/template-csv.php'; ?>
        </div>

        <?php
    }

    public function bulk_product_sheet_import_page_html() {
        ?>

        <div class="entry-header">
            <h1 class="entry-title text-center mt-3" style="color: #2271B1">
                <?php esc_html_e( 'WooCommerce Bulk Product Import Sheet', 'bulk-product-import' ); ?>
            </h1>
        </div>

        <div class="wrap">
            <?php include BULK_PRODUCT_IMPORT_PLUGIN_PATH . '/inc/template-parts/template-sheet.php'; ?>
        </div>

        <?php
    }

    public function save_client_credentials() {
        check_ajax_referer( 'bulk_product_import_nonce', 'nonce' );

        if ( !current_user_can( 'manage_options' ) ) {
            wp_send_json_error( __( 'Unauthorized user', 'bulk-product-import' ) );
        }

        $client_id     = sanitize_text_field( $_POST['client_id'] );
        $client_secret = sanitize_text_field( $_POST['client_secret'] );

        update_option( 'be-client-id', $client_id );
        update_option( 'be-client-secret', $client_secret );

        wp_send_json_success( __( 'Credentials saved successfully', 'bulk-product-import' ) );
    }

    public function save_table_prefix() {

        check_ajax_referer( 'bulk_product_import_nonce', 'nonce' );

        if ( !current_user_can( 'manage_options' ) ) {
            wp_send_json_error( __( 'Unauthorized user', 'bulk-product-import' ) );
        }

        $table_prefix = sanitize_text_field( $_POST['table_prefix'] );
        update_option( 'be-table-prefix', $table_prefix );

        wp_send_json_success( __( 'Table prefix saved successfully', 'bulk-product-import' ) );
    }
}
