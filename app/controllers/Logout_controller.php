<?
class Logout_controller extends Controller
{
    public function main()
    {
        Functions::logout();
        Functions::redirect();
    }
}