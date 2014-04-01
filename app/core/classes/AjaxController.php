<?
class AjaxController extends Controller
{
    public function main() {}

    protected function returnSuccess($type, $message, $data=NULL)
    {
        $response = array(
            'result' => 'success',
            'type' => $type,
            'message' => $message
        );

        if ($data)
            $response['data'] = $data;

        echo json_encode($response);
    }

    protected function returnError($type, $message, $data=NULL)
    {
        $response = array(
            'result' => 'error',
            'type' => $type,
            'message' => $message
        );

        if ($data)
            $response['data'] = $data;

        echo json_encode($response);
    }

    protected function generateCode($length = 5)
    {
        $chars = '123456789';
        $numChars = strlen($chars);
        $string = '';

        for ($i = 0; $i < $length; $i++) {
            $string .= substr($chars, rand(1, $numChars) - 1, 1);
        }

        return $string;
    }
}