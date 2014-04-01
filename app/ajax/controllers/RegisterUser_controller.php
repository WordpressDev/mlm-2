<?
class RegisterUser_controller extends AjaxController
{
    public function main()
    {
        $data = $_POST['data'];

        foreach ($data as &$item)
        {
            $item = trim($item);
        }

        $result = $this->validateForm($data);

        if ($result->isValid())
        {
            if ($data['sponsor'] && $this->model->getSponsorId($data['sponsor']))
                $data['sponsor_id'] = $data['sponsor'];

            $userId = $this->model->registerUser($data);
            $code = $this->saveConfirmCode($userId);
            $this->sendCode($data['phone'], $code);

            return $this->returnSuccess('register', 'Регистрация прошла успешно!');
        }

        return $this->returnError('register', 'Регистрация прошла успешно!', $result->errors);
    }

    private function validateForm($form)
    {
        $result = new Form();

        /*if (!preg_match('/^\+79[0-9]{9}$/', $form['phone'], $match))
            $result->addError(array(
                'type' => 'phone',
                'message' => 'Неверный номер телефона'
            ));*/ // @todo Убрать!!!!!!
        if (!preg_match('/^[а-яА-Я\s]+$/u', $form['name'], $match))
            $result->addError(array(
                'type' => 'name',
                'message' => 'Неверное имя'
            ));
        if (!preg_match("/^(\S+)@([a-z0-9-]+)(\.)([a-z]{2,4})(\.?)([a-z]{0,4})+$/i", $form['email'], $match))
            $result->addError(array(
                'type' => 'email',
                'message' => 'Неверный email'
            ));

        if(isset($_SESSION['captcha_keystring']) && $_SESSION['captcha_keystring'] === $form['captcha'])
        {} else {
            $result->addError(array(
                'type' => 'captcha',
                'message' => 'Введен неверный код!'
            ));
        }

        if (!preg_match("/^[a-zA-Z0-9]+$/i", $form['password'], $match))
            $result->addError(array(
                'type' => 'password',
                'message' => 'Неверный пароль'
            ));
        if (!isset($form['agreement']))
            $result->addError(array(
                'type' => 'agreement',
                'message' => 'Вы не поставили галочку!'
            ));

        return $result;
    }

    private function saveConfirmCode($userId)
    {
        do {
            $code = $this->generateCode();

            if ($this->model->checkCodeUnique($code))
            {
                $this->model->saveConfirmCode($userId, $code);
                break;
            }
        } while (true);

        return $code;
    }

    private function sendCode($phone, $code)
    {
        /*$sms = SmsHelper::getInstance();
        $response = $sms->sendMessage(array(
            "id" => 1,
            "phone"=> $phone,
            "text" => "Код подтверждения : $code"
        ));*/
    }
}
 