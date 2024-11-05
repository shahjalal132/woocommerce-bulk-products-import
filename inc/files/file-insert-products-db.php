<?php

// TRUNCATE Table
function truncate_table( $table_name ) {
    global $wpdb;
    $wpdb->query( "TRUNCATE TABLE $table_name" );
}

// fetch products from api
function fetch_products_from_api() {

    $curl = curl_init();
    curl_setopt_array( $curl, [
        CURLOPT_URL            => '',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING       => '',
        CURLOPT_MAXREDIRS      => 10,
        CURLOPT_TIMEOUT        => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST  => 'GET',
        CURLOPT_HTTPHEADER     => [
            '',
        ],
    ] );

    $response = curl_exec( $curl );

    curl_close( $curl );
    return $response;
}

// insert products to database
function insert_products_db() {
    // Fetch products from the API
    $api_response = fetch_products_from_api();
    if ( is_wp_error( $api_response ) || empty( $api_response ) ) {
        return 'Error fetching products from API or empty response.';
    }

    $products = [];
    if ( !empty( $api_response ) ) {
        $products = json_decode( $api_response, true );
        if ( json_last_error() !== JSON_ERROR_NONE ) {
            return 'Error decoding API response: ' . json_last_error_msg();
        }
    }

    // echo count($products);
    // die();

    // Database insertion
    global $wpdb;
    $table_prefix   = get_option( 'be-table-prefix' ) ?? '';
    $products_table = $wpdb->prefix . $table_prefix . 'sync_products';

    // Truncate table with error handling
    truncate_table( $products_table );

    // Insert products and handle errors individually
    $errors = [];
    foreach ( $products as $product ) {

        $product_data = json_encode( $product );

        /* $sql = $wpdb->prepare(
            "INSERT INTO $products_table (product_number, product_data, status) VALUES (%s, %s, %s)
            ON DUPLICATE KEY UPDATE product_data = %s, status = %s",
            $product_number,
            $product_data,
            'pending',
            $product_data,
            'pending'
        );

        $inserted = $wpdb->query( $sql ); */

        $inserted = $wpdb->insert(
            $products_table,
            [
                'product_number' => '',
                'product_data'   => $product_data,
                'status'         => 'pending',
            ]
        );

        if ( $inserted === false ) {
            $errors[] = 'Error inserting product: ' . $wpdb->last_error;
        }
    }

    // Return appropriate message based on errors
    if ( !empty( $errors ) ) {
        return 'Some products could not be inserted: ' . implode( '; ', $errors );
    }

    return 'Products inserted successfully into the database.';
}

// fetch price from api
function fetch_price_from_api() {

    $curl = curl_init();
    curl_setopt_array( $curl, [
        CURLOPT_URL            => '',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING       => '',
        CURLOPT_MAXREDIRS      => 10,
        CURLOPT_TIMEOUT        => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST  => 'GET',
        CURLOPT_HTTPHEADER     => [
            '',
        ],
    ] );

    $response = curl_exec( $curl );

    curl_close( $curl );
    return $response;

}

// insert price to database
function insert_price_db() {
    // Fetch price data from the API
    $api_response = fetch_price_from_api();
    if ( is_wp_error( $api_response ) || empty( $api_response ) ) {
        return 'Error fetching prices from API or empty response.';
    }

    $prices = [];
    if ( !empty( $api_response ) ) {
        $prices = json_decode( $api_response, true );
        if ( json_last_error() !== JSON_ERROR_NONE ) {
            return 'Error decoding API response: ' . json_last_error_msg();
        }
    }

    // Database insertion
    global $wpdb;
    $table_prefix = get_option( 'be-table-prefix' ) ?? '';
    $price_table  = $wpdb->prefix . $table_prefix . 'sync_price';

    // Truncate table with error handling
    truncate_table( $price_table );

    // Insert prices and handle errors individually
    $errors = [];
    foreach ( $prices as $price ) {
        // Assuming the price array contains keys for 'product_number', 'regular_price', and 'sale_price'
        $product_number = $price['product_number'] ?? '';
        $regular_price  = $price['regular_price'] ?? 0;
        $sale_price     = $price['sale_price'] ?? 0;

        $inserted = $wpdb->insert(
            $price_table,
            [
                'product_number' => $product_number,
                'regular_price'  => $regular_price,
                'sale_price'     => $sale_price,
            ]
        );

        if ( $inserted === false ) {
            $errors[] = 'Error inserting price for product ' . $product_number . ': ' . $wpdb->last_error;
        }
    }

    // Return appropriate message based on errors
    if ( !empty( $errors ) ) {
        return 'Some prices could not be inserted: ' . implode( '; ', $errors );
    }

    return 'Prices inserted successfully into the database.';
}

// fetch price from api
function fetch_stock_from_api() {

    $curl = curl_init();
    curl_setopt_array( $curl, [
        CURLOPT_URL            => '',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING       => '',
        CURLOPT_MAXREDIRS      => 10,
        CURLOPT_TIMEOUT        => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST  => 'GET',
        CURLOPT_HTTPHEADER     => [
            '',
        ],
    ] );

    $response = curl_exec( $curl );

    curl_close( $curl );
    return $response;

}

// insert stock to database
function insert_stock_db() {
    // Fetch stock data from the API
    $api_response = fetch_stock_from_api();
    if ( is_wp_error( $api_response ) || empty( $api_response ) ) {
        return 'Error fetching stock from API or empty response.';
    }

    $stocks = [];
    if ( !empty( $api_response ) ) {
        $stocks = json_decode( $api_response, true );
        if ( json_last_error() !== JSON_ERROR_NONE ) {
            return 'Error decoding API response: ' . json_last_error_msg();
        }
    }

    // Database insertion
    global $wpdb;
    $table_prefix = get_option( 'be-table-prefix' ) ?? '';
    $stock_table  = $wpdb->prefix . $table_prefix . 'sync_stock';

    // Truncate table with error handling
    truncate_table( $stock_table );

    // Insert stock data and handle errors individually
    $errors = [];
    foreach ( $stocks as $stock ) {
        // Assuming each stock contains a 'product_number' and 'stock' field
        $product_number = $stock['product_number'] ?? '';
        $stock          = $stock['stock'] ?? 0;

        $inserted = $wpdb->insert(
            $stock_table,
            [
                'product_number' => $product_number,
                'stock'          => $stock,
            ]
        );

        if ( $inserted === false ) {
            $errors[] = 'Error inserting stock for product ' . $product_number . ': ' . $wpdb->last_error;
        }
    }

    // Return appropriate message based on errors
    if ( !empty( $errors ) ) {
        return 'Some stock records could not be inserted: ' . implode( '; ', $errors );
    }

    return 'Stocks inserted successfully into the database.';
}
