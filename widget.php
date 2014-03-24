<?php
/*
 * ===================================================================
 * -------------Widget library for codeigniter framework--------------
 * ===================================================================
 * install this file as core file,for example:
 * application/core/widget.php
 * -------------------------------------------------------------------
 * @Developer:           Abdullah AbuNada
 * @Design pattern:      HMVC
 * @Date:                24-03-2014
 * @version:             1.0
 * @copyright:           Copyright © 2014 Free Software Foundation GNU
 * -------------------------------------------------------------------
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Widget {

    function Widget() {
        $this->_assign_libraries();
    }
    //
    function run($module, $name) {
        
        $args = func_get_args();
        
        $path = APPPATH . 'modules/' . $module . '/widgets/' . $name . EXT;
        if(file_exists($path)){
            require_once $path;
        }
        else {return FALSE;}
        
        $name = ucfirst($name);
        $widget = new $name();
        // 2 for visible parameter to check permission 
        return call_user_func_array(array($widget, 'run'), array_slice($args, 2));
    }
    //render 
    function render($module, $view, $data = array()) {
        extract($data);
        $path = APPPATH . 'modules/' . $module . '/widgets/views/' . $view . EXT;
        if(file_exists($path)){
            include_once $path;
        }  else {
            return FALSE;    
        }
    }
    //
    function load($object) {
        $this->$object = & load_class(ucfirst($object));
    }
    //
    function _assign_libraries() {
        $ci = & get_instance();
        foreach (get_object_vars($ci) as $key => $object) {
            $this->$key = & $ci->$key;
        }
    }

}

