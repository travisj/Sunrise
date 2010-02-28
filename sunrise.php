<?php
$wpdb->dmtable = $wpdb->base_prefix . 'domain_mapping';
$wpdb->mapping_table = $wpdb->base_prefix . 'base_url_mapping';

$wpdb->suppress_errors();
$full_url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$base_urls = $wpdb->get_results( "SELECT blog_id, base_url FROM {$wpdb->mapping_table}" );

$domain_mapping_id = null;
foreach ($base_urls as $base_url) {
	if (false !== strpos($full_url, $base_url->base_url)) {
		$domain_mapping_id = $base_url->blog_id;
	}
}

$wpdb->suppress_errors( false );
if( $domain_mapping_id ) {
	$current_blog = $wpdb->get_row("SELECT * FROM {$wpdb->blogs} WHERE blog_id = '$domain_mapping_id' LIMIT 1");
	$current_blog->domain = $_SERVER[ 'HTTP_HOST' ];
	$current_blog->path = '/';
	$blog_id = $domain_mapping_id;
	$site_id = $current_blog->site_id;
	define( 'COOKIE_DOMAIN', $_SERVER[ 'HTTP_HOST' ] );

	$current_site = $wpdb->get_row( "SELECT * from {$wpdb->site} WHERE id = '{$current_blog->site_id}' LIMIT 0,1" );
	$current_site->blog_id = $wpdb->get_var( "SELECT blog_id FROM {$wpdb->blogs} WHERE domain='{$current_site->domain}' AND path='{$current_site->path}'" );
	define( 'DOMAIN_MAPPING', 1 );
}
