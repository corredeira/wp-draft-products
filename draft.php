<?php
require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
global $wpdb;

$product_ids = $wpdb->get_col( "
    SELECT ID
    FROM {$wpdb->prefix}posts p
    INNER JOIN  {$wpdb->prefix}postmeta pm ON p.ID = pm.post_id
    WHERE ID NOT IN (SELECT post_id FROM {$wpdb->prefix}postmeta WHERE meta_key = '_thumbnail_id')
    AND p.post_type = 'product'
    AND p.post_status = 'publish'
    AND pm.meta_key = '_stock_status'
    AND pm.meta_value = 'instock'
");

//echo "<pre>"; print_r($product_ids); echo "</pre>";
    if ($product_ids > 0 ){
        foreach($product_ids as $post => $post_id) {
            $my_post = array(
                'ID'           => $post_id,
                'post_status'   =>  'draft'
                
            );
            //echo "<pre>"; print_r($my_post); echo "</pre>";
            
            $new = wp_update_post($my_post);
            echo $new;
          }
        
    }
?>
