<?
spl_autoload_register(array('Autoloader', 'loadClass'));

class Autoloader
{
    public static function loadClass($className, $ajax=NULL)
    {
        // Логирование
        self::logger($className);

        // Проверяем, есть ли в названии запрашиваемого класса название одного из MVC-компонентов.
        preg_match('/(?:_controller)|(?:_model)|(?:_view)/', $className, $matches);
        $match = str_replace('_', '', $matches[0]);

        if ($ajax && $match)
            return self::loadMVCforAjaxReq($className, $match);

        if ($match)
        {
            return self::loadMVC($className, $match);
        } elseif ( self::loadFromCore($className) ) {
        } elseif ( self::loadVendor($className) ) {
        } else {
            return false;
        }

        return true;
    }

    public static function logger($className)
    {
        // logging will be here...
    }

    private static function loadMVC($className, $component)
    {
        $folder = $component . 's';

        // Ищем в приложении (папка app)
        if ( file_exists(ROOT."/app/$folder/$className.php") )
        {
            require_once(ROOT."/app/$folder/$className.php");
            return true;
        }
        // Ищем в ядре
        else
            return self::loadFromCore($className);
    }

    private static function loadFromCore($className)
    {
        if ( file_exists(ROOT."/app/core/$className.php") )
        {
            require_once(ROOT."/app/core/$className.php");
            return true;
        } elseif ( file_exists(ROOT."/app/core/classes/$className.php") ) {
            require_once(ROOT."/app/core/classes/$className.php");
            return true;
        }

        return false;
    }

    private static function loadVendor($className)
    {
        if ( file_exists(ROOT."/vendor/$className.php") )
        {
            require_once(ROOT."/vendor/$className.php");
            return true;
        } elseif ( file_exists(ROOT."/vendor/$className/$className.php") ) {
            require_once(ROOT."/vendor/$className/$className.php");
            return true;
        }

        return false;
    }

    private static function loadMVCforAjaxReq($className, $component)
    {
        $folder = $component . 's';

        if ( file_exists(ROOT."/app/ajax/$folder/$className.php") )
        {
            require_once(ROOT."/app/ajax/$folder/$className.php");
            return true;
        }

        return false;
    }
}
 