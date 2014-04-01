<?
class SmsHelper
{
    private $gate;
    private static $instance = NULL;

    private function __construct()
    {
        $config = Functions::getConfig('sms');

        $this->gate = new ProstorSmsJsonGate($config['login'], $config['password']);
    }

    public static function getInstance()
    {
        if( self::$instance === NULL )
            self::$instance = new self();

        return self::$instance;
    }
    
    public function getBalance()
    {
        $response = $this->gate->credits();

        if ($response['status'] === 'ok')
            return $response['credits'];

        return false;
    }

    public function getSenders()
    {
        //return array('OZBOX.RU');
        $response = $this->gate->senders();

        if ($response['status'] === 'ok')
            return $response['senders'];

        return false;
    }

    public function sendMessage(array $array)
    {
        $data = $this->prepareMessages($array);

        if (!empty($data['prepared']))
        {
            $response = $this->gate->send($data['prepared'], 'testQueue');

            if ($response['status'] === 'ok')
            {
                    $return['sended'] = count($response['messages']) > 1 ?
                        $response['messages'] : $response['messages'][0];
            }
        }

        if (!empty($data['issues']))
            $return['issues'] = count($data['issues']) > 1 ? $data['issues'] : $data['issues'][0];

        return $return;
    }

    // @todo написать правила для валидации телефонного номера
    private function validatePhone($phone)
    {
        if (!$phone)
            return false;

        return true;
    }

    // @todo написать правила для валидации текста сообщения
    private function validateText($text)
    {
        if (!$text)
            return false;

        return true;
    }

    private function prepareMessages(array $array)
    {
        $sender = NULL;

        if (!$array[0])
        {
            $temp = $array;
            unset($array);
            $array[0] = $temp;
            unset($temp);
        }

        for ($i=0; $i<count($array); $i++)
        {
            $clientId = ((int) $array[$i]['id'] > 0) ? (int) $array[$i]['id'] : 1;
            $phoneIssue = false; $textIssue = false; $senderIssue = false; $currentIssues = array();

            if ( !$this->validatePhone($array[$i]['phone']) )
                $phoneIssue = true;
            if ( !$this->validateText($array[$i]['text']) )
                $textIssue = true;
            if (!isset($array[$i]['sender']) && $sender === NULL)
            {
                $senders = $this->getSenders();

                if ($senders === false)
                    $senderIssue = true;
                else {
                    $sender = array_pop($senders);
                    $array[$i]['sender'] = $sender;
                }
            }

            if (!$phoneIssue && !$textIssue && !$senderIssue)
                $request[] = array(
                    'clientId' => $clientId,
                    'phone' => $array[$i]['phone'],
                    'text' => $array[$i]['text'],
                    'sender' => $array[$i]['sender'],
                );
            else {
                if ($phoneIssue)
                    $currentIssues['phone'] = true;
                if ($textIssue)
                    $currentIssues['text'] = true;
                if ($senderIssue)
                    $currentIssues['sender'] = true;

                $currentIssues['id'] = $clientId;

                $issues[] = $currentIssues;
            }
        }

        if (!empty($issues))
            $result['issues'] = $issues;

        if (!empty($request))
            $result['prepared'] = $request;

        return $result;
    }
}