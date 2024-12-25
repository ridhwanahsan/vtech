<?php
/**
 * Import Woocommerce plugin file.
 *
 * Copyright (C) 2010-2020, Smackcoders Inc - info@smackcoders.com
 */

namespace Smackcoders\SMWC;
use PhpParser\Error;
use PhpParser\ParserFactory;
use NXP\MathExecutor;
if ( ! defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly
	
	require_once(dirname(__FILE__,3).'/wp-ultimate-csv-importer/lib/autoload.php');

class ImportHelpers {
	private static $helpers_instance = null;

	public static function getInstance() {

		if (ImportHelpers::$helpers_instance == null) {
			ImportHelpers::$helpers_instance = new ImportHelpers;
			return ImportHelpers::$helpers_instance;
		}
		return ImportHelpers::$helpers_instance;
	}

	public function assign_post_status($data_array) {
		if (isset($data_array['is_post_status']) && $data_array['is_post_status'] != 'on') {
			$data_array ['post_status'] = $data_array['is_post_status'];
			unset($data_array['is_post_status']);
		}
		if (isset($data_array ['post_type']) && $data_array ['post_type'] == 'page') {
			$data_array ['post_status'] = 'publish';
		} else {
			if(isset($data_array['post_status']) || isset($data_array['coupon_status'])) {
				if(isset($data_array['post_status'])) {
					$data_array['post_status'] = strtolower( $data_array['post_status'] );
				} else {
					$data_array['post_status'] = strtolower( $data_array['coupon_status'] );
				}
				$data_array['post_status'] = trim($data_array['post_status']);
				if ($data_array['post_status'] != 'publish' && $data_array['post_status'] != 'private' && $data_array['post_status'] != 'draft' && $data_array['post_status'] != 'pending' && $data_array['post_status'] != 'sticky') {
					$stripPSF = strpos($data_array['post_status'], '{');
					if ($stripPSF === 0) {
						$poststatus = substr($data_array['post_status'], 1);
						$stripPSL = substr($poststatus, -1);
						if ($stripPSL == '}') {
							$postpwd = substr($poststatus, 0, -1);
							$data_array['post_status'] = 'publish';
							$data_array ['post_password'] = $postpwd;
						} else {
							$data_array['post_status'] = 'publish';
							$data_array ['post_password'] = $poststatus;
						}
					} else {
						$data_array['post_status'] = 'publish';
					}
				}
				if ($data_array['post_status'] == 'sticky') {
					$data_array['post_status'] = 'publish';
					$sticky = true;
				}
				else {
				}
			} else {
				$data_array['post_status'] = 'publish';
			}
		}
		return $data_array;
	}

	public function import_post_types($import_type, $importAs = null) {	
		$import_type = trim($import_type);

		$module = array('Posts' => 'post', 'Pages' => 'page', 'Users' => 'user', 'Comments' => 'comments', 'Taxonomies' => $importAs, 'CustomerReviews' =>'wpcr3_review', 'Categories' => 'categories', 'Tags' => 'tags', 'eShop' => 'post', 'WooCommerce' => 'product', 'WPeCommerce' => 'wpsc-product','WPeCommerceCoupons' => 'wpsc-product', 'MarketPress' => 'product', 'MarketPressVariations' => 'mp_product_variation','WooCommerceVariations' => 'product', 'WooCommerceOrders' => 'product', 'WooCommerceCoupons' => 'product', 'WooCommerceRefunds' => 'product', 'CustomPosts' => $importAs);
		foreach (get_taxonomies() as $key => $taxonomy) {
			$module[$taxonomy] = $taxonomy;
		}
		if(array_key_exists($import_type, $module)) {
			return $module[$import_type];
		}
		else {
			return $import_type;
		}
	}

	public function UCI_WPML_Supported_Posts ($data_array, $pId) {
		global $sitepress, $wpdb;
		$get_trid = $wpdb->get_results("select trid from {$wpdb->prefix}icl_translations ORDER BY translation_id DESC limit 1");
		$trid = $get_trid[0]->trid;
		if(empty($data_array['translated_post_title']) && !empty($data_array['language_code'])){
			$wpdb->insert( $wpdb->prefix.'icl_translations', array('element_type' => 'post_'.$data_array['post_type'],'language_code' => $data_array['language_code'],'element_id' => $pId , 'trid' => $trid + 1));
		}
		elseif(!empty($data_array['language_code']) && !empty($data_array['translated_post_title'])){
			$update_query = $wpdb->prepare("select ID,post_type from $wpdb->posts where post_title = %s and post_type=%s order by ID DESC",$data_array['translated_post_title'] , $data_array['post_type']);
			$ID_result = $wpdb->get_results($update_query);
			if(is_array($ID_result) && !empty($ID_result)) {
				$element_id = $ID_result[0]->ID;
				$post_type = $ID_result[0]->post_type;
			}else{
				return false;
			}
			/* Update Multi-language */
			$update = $wpdb->prepare("select translation_id from $wpdb->posts where element_id = %s  order by ID DESC",$pId);
			$result_ID = $wpdb->get_results($update); 
			if(is_array($result_ID) && !empty($result_ID)) {
				$upelement_id = $result_ID[0]->ID;
			}
			$trid_id = $sitepress->get_element_trid($element_id,'post_'.$post_type);
			$translate_lcode = $sitepress->get_language_for_element($element_id,'post_'.$post_type);
			if(!empty($result_ID)){  
				$wpdb->update($wpdb->prefix.'icl_translations', array(
					'element_type' => 'post_'.$data_array['post_type'],
					'trid'      => $trid_id,
					'language_code'  => $data_array['language_code'],
					'source_language_code' => $translate_lcode

				), array('element_id' => $pId ), array( '%s', '%s', '%s', '%s' ), array( '%d' ) );
			} else{
				$wpdb->insert( $wpdb->prefix.'icl_translations', array( 'element_type' => 'post_'.$data_array['post_type'],'trid' => $trid_id, 'language_code' => $data_array['language_code'], 'source_language_code' => $translate_lcode ,'element_id' => $pId));
			}
		}
	}
	public function get_meta_values($map , $header_array , $value_array){

		$post_values = [];
		if (is_array($map)) {
			$trim_content = array(
				'->static' => '', 
				'->math' => '', 
				'->cus1' => '',
				'->num' => ''
			);

			foreach($map as $header_keys => $value){
				if( strpos($header_keys, '->cus2') !== false) {
					if(!empty($value)){
						$this->write_to_customfile($value, $header_array, $value_array);
						unset($map[$header_keys]);
					}
				}
				else{
					$header_trim = strtr($header_keys, $trim_content);
					if($header_trim != $header_keys){
						unset($map[$header_keys]);
					}
					$map[$header_trim] = $value;
				}
			}

			foreach($map as $key => $value){	
				$csv_value= trim($map[$key]);

				if(!empty($csv_value)){
					//$pattern = "/({([a-z A-Z 0-9 | , _ -]+)(.*?)(}))/";
					$pattern1 = '/{([^}]*)}/';
					$pattern2 = '/\[([^\]]*)\]/';

					if(preg_match_all($pattern1, $csv_value, $matches, PREG_PATTERN_ORDER)){		
						//check for inbuilt or custom function call -> enclosed in []
						if(preg_match_all($pattern2, $csv_value, $matches2)){
							$matched_element = $matches2[1][0];
							
							foreach($matches[1] as $value){
								$get_value = $this->replace_header_with_values($value, $header_array, $value_array);
								$values = '{'.$value.'}';
								$get_value = "'".$get_value."'";
								$matched_element = str_replace($values, $get_value, $matched_element);
							}
						
							$csv_element = $this->evalPhp($matched_element);
							$wp_element= trim($key);
							if(!empty($csv_element) && !empty($wp_element)){
								$post_values[$wp_element] = $csv_element;
							}
						}
						else{
							$csv_element = $csv_value;
							
							//foreach($matches[2] as $value){
							foreach($matches[1] as $value){
								$get_key = array_search($value , $header_array);
								if(isset($value_array[$get_key])){
									$csv_value_element = $value_array[$get_key];	

									$value = '{'.$value.'}';
									$csv_element = str_replace($value, $csv_value_element, $csv_element);
								}
							}
							$math = 'MATH';
							if (strpos($csv_element, $math) !== false) {
								$equation = str_replace('MATH', '', $csv_element);
								$csv_element = $this->evalMath($equation);
							}

							$wp_element= trim($key);
							if(!empty($csv_element) && !empty($wp_element)){
								$csv_ele1 = explode('|',$csv_element)	;
								$post_values[$wp_element] = $csv_ele1;
							}	
						}
					}

					// for custom function without headers in it
					elseif(preg_match_all($pattern2, $csv_value, $matches2)){
						$matched_element = $matches2[1][0];
					
						$wp_element= trim($key);
						$csv_element1 = @eval("return " . $matched_element . ";" );
						$post_values[$wp_element] = $csv_element1;
					}

					elseif(!in_array($csv_value , $header_array)){
						$wp_element= trim($key);
						$post_values[$wp_element] = $csv_value;
					}

					else{
						$get_key = array_search($csv_value , $header_array);

						if(isset($value_array[$get_key])){
							$csv_element = $value_array[$get_key];	
							$csv_ele1=explode('|',$csv_element)	;
							//foreach($csv_ele1 as $key => $val){
							$wp_element = trim($key);
							if(isset($csv_element) && !empty($wp_element)){
								$post_values[$wp_element] = $csv_ele1;
							}
							//}
							//}

						}
					}
				}
			}
		}

		return $post_values;
	}
	public function write_to_customfile($csv_value, $header_array=null, $value_array=null){
		//if(preg_match_all('/{+(.*?)}/', $csv_value, $matches)) {
		
			// foreach($matches[1] as $value){
			// 	$get_value1 = $this->replace_header_with_values($value, $header_array, $value_array);
			// 	$values1 = '{'.$value.'}';
			// 	$get_value1 = "'".$get_value1."'";
			// 	$csv_value = str_replace($values1, $get_value1, $csv_value);
			// }
		
			$upload = wp_upload_dir();
   			$upload_base_url = $upload['basedir'];
        	$customfn_file_path = $upload_base_url . '/smack_uci_uploads/customFunction.php';

			if(!file_exists($customfn_file_path)){
				$add_php_tag = '<?php';
				$openFile = fopen($customfn_file_path, "w+");
				fwrite($openFile, $add_php_tag);
				fclose($openFile);
				chmod($customfn_file_path , 0777);
			}

			$get_custom_content = file_get_contents($customfn_file_path);
			$exp_data =explode('{',$csv_value);
			if(strpos($get_custom_content,$exp_data[0]) !== false) {
			}
			else{
				$openFile = fopen($customfn_file_path, "a+");
				fwrite($openFile, "\n".$csv_value);
				fclose($openFile);
				chmod($customfn_file_path , 0777);
			}
			require_once $customfn_file_path;
		//}
	}

	public function replace_header_with_values($csv_header, $header_array, $value_array){
		$csv_value = $csv_header;
		$get_key = array_search($csv_header , $header_array);
		if(isset($value_array[$get_key])){
			$csv_value = $value_array[$get_key];
		}
		return $csv_value;
	}


	public function get_header_values($map , $header_array , $value_array){
		$current_user = wp_get_current_user();
		$current_user_role = $current_user->roles[0];
		if($current_user_role == 'administrator'){
		$post_values = [];
		$trim_content = array(
			'->static' => '', 
			'->math' => '', 
			'->cus1' => '',
			'->openAI' => '',
		);
		if(is_array($map)){
			foreach($map as $header_keys => $value){
				if( strpos($header_keys, '->cus2') !== false) {
					if(!empty($value)){
						$this->write_to_customfile($value, $header_array, $value_array);
						unset($map[$header_keys]);
					}
				}
				else{
					$header_trim = strtr($header_keys, $trim_content);
					if($header_trim != $header_keys){
						unset($map[$header_keys]);
					}
					$map[$header_trim] = $value;
				}
			}
			foreach($map as $key => $value){
				$csv_value= trim($map[$key]);
				if(!empty($csv_value)){
					$pattern1 = '/{([^}]*)}/';
					$pattern2 = '/\[([^\]]*)\]/';
					if(preg_match_all($pattern1, $csv_value, $matches, PREG_PATTERN_ORDER)){		
						
						//check for inbuilt or custom function call -> enclosed in []
						if(preg_match_all($pattern2, $csv_value, $matches2)){
							$matched_element = $matches2[1][0];
							
							foreach($matches[1] as $value){
								$get_value = $this->replace_header_with_values($value, $header_array, $value_array);
								$values = '{'.$value.'}';
								$get_value = "'".$get_value."'";
								$matched_element = str_replace($values, $get_value, $matched_element);
							}
							$csv_element = $this->evalPhp($matched_element);
						}
						else{
							$csv_element = $csv_value;


							foreach($matches[1] as $value){
								$get_key = array_search($value , $header_array);
								if(isset($value_array[$get_key])){
									$csv_value_element = $value_array[$get_key];
									$value = '{'.$value.'}';
									$csv_element = str_replace($value, $csv_value_element, $csv_element);
								}
							}
							$math = 'MATH';
							if (strpos($csv_element, $math) !== false) {

								$equation = str_replace('MATH', '', $csv_element);
								$csv_element = $this->evalMath($equation);
							}
						}
						$wp_element= trim($key);
						if(!empty($csv_element) && !empty($wp_element)){
							$post_values[$wp_element] = $csv_element;
						}	
					}

					// for custom function without headers in it
					elseif(preg_match_all($pattern2, $csv_value, $matches2)){
						$matched_element = $matches2[1][0];
					
						$wp_element= trim($key);
						$csv_element1 = $this->evalPhp($matched_element);
						$post_values[$wp_element] = $csv_element1;
					}
					elseif(!in_array($csv_value , $header_array)){
						$wp_element= trim($key);
						$post_values[$wp_element] = $csv_value;
					}
					
					
					else{
							$get_key= array_search($csv_value , $header_array);		
							if(!empty($value_array[$get_key])){
								$csv_element = $value_array[$get_key];	
								$wp_element = trim($key);
								if(!empty($csv_element) && !empty($wp_element)){
									$post_values[$wp_element] = $csv_element;
								}
							}
						
					}
				}
			}
		}
		}	
		return $post_values;
	}


	/**
	 * Function to evaluate Math equations
	 */
	public function evalMath($equation) {
	    //input
	    $equation = preg_replace("/[^0-9+\-.*\/()%]/", "", $equation);

	    // Convert percentages to decimal
	    $equation = preg_replace("/([+-])([0-9]{1})(%)/", "*(1$1.0$2)", $equation);
	    $equation = preg_replace("/([+-])([0-9]+)(%)/", "*(1$1.$2)", $equation);

	    try {
	    	$executor = new MathExecutor();

			return	$executor->execute($equation);
	    } catch (Exception $e) {
	        $return("Unable to calculate equation");
	    }
	}

	/**
	 * Function to evaluate PHP expressions
	 */
	public function evalPhp($expression)	{
		$parser = (new ParserFactory)->createForNewestSupportedVersion();

		try {
    		$parser->parse($expression);
			$value=$parser->parse($expression);
			if(!empty($value)){
				$expression=sanitize_text_field($expression);
				return eval('return '.$expression.';');
			}
    	} catch (Error $error) {
    		return 'Parse Error: '. $error->getMessage();
		}
	}


	public function update_log($message , $status , $verify , $post_id , $hash_key){

		global $wpdb;
		$importlog_table_name = $wpdb->prefix ."import_log_detail";

		$wpdb->insert($importlog_table_name, array(
			'hash_key' => $hash_key,
			'message' => "{$message}",
			'status' => "{$status}",
			'verify' => "{$verify}",
			'post_id' => $post_id,

		),
		array('%s', '%s', '%s', '%s', '%d')
		);
	}

	public function update_error_log($message , $hash_key , $post_id){
		global $wpdb;
		$importlog_table_name = $wpdb->prefix ."import_log_detail";

		$wpdb->insert($importlog_table_name, array(
			'hash_key' => $hash_key,
			'message' => "{$message}",
			'post_id' => $post_id

		),
		array('%s', '%s', '%d')
		);
	}

	public function update_category_log($category , $post_id){
		global $wpdb;
		$wpdb->update($wpdb->prefix.'import_log_detail', array(
			'categories' => "{$category}"
		), 
		array('post_id' => $post_id)
		);
	}

	public function update_tag_log($tag , $post_id){
		global $wpdb;
		$wpdb->update($wpdb->prefix.'import_log_detail', array(
			'tags' => "{$tag}"
		), 
		array('post_id' => $post_id)
		);
	}
	public function update_status_log($status , $verify , $post_id){
		global $wpdb;
		$wpdb->update($wpdb->prefix.'import_log_detail', array(
			'status' => "{$status}",
			'verify' => "{$verify}"
		), 
		array('post_id' => $post_id)
		);
	}

	public function formatSizeUnits($bytes)
	{
		if ($bytes >= 1073741824)
		{
			$bytes = number_format($bytes / 1073741824, 2) . ' GB';
		}
		elseif ($bytes >= 1048576)
		{
			$bytes = number_format($bytes / 1048576, 2) . ' MB';
		}
		elseif ($bytes >= 1024)
		{
			$bytes = number_format($bytes / 1024, 2) . ' KB';
		}
		elseif ($bytes > 1)
		{
			$bytes = $bytes . ' bytes';
		}
		elseif ($bytes == 1)
		{
			$bytes = $bytes . ' byte';
		}
		else
		{
			$bytes = '0 bytes';
		}

		return $bytes;
	}

	public function update_count($unikey_value,$unikey_name){
		$response = [];
		global $wpdb;
		$logTableName = $wpdb->prefix ."import_detail_log";
		$get_data =  $wpdb->get_results("SELECT skipped , created , updated FROM $logTableName WHERE $unikey_name = '$unikey_value' ");
		$skipped = $get_data[0]->skipped;
		$response['skipped'] = $skipped + 1;
		$created = $get_data[0]->created;
		$response['created'] = $created + 1;
		$updated = $get_data[0]->updated;
		$response['updated'] = $updated + 1;

		return $response;
	}

}
