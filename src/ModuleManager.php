<?php

class ModuleManager
{
    public static $modules_install = array();
    /**
     * Includes file with module installation class.
     *
     * Do not use directly.
     *
     * @param string $module_class_name module class name - underscore separated
     * @return bool
     */
    public static final function include_install($module_class_name) {
        if(isset(self::$modules_install[$module_class_name])) return true;
        $full_path = __DIR__ . '/modules/' . $module_class_name . '/' . $module_class_name . 'Install.php';
        if (!file_exists($full_path)) return false;
        ob_start();
        $ret = require_once($full_path);
        ob_end_clean();
        $x = $module_class_name.'Install';
        if(!(class_exists($x, false)) || !array_key_exists('ModuleInstall',class_parents($x)))
            trigger_error('Module ' . $module_class_name . ': Invalid install file', E_USER_ERROR);
        self::$modules_install[$module_class_name] = new $x($module_class_name);
        return true;
    }

}