<?php
// Get WooCommerce API credentials from the WordPress options
$client_id     = get_option( 'be-client-id' ) ?? '';
$client_secret = get_option( 'be-client-secret' ) ?? '';
?>

<!-- API credentials form -->
<div class="container-fluid api-credentials">
    <div class="row">
        <div class="col-sm-12">
            <h4 class="text-center mb-4">
                <?php esc_html_e( 'WooCommerce API Credentials', 'bulk-product-import' ); ?>
            </h4>

            <!-- Form for entering WooCommerce API credentials -->
            <form id="client-credentials-form">
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label text-start" for="client-id">
                        <?php esc_html_e( 'Consumer key', 'bulk-product-import' ); ?>
                    </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="client-id" id="client-id"
                               value="<?php echo esc_attr( $client_id ); ?>"
                               placeholder="<?php esc_attr_e( 'Consumer key', 'bulk-product-import' ); ?>" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label text-start" for="client-secret">
                        <?php esc_html_e( 'Consumer secret', 'bulk-product-import' ); ?>
                    </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="client-secret" id="client-secret"
                               value="<?php echo esc_attr( $client_secret ); ?>"
                               placeholder="<?php esc_attr_e( 'Consumer secret', 'bulk-product-import' ); ?>" required>
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
