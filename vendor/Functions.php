<?
class Functions
{
    public static function login(array $info)
    {
        if (!empty($info))
        {
            $newsModel = new News_model();
            $allNews = $newsModel->getAllNews();
            $watchedNews = $newsModel->getWatchedNews($info['id']);
            $unwatchedNews = count($allNews);

            for ($i=0; $i<count($allNews); $i++)
            {
                for ($j=0; $j<count($watchedNews); $j++)
                {
                    if ($allNews[$i]['id'] == $watchedNews[$j])
                    {
                        $unwatchedNews--;
                        continue;
                    }
                }
            }

            $info['fresh_news'] = $unwatchedNews;
            $_SESSION['user'] = $info;
            return true;
        }

        return false;
    }

    public static function logout()
    {
        session_destroy();
        return true;
    }

    public static function getConfig($configName)
    {
        $config = Register::getInstance()->$configName;

        if ($config)
            return $config;
        else {
            if ( file_exists(ROOT."/config/$configName.php") )
            {
                $config = require_once(ROOT."/config/$configName.php");
                Register::getInstance()->$configName = $config;
                return $config;
            }
        }

        throw new ErrorException("Нет конфигурации по имени $configName");
    }

    public static function isChecked($one, $two)
    {
        if ($one == $two)
            return 'checked="checked"';
        else
            return '';
    }

    public static function cssTag($name)
    {
        if ($name)
            return '<link href="'.self::cssFolder().'/'.$name.'.css" rel="stylesheet" type="text/css" />';

        return false;
    }

    private static function cssFolder()
    {
        return '/css';
    }

    public static function jsTag($name, $vendorName=NULL)
    {
        if (!$name)
            return false;

        $path = self::jsFolder().'/'.($vendorName ? 'vendor/'.$vendorName.'/' : '').$name.'.js';

        return '<script type="text/javascript" src="'.$path.'"></script>';
    }

    private static function jsFolder()
    {
        return '/js';
    }

    public static function redirect($url=NULL)
    {
        $url = '/'.$url;
        echo '<META HTTP-EQUIV="REFRESH" CONTENT="0; URL='.$url.'">';
        die();
    }

    public static function transformName($session)
    {
        $lastname = $session['lastname'];
        $firstname = mb_substr($session['firstname'],0,1,'UTF-8');
        $middlename = mb_substr($session['middlename'],0,1,'UTF-8');

        $cutName = "$lastname $firstname.$middlename.";

        return $cutName;
    }

    public static function transformDate($timestamp, $unix=false, $hours=NULL, $quotes=NULL, $inArray=NULL)
    {
        if ($unix)
            $unixTime = $timestamp;
        else
            $unixTime = strtotime($timestamp);

        $month = (int) date('m', $unixTime);
        $date = (int) date('j', $unixTime);
        $year = (int) date('Y', $unixTime);

        switch ($month) {
            case 1:
                $monthStr = 'января';
                break;
            case 2:
                $monthStr = 'февраля';
                break;
            case 3:
                $monthStr = 'марта';
                break;
            case 4:
                $monthStr = 'апреля';
                break;
            case 5:
                $monthStr = 'мая';
                break;
            case 6:
                $monthStr = 'июня';
                break;
            case 7:
                $monthStr = 'июля';
                break;
            case 8:
                $monthStr = 'августа';
                break;
            case 9:
                $monthStr = 'сентября';
                break;
            case 10:
                $monthStr = 'октября';
                break;
            case 11:
                $monthStr = 'ноября';
                break;
            case 12:
                $monthStr = 'декабря';
                break;
        }

        if ($quotes)
            $return = "&laquo;$date&raquo; $monthStr $year г.";
        else
            $return = "$date $monthStr $year г.";

        if ($inArray)
        {
            return array(
                'day' => $date,
                'month' => $monthStr,
                'year' => $year.'г.',
            );
        }

        if ($hours)
        {
            $time = date('H:i', $unixTime);
            $return .= ' в '.$time;
        }

        return $return;
    }

    public static function unserialize($serialized)
    {
        $str = preg_replace('/\&quot;/', '"', $serialized);
        $return = unserialize($str);

        return $return;
    }

    public static function firstToUpper($str)
    {
        return mb_substr(
            mb_strtoupper($str,'utf-8'),0,1,'utf-8')    .
            mb_strtolower(
                mb_substr($str,1, mb_strlen(
                        $str,'utf-8'
                    ),'utf-8'
                ),'utf-8'
            );
    }

    public static function outDownload($filepath, $filename)
    {
        // fix for IE catching or PHP bug issue
        header("Pragma: public");
        header("Expires: 0"); // set expiration time
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        // browser must download file from server instead of cache

        // force download dialog
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");

        // use the Content-Disposition header to supply a recommended filename and
        // force the browser to display the save dialog.
        header("Content-Disposition: attachment; filename=".$filename.";");

        /*
        The Content-transfer-encoding header should be binary, since the file will be read
        directly from the disk and the raw bytes passed to the downloading computer.
        The Content-length header is useful to set for downloads. The browser will be able to
        show a progress meter as a file downloads. The content-lenght can be determines by
        filesize function returns the size of a file.
        */
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: ".filesize($filepath));

        @readfile($filepath);
    }
    
    public static function sendMail($email, array $params, $type)
    {
        $mailMessages = self::getConfig('mail_messages');
        $mailMessage = $mailMessages[$type];

        foreach($params as $key=>$value)
        {
            $mailMessage['message'] = str_replace('{'.$key.'}', $value, $mailMessage['message']);
        }

        mail($email, $mailMessage['subject'], $mailMessage['message'], "Content-type: text/html; charset=utf-8"."\n\r");
    }
}
 