<?php
/**
 * Array2XML
 *
 * @author Zapic
 * @version 0.0.1
 * @since
 * v0.0.1 First release.
 * 
 * @method string execute(Array $data[,boolean $root]) Array that need to convert to XML.
 * @method void setRoot(boolean $root) Set that should output has root.
 */
class Array2XML {
	private $root;
	
	function __construct($root = true){
		$this->setRoot($root);
    }
	
	/**
	 * Set output XML should has root in default.
	 *
	 * @parma boolean root Should add root to XML in default.
	 * 
	 */
	function setRoot($root){
		$this->root = $root;
	}
	
	/**
	 * Array to XML
	 *
	 * @parma Array data Array that need to convert to XML.
	 * @parma boolean root Overwrite default XML-has-root setting.
	 * @return string the XML document string.
	 */
	function execute($data,$root = NULL) {
		$root = is_null($root) ? $this->root : $root;
		$str = '';
		if ($root) $str .= '<?xml version="1.0" encoding="UTF-8"?><xml>';
		foreach ($data as $key => $val) {
			$key = preg_replace('/\[\d*\]/', '', $key);
			if (is_numeric($key)) {
				$key = "item" . $key;
			}
			if (is_array($val)) {
				$child = $this->execute($val, false);
				$str .= "<$key>$child</$key>";
			} else {
				if (preg_match('/[<\/>]/', $key)) {
					$str .= "<$key><![CDATA[$val]]></$key>";
				} else {
					$str .= "<$key>$val</$key>";
				}
			}
		}
		if ($root) $str .= "</xml>";
		return $str;
	}
}