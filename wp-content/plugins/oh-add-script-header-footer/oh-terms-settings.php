<?php
/**
 * Created by PhpStorm.
 * User: oren
 * Date: 08-Nov-17
 * Time: 8:19 AM
 */

class OHHeaderFooterTerms {


	function __construct() {


		$taxonomies = get_taxonomies();

		if ( $taxonomies ) {
			foreach ( $taxonomies  as $key=>$taxonomy ) {
				add_action( $key.'_edit_form_fields', array( $this, 'edit_category_fields' ) );
				add_action( 'edited_'.$key, array( $this, 'update_category_meta' ) );
			}
		}

	}


	function update_category_meta( $term_id ) {

		if ( isset( $_POST['oh-hide-header'] ) && '' !== $_POST['oh-hide-header'] ) {
			update_term_meta( $term_id, 'oh-hide-header', $_POST['oh-hide-header'] );
		} else {
			delete_term_meta( $term_id, 'oh-hide-header' );
		}
		if ( isset( $_POST['oh-hide-footer'] ) && '' !== $_POST['oh-hide-footer'] ) {
			update_term_meta( $term_id, 'oh-hide-footer', $_POST['oh-hide-footer'] );
		} else {
			delete_term_meta( $term_id, 'oh-hide-footer' );
		}
		if ( isset( $_POST['oh-header-script'] )   ) {
			update_term_meta( $term_id, 'oh-header-script', $_POST['oh-header-script'] );
		}

		if ( isset( $_POST['oh-footer-script'] )   ) {
			update_term_meta( $term_id, 'oh-footer-script', $_POST['oh-footer-script'] );
		}



	}




	function edit_category_fields( $term ) {


		// get current group
		$hide_header = get_term_meta( $term->term_id, 'oh-hide-header', true );
		$hide_footer = get_term_meta( $term->term_id, 'oh-hide-footer', true );
		$header      = get_term_meta( $term->term_id, 'oh-header-script', true );
		$footer      = get_term_meta( $term->term_id, 'oh-footer-script', true );

		?>


        <tr class="form-field term-group-wrap">
            <th scope="row"><label for="oh_add_script_header_hide">

					<?php _e( "Hide Generic header script", 'oh_add_script' ); ?>

                </label></th>
            <td><input type="checkbox" <?php echo checked( $hide_header, 'on', false )
				?>
                       name="oh-hide-header" id="oh_add_script_header_hide"/>

                <p class="description"></p></td>
        </tr>
        <tr class="form-field term-group-wrap">
            <th scope="row"><label for="oh_add_script_footer_hide">
					<?php _e( "Hide Generic Footer script", 'oh_add_script' ); ?>

                </label></th>
            <td><input type="checkbox" <?php echo checked( $hide_footer, 'on', false )
				?>
                       name="oh-hide-footer" id="oh_add_script_footer_hide"/>

                <p class="description"></p></td>
        </tr>
        <tr class="form-field term-group-wrap">
            <th scope="row"><label
                        for="oh_add_script_header"><?php _e( 'Customer Header Script', 'oh_add_script' ); ?></label>
            </th>
            <td><textarea class="large-text" cols="50" rows="5" id="oh_add_script_header" name="oh-header-script"><?php echo $header ?></textarea>
                <p class="description"></p></td>
        </tr>
        <tr class="form-field term-group-wrap">
        <th scope="row"><label
                    for="oh_add_script_footer"><?php _e( 'Customer Footer Script', 'oh_add_script' ); ?></label></th>
        <td><textarea class="large-text" cols="50" rows="5" id="oh_add_script_footer" name="oh-footer-script"><?php echo $footer ?></textarea>
            <p class="description"></p></td>
        </tr><?php
	}
}

if ( is_admin() ) {
	$my_terms_settings_page = new OHHeaderFooterTerms();
}