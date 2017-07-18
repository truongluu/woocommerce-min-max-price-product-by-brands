<?php
 
 // select product with min sale percents with product_ids

SELECT posts.post_parent, FLOOR(100 -((MIN( CAST(meta1.meta_value AS UNSIGNED )))*100/meta.meta_value)) AS percent
FROM wp_posts AS posts
INNER JOIN wp_postmeta AS meta
ON posts.ID = meta.post_id
INNER JOIN wp_postmeta AS meta1
ON posts.ID = meta1.post_id
WHERE posts.post_parent IN( $product_ids ) AND posts.post_type = 'product_variation' AND meta.meta_key LIKE '%regular_price' AND meta1.meta_key LIKE '%sale_price' AND meta1.meta_value <> ''
GROUP BY posts.post_parent