<?php

namespace BULK_IMPORT\Inc;

defined( "ABSPATH" ) || exit( "Direct Access Not Allowed" );

use BULK_IMPORT\Inc\Traits\Singleton;

class Enqueue_Assets {

    use Singleton;

    public function __construct() {
        $this->setup_hooks();
    }

    public function setup_hooks() {
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_css' ] );
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_js' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_style' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_script' ] );
    }

    public function enqueue_css() {
        // Register CSS
        wp_register_style( "be-public-style", BULK_PRODUCT_IMPORT_ASSETS_URL . "/public/css/be-public-style.css", );
        wp_register_style( "be-bootstrap", BULK_PRODUCT_IMPORT_ASSETS_URL . "/public/css/bootstrap.min.css" );

        // enqueue CSS
        wp_enqueue_style( "be-public-style" );
        wp_enqueue_style( "be-bootstrap" );
    }

    public function enqueue_js() {

        // Register JS
        wp_register_script( "be-public-scripts", BULK_PRODUCT_IMPORT_ASSETS_URL . "/public/js/be-public-scripts.js", [ 'jquery' ], false, true );
        wp_register_script( "be-bootstrap", BULK_PRODUCT_IMPORT_ASSETS_URL . "/public/js/bootstrap.bundle.min.js", [], false, true );

        // enqueue JS
        wp_enqueue_script( "be-public-scripts" );
        wp_enqueue_script( "be-bootstrap" );
    }

    public function admin_enqueue_style() {
        wp_register_style( "be-admin-bootstrap", BULK_PRODUCT_IMPORT_ASSETS_URL . "/admin/css/bootstrap.min.css" );
        wp_register_style( "be-admin-toastify", BULK_PRODUCT_IMPORT_ASSETS_URL . "/admin/css/toastify.css" );
        wp_register_style( "be-admin-style", BULK_PRODUCT_IMPORT_ASSETS_URL . "/admin/css/be-admin-style.css" );

        wp_enqueue_style( "be-admin-bootstrap" );
        wp_enqueue_style( "be-admin-toastify" );
        wp_enqueue_style( "be-admin-style" );
    }

    public function admin_enqueue_script() {
        // register confetti js
        wp_register_script( "be-confetti", BULK_PRODUCT_IMPORT_ASSETS_URL . "/admin/js/confetti.min.js", [], false, true );

        // toastify js
        wp_register_script( "toastify", BULK_PRODUCT_IMPORT_ASSETS_URL . "/admin/js/toastify.js", [], false, true );

        // register admin menu js
        wp_register_script( "be-admin-script", BULK_PRODUCT_IMPORT_ASSETS_URL . "/admin/js/be-admin-scripts.js", [ 'jquery' ], false, true );
        wp_localize_script( 'be-admin-script', 'bulkProductImport', [
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonce'    => wp_create_nonce( 'bulk_product_import_nonce' ),
        ] );

        wp_enqueue_script( "jquery-ui-tabs" );
        wp_enqueue_script( "be-confetti" );
        wp_enqueue_script( "toastify" );
        wp_enqueue_script( "be-admin-script" );
    }
}