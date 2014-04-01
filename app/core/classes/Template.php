<?
class Template
{
    public static function __callStatic($name, array $params=NULL)
    {
        if ($params)
            $view = $params[0];

        if ( file_exists(ROOT."/templates/$name.php") )
            return require_once(ROOT."/templates/$name.php");
    }
} 