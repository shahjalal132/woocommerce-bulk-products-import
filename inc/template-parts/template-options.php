<?php

$option1 = get_option( 'bpi_option1' ) ?? '';

?>

<!-- API credentials form -->
<div class="container-fluid bpi_options">
    <div class="row">
        <div class="col-sm-12">
            <h4 class="text-center mb-4">
                <?php esc_html_e( 'BPI Options', 'bulk-product-import' ); ?>
            </h4>

            <!-- Form for entering WooCommerce API credentials -->
            <form id="bpi_options">
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label text-start" for="option1">
                        <?php esc_html_e( 'Options1', 'bulk-product-import' ); ?>
                    </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="option1" id="option1"
                            value="<?php echo esc_attr( $option1 ); ?>"
                            placeholder="<?php esc_attr_e( 'Options1', 'bulk-product-import' ); ?>">
                    </div>
                </div>

                <!-- Submit button to save credentials -->
                <div class="row mt-4">
                    <div class="col text-start">
                        <input type="submit" class="btn btn-primary" id="options-save"
                            value="<?php esc_attr_e( 'Save', 'bulk-product-import' ); ?>">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>