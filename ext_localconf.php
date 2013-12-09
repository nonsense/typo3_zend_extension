<?php

if (!defined ('TYPO3_MODE')) die ('Access denied.');

$_EXTCONF = unserialize($_EXTCONF);

// Prepend the Zend Framework directory to the beginning of the PHP include_path
if(!empty($_EXTCONF['addIncludePath'])) {
	$includePath = t3lib_extMgm::extPath('zend_framework');
	$includePaths = explode(PATH_SEPARATOR, get_include_path());
	if(!in_array($includePath, $includePaths)) {
		array_unshift($includePaths, $includePath);
		set_include_path(implode(PATH_SEPARATOR, $includePaths));
	}
	unset($includePath);
	unset($includePaths);
}

/**
 * Our autoloader callback method
 *
 * @param string $class
 */
function zend_framework_autoload($class) {
	if(substr($class, 0, 5) == 'Zend_') {
		$path = t3lib_extMgm::extPath('zend_framework') . str_replace('_', '/', $class) . '.php';
		require_once($path);
	}
}

// Registering the above autoload callback
if(!empty($_EXTCONF['registerAutoload'])) {
	spl_autoload_register('zend_framework_autoload');
}

?>