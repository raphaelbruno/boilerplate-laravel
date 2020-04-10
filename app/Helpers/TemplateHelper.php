<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Gate;

class TemplateHelper 
{
    
    public static function getItemID()
    {
        $params = \Route::getCurrentRoute()->parameters();
        return !empty($params) ? array_values($params)[0] : false;
    }
    
    public static function getCurrentResource()
    {
        $resource = null;
        if (preg_match('#(\w*:)*(\w+).*#', \Route::getCurrentRoute()->getName(), $matches))
            $resource = $matches[2];

        return $resource;
    }
    
    public static function displayMenu($item)
    {
        if(!isset($item['permission'])) return true;
        else
        {
            $permissions = is_array($item['permission']) ? $item['permission'] : [$item['permission']];
            foreach($permissions as $permission)
                if(Gate::check($permission)) return true;
        }

        return false;
    }
    
    public static function isMenuActive($item)
    {
        if(!empty($item))
        {
            // Same Action
            if(isset($item['action']) && $item['action'] == \Route::getCurrentRoute()->getName())
                return true;

            // Same Resource
            if(isset($item['resource']) && in_array(self::getCurrentResource(), is_array($item['resource']) ? $item['resource'] : [$item['resource']]))
                return true;
            
            // Has Ative Subitem
            if(isset($item['children']))
                foreach($item['children'] as $child)
                    if(isset($child['action']) && $child['action'] == \Route::getCurrentRoute()->getName())
                        return true;
        }
        return false;
    }
}