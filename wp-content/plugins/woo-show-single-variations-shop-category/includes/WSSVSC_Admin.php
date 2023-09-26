<?php
/**
 * This class is loaded on the back-end since its main job is 
 * to display the Admin to box.
 */

class WSSVSC_Admin {
	
	public function __construct () {

		add_action( 'admin_init', array( $this, 'WSSVSC_register_settings' ) );
		add_action( 'admin_menu', array( $this, 'WSSVSC_admin_menu' ) );
		add_filter( 'woocommerce_product_data_tabs', array( $this, 'WSSVSC_custom_product_tabs' ) );
		add_filter( 'woocommerce_product_data_panels', array( $this, 'WSSVSC_custom_product_panels' ) );
		add_action( 'woocommerce_process_product_meta', array( $this, 'WSSVSC_custom_save' ) );
		if ( is_admin() ) {
			return;
		}
		
	}

	public function WSSVSC_custom_product_tabs( $tabs) {
		$tabs['wwsvsc_tab'] = array(
			'label'		=> __( 'Single Variation', 'wssvsc' ),
			'target'  =>  'wwsvsc_tab_content',
	        'priority' => 60,
	        'class'   => array()
		);
		return $tabs;
	}

	public function WSSVSC_custom_product_panels() {
		global $post;
		?>
		<div id='wwsvsc_tab_content' class='panel woocommerce_options_panel'>
			<div class='options_group'>
				<?php
					woocommerce_wp_checkbox( array(
						'id' 		=> '_wwsvsc_exclude_product_single',
						'label' 	=> __( 'Exclude Single Variation', 'wssvsc' ),
						'description'   => __( 'Enable this option to exclude single variation on shop & category pages.', 'wssvsc' ) 
					) );
				?>
				<?php
					woocommerce_wp_checkbox( array(
						'id' 		=> '_wwsvsc_exclude_product_parent',
						'label' 	=> __( 'Hide Parent Variable Product', 'wssvsc' ),
						'description'   => __( 'Enable this option to Hide parent variation on shop & category pages.<br/><strong>Note: this option will be not work for Show Variations Dropdown</strong>', 'wssvsc' ) 
					) );
				?>
		</div>
	</div>
		<?php
	}

	public function WSSVSC_custom_save( $post_id ) {
	
		$wwsvsc_exclude_product_single = isset( $_POST['_wwsvsc_exclude_product_single'] ) ? 'yes' : 'no';
		update_post_meta( $post_id, '_wwsvsc_exclude_product_single', $wwsvsc_exclude_product_single );

		$wwsvsc_exclude_product_parent = isset( $_POST['_wwsvsc_exclude_product_parent'] ) ? 'yes' : 'no';
		update_post_meta( $post_id, '_wwsvsc_exclude_product_parent', $wwsvsc_exclude_product_parent );
	}
	public function WSSVSC_admin_menu () {

		add_options_page('Woo Variation Settings', 'Woo Variation Settings', 'manage_options', 'WSSVSC', array( $this, 'WSSVSC_page' ));
	}

