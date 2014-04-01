<?
class Register
{
    private static $instance = NULL;

    public static function getInstance()
    {
        if( self::$instance === NULL )
            self::$instance = new self();

        return self::$instance;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }
}
 