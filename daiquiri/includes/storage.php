<?php
/**
 * Theme storage manipulations
 *
 * @package WordPress
 * @subpackage DAIQUIRI
 * @since DAIQUIRI 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Get theme variable
if (!function_exists('daiquiri_storage_get')) {
	function daiquiri_storage_get($var_name, $default='') {
		global $DAIQUIRI_STORAGE;
		return isset($DAIQUIRI_STORAGE[$var_name]) ? $DAIQUIRI_STORAGE[$var_name] : $default;
	}
}

// Set theme variable
if (!function_exists('daiquiri_storage_set')) {
	function daiquiri_storage_set($var_name, $value) {
		global $DAIQUIRI_STORAGE;
		$DAIQUIRI_STORAGE[$var_name] = $value;
	}
}

// Check if theme variable is empty
if (!function_exists('daiquiri_storage_empty')) {
	function daiquiri_storage_empty($var_name, $key='', $key2='') {
		global $DAIQUIRI_STORAGE;
		if (!empty($key) && !empty($key2))
			return empty($DAIQUIRI_STORAGE[$var_name][$key][$key2]);
		else if (!empty($key))
			return empty($DAIQUIRI_STORAGE[$var_name][$key]);
		else
			return empty($DAIQUIRI_STORAGE[$var_name]);
	}
}

// Check if theme variable is set
if (!function_exists('daiquiri_storage_isset')) {
	function daiquiri_storage_isset($var_name, $key='', $key2='') {
		global $DAIQUIRI_STORAGE;
		if (!empty($key) && !empty($key2))
			return isset($DAIQUIRI_STORAGE[$var_name][$key][$key2]);
		else if (!empty($key))
			return isset($DAIQUIRI_STORAGE[$var_name][$key]);
		else
			return isset($DAIQUIRI_STORAGE[$var_name]);
	}
}

// Inc/Dec theme variable with specified value
if (!function_exists('daiquiri_storage_inc')) {
	function daiquiri_storage_inc($var_name, $value=1) {
		global $DAIQUIRI_STORAGE;
		if (empty($DAIQUIRI_STORAGE[$var_name])) $DAIQUIRI_STORAGE[$var_name] = 0;
		$DAIQUIRI_STORAGE[$var_name] += $value;
	}
}

// Concatenate theme variable with specified value
if (!function_exists('daiquiri_storage_concat')) {
	function daiquiri_storage_concat($var_name, $value) {
		global $DAIQUIRI_STORAGE;
		if (empty($DAIQUIRI_STORAGE[$var_name])) $DAIQUIRI_STORAGE[$var_name] = '';
		$DAIQUIRI_STORAGE[$var_name] .= $value;
	}
}

// Get array (one or two dim) element
if (!function_exists('daiquiri_storage_get_array')) {
	function daiquiri_storage_get_array($var_name, $key, $key2='', $default='') {
		global $DAIQUIRI_STORAGE;
		if ( '' === $key2 ) {
			return ! empty( $var_name ) && '' !== $key && isset( $DAIQUIRI_STORAGE[ $var_name ][ $key ] ) ? $DAIQUIRI_STORAGE[ $var_name ][ $key ] : $default;
		} else {
			return ! empty( $var_name ) && '' !== $key && isset( $DAIQUIRI_STORAGE[ $var_name ][ $key ][ $key2 ] ) ? $DAIQUIRI_STORAGE[ $var_name ][ $key ][ $key2 ] : $default;
		}
	}
}

// Set array element
if (!function_exists('daiquiri_storage_set_array')) {
	function daiquiri_storage_set_array($var_name, $key, $value) {
		global $DAIQUIRI_STORAGE;
		if (!isset($DAIQUIRI_STORAGE[$var_name])) $DAIQUIRI_STORAGE[$var_name] = array();
		if ($key==='')
			$DAIQUIRI_STORAGE[$var_name][] = $value;
		else
			$DAIQUIRI_STORAGE[$var_name][$key] = $value;
	}
}

// Set two-dim array element
if (!function_exists('daiquiri_storage_set_array2')) {
	function daiquiri_storage_set_array2($var_name, $key, $key2, $value) {
		global $DAIQUIRI_STORAGE;
		if (!isset($DAIQUIRI_STORAGE[$var_name])) $DAIQUIRI_STORAGE[$var_name] = array();
		if (!isset($DAIQUIRI_STORAGE[$var_name][$key])) $DAIQUIRI_STORAGE[$var_name][$key] = array();
		if ($key2==='')
			$DAIQUIRI_STORAGE[$var_name][$key][] = $value;
		else
			$DAIQUIRI_STORAGE[$var_name][$key][$key2] = $value;
	}
}

// Merge array elements
if (!function_exists('daiquiri_storage_merge_array')) {
	function daiquiri_storage_merge_array($var_name, $key, $value) {
		global $DAIQUIRI_STORAGE;
		if (!isset($DAIQUIRI_STORAGE[$var_name])) $DAIQUIRI_STORAGE[$var_name] = array();
		if ($key==='')
			$DAIQUIRI_STORAGE[$var_name] = array_merge($DAIQUIRI_STORAGE[$var_name], $value);
		else
			$DAIQUIRI_STORAGE[$var_name][$key] = array_merge($DAIQUIRI_STORAGE[$var_name][$key], $value);
	}
}

// Add array element after the key
if (!function_exists('daiquiri_storage_set_array_after')) {
	function daiquiri_storage_set_array_after($var_name, $after, $key, $value='') {
		global $DAIQUIRI_STORAGE;
		if (!isset($DAIQUIRI_STORAGE[$var_name])) $DAIQUIRI_STORAGE[$var_name] = array();
		if (is_array($key))
			daiquiri_array_insert_after($DAIQUIRI_STORAGE[$var_name], $after, $key);
		else
			daiquiri_array_insert_after($DAIQUIRI_STORAGE[$var_name], $after, array($key=>$value));
	}
}

// Add array element before the key
if (!function_exists('daiquiri_storage_set_array_before')) {
	function daiquiri_storage_set_array_before($var_name, $before, $key, $value='') {
		global $DAIQUIRI_STORAGE;
		if (!isset($DAIQUIRI_STORAGE[$var_name])) $DAIQUIRI_STORAGE[$var_name] = array();
		if (is_array($key))
			daiquiri_array_insert_before($DAIQUIRI_STORAGE[$var_name], $before, $key);
		else
			daiquiri_array_insert_before($DAIQUIRI_STORAGE[$var_name], $before, array($key=>$value));
	}
}

// Push element into array
if (!function_exists('daiquiri_storage_push_array')) {
	function daiquiri_storage_push_array($var_name, $key, $value) {
		global $DAIQUIRI_STORAGE;
		if (!isset($DAIQUIRI_STORAGE[$var_name])) $DAIQUIRI_STORAGE[$var_name] = array();
		if ($key==='')
			array_push($DAIQUIRI_STORAGE[$var_name], $value);
		else {
			if (!isset($DAIQUIRI_STORAGE[$var_name][$key])) $DAIQUIRI_STORAGE[$var_name][$key] = array();
			array_push($DAIQUIRI_STORAGE[$var_name][$key], $value);
		}
	}
}

// Pop element from array
if (!function_exists('daiquiri_storage_pop_array')) {
	function daiquiri_storage_pop_array($var_name, $key='', $defa='') {
		global $DAIQUIRI_STORAGE;
		$rez = $defa;
		if ($key==='') {
			if (isset($DAIQUIRI_STORAGE[$var_name]) && is_array($DAIQUIRI_STORAGE[$var_name]) && count($DAIQUIRI_STORAGE[$var_name]) > 0) 
				$rez = array_pop($DAIQUIRI_STORAGE[$var_name]);
		} else {
			if (isset($DAIQUIRI_STORAGE[$var_name][$key]) && is_array($DAIQUIRI_STORAGE[$var_name][$key]) && count($DAIQUIRI_STORAGE[$var_name][$key]) > 0) 
				$rez = array_pop($DAIQUIRI_STORAGE[$var_name][$key]);
		}
		return $rez;
	}
}

// Inc/Dec array element with specified value
if (!function_exists('daiquiri_storage_inc_array')) {
	function daiquiri_storage_inc_array($var_name, $key, $value=1) {
		global $DAIQUIRI_STORAGE;
		if (!isset($DAIQUIRI_STORAGE[$var_name])) $DAIQUIRI_STORAGE[$var_name] = array();
		if (empty($DAIQUIRI_STORAGE[$var_name][$key])) $DAIQUIRI_STORAGE[$var_name][$key] = 0;
		$DAIQUIRI_STORAGE[$var_name][$key] += $value;
	}
}

// Concatenate array element with specified value
if (!function_exists('daiquiri_storage_concat_array')) {
	function daiquiri_storage_concat_array($var_name, $key, $value) {
		global $DAIQUIRI_STORAGE;
		if (!isset($DAIQUIRI_STORAGE[$var_name])) $DAIQUIRI_STORAGE[$var_name] = array();
		if (empty($DAIQUIRI_STORAGE[$var_name][$key])) $DAIQUIRI_STORAGE[$var_name][$key] = '';
		$DAIQUIRI_STORAGE[$var_name][$key] .= $value;
	}
}

// Call object's method
if (!function_exists('daiquiri_storage_call_obj_method')) {
	function daiquiri_storage_call_obj_method($var_name, $method, $param=null) {
		global $DAIQUIRI_STORAGE;
		if ($param===null)
			return !empty($var_name) && !empty($method) && isset($DAIQUIRI_STORAGE[$var_name]) ? $DAIQUIRI_STORAGE[$var_name]->$method(): '';
		else
			return !empty($var_name) && !empty($method) && isset($DAIQUIRI_STORAGE[$var_name]) ? $DAIQUIRI_STORAGE[$var_name]->$method($param): '';
	}
}

// Get object's property
if (!function_exists('daiquiri_storage_get_obj_property')) {
	function daiquiri_storage_get_obj_property($var_name, $prop, $default='') {
		global $DAIQUIRI_STORAGE;
		return !empty($var_name) && !empty($prop) && isset($DAIQUIRI_STORAGE[$var_name]->$prop) ? $DAIQUIRI_STORAGE[$var_name]->$prop : $default;
	}
}
?>