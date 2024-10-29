<?php
// Get WooCommerce API credentials from the WordPress options
$client_id     = get_option( 'be-client-id' ) ?? '';
$client_secret = get_option( 'be-client-secret' ) ?? '';
?>

<!-- API credentials form -->
<div class="container-fluid api-credentials">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <!-- Title for the API credentials section -->
            <h4 class="text-center mb-4">
                <?php esc_html_e( 'WooCommerce API Credentials', 'bulk-product-import' ); ?>
            </h4>

            <!-- Form for entering WooCommerce API credentials -->
            <form id="client-credentials-form">
                <div class="row mb-3">
                    <!-- Label for Client ID -->
                    <label class="col-sm-4 col-form-label text-start" for="client-id">
                        <?php esc_html_e( 'Client ID', 'bulk-product-import' ); ?>
                    </label>
                    <!-- Input for Client ID -->
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="client-id" id="client-id"
                               value="<?php echo esc_attr( $client_id ); ?>"
                               placeholder="<?php esc_attr_e( 'Client ID', 'bulk-product-import' ); ?>" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <!-- Label for Client Secret -->
                    <label class="col-sm-4 col-form-label text-start" for="client-secret">
                        <?php esc_html_e( 'Client Secret', 'bulk-product-import' ); ?>
                    </label>
                    <!-- Input for Client Secret -->
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="client-secret" id="client-secret"
                               value="<?php echo esc_attr( $client_secret ); ?>"
                               placeholder="<?php esc_attr_e( 'Client Secret', 'bulk-product-import' ); ?>" required>
                    </div>
                </div>

                <!-- Submit button to save credentials -->
                <div class="row mt-4">
                    <div class="col text-start">
                        <input type="submit" class="btn btn-primary" id="credential-save"
                               value="<?php esc_attr_e( 'Save', 'bulk-product-import' ); ?>">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
