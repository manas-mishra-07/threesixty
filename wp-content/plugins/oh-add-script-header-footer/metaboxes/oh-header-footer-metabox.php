<div class="postbox">
    <div class="inside">
        <table width="100%">
            <tr>
                <td valign="top">
                    <p>
                        <label for="oh_add_script_header_hide">
                            <input type="checkbox" <?php echo checked( $hide_header, 'on', false ) ?>
                                   name="oh_add_script_header_hide" id="oh_add_script_header_hide"/>
							<?php _e( "Hide Generic header script", 'oh_add_script' ); ?>

                        </label></p>
                    <p>
                        <label for="oh_add_script_header_hide">
                            <input type="checkbox" <?php echo checked( $hide_footer, 'on', false ) ?>
                                   name="oh_add_script_footer_hide" id="oh_add_script_footer_hide"/>
							<?php _e( "Hide Generic Footer script", 'oh_add_script' ); ?>

                        </label></p>

                </td>
				<?php if ( get_option( 'sogo_header_footer_lk_status' ) != 'valid' ): ?>
                    <td width="250">

                        <p><a target='_blank' href='https://pluginsmarket.com/downloads/sogo-header-footer/'><img
                                        style="max-width: 100%; height: auto"
                                        src='<?php echo plugins_url( 'images/300-250.jpg', __FILE__ ) ?>'
                                        alt='Sogo Web Development'/></a></p>
                        <p>
							<?php _e( "Upgrade now to a premium version and remove the ads!", 'oh_add_script' ); ?>
                            <a class="button-primary"
                               href="https://pluginsmarket.com/downloads/sogo-header-footer/"> <?php _e( "Upgrade now", 'oh_add_script' ); ?></a>
                        </p>

                    </td>
				<?php endif; ?>
            </tr>

        </table>

    </div>
    <!-- .inside -->

</div>
<!-- .postbox -->

<div class="postbox">
    <div class="inside">
        <table width="100%">
            <tr>
                <td valign="top">
                    <p>
                        <label for="oh_add_script_header">
							<?php _e( "add script / style to be added to the header of the page", 'oh_add_script' ); ?>
                        </label>
                        <textarea style="display: block;width: 90%;min-height: 150px;" id="oh_add_script_header"
                                  name="oh_add_script_header" size="25"><?php echo $value ?> </textarea>
                    </p>


                </td>
				<?php if ( get_option( 'sogo_header_footer_lk_status' ) != 'valid' ): ?>
                    <td width="250" valign="top">

                        <p><a target='_blank' href='https://pluginsmarket.com/downloads/sogo-header-footer/'><img
                                        style="max-width: 100%; height: auto"
                                        src='<?php echo plugins_url( 'images/300-250.jpg', __FILE__ ) ?>'
                                        alt='Sogo Web Development'/></a></p>
                        <p>
							<?php _e( "Upgrade now to a premium version and remove the ads!", 'oh_add_script' ); ?>
                            <a class="button-primary"
                               href="https://pluginsmarket.com/downloads/sogo-header-footer/"> <?php _e( "Upgrade now", 'oh_add_script' ); ?></a>
                        </p>

                    </td>
				<?php endif; ?>
            </tr>

            <tr>
                <td valign="top">
                    <p>

                        <label for="oh_add_script_header">
							<?php _e( "add script to be added to the footer of the page before the </body> (e.g Google Re-Marketing / Google Conversion )", 'oh_add_script_footer' ); ?>
                        </label>
                        <textarea style="display: block;width: 90%;min-height: 150px;" id="oh_add_script_footer"
                                  name="oh_add_script_footer" size="25"><?php echo $value_footer ?></textarea>
                    </p>
                    <p><?php _e( "You should put the code with the script tags<code> &lt;script type='text/javascript'&gt; the code &lt;/script&gt;</code>", 'oh_add_script_footer' ); ?></p>

                </td>
				<?php if ( get_option( 'sogo_header_footer_lk_status' ) != 'valid' ): ?>
                    <td width="250" valign="top">

                        <p><a target='_blank' href='https://pluginsmarket.com/downloads/sogo-header-footer/'><img
                                        style="max-width: 100%; height: auto"
                                        src='<?php echo plugins_url( 'images/300-250.jpg', __FILE__ ) ?>'
                                        alt='Sogo Web Development'/></a></p>
                        <p>
							<?php _e( "Upgrade now to a premium version and remove the ads!", 'oh_add_script' ); ?>
                            <a class="button-primary"
                               href="https://pluginsmarket.com/downloads/sogo-header-footer/"> <?php _e( "Upgrade now", 'oh_add_script' ); ?></a>
                        </p>
                    </td>
				<?php endif; ?>
            </tr>

        </table>

    </div>
    <!-- .inside -->

</div>
<!-- .postbox -->







