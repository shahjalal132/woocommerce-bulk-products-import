<?php
// Get the table prefix option from the WordPress options
$table_prefix = get_option( 'be-table-prefix' ) ?? '';
?>

<div id="db-tables" class="common-shadow container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <!-- Title for the Table Prefix Section -->
            <h4 class="text-center mb-4">
                <?php esc_html_e( 'Custom Table Prefix', 'bulk-product-import' ); ?>
            </h4>

            <!-- Form to set the table prefix -->
            <form action="" method="post">
                <div class="row mb-3">
                    <!-- Label for Table Prefix -->
                    <label class="col-sm-4 col-form-label text-end" for="table-prefix">
                        <?php esc_html_e( 'Table Prefix', 'bulk-product-import' ); ?>
                    </label>
                    <!-- Input for Table Prefix -->
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="table-prefix" id="table-prefix"
                               placeholder="<?php esc_attr_e( 'Enter Table Prefix', 'bulk-product-import' ); ?>"
                               value="<?php echo esc_attr( $table_prefix ); ?>">
                    </div>
                </div>

                <!-- Submit button to save table prefix -->
                <div class="row">
                    <div class="col text-start">
                        <input type="submit" class="btn btn-primary" id="save-table-prefix"
                               value="<?php esc_attr_e( 'Save', 'bulk-product-import' ); ?>">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
