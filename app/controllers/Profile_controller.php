<?
class Profile_controller extends Controller
{
    public function main()
    {
        $user = $_SESSION['user'];

        $data = array (
            'name' => ($_POST['name'] ? $_POST['name'] : $user['name']),
            'email' => ($_POST['email'] ? $_POST['email'] : $user['email']),
            'md5_password' => ($_POST['password'] ? md5($_POST['password']) : NULL),
            'city' => (isset($_POST['city']) ? $_POST['city'] : $user['city']),
            'about' => (isset($_POST['about']) ? $_POST['about'] : $user['about']),
        );
        $errors = $this->validateForm($data);

        if (empty($errors) && is_uploaded_file($_FILES['avatar']['tmp_name']))
        {
            $result = $this->uploadFile();

            if ($result['error'])
                $errors['avatar'] = $result['error'];
            else
                $data['avatar'] = $result['ext'];
        }

        if ($_POST['name'] && empty($errors))
        {
            $this->model->updateUser($user['id'], $data);
            Functions::login( $this->model->getUserById($user['id']) );
            return Functions::redirect('profile');
        }

        $this->view['avatar'] =
            $user['avatar'] ? '/uploads/avatars/'.$user['id'].'.'.$user['avatar'] : NULL;
        $this->view['data'] = $data;
        $this->view['errors'] = $errors;
    }

    private function validateForm($form)
    {
        if (!preg_match('/^[а-яА-Я\s]+$/u', $form['name'], $match))
            $errors['name'] = 'Неверное имя';

        if (!preg_match("/^(\S+)@([a-z0-9-]+)(\.)([a-z]{2,4})(\.?)([a-z]{0,4})+$/i", $form['email'], $match))
            $errors['email'] = 'Неверный email';

        return $errors;
    }
    
    private function uploadFile()
    {
        // Проверяем размер файла, не больше 10 Мб!
        if ( $_FILES['avatar']['size'] > 10 * 1024 * 1024 )
            return array('error' => 'Превышен максимально допустимый размер файла');

        // Пероверяем тип файла/
        if (!$this->checkFileType($_FILES['avatar']))
            return array('error' => 'Неразрешенный тип файла!');

        if (($ext = $this->saveFile($_FILES['avatar'])) === false )
            return array('error' => 'При сохранении файла произошла ошибка!');

        return array('ext' => $ext);
    }

    // Проверка типа файла
    private function checkFileType($file)
    {
        $imgTypes = array(
            'image/png',
            'image/jpeg',
            'image/gif'
        );
        if ( in_array($file['type'], $imgTypes) )
            return true;
        else
            return false;
    }

    private function saveFile(array $file)
    {
        $pathInfo = pathinfo($file['name']);
        $fileExt = $pathInfo['extension'];
        $filePath = ROOT.'/public_html/uploads/avatars/'.$_SESSION['user']['id'].'.'.$fileExt;

        if (move_uploaded_file($file['tmp_name'], $filePath) )
            return $fileExt;

        return false;
    }
}