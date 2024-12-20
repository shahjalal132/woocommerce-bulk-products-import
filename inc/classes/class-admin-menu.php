<?php

namespace BULK_IMPORT\Inc;
use BULK_IMPORT\Inc\Traits\Program_Logs;

defined( "ABSPATH" ) || exit( "Direct Access Not Allowed" );

use BULK_IMPORT\Inc\Traits\Singleton;

class Admin_Menu {

    use Singleton;
    use Program_Logs;

    public function __construct() {
        $this->setup_hooks();
    }

    public function setup_hooks() {
        add_action( 'admin_menu', [ $this, 'register_admin_menu' ] );
        // add_action( 'admin_menu', [ $this, 'register_csv_import_menu' ] );
        // add_action( 'admin_menu', [ $this, 'register_sheet_import_menu' ] );
        add_filter( 'plugin_action_links_' . BULK_PRODUCT_IMPORT_PLUGIN_BASE_NAME, [ $this, 'be_add_settings_link' ] );
        add_action( 'plugins_loaded', [ $this, 'bulk_product_import_plugin_load_textdomain' ] );
        add_action( 'wp_ajax_save_client_credentials', [ $this, 'save_client_credentials' ] );
        add_action( 'wp_ajax_save_table_prefix', [ $this, 'save_table_prefix' ] );
        add_action( 'wp_ajax_save_options', [ $this, 'save_options_callback' ] );
    }

    public function be_add_settings_link( $links ) {
        $settings_link = '<a href="admin.php?page=bpi_settings">' . __( 'Settings', 'bulk-product-import' ) . '</a>';
        array_unshift( $links, $settings_link );
        return $links;
    }

    public function bulk_product_import_plugin_load_textdomain() {
        load_plugin_textdomain( 'bulk-product-import', false, BULK_PRODUCT_IMPORT_PLUGIN_DIR_NAME . '/languages' );
    }

    public function register_admin_menu() {
        add_menu_page(
            __( 'BPI Settings', 'bulk-product-import' ),
            __( 'BPI Settings', 'bulk-product-import' ),
            'manage_options',
            'bpi_settings',
            [ $this, 'bulk_product_import_page_html' ],
            'dashicons-admin-generic',
            80
        );
    }

    public function register_csv_import_menu() {
        add_submenu_page(
            'bpi_settings',
            'CSV Import',
            'CSV Import',
            'manage_options',
            'bulk_product_csv_import',
            [ $this, 'bulk_product_csv_import_page_html' ]
        );
    }

    public function register_sheet_import_menu() {
        add_submenu_page(
            'bpi_settings',
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
                            class="nav-link be-nav-links"><?php esc_html_e( 'API', 'bulk-product-import' ); ?></a>
                    </li>
                    <li class="nav-item"><a href="#tables"
                            class="nav-link be-nav-links"><?php esc_html_e( 'Table Prefix', 'bulk-product-import' ); ?></a>
                    </li>
                    <!-- <li class="nav-item"><a href="#options"
                            class="nav-link be-nav-links"><?php // esc_html_e( 'Options', 'bulk-product-import' ); ?></a>
                    </li> -->
                    <li class="nav-item"><a href="#endpoints"
                            class="nav-link be-nav-links"><?php esc_html_e( 'Endpoints', 'bulk-product-import' ); ?></a>
                    </li>
                </ul>

                <div id="api">
                    <?php include BULK_PRODUCT_IMPORT_PLUGIN_PATH . '/inc/template-parts/template-api.php'; ?>
                </div>

                <div id="tables">
                    <?php include BULK_PRODUCT_IMPORT_PLUGIN_PATH . '/inc/template-parts/template-tables.php'; ?>
                </div>

                <!-- <div id="options">
                    <?php // include BULK_PRODUCT_IMPORT_PLUGIN_PATH . '/inc/template-parts/template-options.php'; ?>
                </div> -->

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

    public function save_options_callback() {

        check_ajax_referer( 'bulk_product_import_nonce', 'nonce' );

        if ( !current_user_can( 'manage_options' ) ) {
            wp_send_json_error( __( 'Unauthorized user', 'bulk-product-import' ) );
        }

        $option1 = sanitize_text_field( $_POST['option1'] );
        update_option( 'bpi_option1', $option1 );

        wp_send_json_success( __( 'Options saved successfully', 'bulk-product-import' ) );
    }
}
