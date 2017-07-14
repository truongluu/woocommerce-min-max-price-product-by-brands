<?php
  $start = microtime( false );
  $args = array(
      'taxonomy' => 'product_brand',
      'orderby'    => 'title',
      'order'      => 'ASC',
      'hide_empty' => false
  );
  $brands = get_terms( $args );
  $brandsArr = [];
  foreach( $brands as $brand ) {
    $brandsArr[$brand->term_id]['name'] =  $brand->name;
    $brandsArr[$brand->term_id]['count'] =  $brand->count;
  }

  $productPriceByBrandQuery =<<<QUERYSTRING
    SELECT taxes.`term_id`, MAX( CAST(postmeta.meta_value AS UNSIGNED )) AS max,  MIN( CAST(postmeta.meta_value AS UNSIGNED )) AS min
    FROM `wp_term_relationships` AS relations
    INNER JOIN `wp_term_taxonomy` AS taxes
    ON relations.`term_taxonomy_id` = taxes.`term_taxonomy_id`
    INNER JOIN wp_postmeta AS postmeta
    ON relations.`object_id` = postmeta.post_id

    WHERE taxes.`taxonomy` = 'product_brand' AND postmeta.meta_key LIKE '%price' AND postmeta.meta_value != ''

    GROUP BY taxes.`term_id`
QUERYSTRING;

  global $wpdb;
  $priceByBrand = $wpdb->get_results( $productPriceByBrandQuery );
  $end = microtime(false ) - $start;
  $dataRow = '';
  foreach( $priceByBrand as $brandPrice ) {
    $dataRow .=<<<ROW
      <tr>
         <td>{$brandsArr[$brandPrice->term_id]['name']}</td>
        <td>{$brandsArr[$brandPrice->term_id]['count']}</td>
        <td>{$brandPrice->max}</td>
        <td>{$brandPrice->min}</td>
      </tr>
ROW;
    
  }
?>
</div>
<table style="width: 550px; margin: 0 auto;">
  <thead>
    <tr>
      <th>Name</th>
      <th>Count</th>
      <th>Max Price</th>
      <th>Min Price</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <?php echo $dataRow;?>
    </tr>
  </tbody>
</table>