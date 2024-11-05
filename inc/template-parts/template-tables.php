<?php
// Get the table prefix option from the WordPress options
$table_prefix = get_option( 'be-table-prefix' ) ?? '';
?>

<div id="db-tables" class="common-shadow mt-4">
    <div class="row">
        <div class="col-sm-12">
            <!-- Title for the Table Prefix Section -->
            <h4 class="text-center mb-4">
                <?php esc_html_e( 'Custom Table Prefix', 'just-another-panel' ); ?>
            </h4>

            <!-- Form to set the table prefix -->
            <form action="" method="post">
                <div class="row align-items-center justify-content-between mb-3">
                    <!-- Label for Table Prefix -->
                    <label class="col-sm-4 col-form-label" for="table-prefix">
                        <?php esc_html_e( 'Table Prefix', 'just-another-panel' ); ?>
                    </label>
                    <!-- Input for Table Prefix -->
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="table-prefix" id="table-prefix"
                               placeholder="<?php esc_attr_e( 'Enter Table Prefix', 'just-another-panel' ); ?>"
                               value="<?php echo esc_attr( $table_prefix ); ?>">
                    </div>
                </div>

                <!-- Submit button to save table prefix -->
                <div class="row">
                    <div class="col text-start">
                        <input type="submit" class="btn btn-primary" id="save-table-prefix"
                               value="<?php esc_attr_e( 'Save', 'just-another-panel' ); ?>">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
