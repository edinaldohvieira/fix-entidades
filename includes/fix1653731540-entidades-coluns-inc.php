<?php
/*
fix1653731540-entidades-coluns-inc.php
*/

if ( ! defined( 'ABSPATH' ) ) { exit; }

add_filter( 'manage_entidades_posts_columns', 'fix1653736150' );
function fix1653736150( $columns ) {
	/* ref o original padrão
	  [cb]          => <input type="checkbox" />
	  [title]       => Title
	  [author]      => Author
	  [categories]  => Categories
	  [tags]        => Tags
	  [comments]    => [..] Comments [..]
	  [date]        => Date

	*/
  	// $columns['image'] = __( 'Image' );
  	// $columns['price'] = __( 'Price', 'smashing' );
  	// $columns['area'] = __( 'Area', 'smashing' );
  	// return $columns;

	$columns = array(
		'cb' => $columns['cb'],
		// 'image' => __( 'Image' ),
		'title' => __( 'Key' ),
		'fix1653735805_usuario_id' => 'User ID',
		'fix1653735805_nome' => __( 'Nome' ),
		'fix1653735805_cpf_cnpj' => __( 'CPF/CNPJ' ),
	);
	return $columns;

}


add_action( 'manage_entidades_posts_custom_column', 'fix1653736175', 10, 2);
function fix1653736175( $column, $post_id ) {
	// Image column
	// if ( 'image' === $column ) {
	// 	echo get_the_post_thumbnail( $post_id, array(80, 80) );
	// }

	if ( 'fix1653735805_usuario_id' === $column ) {
		$fix1653735805_usuario_id = get_post_meta( $post_id, 'fix1653735805_usuario_id', true );
		echo $fix1653735805_usuario_id;
	}


	if ( 'fix1653735805_nome' === $column ) {
		$fix1653735805_nome = get_post_meta( $post_id, 'fix1653735805_nome', true );
		echo $fix1653735805_nome;
	}

	if ( 'fix1653735805_cpf_cnpj' === $column ) {
		$fix1653735805_cpf_cnpj = get_post_meta( $post_id, 'fix1653735805_cpf_cnpj', true );
		echo $fix1653735805_cpf_cnpj;
	}

	// if ( 'price' === $column ) {
	// 	$price = get_post_meta( $post_id, 'price_per_month', true );
	// 	if ( ! $price ) {
	// 		_e( 'n/a' );
	// 	} else {
	// 		echo '$ ' . number_format( $price, 0, '.', ',' ) . ' p/m';
	// 	}
	// }


	// if ( 'area' === $column ) {
	// 	$area = get_post_meta( $post_id, 'area', true );
	// 	if ( ! $area ) {
	// 		_e( 'n/a' );
	// 	} else {
	// 		echo number_format( $area, 0, '.', ',' ) . ' m2';
	// 	}
	// }

}


add_filter( 'manage_edit-entidades_sortable_columns', 'fix1653736192');
function fix1653736192( $columns ) {
  $columns['fix1653735805_nome'] = 'fix1653735805_nome';
  $columns['fix1653735805_cpf_cnpj'] = 'fix1653735805_cpf_cnpj';
  // $columns['fix164833_valor'] = 'fix164833_valor';
  // $columns['price'] = 'price_per_month';
  return $columns;
}


add_action( 'pre_get_posts', 'fix1653736220' );
function fix1653736220( $query ) {
	if( ! is_admin() || ! $query->is_main_query() ) {
		return;
	}

	if ( 'fix1653735805_nome' === $query->get( 'orderby') ) {
		$query->set( 'orderby', 'meta_value' );
		$query->set( 'meta_key', 'fix1653735805_nome' );
		$query->set( 'meta_type', 'CHAR' );
	}
	// if ( 'fix164833_vencimento' === $query->get( 'orderby') ) {
	// 	$query->set( 'orderby', 'meta_value' );
	// 	$query->set( 'meta_key', 'fix164833_vencimento' );
	// 	$query->set( 'meta_type', 'DATE' );
	// }
	// if ( 'fix164833_valor' === $query->get( 'orderby') ) {
	// 	$query->set( 'orderby', 'meta_value' );
	// 	$query->set( 'meta_key', 'fix164833_valor' );
	// 	$query->set( 'meta_type', 'NUMERIC' );
	// }
	// if ( 'price_per_month' === $query->get( 'orderby') ) {
	// 	$query->set( 'orderby', 'meta_value' );
	// 	$query->set( 'meta_key', 'price_per_month' );
	// 	$query->set( 'meta_type', 'numeric' );
	// }
}
/*
See:
https://developer.wordpress.org/reference/classes/wp_meta_query/
type (string) – Custom field type. Possible values are 
NUMERIC 
BINARY 
CHAR 
DATE, 
DATETIME 
DECIMAL 
SIGNED 
TIME 
UNSIGNED
Default value is ‘CHAR’.

*/