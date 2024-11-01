<?php 
/*
* Magical addons functions 
*
*
*/

function wooaddons_get_allowed_html_tags() {
    $allowed_html = [
        'b' => [],
        'i' => [],
        'u' => [],
        'em' => [],
        'br' => [],
        'abbr' => [
            'title' => [],
        ],
        'span' => [
            'class' => [],
        ],
        'strong' => [],
    ];

        $allowed_html['a'] = [
            'href' => [],
            'title' => [],
            'class' => [],
            'id' => [],
        ];
  
    return $allowed_html;
}

function wooaddons_kses_tags( $string = '' ) {
    return wp_kses( $string, wooaddons_get_allowed_html_tags() );
}
/**
 * Check elementor version
 *
 * @param string $version
 * @param string $operator
 * @return bool
 */
function wooaddons_elementor_version_check( $operator = '<', $version = '2.6.0' ) {
    return defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, $version, $operator );
}

/**
 *  Taxonomy List
 * @return array
 */
function wooaddons_taxonomy_list( $taxonomy = 'product_cat' ){
    $terms = get_terms( array(
        'taxonomy' => $taxonomy,
        'hide_empty' => true,
    ));
    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
        foreach ( $terms as $term ) {
            $options[ $term->slug ] = $term->name;
        }
        return $options;
    }
}


/**
 * Get Post List
 * return array
 */
function wooaddons_product_name( $post_type = 'product' ){
    $options = array();
    $options['0'] = __('Select','wooaddons-for-elementor');
   // $perpage = wooaddons_get_option( 'loadproductlimit', 'wooaddons_others_tabs', '20' );
    $all_post = array( 'posts_per_page' => -1, 'post_type'=> $post_type );
    $post_terms = get_posts( $all_post );
    if ( ! empty( $post_terms ) && ! is_wp_error( $post_terms ) ){
        foreach ( $post_terms as $term ) {
            $options[ $term->ID ] = $term->post_title;
        }
        return $options;
    }
}

    // Customize rating html
    if( !function_exists('wooaddons_wc_get_rating_html') ){
        function wooaddons_wc_get_rating_html( $wae_class = '' ){
            if ( get_option( 'woocommerce_enable_review_rating' ) === 'no' ) { return; }
            global $product;
            $rating_count = $product->get_rating_count();
            $review_count = $product->get_review_count();
            $average      = $product->get_average_rating();
            if ( $rating_count > 0 ) {
                $rating_whole = $average / 5*100;
                $wrapper_class = is_single() ? 'rating-number' : 'top-rated-rating';
                ob_start();
            ?>
            <div class="wae-rating">
                <div class="woopg-product-rating <?php echo esc_attr( $wae_class ); ?>">
                <div class="<?php echo esc_attr( $wrapper_class ); ?>">
                    <span class="wd-product-ratting">
                        <span class="wd-product-user-ratting" style="width: <?php echo esc_attr( $rating_whole );?>%;">
                            <i class="eicon-star"></i>
                            <i class="eicon-star"></i>
                            <i class="eicon-star"></i>
                            <i class="eicon-star"></i>
                            <i class="eicon-star"></i>
                        </span>
                        <i class="eicon-star-o"></i>
                        <i class="eicon-star-o"></i>
                        <i class="eicon-star-o"></i>
                        <i class="eicon-star-o"></i>
                        <i class="eicon-star-o"></i>
                    </span>
                </div>
                </div>
            </div>
            <?php
                $html = ob_get_clean();
            } else { $html  = ''; }
            return $html;
        }
    }
    // Customize rating html
    if( !function_exists('wooaddons_wc_empty_rating_html') ){
        function wooaddons_wc_empty_rating_html(){
            if ( get_option( 'woocommerce_enable_review_rating' ) === 'no' ) { return; }
            global $product;
            $rating_count = $product->get_rating_count();
            if ( $rating_count < 1 ) {
             ?>
            <div class="wooaddons-no-rating"></div>
            <?php
        }
    }
}

/* 
* Category list
* return first one
*/
function wooaddons_product_category( $id = null, $taxonomy = 'product_cat', $limit = 1 ) { 
    $terms = get_the_terms( $id, $taxonomy );
    $i = 0;
    if ( is_wp_error( $terms ) )
        return $terms;

    if ( empty( $terms ) )
        return false;

    foreach ( $terms as $term ) {
        $i++;
        $link = get_term_link( $term, $taxonomy );
        if ( is_wp_error( $link ) ) {
            return $link;
        }
        echo '<a href="' . esc_url( $link ) . '">' . $term->name . '</a>';
        if( $i == $limit ){
            break;
        }else{ continue; }
    }
}

function wooaddons_products_badge(){
    global $post, $product;

     if ( $product->is_on_sale() ){
         ?>
    <div class="wooaddons-badge">
     <?php esc_html_e( 'Sale!', 'wooaddons-for-elementor' ); ?>   
    </div>
    <?php
        }elseif( $product->is_featured() ){
    ?>
    <div class="wooaddons-badge">
     <?php esc_html_e( 'Featured!', 'wooaddons-for-elementor' ); ?>   
    </div>


    <?php
        }


}




