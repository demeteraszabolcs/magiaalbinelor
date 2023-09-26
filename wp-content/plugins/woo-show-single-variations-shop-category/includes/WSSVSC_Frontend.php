<?php
/**
 * This class is loaded on the back-end since its main job is 
 * to display the Admin to box.
 */

class WSSVSC_Frontend {
	
	public function __construct () {

		if(get_option('gmwsvs_enable_setting')=='yes'){
			if(get_option('gmwsvs_optionc')=='singlevari'){
				add_action( 'woocommerce_product_query', array( $this, 'WSSVSC_woocommerce_product_query' ) );
				add_filter( 'posts_clauses', array( $this, 'WSSVSC_posts_clauses' ), 10, 2);
			}else{
				add_filter( 'woocommerce_loop_add_to_cart_link', array( $this, 'WSSVSC_display_variation_dropdown_on_shop_page' ) );
			}
			
		}
		add_action( 'woocommerce_save_product_variation', array( $this, 'on_variation_save' ), 10, 2 );
	}

	public function WSSVSC_display_variation_dropdown_on_shop_page(){
		 global $product;
		// print_r( $product);
		 $proid= $product->get_id();
		 $wwsvsc_exclude_product_single = get_post_meta( $proid, '_wwsvsc_exclude_product_single', true ); 
		 if( $product->is_type( 'variable' ) && ($wwsvsc_exclude_product_single!='yes')) {
			
		  wp_enqueue_script('wc-add-to-cart-variation');

		  $attribute_keys = array_keys( $product->get_variation_attributes() );

		  ?>

		  <form class="variations_form cart" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->id ); ?>" data-product_variations="<?php echo htmlspecialchars( json_encode( $product->get_available_variations() ) ) ?>">
		    <?php do_action( 'woocommerce_before_variations_form' ); ?>

		    <?php if ( empty( $product->get_available_variations() ) && false !== $product->get_available_variations() ) : ?>
		      <p class="stock out-of-stock">
		        <?php _e( 'This product is currently out of stock and unavailable.', 'woocommerce' ); ?>
		      </p>
		    <?php else : ?>
		      <table class="variations" cellspacing="0">
		        <tbody>
		          <?php foreach ( $product->get_variation_attributes() as $attribute_name => $options ) : ?>
		          <tr>
		            <td class="label"><label for="<?php echo sanitize_title( $attribute_name ); ?>"><?php echo wc_attribute_label( $attribute_name ); ?></label></td>
		            <td class="value">
		              <?php
		                $selected = isset( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ? wc_clean( urldecode( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ) : $product->get_variation_default_attribute( $attribute_name );
		                wc_dropdown_variation_attribute_options( array( 'options' => $options, 'attribute' => $attribute_name, 'product' => $product, 'selected' => $selected ) );
		              ?>
		            </td>
		          </tr>
		          <?php endforeach;?>
		        </tbody>
		      </table>

		      <?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		      <div class="single_variation_wrap">
		        <?php
		          /**
		           * woocommerce_before_single_variation Hook.
		           */
		          do_action( 'woocommerce_before_single_variation' );

		          /**
		           * woocommerce_single_variation hook. Used to output the cart button and placeholder for variation data.
		           * @since 2.4.0
		           * @hooked woocommerce_single_variation - 10 Empty div for variation data.
		           * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
		           */
		          do_action( 'woocommerce_single_variation' );

		          /**
		           * woocommerce_after_single_variation Hook.
		           */
		          do_action( 'woocommerce_after_single_variation' );
		        ?>
		      </div>

		      <?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
		      
		    <?php endif; ?>

		    <?php do_action( 'woocommerce_after_variations_form' ); ?>
		    
		  </form>

		  <?php } else { 
		 

	echo sprintf( '<a href="%s" data-quantity="%s" class="%s" %s>%s</a>',
		esc_url( $product->add_to_cart_url() ),
		esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
		esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
		isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
		esc_html( $product->add_to_cart_text() )
	)

		  	?>
		   
		   
		<?php }
	}

	public function WSSVSC_woocommerce_product_query ($q) {

		$tax_query = (array) $q->get( 'tax_query' );
		$q->set( 'post_type', array('product','product_variation') );
		$q->set( 'gmwsvsfilter', 'yes' );
		$meta_query = (array) $q->get( 'meta_query' );
		/*$meta_query[] = array(
								'relation' => 'OR',
								array(
											'key' => '_wwsvsc_exclude_product_single',
											'value' => 'yes',
											'compare' => 'NOT EXISTS'
											
										),
								array(
											'key' => '_wwsvsc_exclude_product_single',
											'value' => 'yes',
											
											'compare' => '!=',
										),
							);*/
		$meta_query[] = array(
								'relation' => 'OR',
								array(
											'key' => '_wwsvsc_exclude_product_parent',
											'value' => 'yes',
											'compare' => 'NOT EXISTS'
										),
								array(
											'key' => '_wwsvsc_exclude_product_parent',
											'value' => 'yes',
											'compare' => '!=',
										),
							);
		/*echo '<pre>';
		print_r($meta_query);
		echo '</pre>';*/
		$q->set( 'meta_query', $meta_query );
	}

	public function WSSVSC_posts_clauses ($clauses, $query) {
		global $wpdb;
		if($query->query_vars['gmwsvsfilter']=='yes'){
			if(get_option('gmwsvs_hide_parent_product')=='yes'){
				$clauses['where'] .= " AND  0 = (select count(*) as totalpart from {$wpdb->posts} as oc_posttb where oc_posttb.post_parent = {$wpdb->posts}.ID and oc_posttb.post_type= 'product_variation') ";
			}
			$clauses['join'] .= " LEFT JOIN {$wpdb->postmeta} as  oc_posttba ON ({$wpdb->posts}.post_parent = oc_posttba.post_id AND oc_posttba.meta_key = '_wwsvsc_exclude_product_single' )";
			$clauses['where'] .= " AND  ( oc_posttba.meta_value IS NULL OR oc_posttba.meta_value!='yes') ";
				/*echo "<pre>";
			print_r($clauses);
			echo "</pre>";*/
			
		}
		
		return $clauses;
	}

	public function on_variation_save( $variation_id, $i = false ) {

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

/*add_filter( 'posts_request', 'dump_request' );

function dump_request( $input ) {

    var_dump($input);

    return $input;
}
*/
?>