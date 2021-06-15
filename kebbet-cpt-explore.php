<?php
/**
 * Plugin Name: Kebbet plugins - Custom Post Type: explore
 * Plugin URI: https://github.com/kebbet/kebbet-cpt-explore
 * Description: Registers a Custom Post Type.
 * Version: 20210519.02
 * Author: Erik Betshammar
 * Author URI: https://verkan.se
 *
 * @package kebbet-cpt-explore
 */

namespace kebbet\cpt\explore;

const POSTTYPE = 'explore';
const SLUG     = 'explore';
const ICON     = 'rest-api';
const MENUPOS  = 8;

/**
 * Link to ICONS
 *
 * @link https://developer.wordpress.org/resource/dashicons/
 */

/**
 * Hook into the 'init' action
 */
function init() {
	load_textdomain();
	register();
}
add_action( 'init', __NAMESPACE__ . '\init', 0 );

/**
 * Flush rewrite rules on registration.
 *
 * @link https://codex.wordpress.org/Function_Reference/register_post_type
 */
function rewrite_flush() {
	// First, we "add" the custom post type via the above written function.
	// Note: "add" is written with quotes, as CPTs don't get added to the DB,
	// They are only referenced in the post_type column with a post entry,
	// when you add a post of this CPT.
	register();

	// ATTENTION: This is *only* done during plugin activation hook in this example!
	// You should *NEVER EVER* do this on every page load!!
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, __NAMESPACE__ . '\rewrite_flush' );

/**
 * Load plugin textdomain.
 */
