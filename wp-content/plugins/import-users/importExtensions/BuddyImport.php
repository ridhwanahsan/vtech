<?php
/******************************************************************************************
 * Copyright (C) Smackcoders. - All Rights Reserved under Smackcoders Proprietary License
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * You can contact Smackcoders at email address info@smackcoders.com.
 *******************************************************************************************/

namespace Smackcoders\SMUSERS;

if ( ! defined( 'ABSPATH' ) )
exit; // Exit if accessed directly

class BuddyImport extends UsersImport{
	private static $buddy_instance = null;

	public static function getInstance() {

		if (BuddyImport::$buddy_instance == null) {
			BuddyImport::$buddy_instance = new BuddyImport;
			return BuddyImport::$buddy_instance;
		}
        return BuddyImport::$buddy_instance;
    }

    function set_buddy_values($header_array ,$value_array , $map, $post_id , $type){
        $post_values = [];
		$helpers_instance = ImportHelpers::getInstance();	
		$post_values = $helpers_instance->get_header_values($map , $header_array , $value_array);
		$this->buddy_import_function($post_values,$type, $post_id);
       
    }

    function buddy_import_function($data_array, $importas,$uID) {
       
        global $wpdb;
        foreach($data_array as $data_key => $data_value) {
            $get_buddy_fields = $wpdb->get_results($wpdb->prepare("select type , name from {$wpdb->prefix}bp_xprofile_fields where id= $data_key" ), ARRAY_A);
            foreach($get_buddy_fields as $buddy_fields){
                $field_type = $buddy_fields['type'];
                if($field_type == 'multiselect_custom_post_type') 
                {
                    $explode = explode('|',$data_value);
                    $data_value = serialize($explode); 
                }
                elseif($field_type == 'multiselectbox')
                {
                    $explode = explode('|',$data_value);
                    $data_value = serialize($explode); 
                    
                }
                elseif($field_type == 'multiselect_custom_taxonomy')
                {
                    $explode = explode('|',$data_value);
                    $data_value = serialize($explode); 
                }
                
                elseif($field_type == 'fromto')
                {
                    $explode = explode('|',$data_value);  
                    $data_results['from'] = $explode[0];
                    $data_results['to'] = $explode[1]; 
                    $data_value = serialize($data_results);
                }
                elseif($field_type == 'image')
                {
                    $image_name = $data_value;
                    $upload_path = wp_upload_dir(); 
                    $path =  $upload_path['basedir'].'/bpxcftr-profile-uploads/'.$uID.'/image';
                    $base_name=basename($image_name);
                    wp_mkdir_p($path);
                    $data = file_get_contents($image_name);
                    $new = $path.'/'.$base_name;
                    file_put_contents($new, $data); 
                    $image_path = "bpxcftr-profile-uploads/$uID/image/".basename($image_name);
                    $data_value = $image_path; 
                }
                elseif($field_type == 'file')
                {
                    $file_name = $data_value;
                    $upload_path = wp_upload_dir(); 
                    $path =  $upload_path['basedir'].'/bpxcftr-profile-uploads/'.$uID.'/file';
                    $base_name=basename($file_name);
                    wp_mkdir_p($path);
                    $data = file_get_contents($file_name);
                    $new = $path.'/'.$base_name;
                    file_put_contents($new, $data);  
                    $file_path = "bpxcftr-profile-uploads/$uID/file/".basename($file_name);
                    $data_value = $file_path;
                }
            } 
            $wpdb->insert("{$wpdb->prefix}bp_xprofile_data", array('field_id' => $data_key,'user_id' => $uID,'value' => $data_value));        
        }
    }
}
global $buddy_class;
$buddy_class = new BuddyImport;