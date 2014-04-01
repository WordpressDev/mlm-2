<?
class Captcha_controller extends Controller
{
    public function main()
    {
        require_once(ROOT.'/vendor/kcaptcha/Kcaptcha.php');
        $captcha = new Kcaptcha();

        if($_REQUEST[session_name()]){
            $_SESSION['captcha_keystring'] = $captcha->getKeyString();
        }
    }
}