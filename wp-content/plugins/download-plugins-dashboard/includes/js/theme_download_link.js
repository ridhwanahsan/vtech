/**
 * theme_download_link
 *
 * @version 1.8.8
 * @since   1.1.0
 *
 * @author  WPFactory
 */

jQuery( document ).ready( function () {
	jQuery( 'div.theme-actions' ).each( function () {
		let theme_name = jQuery( this ).parents( 'div.theme' ).attr( 'data-slug' );
		let url = new URL( alg_object.themes_url );
		let params = new URLSearchParams( url.search );
		params.set( 'alg_download_theme', theme_name );
		params.set( alg_object.nonce.param, alg_object.nonce.value );
		url.search = params.toString();
		jQuery( this ).append( '<a class="button alg_download_theme" href="' + url.toString() + '">' + alg_localize_object.download_link_text + '</a>' );
	} );
} );
