<?php 
class BindParam{ 
    private $values = array(), $types = ''; 
    
    public function add( $type, $value ){ 
        $this->values[] = $value; 
        $this->types .= $type; 
    } 
    
    public function get(){ 
        return array_merge(array($this->types), $this->values); 
    } 

    public static function refValues($arr) {
	    if (strnatcmp(phpversion(),'5.3') >= 0) {//Reference is required for PHP 5.3+ 
	        $refs = array();
	        foreach($arr as $key => $value)
	            $refs[$key] = &$arr[$key];
	        return $refs;
	    }
	    return $arr;
	}
} 
?> 