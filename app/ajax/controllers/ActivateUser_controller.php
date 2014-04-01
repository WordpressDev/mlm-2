<?
class ActivateUser_controller extends AjaxController
{
    public function main()
    {
        $data = $this->transformData($_POST['data']);

        $user = $this->model->getUserByPhone($data['phone']);

        if ($_POST['action'] == 'resendCode')
            return $this->resendCode($user['id'], $data['phone']);

        if ($user['active'] == 1)
            return $this->returnError('active', 'Пользователь уже активирован!');

        $checkCode = $this->model->checkCode($user['id'], $data['code']);

        if (!empty($checkCode))
        {
            $this->model->activateUser($user['id']);
            $this->model->deleteCode($user['id'], $data['code']);

            Functions::login($user);

            return $this->returnSuccess('activate', 'Пользователь успешно активирован!');
        }

        return $this->returnError('activate', 'Неверный код!');
    }

    public function transformData($data)
    {
        $data['phone'] = str_replace('+', '', $data['phone']);

        return $data;
    }

    public function resendCode($userId, $phone)
    {
        $code = $this->model->getCode($userId);

        $sms = SmsHelper::getInstance();
        $response = $sms->sendMessage(array(
            "id" => 1,
            "phone"=> $phone,
            "text" => "Код подтверждения : $code"
        ));
    }
}