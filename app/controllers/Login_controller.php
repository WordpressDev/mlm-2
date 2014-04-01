<?
class Login_controller extends Controller
{
    public function main()
    {
        if (isset($_SESSION['user']))
            return Functions::redirect();

        if (isset($_POST['phone']) && isset($_POST['password']))
        {
            $user = $this->model->getUserByPhoneAndPassword(
                $this->transformPhone( $_POST['phone'] ),
                md5($_POST['password'])
            );

            if (!empty($user))
            {
                Functions::login($user);
                return Functions::redirect();
            } else
                $this->view['errors'] = 'Введен неправильный логин или пароль!';
        }
    }

    private function transformPhone($phone)
    {
        $phone = str_replace('+', '', $phone);

        return $phone;
    }
}