	public function WSSVSC_page() {

		if($_REQUEST['msg']=='success'){
	?>
		<div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible">
			<p><strong>Variation Proccess Completed</strong></p>
			<button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
		</div>
	<?php
	}
	?>
	

	<div>
	   <?php screen_icon(); ?>
	   <h2><?php _e('WooCommerce Shop & Category Setting', 'gmwsvs'); ?></h2>
	   <form method="post" action="options.php">
	      <?php 
	      settings_fields( 'gmwsvs_options_group' ); 
	      $gmwsvs_enable_setting = get_option('gmwsvs_enable_setting');
	      $gmwsvs_hide_parent_product = get_option('gmwsvs_hide_parent_product');
	      $gmwsvs_optionc = get_option('gmwsvs_optionc');
	      ?>
	      <table class="form-table">
		         
		         <tr valign="top">
		            <th scope="row">
		               <label for="gmwsvs_enable_setting"><?php _e('Enable', 'gmwsvs'); ?></label>
		            </th>
		            <td>
		               <input class="regular-text" type="checkbox" id="gmwsvs_enable_setting" <?php echo (($gmwsvs_enable_setting=='yes')?'checked':'') ; ?> name="gmwsvs_enable_setting" value="yes" />
		            </td>
		         </tr>
		         <tr>
	                <th scope="row"><label><?php _e('Option', 'gmtrip'); ?></label></th>
	                <td>
	                   <input type="radio" name="gmwsvs_optionc" <?php echo ($gmwsvs_optionc=='singlevari')?'checked':''; ?> value="singlevari"><?php _e('WooCommerce Show Variations As Single Product On Shop & Category', 'gmwsvs'); ?><br/>
	                   <input type="radio" name="gmwsvs_optionc" <?php echo ($gmwsvs_optionc=='variatdrop')?'checked':''; ?> value="variatdrop"><?php _e('Woocommerce Show Variations Dropdown On Shop & Category', 'gmwsvs'); ?>
	                 
	                </td>
	            </tr>
	            <tr valign="top">
		            <th scope="row">
		               <label for="gmwsvs_hide_parent_product"><?php _e('Variable Parent Product', 'gmwsvs'); ?></label>
		            </th>
		            <td>
		               <input class="regular-text" type="checkbox" id="gmwsvs_hide_parent_product" <?php echo (($gmwsvs_hide_parent_product=='yes')?'checked':'') ; ?> name="gmwsvs_hide_parent_product" value="yes" />
		               <?php _e('Hide Parent Product of Variable Product', 'gmwsvs'); ?>
		               <p class="description"><?php _e('<strong>Note:</strong> This option will be work for just <strong>Show Variations As Single Product</strong>', 'gmwsvs'); ?></p>
		            </td>
		         </tr>
	      </table>
	      <?php  submit_button(); ?>
	   </form>
	   <hr>
	   <?php
	  /* $args = array(
	   	'post_type' => 'product_variation',
	   	'meta_query' => array(
					        array(
					            'key'     => 'gmwsvs_is_tax_setup',
					            'compare' => 'NOT EXISTS',
					        ),
					    ),
	   );
	   $query1 = new WP_Query( $args );
	   echo "<pre>";
	   print_r($query1);
	   echo "</pre>";*/
	   global $wpdb;
	  $tolaleft = "SELECT count(*) as total  FROM {$wpdb->posts} as t1 LEFT JOIN {$wpdb->postmeta} as t2 ON (t1.ID = t2.post_id AND t2.meta_key = 'gmwsvs_is_tax_setup' ) WHERE 1=1  AND ( t2.post_id IS NULL) AND t1.post_type = 'product_variation' AND (t1.post_status = 'publish' OR t1.post_status = 'future' OR t1.post_status = 'draft' OR t1.post_status = 'pending' OR t1.post_status = 'private')";
	  $user_count = $wpdb->get_var($tolaleft);
	  ?>
	  <p>Run this process so variation will be show up <Strong style='color:red;'><?php echo $user_count;?> Products Lefts</Strong></p>
	   <a href="<?php echo get_admin_url()."?action=run_process";?>" class="button button-primary"><?php _e('Proccess For Product Visibiliy', 'gmwsvs'); ?></a> 
	</div>
	<?php
	}

	public function WSSVSC_register_settings() {

		
		register_setting( 'gmwsvs_options_group', 'gmwsvs_enable_setting', array( $this, 'gmwsvs_accesstoken_callback' ) );
		register_setting( 'gmwsvs_options_group', 'gmwsvs_optionc', array( $this, 'gmwsvs_accesstoken_callback' ) );
		register_setting( 'gmwsvs_options_group', 'gmwsvs_hide_parent_product', array( $this, 'gmwsvs_accesstoken_callback' ) );

		if($_REQUEST['action']=='run_process'){
				$args = array(
				   	'post_type' => 'product_variation',
				   	'posts_per_page' => -1,
				   	'meta_query' => array(
								        array(
								            'key'     => 'gmwsvs_is_tax_setup',
								            'compare' => 'NOT EXISTS',
								        ),
								    ),
			   );
			   $the_query = new WP_Query( $args );
			   if ( $the_query->have_posts() ) {
        			while ( $the_query->have_posts() ) {
        				$the_query->the_post();
        				global $post;
        				$variation_id = $post->ID;
        				$parent_product_id = wp_get_post_parent_id( $variation_id );

				        if( $parent_product_id ) {

				            // add categories and tags to variaition
				            $taxonomies = array(
				                'product_cat',
				                'product_tag'
				            );

				            foreach( $taxonomies as $taxonomy ) {

				                $terms = (array) wp_get_post_terms( $parent_product_id, $taxonomy, array("fields" => "ids") );
				                wp_set_post_terms( $variation_id, $terms, $taxonomy );

				            }

				            update_post_meta( $variation_id, 'gmwsvs_is_tax_setup', 'yes' );

				        }
				    }
				}
				wp_redirect(  get_admin_url().'options-general.php?page=WSSVSC&msg=success' );
			exit;
		}
	}
	
	
	public function gmwsvs_accesstoken_callback($option) {
		if ( empty( $option ) ) {
		}
		return $option;
	}

	
	
}



?>