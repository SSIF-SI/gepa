<?php 
class Common{
	public static function fieldFromLabel($label) {
		return strtolower ( str_replace ( array (
				" ",
				"'",
				"/"
		), "_", strtolower($label) ) );
	}
	public static function labelFromField($field, $upperFirst = true) {
		$field = strtolower ( str_replace ( array (
				"_",
				"'",
				"/"
		), " ", $field ) );
		return $upperFirst ? ucfirst($field) : $field;
	}
	
	public static function redirect($url = HTTP_ROOT){
		header("Location: " . $url);
		die();
	}
	
	public static function createPostMetadata($postArray, $id_parent=null){
		$retArray = array();
		
		foreach ( $postArray as $key=>$post ) :
			if(preg_match("/(\d{2})\/(\d{2})\/(\d{4})$/", $post)){
				$post = Utils::convertDateFormat($post, "d/m/Y", DB_DATE_FORMAT);
			}
				
			$key = self::labelFromField($key, false);
			$retArray [$key] = $post;
		endforeach;
		
		if(!is_null($id_parent))
			$retArray = array($id_parent => $retArray);
		
		return $retArray;
	}	
	
	public static function getFileExtension($file){
		$path_parts = pathinfo($file);
		return $path_parts['extension'];
		
	}
	
	
}
?>