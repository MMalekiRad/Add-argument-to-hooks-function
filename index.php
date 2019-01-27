<?php

class post_types {
	public static function make_product_post_type() {
		eval( self::get_methods_body( 'post_types', 'post_type_maker',
			array(
				'Books',
				'Book'
			) ) );
	}

	public static function get_methods_body( $class, $function, $args ) {
		try {
			$func = new ReflectionMethod( $class, $function );
		} catch
		( ReflectionException $e ) {
		}
		$filename   = $func->getFileName();
		$start_line = $func->getStartLine();
		$end_line   = $func->getEndLine() - 1;
		$length     = $end_line - $start_line;
		$source     = file( $filename );
		$body       = implode( "", array_slice( $source, $start_line, $length ) );
		$body       = '$args = array(' . '"' . implode( '","', $args ) . '"' . ')' . ';' . $body;

		return $body;
	}

	private static function post_type_maker( $args ) {

		$post_type_name_to_show        = $args[0];
		$post_type_name_to_database_en = $args[1];
		$labels                        = array(
			'name'               => _x( $post_type_name_to_show . 's', 'post type general name', 'your-plugin-textdomain' ),
			'singular_name'      => _x( $post_type_name_to_show, 'post type singular name', 'your-plugin-textdomain' ),
			'menu_name'          => _x( $post_type_name_to_show . 's', 'admin menu', 'your-plugin-textdomain' ),
			'name_admin_bar'     => _x( $post_type_name_to_show, 'add new on admin bar', 'your-plugin-textdomain' ),
			'add_new'            => _x( 'Add New', $post_type_name_to_show, 'your-plugin-textdomain' ),
			'add_new_item'       => __( 'Add New ' . $post_type_name_to_show, 'your-plugin-textdomain' ),
			'new_item'           => __( 'New ' . $post_type_name_to_show, 'your-plugin-textdomain' ),
			'edit_item'          => __( 'Edit ' . $post_type_name_to_show, 'your-plugin-textdomain' ),
			'view_item'          => __( 'View ' . $post_type_name_to_show, 'your-plugin-textdomain' ),
			'all_items'          => __( 'All ' . $post_type_name_to_show . 's', 'your-plugin-textdomain' ),
			'search_items'       => __( 'Search ' . $post_type_name_to_show . 's', 'your-plugin-textdomain' ),
			'parent_item_colon'  => __( 'Parent ' . $post_type_name_to_show . 's:', 'your-plugin-textdomain' ),
			'not_found'          => __( 'No ' . $post_type_name_to_show . 's found.', 'your-plugin-textdomain' ),
			'not_found_in_trash' => __( 'No ' . $post_type_name_to_show . 's found in Trash.', 'your-plugin-textdomain' )
		);

		$args = array(
			'labels'             => $labels,
			'description'        => __( 'Description.', 'your-plugin-textdomain' ),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => $post_type_name_to_database_en ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
		);

		register_post_type( $post_type_name_to_database_en, $args );
	}
}

add_action('init', "post_types::make_product_post_type");