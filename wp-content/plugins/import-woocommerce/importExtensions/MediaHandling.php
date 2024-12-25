<?php
/**
 * Import Woocommerce plugin file.
 *
 * Copyright (C) 2010-2020, Smackcoders Inc - info@smackcoders.com
 */

 namespace Smackcoders\SMWC;

if ( ! defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly

class MediaHandling{
	private static $instance=null,$smack_instance;
	public $header_array,$core_instance;
	public $value_array;

	public function __construct(){
		
		include_once(ABSPATH . 'wp-admin/includes/image.php');		
		add_action('wp_ajax_image_options', array($this , 'imageOptions'));
		add_action('wp_ajax_delete_image' , array($this , 'deleteImage'));
	}

	public static function imageOptions(){	
		check_ajax_referer('smack-ultimate-csv-importer', 'securekey');
		$media_settings['media_handle_option'] = sanitize_text_field($_POST['media_handle_option']);
		$media_settings['use_ExistingImage'] = sanitize_text_field($_POST['use_ExistingImage']);
		$media_settings['enable_postcontent_image'] = sanitize_text_field($_POST['postContent_image_option']);
		$image_info = array(
			'media_settings'  => $media_settings
		);
		update_option( 'smack_image_options', $image_info );
		$result['success'] = 'true';
		echo wp_json_encode($result);
		wp_die();
	}
	public static function getInstance() {
		if (MediaHandling::$instance == null) {
			MediaHandling::$instance = new MediaHandling;
			return MediaHandling::$instance;
		}
		return MediaHandling::$instance;
	}

	public function deleteImage(){
		check_ajax_referer('smack-ultimate-csv-importer', 'securekey');
		$image = sanitize_text_field($_POST['image']);
		$media_dir = wp_get_upload_dir();
		$names = glob($media_dir['path'].'/'.'*.*');
		foreach($names as $values){
			if (strpos($values, $image) !== false) {
				unlink($values);
			}
		}   
		$result['success'] = 'true';
		echo wp_json_encode($result);
		wp_die();     
	}
	public function media_handling($img_url , $post_id , $data_array = null,$module = null, $image_type = null ,$hash_key = null,$templatekey = null,$header_array=null,$value_array=null,$indexs=null,$acf_wpname_element=null,$acf_image_meta=null){
		$encodedurl = urlencode($img_url);
		$img_url = urldecode($encodedurl);
		$url = parse_url($img_url);
		if($hash_key == null)
			$hash_key = "";
		$media_handle = get_option('smack_image_options');	
		if(isset($url['scheme']) && $url['scheme'] == 'http' || $url['scheme'] == 'https' ){		
			$image_name = basename($img_url);
			$image_title = sanitize_file_name( pathinfo( $image_name, PATHINFO_FILENAME ) );
		}else{
			$image_title=preg_replace('/\\.[^.\\s]{3,4}$/', '', $img_url);
		}
		global $wpdb;
		if($media_handle['media_settings']['use_ExistingImage'] == 'true'){
			if(is_numeric($img_url)){
				$attach_id=$img_url;
				if(!empty($data_array['featured_image'])) {
					set_post_thumbnail( $post_id, $attach_id );
				}
				return $attach_id;
			}
			else{
				$attachment_id = $wpdb->get_results("SELECT ID FROM {$wpdb->prefix}posts WHERE post_type = 'attachment' AND guid LIKE '%$image_title%'", ARRAY_A);

			}
			if(is_array($attachment_id) && !empty($attachment_id[0]['ID']) && $image_type != 'Featured'){
					$table_name = $wpdb->prefix . 'smackcsv_file_events';
					$post_title = $wpdb->get_var("SELECT post_title FROM {$wpdb->prefix}posts WHERE ID = '{$post_id}' AND post_status != 'trash'");
					$file_name = $wpdb->get_var("SELECT file_name FROM $table_name WHERE hash_key = '$hash_key'");
					$shortcode_table = $wpdb->prefix . "ultimate_csv_importer_shortcode_manager";                                                                   
					$attach_id = $attachment_id[0]['ID'];
					$check_id = $wpdb->get_results("SELECT ID FROM {$wpdb->prefix}posts WHERE ID ='{$attach_id}' AND post_title ='image-failed' AND post_type = 'attachment' AND guid LIKE '%$image_title%'", ARRAY_A);
					if(!empty($check_id)){
						$failed_ids = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}ultimate_csv_importer_shortcode_manager WHERE post_id='{$post_id}' AND media_id = '{$attach_id}'");
						if(!empty($failed_ids) && $failed_ids[0]->post_id != $post_id){
							$attach_id = $check_id[0]['ID'];;
							$insert_status = $wpdb->insert($shortcode_table,
							array(
								'post_id' => $post_id,
								'post_title' => $post_title,
								'image_shortcode' => $image_type.'_image__'.$acf_wpname_element,
								'media_id' => $attach_id,
								'original_image' => $img_url,
								'indexs' => $indexs,
								'image_meta' => $acf_image_meta,
								'hash_key' => $hash_key,
								'import_type' => $module,
								'file_name' => $file_name
							),
							array('%d','%s','%s','%d','%s','%d','%s','%s','%s','%s')
							);
							if($insert_status){
								$this->store_failed_image_ids($attach_id);
							}
							 
						}elseif(($failed_ids[0]->post_id == $post_id) && ($check_id[0]['ID'] == $failed_ids[0]->media_id)){
							$attach_id = $check_id[0]['ID'];
							$insert_status = $wpdb->insert($shortcode_table,
							array(
								'post_id' => $post_id,
								'post_title' => $post_title,
								'image_shortcode' => $image_type.'_image__'.$acf_wpname_element,
								'media_id' => $attach_id,
								'original_image' => $img_url,
								'indexs' => $indexs,
								'image_meta' => $acf_image_meta,
								'hash_key' => $hash_key,
								'import_type' => $module,
								'file_name' => $file_name
							),
							array('%d','%s','%s','%d','%s','%d','%s','%s','%s','%s')
							);
							if($insert_status){
								$this->store_failed_image_ids($attach_id);
							}
						}
						elseif(empty($failed_ids) ){
							$insert_status = $wpdb->insert($shortcode_table,
							array(
								'post_id' => $post_id,
								'post_title' => $post_title,
								'image_shortcode' => $image_type.'_image__'.$acf_wpname_element,
								'media_id' => $attach_id,
								'original_image' => $img_url,
								'indexs'=>$indexs,
								'hash_key' => $hash_key,
								'import_type' => $module,
								'file_name' => $file_name,
							),
							array('%d','%s','%s','%d','%s','%d','%s','%s','%s')
							);
							if($insert_status){
								$this->store_failed_image_ids($attach_id);
							}
						}
						
						//return $attach_id;
					}				   
			}
			else{
				$attach_id = $this->image_function($img_url , $post_id , $data_array,'','use_existing_image',$header_array,$value_array);
			}

		}
		else{
			$img_url = is_array($img_url) ? implode(',', array_filter($img_url)) : $img_url;
			$hash_key = is_array($hash_key) ? implode(',', array_filter($hash_key)) : $hash_key;
			$templatekey = is_array($templatekey) ? implode(',', array_filter($templatekey)) : $templatekey;
			$module = is_array($module) ? implode(',', array_filter($module)) : $module;
			$image_type = is_array($image_type) ? implode(',', array_filter($image_type)) : $image_type;
			$img_url = esc_sql($img_url);
			$hash_key = esc_sql($hash_key);
			$templatekey = esc_sql($templatekey);
			$module = esc_sql($module);
			$image_type = esc_sql($image_type);
			
			$attach_id = $this->image_function($img_url, $post_id, $data_array,'','',$header_array,$value_array);
			// if ($attach_id != null) {
			// 	global $wpdb;
			// 	$image_table = $wpdb->prefix . "ultimate_csv_importer_media";
			// 	$wpdb->query($wpdb->prepare("INSERT INTO $image_table (image_url, attach_id, post_id, hash_key, templatekey, module, image_type, status) VALUES (%s, %d, %d, %s, %s, %s, %s, 'Completed')",$img_url,$attach_id,$post_id,$hash_key,$templatekey,$module,$image_type));
			// }

		}
		return $attach_id;
	}

	public function image_function($f_img , $post_id , $data_array = null,$option_name = null, $use_existing_image = false,$header_array = null , $value_array = null){
	
		global $wpdb;
		$f_img = urldecode($f_img);
		// $image = explode("?", $f_img);
		// $f_img=$image[0];
		$media_handle = get_option('smack_image_options');
		if(!empty($header_array) && !empty($value_array) ){
			$media_settings = array_combine($header_array,$value_array);
		}

		if(preg_match_all('/\b(?:(?:https?|http|ftp|file):\/\/|www\.|ftp\.)[-A-Z0-9+&@#\/%=~_|$?!:,.]*[A-Z0-9+&@#\/%=~_|$]/i', $f_img , $matchedlist, PREG_PATTERN_ORDER)) {
			$f_img = $f_img;
		}   
		else{
			$media_dir = wp_get_upload_dir();
			$names = glob($media_dir['path'].'/'.'*.*');
			foreach($names as $values){
				if (strpos($values, $f_img) !== false) {
					$f_img = $media_dir['url'].'/'.$f_img;
				}
			}            
		}

		$image_name = pathinfo($f_img);
		//if(!empty($media_handle['media_settings']['file_name'])){	
			//$file_type = wp_check_filetype( $f_img, null );
			//$ext = '.'. $file_type['ext'];
			// if(!empty($media_settings[$media_handle['media_settings']['file_name']])){
			// 	$fimg_name = $media_settings[$media_handle['media_settings']['file_name']].$ext;
			// }
		//}		
		//else{
			$fimg_name = $image_name['basename'];
		//}
		$file_type = wp_check_filetype( $fimg_name, null );
		if($use_existing_image){
			if(empty($file_type['ext'])){
				$fimg_name = @basename($f_img);
				$fimg_name = str_replace(' ', '-', trim($fimg_name));
				$fimg_name = preg_replace('/[^a-zA-Z0-9._\-\s]/', '', $fimg_name);
			}
			$attachment_id = $wpdb->get_var("SELECT ID FROM ".$wpdb->prefix."posts WHERE post_type = 'attachment' AND guid LIKE '%$fimg_name'");

			if($attachment_id){
				if(!empty($data_array['featured_image'])){
					set_post_thumbnail( $post_id, $attachment_id );
					return $attachment_id;
				}else{
					return $attachment_id;
				}
			}
		}

		$attachment_title = sanitize_file_name( pathinfo( $fimg_name, PATHINFO_FILENAME ) );
		$file_type = wp_check_filetype( $fimg_name, null ); 
		$dir = wp_upload_dir();
		$dirname = date('Y') . '/' . date('m');
		$uploads_use_yearmonth = get_option('uploads_use_yearmonth_folders');
        if($uploads_use_yearmonth == 1){
            $uploaddir_paths = $dir ['basedir'] . '/' . $dirname ;
            $uploaddir_url = $dir ['baseurl'] . '/' . $dirname;
        }
        else{
            $uploaddir_paths = $dir ['basedir'];
            $uploaddir_url = $dir ['baseurl'];
        }
		$f_img = str_replace(" ","%20",$f_img);
		if(empty($file_type['ext'])){
			$fimg_name = @basename($f_img);
			$fimg_name = str_replace(' ', '-', trim($fimg_name));
			$fimg_name = preg_replace('/[^a-zA-Z0-9._\-\s]/', '', $fimg_name);
		}
		if ($uploaddir_paths != "" && $uploaddir_paths) {
			if (strpos($fimg_name, ' ') !== false) {
				$fimg_name = str_replace(' ', '-', $fimg_name);
				$fimg_name = preg_replace('/[^a-zA-Z0-9._\-\s]/', '', $fimg_name);
			}
			$uploaddir_path = $uploaddir_paths . "/" . $fimg_name;
		}
	
			if($file_type['ext'] == 'jpeg'){
				$response = wp_safe_remote_get($f_img, array( 'timeout' => 30));		
			}else{
				$response = wp_safe_remote_get($f_img, array( 'timeout' => 10));		
			}	
			if(is_wp_error($response))	{
				return null;
			}
			$rawdata =  wp_remote_retrieve_body($response);
		
		$http_code = wp_remote_retrieve_response_code($response);
		if($http_code == 404){
			return null;
		}

		if ( $http_code != 200 && strpos( $rawdata, 'Not Found' ) != 0 ) {
			return null;
		}
		if(is_plugin_active('exmage-wp-image-links/exmage-wp-image-links.php')){
			$guid =$fimg_name;
		}
		if ($rawdata == false) {
			return null;
		} else {		
			if(is_plugin_active('exmage-wp-image-links/exmage-wp-image-links.php')){
				$link = new \EXMAGE_WP_IMAGE_LINKS;
				$postID = $link->add_image($data_array['featured_image'],$value);
				wp_update_post(array(
					'ID'           => $postID['id'],
					'post_title'   => $data_array['title'],
					'post_content' => $data_array['description'],
					'post_excerpt' => $data_array['caption']
				));
               // if($postID['id'] != null && isset($data_array['alt_text'])){  
					//update_post_meta($postID['id'], '_wp_attachment_image_alt', $data_array['alt_text']);
				//}
			}
			else{
				if (file_exists($uploaddir_path)) {
					$i = 1;
					$exist = true;
					while($exist){
						$fimg_name = $attachment_title . "-" . $i . "." . $file_type['ext'];        
						$uploaddir_path = $uploaddir_paths . "/" . $fimg_name;

						if (file_exists($uploaddir_path)) {
							$i = $i + 1;
						}
						else{
							$exist = false;
						}
					}
				}
				$fp = fopen($uploaddir_path, 'x');
				fwrite($fp, $rawdata);
				fclose($fp);
			}
		}
		if(empty($file_type['type'])){
			$file_type['type'] = 'image/jpeg';
		}
		if(is_plugin_active('exmage-wp-image-links/exmage-wp-image-links.php')){
			$guids =$data_array['featured_image'];
		}
		else{
			$guids=$uploaddir_url . "/" .  $fimg_name;
		}
		if(!empty($data_array['title'])){
			$attachment_title = $data_array['title'];
		}else{
			$attachment_title = str_replace('-', ' ', $attachment_title);
		}
		$post_info = array(
			'guid'           => $guids,
			'post_mime_type' => $file_type['type'],
			'post_title'     => $attachment_title,
			'post_content'   => '',
			'post_status'    => 'inherit',
		);
		if(!is_plugin_active('exmage-wp-image-links/exmage-wp-image-links.php')){
			$attach_id = wp_insert_attachment( $post_info,$uploaddir_path, $post_id );
			$attach_data = wp_generate_attachment_metadata( $attach_id, $uploaddir_path );
			wp_update_attachment_metadata( $attach_id,  $attach_data );
		}

		if(!empty($data_array['featured_image'])) {
			set_post_thumbnail( $post_id, $attach_id );
		}
		return $attach_id;
	}

	public function get_filename_path($image_url){
			$image_name = pathinfo($image_url);
			$fimg_name = $image_name['basename'];
			$fimg_name_without_ext = $image_name['filename'];
			if(empty($fimg_name_without_ext)){
				$fimg_name_without_ext = $fimg_name;
			}
			$file_type = wp_check_filetype( $fimg_name, null );
			if(empty($file_type['ext'])){
				$fimg_name = @basename($image_url);
				$fimg_name = str_replace(' ', '-', trim($fimg_name));
				$fimg_name = preg_replace('/[^a-zA-Z0-9._\-\s]/', '', $fimg_name);
			}

			if (strstr($image_url, 'https://drive.google.com')){
				preg_match('/[?&]id=([^&]+)/', $image_url, $matches);
				$fimg_name = isset($matches[1]) ? $matches[1] : basename($image_url);	
			}
			$dir = wp_upload_dir();
			$dirname = date('Y') . '/' . date('m');
			$uploads_use_yearmonth = get_option('uploads_use_yearmonth_folders');
			if($uploads_use_yearmonth == 1){
				$uploaddir_paths = $dir ['basedir'] . '/' . $dirname ;
				$uploaddir_url = $dir ['baseurl'] . '/' . $dirname;
			}
			else{
				$uploaddir_paths = $dir ['basedir'];
				$uploaddir_url = $dir ['baseurl'];
			}
			if ($uploaddir_paths != "" && $uploaddir_paths) {
				$uploaddir_path = $uploaddir_paths . "/" . $fimg_name;
			}

			return ['uploaddir_path' => $uploaddir_path,'uploaddir_url' => $uploaddir_url,'fimg_name' => $fimg_name];	
	}
	public function image_meta_table_entry($line_number ,$post_values, $post_id ,$acf_wpname_element, $acf_csv_name, $hash_key, $plugin,$get_import_type,$templatekey = null,$gmode = null,$header_array = null, $value_array = null,$imgformat = null,$typecct = null,$indexs=null){
		global $wpdb;
		$table_name = $wpdb->prefix . 'smackcsv_file_events';
		$file_name = $wpdb->get_var("SELECT file_name FROM $table_name WHERE hash_key = '$hash_key'");
		$post_title = $wpdb->get_var("SELECT post_title FROM {$wpdb->prefix}posts WHERE ID = '{$post_id}' AND post_status != 'trash'");
		$failed_ids = $wpdb->get_results("SELECT post_title,post_id,image_shortcode,media_id,original_image FROM {$wpdb->prefix}ultimate_csv_importer_shortcode_manager WHERE image_shortcode ='Featured_image_' AND post_id = '{$post_id}' AND original_image = '{$acf_csv_name}' ");
		//$core_instance = CoreFieldsImport::getInstance();
		$core_instance = new WooCommerceCoreImport;
		$shortcode_table = $wpdb->prefix . "ultimate_csv_importer_shortcode_manager";
		
		$get_path_values = $this->get_filename_path($acf_csv_name);
		$uploaddir_path = isset($get_path_values['uploaddir_path']) ? $get_path_values['uploaddir_path'] : '';
		$uploaddir_url = isset($get_path_values['uploaddir_url']) ? $get_path_values['uploaddir_url'] : '';
		$fimg_name = isset($get_path_values['fimg_name']) ? $get_path_values['fimg_name'] : '';
		$file_type = 'image/jpeg';
		if(isset($post_id) && !empty($acf_csv_name) ){
				if(strpos($plugin, 'jetengine_') !== false ){
					$image_meta_value = array(
						'headerarray' => $header_array,
						'valuearray' => $value_array,
						'tablename' => $typecct,	
						'returnformat' => $imgformat						
					);
					$acf_image_meta  =json_encode($image_meta_value);
				}       
					$acf_image_meta = isset($acf_image_meta) ? $acf_image_meta : null;
					$attach_id = $this->media_handling($acf_csv_name, $post_id, $post_values,$get_import_type,$plugin,$hash_key,'',$header_array,$value_array,$indexs,$acf_wpname_element,$acf_image_meta);
					$failed_id = $wpdb->get_results("SELECT post_title,post_id,image_shortcode,media_id,original_image FROM {$wpdb->prefix}ultimate_csv_importer_shortcode_manager WHERE post_id = '{$post_id}' AND original_image = '{$acf_csv_name}' AND image_shortcode = '" . esc_sql($plugin.'_image__'.$acf_wpname_element) . "' ");  
					if(!empty($attach_id)){
						$this->store_image_ids($attach_id ); //store the image id
						return $attach_id;
					}
					elseif(empty($attach_id) || !empty($failed_id) || empty($failed_id)){
							if(empty($failed_id)){
								$post_info = array(
									'guid'           => $uploaddir_url . "/" .  $fimg_name,
									'post_mime_type' => $file_type,
									'post_title'     => 'image-failed',
									'post_content'   => '',
									'post_status'    => 'inherit',
									'post_author'  => isset($post_values['author']) ? $post_values['author'] : ''
								);
								$attach_id = wp_insert_attachment( $post_info,$uploaddir_path, $post_id );
							}
							elseif($failed_id[0]->original_image != $acf_csv_name){
								$post_info = array(
									'guid'           => $uploaddir_url . "/" .  $fimg_name,
									'post_mime_type' => $file_type,
									'post_title'     => 'image-failed',
									'post_content'   => '',
									'post_status'    => 'inherit',
									'post_author'  => $post_values['author']
								);
								$attach_id = wp_insert_attachment( $post_info,$uploaddir_path, $post_id );
							}
							elseif(($failed_id[0]->image_shortcode == 'Featured_image_') && ($failed_id[0]->original_image == $acf_csv_name)){
								$post_info = array(
									'guid'           => $uploaddir_url . "/" .  $fimg_name,
									'post_mime_type' => $file_type,
									'post_title'     => 'image-failed',
									'post_content'   => '',
									'post_status'    => 'inherit',
									'post_author'  => $post_values['author']
								);
								$attach_id = wp_insert_attachment( $post_info,$uploaddir_path, $post_id );
							}
							if(empty($failed_id)){
								$insert_status = $wpdb->insert($shortcode_table,
									array(
										'post_id' => $post_id,
										'post_title' => $post_title,
										'image_shortcode' => $plugin.'_image__'.$acf_wpname_element,
										'media_id' => $attach_id,
										'original_image' => $acf_csv_name,
										'indexs' => $indexs,
										'image_meta' => $acf_image_meta,
										'hash_key' => $hash_key,
										'import_type' => $get_import_type,
										'file_name' => $file_name
									),
									array('%d','%s','%s','%d','%s','%d','%s','%s','%s','%s')
								);
								if($insert_status){
									$this->store_image_ids($attach_id);//store number of image ids
									$this->store_failed_image_ids($attach_id);//store failed image ids
								}
							}
							else{
								$media_id = $failed_id[0]->media_id;
								$attachment_id = $wpdb->get_results("SELECT ID FROM {$wpdb->prefix}posts WHERE ID = $media_id AND post_title ='image-failed' AND post_type = 'attachment' AND guid LIKE '%$fimg_name%'", ARRAY_A);
								$attach_id= $attachment_id[0]['ID'];
							}		
						return isset($attach_id) ? $attach_id : '';	
				}else{
					$attachment_id = $wpdb->get_results("SELECT ID FROM {$wpdb->prefix}posts WHERE post_title ='image-failed' AND post_type = 'attachment' AND guid LIKE '%$fimg_name%'", ARRAY_A);
				}
			return $attach_id;
		}
	}
	public function store_image_ids($attach_id){
		//get number of images count
			$stored_ids = get_option('total_attachment_ids', '');
			$att_id = $attach_id;
			if ($stored_ids === '') {
				add_option('total_attachment_ids', serialize(array($att_id)));
				$stored_ids = unserialize(get_option('total_attachment_ids', ''));
			} else {
				$get_stored_ids = unserialize(get_option('total_attachment_ids', ''));
				if (is_array($get_stored_ids) && !empty($att_id)) {
					$att_id = is_array($att_id) ? $att_id : array($att_id);
					$stored_ids = array_merge($get_stored_ids,$att_id);
				} else {
					$stored_ids = $att_id;
				}
				update_option('total_attachment_ids', serialize($stored_ids));
				$stored_ids = unserialize(get_option('total_attachment_ids', ''));
			}
	}
	public function store_failed_image_ids($attach_id){
		//get number of failed images count 
			$stored_ids = get_option('failed_attachment_ids', '');
			$att_id = $attach_id;
			if ($stored_ids === '') {
				add_option('failed_attachment_ids', serialize(array($att_id)));
				$stored_ids = unserialize(get_option('failed_attachment_ids', ''));
			} else {
				$get_stored_ids = unserialize(get_option('failed_attachment_ids', ''));
				if (is_array($get_stored_ids) && !empty($att_id)) {
					$att_id = is_array($att_id) ? $att_id : array($att_id);
					$stored_ids = array_merge($get_stored_ids,$att_id);
				} else {
					$stored_ids = $att_id;
				}
				update_option('failed_attachment_ids', serialize($stored_ids));
				$stored_ids = unserialize(get_option('failed_attachment_ids', ''));
			}
	}

}