function load_textdomain() {
	load_plugin_textdomain( 'kebbet-cpt-explore', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}

/**
 * Register Custom Post Type
 */
function register() {

	$labels_args       = array(
		'name'                     => _x( 'Explore', 'Post Type General Name', 'kebbet-cpt-explore' ),
		'singular_name'            => _x( 'Explore', 'Post Type Singular Name', 'kebbet-cpt-explore' ),
		'menu_name'                => __( 'Explore', 'kebbet-cpt-explore' ),
		'name_admin_bar'           => __( 'Explore post', 'kebbet-cpt-explore' ),
		'parent_item_colon'        => __( 'Parent post:', 'kebbet-cpt-explore' ),
		'all_items'                => __( 'All posts', 'kebbet-cpt-explore' ),
		'add_new_item'             => __( 'Add new', 'kebbet-cpt-explore' ),
		'add_new'                  => __( 'Add new post', 'kebbet-cpt-explore' ),
		'new_item'                 => __( 'New post', 'kebbet-cpt-explore' ),
		'edit_item'                => __( 'Edit post', 'kebbet-cpt-explore' ),
		'update_item'              => __( 'Update post', 'kebbet-cpt-explore' ),
		'view_item'                => __( 'View post', 'kebbet-cpt-explore' ),
		'view_items'               => __( 'View posts', 'kebbet-cpt-explore' ),
		'search_items'             => __( 'Search posts', 'kebbet-cpt-explore' ),
		'not_found'                => __( 'Not found', 'kebbet-cpt-explore' ),
		'not_found_in_trash'       => __( 'No posts found in Trash', 'kebbet-cpt-explore' ),
		'featured_image'           => __( 'Featured image', 'kebbet-cpt-explore' ),
		'set_featured_image'       => __( 'Set featured image', 'kebbet-cpt-explore' ),
		'remove_featured_image'    => __( 'Remove featured image', 'kebbet-cpt-explore' ),
		'use_featured_image'       => __( 'Use as featured image', 'kebbet-cpt-explore' ),
		'insert_into_item'         => __( 'Insert into item', 'kebbet-cpt-explore' ),
		'uploaded_to_this_item'    => __( 'Uploaded to this post', 'kebbet-cpt-explore' ),
		'items_list'               => __( 'Items list', 'kebbet-cpt-explore' ),
		'items_list_navigation'    => __( 'Items list navigation', 'kebbet-cpt-explore' ),
		'filter_items_list'        => __( 'Filter items list', 'kebbet-cpt-explore' ),
		'archives'                 => __( 'Explore posts archive', 'kebbet-cpt-explore' ),
		'attributes'               => __( 'Explore post attributes', 'kebbet-cpt-explore' ),
		'item_published'           => __( 'Post published', 'kebbet-cpt-explore' ),
		'item_published_privately' => __( 'Post published privately', 'kebbet-cpt-explore' ),
		'item_reverted_to_draft'   => __( 'Post reverted to Draft', 'kebbet-cpt-explore' ),
		'item_scheduled'           => __( 'Post scheduled', 'kebbet-cpt-explore' ),
		'item_updated'             => __( 'Post updated', 'kebbet-cpt-explore' ),
	);
	$supports_args     = array(
		'author',
		'title',
		'editor',
		'thumbnail',
		'page-attributes',
	);
	$rewrite_args      = array(
		'slug'       => SLUG,
		'with_front' => false,
		'pages'      => false,
		'feeds'      => true,
	);
	$capabilities_args = array(
		'edit_post'          => 'edit_' . POSTTYPE,
		'edit_posts'         => 'edit_' . POSTTYPE .'s',
		'edit_others_posts'  => 'edit_others_' . POSTTYPE .'s',
		'publish_posts'      => 'publish_' . POSTTYPE .'s',
		'read_post'          => 'read_' . POSTTYPE .'s',
		'read_private_posts' => 'read_private_' . POSTTYPE .'s',
		'delete_post'        => 'delete_' . POSTTYPE,
	);
	$post_type_args    = array(
		'label'               => __( 'Explore post type', 'kebbet-cpt-explore' ),
		'description'         => __( 'Custom post type for explore posts', 'kebbet-cpt-explore' ),
		'labels'              => $labels_args,
		'supports'            => $supports_args,
		'taxonomies'          => array(),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => MENUPOS,
		'menu_icon'           => 'dashicons-' . ICON,
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => SLUG,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'rewrite'             => $rewrite_args,
		'capabilities'        => $capabilities_args,
		// Adding map_meta_cap will map the meta correctly.
		'show_in_rest'        => true,
		'map_meta_cap'        => true,
	);
	register_post_type( POSTTYPE, $post_type_args );
}

/**
 * Adds custom capabilities to CPT. Adjust it with plugin URE later with its UI.
 */
function add_custom_capabilities() {

	// Gets the editor and administrator roles.
	$admins = get_role( 'administrator' );
	$editor = get_role( 'editor' );

	// Add custom capabilities.
	$admins->add_cap( 'edit_' . POSTTYPE );
	$admins->add_cap( 'edit_' . POSTTYPE .'s' );
	$admins->add_cap( 'edit_others_' . POSTTYPE .'s' );
	$admins->add_cap( 'publish_' . POSTTYPE .'s' );
	$admins->add_cap( 'read_' . POSTTYPE .'s' );
	$admins->add_cap( 'read_private_' . POSTTYPE .'s' );
	$admins->add_cap( 'delete_' . POSTTYPE );

	$editor->add_cap( 'edit_' . POSTTYPE );
	$editor->add_cap( 'edit_' . POSTTYPE .'s' );
	$editor->add_cap( 'edit_others_' . POSTTYPE .'s' );
	$editor->add_cap( 'publish_' . POSTTYPE .'s' );
	$editor->add_cap( 'read_' . POSTTYPE .'s' );
	$editor->add_cap( 'read_private_' . POSTTYPE .'s' );
	$editor->add_cap( 'delete_' . POSTTYPE );
}
add_action( 'admin_init', __NAMESPACE__ . '\add_custom_capabilities');

/**
 * Post type update messages.
 *
 * See /wp-admin/edit-form-advanced.php
 *
 * @param array $messages Existing post update messages.
 *
 * @return array Amended post update messages with new CPT update messages.
 */
function post_updated_messages( $messages ) {

	$post             = get_post();
	$post_type        = get_post_type( $post );
	$post_type_object = get_post_type_object( $post_type );

	$messages[ POSTTYPE ] = array(
		0  => '',
		1  => __( 'Post updated.', 'kebbet-cpt-explore' ),
		2  => __( 'Custom field updated.', 'kebbet-cpt-explore' ),
		3  => __( 'Custom field deleted.', 'kebbet-cpt-explore' ),
		4  => __( 'Post updated.', 'kebbet-cpt-explore' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Post restored to revision from %s', 'kebbet-cpt-explore' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6  => __( 'Post published.', 'kebbet-cpt-explore' ),
		7  => __( 'Post saved.', 'kebbet-cpt-explore' ),
		8  => __( 'Post submitted.', 'kebbet-cpt-explore' ),
		9  => sprintf(
			/* translators: %1$s: date and time of the scheduled post */
			__( 'Post scheduled for: <strong>%1$s</strong>.', 'kebbet-cpt-explore' ),
			date_i18n( __( 'M j, Y @ G:i', 'kebbet-cpt-explore' ), strtotime( $post->post_date ) )
		),
		10 => __( 'Post draft updated.', 'kebbet-cpt-explore' ),
	);
	if ( $post_type_object->publicly_queryable && POSTTYPE === $post_type ) {

		$permalink         = get_permalink( $post->ID );
		$view_link         = sprintf(
			' <a href="%s">%s</a>',
			esc_url( $permalink ),
			__( 'View Post', 'kebbet-cpt-explore' )
		);
		$preview_permalink = add_query_arg( 'preview', 'true', $permalink );
		$preview_link      = sprintf(
			' <a target="_blank" href="%s">%s</a>',
			esc_url( $preview_permalink ),
			__( 'Preview Post', 'kebbet-cpt-explore' )
		);

		$messages[ $post_type ][1]  .= $view_link;
		$messages[ $post_type ][6]  .= $view_link;
		$messages[ $post_type ][9]  .= $view_link;
		$messages[ $post_type ][8]  .= $preview_link;
		$messages[ $post_type ][10] .= $preview_link;

	}

	return $messages;

}
add_filter( 'post_updated_messages', __NAMESPACE__ . '\post_updated_messages' );

/**
 * Custom bulk post updates messages
 *
 * @param array  $bulk_messages The messages for bulk updating posts.
 * @param string $bulk_counts Number of updated posts.
 */
function bulk_post_updated_messages( $bulk_messages, $bulk_counts ) {

	$bulk_messages[ POSTTYPE ] = array(
		/* translators: %$1s: singular of posts, %$2s: plural of posts.  */
		'updated'   => _n( '%$1s post updated.', '%$2s posts updated.', $bulk_counts['updated'], 'kebbet-cpt-explore' ),
		/* translators: %$1s: singular of posts, %$2s: plural of posts.  */
		'locked'    => _n( '%$1s post not updated, somebody is editing it.', '%$2s posts not updated, somebody is editing them.', $bulk_counts['locked'], 'kebbet-cpt-explore' ),
		/* translators: %$1s: singular of posts, %$2s: plural of posts.  */
		'deleted'   => _n( '%$1s post permanently deleted.', '%$2s posts permanently deleted.', $bulk_counts['deleted'], 'kebbet-cpt-explore' ),
		/* translators: %$1s: singular of posts, %$2s: plural of posts.  */
		'trashed'   => _n( '%$1s post moved to the Trash.', '%$2s posts moved to the Trash.', $bulk_counts['trashed'], 'kebbet-cpt-explore' ),
		/* translators: %$1s: singular of posts, %$2s: plural of posts.  */
		'untrashed' => _n( '%$1s post restored from the Trash.', '%$2s posts restored from the Trash.', $bulk_counts['untrashed'], 'kebbet-cpt-explore' ),
	);

	return $bulk_messages;

}
add_filter( 'bulk_post_updated_messages', __NAMESPACE__ . '\bulk_post_updated_messages', 10, 2 );

/**
 * Add the content to the `At a glance`-widget.
 */
require_once plugin_dir_path( __FILE__ ) . 'inc/at-a-glance.php';

/**
 * Adds and modifies the admin columns for the post type.
 */
require_once plugin_dir_path( __FILE__ ) . 'inc/admin-columns.php';