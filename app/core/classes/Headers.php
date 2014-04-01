<?
class Headers
{
    public static function notFound($return=NULL)
    {
        $text = "HTTP/1.0 404 Not Found";

        if ($return)
            return $text;

        header($text);
    }
}
 