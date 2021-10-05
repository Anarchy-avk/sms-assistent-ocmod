<?php

namespace SmsAssistentBy\Lib;

class sms_assistent
{

    private $version = '1.9';
    private $vendor = null;

    private $api_url = 'https://userarea.sms-assistent.by/';
    private $user_login = '';
    private $user_password = '';
    private $user_token = '';
    private $webhook_url = '';
    private $subscribe_name = '';
    private $sender_SMS = '';
    private $sender_viber = '';

    private $api_mode = 'json';

    private $error = 0;
    private $error_messages = array();

    function __construct($login, $password, $token = '')
    {

        $this->user_login = $login;
        $this->user_password = $password;
        $this->user_token = $token;

    }

    public function postContent($url, $postdata, $content_type = '')
    {

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 120);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_ENCODING, 'gzip,deflate');

        $header = [];
        switch ($content_type) {

            case 'text/json' :
            case 'text/xml' :
            {

                $header = [
                    'Content-Type: ' . $content_type
                ];
                curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
                break;
            }

        }

        if (!empty($this->user_token)) {

            $header[] = 'requestAuthToken: ' . $this->user_token;
            if (isset($postdata['password'])) {

                unset($postdata['password']);

            }

        }

        if (count($header) > 0) {

            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);

        }

        if(!empty($this->vendor)) {

            $postdata['Vendor'] = $this->vendor;

        }

        curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
        $res_info = curl_exec($curl);

        $res = array(
            'curl_info' => curl_getinfo($curl),
            'curl_error' => curl_errno($curl),
            'curl_error_message' => curl_error($curl),
            'curl_result' => $res_info
        );

        curl_close($curl);

        return $res;

    }

    public function getBalance()
    {

        $url = $this->api_url . 'api/v1.2/credits/plain';
        $postdata = array(
            'user' => $this->user_login,
            'password' => $this->user_password
        );

        $res = $this->postContent($url, $postdata);

        $res = $this->getResult($res, 'plain_balance');

        return array(
            'error' => $this->error,
            'error_messages' => $this->error_messages,
            'result' => $res
        );

    }

    public function sendSms($tels, $sms_text, $sms_live = '48', $date_send = false, $template_id = false, $tags_replace = false)
    {

        if (is_array($tels) && count($tels) > 1) {

            return $this->sendSmsJson($tels, $sms_text, $sms_live, $date_send, $template_id, $tags_replace);

        } else {

            if (is_array($tels))
                $tel = $tels[0];

            return $this->sendSmsPlain($tel, $sms_text, $sms_live, $date_send, $template_id, $tags_replace);

        }

    }

    /**
     * Отправить вайбер сообщение
     * @param string|array $tels - получатели сообщений в виде строчки или массива, если необходимо несколько
     * @param string $message_text - текст Viber сообщения
     * @param int $message_live - срок жизни сообщения в часах
     * @param bool|string $date_send - дата отправки сообщения в формате ГГГГММДДЧЧММ, false - если нужно отправить мгновенно
     * @param array $viber_rich - массив с параметрами рекламного сообщения. Все параметры обязательны, если планируется рекламное сообщение.
     * viber_image - URL изображения в формате JPG, JPEG, PNG
     * viber_button - наименование кнопки в сообщении
     * viber_url - URL с информацией, на который осуществляется переход после нажатия на кнопку
     * @param array $sms_resend - массив с параметрами для отправки SMS, в случае недоставки по Viber. Все параметры обязательны, если планируется отправка SMS
     * sms_sender - отправитель SMS
     * sms_text - текст SMS
     * @return array
     */
    public function sendViber($tels, string $message_text, int $message_live = 48, $date_send = false, array $viber_rich = [], array $sms_resend = [])
    {

        if (is_array($tels) && count($tels) > 1)
        {

            return $this->sendViberJson($tels, $message_text, $message_live, $date_send, $viber_rich, $sms_resend);

        }

        else
        {
            if (is_array($tels))
                $tel = $tels[0];

            return $this->sendViberPlain($tel, $message_text, $message_live, $date_send, $viber_rich, $sms_resend);

        }

    }

    private function sendSmsPlain($tel, $sms_text, $sms_live = 48, $date_send = false)
    {

        $url = $this->api_url . 'api/v1.2/send_sms/plain';
        $postdata = array(
            'user' => $this->user_login,
            'password' => $this->user_password,
            'sender' => $this->sender_SMS,
            'recipient' => $tel,
            'message' => $sms_text,
            'validity_period' => $sms_live
        );

        if (!empty($this->webhook_url)) {

            $postdata['webhook_url'] = $this->webhook_url;

        }

        if (!empty($this->subscribe_name)) {

            $postdata['name'] = $this->subscribe_name;

        }

        if ($date_send !== false) {

            $postdata['date_send'] = $date_send;

        }

        $res = $this->postContent($url, $postdata);

        $res = $this->getResult($res, 'plain_send');

        return array(
            'error' => $this->error,
            'error_messages' => $this->error_messages,
            'result' => $res,
            'type' => 'plain'
        );

    }

    private function sendViberPlain($tel, $message_text, $message_live = 48, $date_send = false, array $viber_rich = [], array $sms_resend = [])
    {

        $url = $this->api_url . 'api/v1.2/send_viber/plain';
        $postdata = array(
            'user' => $this->user_login,
            'password' => $this->user_password,
            'sender' => $this->sender_viber,
            'recipient' => $tel,
            'message' => $message_text,
            'validity_period' => $message_live
        );

        if (count($viber_rich) > 0) {

            $postdata['viber_image'] = $viber_rich['viber_image'];
            $postdata['viber_button_caption'] = $viber_rich['viber_button'];
            $postdata['viber_button_url'] = $viber_rich['viber_url'];

        }

        if (count($sms_resend) > 0) {

            $postdata['viber_sms_resend'] = 1;
            $postdata['viber_sms_text'] = $sms_resend['sms_text'];
            $postdata['viber_sms_sender'] = $sms_resend['sms_sender'];

        }

        if (!empty($this->webhook_url)) {

            $postdata['webhook_url'] = $this->webhook_url;

        }

        if (!empty($this->subscribe_name)) {

            $postdata['name'] = $this->subscribe_name;

        }

        if ($date_send !== false) {

            $postdata['date_send'] = $date_send;

        }

        $res = $this->postContent($url, $postdata);

        $res = $this->getResult($res, 'plain_viber_send');

        return array(
            'error' => $this->error,
            'error_messages' => $this->error_messages,
            'result' => $res,
            'type' => 'plain'
        );

    }

    private function sendSmsJson($tels, $sms_text, $sms_live = '48', $date_send = false, $template_id = false, $tags_replace = false)
    {

        $url = $this->api_url . 'api/v1.2/json';

        $postdata = array(
            'login' => $this->user_login,
            'password' => $this->user_password,
            'command' => 'sms_send',
            'date_send' => $date_send,
            'message' => array(
                'msg' => array()
            )
        );

        if (!empty($this->subscribe_name)) {

            $postdata['name'] = $this->subscribe_name;

        }

        if (!empty($this->webhook_url)) {

            $postdata['webhook_url'] = $this->webhook_url;

        }

        if ((is_array($sms_text)) && (count($sms_text) != count($tels))) {

            $this->error = 1;
            $this->error_messages[] = $this->getErrorByCode(-100);

        }

        if ((is_array($template_id)) && (count($template_id) != count($template_id))) {

            $this->error = 1;
            $this->error_messages[] = $this->getErrorByCode(-101);

        }

        if ($this->error == 0) {

            foreach ($tels as $k => $v_tel) {

                $postdata['message']['msg'][] = array(
                    'recepient' => $v_tel,
                    'validity_period' => $sms_live,
                    'sms_text' => ((is_array($sms_text)) ? $sms_text[$k] : $sms_text),
                    'sender' => $this->sender_SMS
                );

                if ($template_id !== false) {

                    $postdata['message']['msg'][count($postdata['message']['msg']) - 1]['template_id'] = (is_array($template_id)) ? $template_id[$k] : $template_id;

                }

                if ($tags_replace !== false) {

                    $postdata['message']['msg'][count($postdata['message']['msg']) - 1]['tags_replace'] = $tags_replace;

                }
            }

            $json_postdata = json_encode($postdata, JSON_UNESCAPED_UNICODE);

            $res = $this->postContent($url, $json_postdata, 'text/json');

            $res = $this->getResult($res, 'json_send');

            return array(
                'error' => $this->error,
                'error_messages' => $this->error_messages,
                'result' => $res,
                'type' => 'json'
            );

        }

        else return array(
            'error' => $this->error,
            'error_messages' => $this->error_messages
        );

    }

    private function sendViberJson($tels, $message_text, $message_live = '48', $date_send = false, array $viber_rich = [], array $sms_resend = [])
    {

        $url = $this->api_url . 'api/v1.2/json';

        $postdata = array(
            'login' => $this->user_login,
            'password' => $this->user_password,
            'command' => 'viber_send',
            'message' => array(
                'msg' => array()
            )
        );

        if ($date_send !== false) {

            $postdata['date_send'] = $date_send;

        }

        if (count($viber_rich) > 0) {

            $postdata['viber_image'] = $viber_rich['viber_image'];
            $postdata['viber_button_caption'] = $viber_rich['viber_button'];
            $postdata['viber_button_url'] = $viber_rich['viber_url'];

        }

        if (count($sms_resend) > 0) {

            $postdata['viber_sms_resend'] = 1;
            $postdata['viber_sms_text'] = $sms_resend['sms_text'];
            $postdata['viber_sms_sender'] = $sms_resend['sms_sender'];

        }

        if (!empty($this->subscribe_name)) {

            $postdata['name'] = $this->subscribe_name;

        }

        if (!empty($this->webhook_url)) {

            $postdata['webhook_url'] = $this->webhook_url;

        }

        if ($this->error == 0) {

            foreach ($tels as $v_tel) {

                if (count($sms_resend) > 0) {

                    $postdata['message']['msg'][] = array(
                        'recepient' => $v_tel,
                        'validity_period' => $message_live,
                        'viber_text' => $message_text,
                        'viber_sms_text' => $sms_resend['sms_text'],
                        'sender' => $this->sender_viber
                    );

                } else {

                    $postdata['message']['msg'][] = array(
                        'recepient' => $v_tel,
                        'validity_period' => $message_live,
                        'viber_text' => $message_text,
                        'sender' => $this->sender_viber
                    );

                }

            }

            $json_postdata = json_encode($postdata, JSON_UNESCAPED_UNICODE);

            $res = $this->postContent($url, $json_postdata, 'text/json');

            $res = $this->getResult($res, 'json_viber_send');

            return array(
                'error' => $this->error,
                'error_messages' => $this->error_messages,
                'result' => $res,
                'type' => 'json'
            );

        }

    }

    public function getSenders()
    {

        $url = $this->api_url . 'api/v1.2/json';

        $postdata = array(
            'login' => $this->user_login,
            'password' => $this->user_password,
            'command' => 'get_senders'
        );

        $json_postdata = json_encode($postdata, JSON_UNESCAPED_UNICODE);

        $res = $this->postContent($url, $json_postdata, 'text/json');

        $res = $this->getResult($res, 'json_senders');

        return array(
            'error' => $this->error,
            'error_messages' => $this->error_messages,
            'result' => $res
        );

    }

    public function getTemplates()
    {

        $url = $this->api_url . 'api/v1.2/json';

        $postdata = array(
            'login' => $this->user_login,
            'password' => $this->user_password,
            'command' => 'get_templates'
        );

        $json_postdata = json_encode($postdata, JSON_UNESCAPED_UNICODE);

        $res = $this->postContent($url, $json_postdata, 'text/json');

        $res = $this->getResult($res, 'json_templates');

        return array(
            'error' => $this->error,
            'error_messages' => $this->error_messages,
            'result' => $res
        );

    }

    private function getResult($result, $rtype, $params = array())
    {

        $f_res = false;

        if ((int)$result['curl_error'] == 0) {

            switch ($rtype) {

                case 'plain_viber_send' :
                {

                    if ((int)$result['curl_result'] < 0) {

                        $this->error = 1;
                        $this->error_messages[] = $this->getErrorByCode($result['curl_result']);

                    } else {

                        $f_res[] = array(
                            'message_code' => (int)$result['curl_result'],
                            'message_count' => 0,
                            'message_error' => 0,
                            'messaqe_error_code' => 0,
                            'message_error_msg' => '',
                            'operator_code' => 0
                        );

                    }
                    break;

                }

                case 'plain_send' :
                {

                    if ((int)$result['curl_result'] < 0) {

                        $this->error = 1;
                        $this->error_messages[] = $this->getErrorByCode($result['curl_result']);

                    } else {

                        $f_res[] = array(
                            'sms_code' => (int)$result['curl_result'],
                            'sms_count' => 0,
                            'sms_error' => 0,
                            'sms_error_code' => 0,
                            'sms_error_msg' => '',
                            'operator_code' => 0
                        );

                    }
                    break;

                }

                case 'plain_balance' :
                {

                    if ((int)$result['curl_result'] < 0) {

                        $this->error = 1;
                        $this->error_messages[] = $this->getErrorByCode($result['curl_result']);

                    } else {

                        $f_res = $result['curl_result'];

                    }
                    break;

                }

                case 'json_send' :
                {

                    $f_res = array();

                    $json_res = json_decode($result['curl_result']);

                    if (isset($json_res->error)) {

                        $this->error = 1;
                        $this->error_messages[] = $this->getErrorByCode($json_res->error);

                    } elseif (isset($json_res->message)) {

                        if (count($json_res->message->msg) > 0) {

                            foreach ($json_res->message->msg as $k => $v_msg) {

                                $f_res[] = array(
                                    'sms_code' => (int)$v_msg->sms_id,
                                    'sms_count' => (int)$v_msg->sms_count,
                                    'sms_error' => ((int)$v_msg->sms_id == 0) ? 1 : 0,
                                    'sms_error_code' => ((int)$v_msg->sms_id == 0) ? $v_msg->error_code : 0,
                                    'sms_error_msg' => ((int)$v_msg->sms_id == 0) ? $this->getErrorByCode($v_msg->error_code) : '',
                                    'operator_code' => (int)$v_msg->operator,
                                    'sms_tel' => $v_msg->recipient
                                );

                            }

                        }

                    } else {

                        $this->error = 1;
                        $this->error_messages[] = $this->getErrorByCode(-10);

                    }

                    break;

                }

                case 'json_viber_send' :
                {

                    $f_res = array();

                    $json_res = json_decode($result['curl_result']);

                    if (isset($json_res->error)) {

                        $this->error = 1;
                        $this->error_messages[] = $this->getErrorByCode($json_res->error);

                    } elseif (isset($json_res->message)) {

                        if (count($json_res->message->msg) > 0) {

                            foreach ($json_res->message->msg as $k => $v_msg) {

                                $f_res[] = array(
                                    'message_code' => (int)$v_msg->message_id,
                                    'message_count' => (int)$v_msg->message_count,
                                    'message_error' => ((int)$v_msg->message_id == 0) ? 1 : 0,
                                    'message_error_code' => ((int)$v_msg->message_id == 0) ? $v_msg->error_code : 0,
                                    'message_error_msg' => ((int)$v_msg->message_id == 0) ? $this->getErrorByCode($v_msg->error_code) : '',
                                    'operator_code' => (int)$v_msg->operator,
                                    'message_tel' => $v_msg->recipient
                                );

                            }

                        }

                    } else {

                        $this->error = 1;
                        $this->error_messages[] = $this->getErrorByCode(-10);

                    }

                    break;

                }

            }

        } else {

            $this->error = 1;
            $this->error_messages[] = 'Ошибка выполнения запроса к API серверу. Код ошибки CURL - ' . $result['curl_error'] . '. Пояснение по ошибке: ' . $result['curl_error_message'];

        }

        return $f_res;

    }

    private function getErrorByCode($error_code)
    {

        $f_res = '';

        switch ($error_code) {

            case '-1' :
                $f_res = 'Недостаточно средств';
                break;
            case '-2' :
                $f_res = 'Неверный логин или пароль, или другая ошибка аутентификации.';
                break;
            case '-3' :
                $f_res = 'Отсутствует текст сообщения';
                break;
            case '-4' :
                $f_res = 'Некорректное значение номера получателя';
                break;
            case '-5' :
                $f_res = 'Некорректное значение отправителя сообщения';
                break;
            case '-6' :
                $f_res = 'Отсутствует логин';
                break;
            case '-7' :
                $f_res = 'Отсутствует пароль';
                break;
            case '-10' :
                $f_res = 'Ошибка целосности или валидности пакета';
                break;
            case '-11' :
                $f_res = 'Некорректное значение ID сообщения';
                break;
            case '-12' :
                $f_res = 'API не включено в ЛК клиента на странице "SMS-рассылка" - "Рассылка по API"';
                break;
            case '-13' :
                $f_res = 'Заблокировано';
                break;
            case '-14' :
                $f_res = 'Запрос не укладывается в ограничения по времени на отправку SMS (ограничения по времени устанавливаются в разделе "Мои настройки" – вкладка "Персональные настройки")';
                break;
            case '-15' :
                $f_res = 'Некорректное значение даты отправки рассылки';
                break;
            case '-16' :
                $f_res = 'Нет шаблонов';
                break;
            case '-17' :
                $f_res = 'Нет ни одного отправителя, которые доступны для отправки SMS';
                break;
            case '-18' :
                $f_res = 'Не найден шаблон по коду';
                break;
            case '-19' :
                $f_res = 'При подтверждении номера телефона SMS-кодом не передано значение хэш для проверки';
                break;
            case '-20' :
                $f_res = 'При подтверждение номера телефона SMS-кодом не передано значение кода для проверки';
                break;
            case '-21' :
                $f_res = 'Превышено разрешенное количество проверок по одному номеру телефона';
                break;
            case '-22' :
                $f_res = 'При подтверждение номера телефона SMS-кодом текст SMS не укладывается в длину 1 SMS';
                break;
            case '-23' :
                $f_res = 'Введённый код неверен. Введите правильный код или отправьте еще одно SMS и повторите ввод кода';
                break;
            case '-24' :
                $f_res = 'URL вебхука не прошел валидацию.';
                break;
            case '-25' :
                $f_res = 'Не корректно передан список телефонов для отправки HLR.';
                break;
            case '-26' :
                $f_res = 'Не корректно передан список телефонов для проверки статусов HLR.';
                break;
            case '-27' :
                $f_res = 'Ваш аккаунт заблокирован. Обратитесь, пожалуйста, в службу технической поддержки.';
                break;
            case '-28' :
                $f_res = 'Текст Viber-сообщения больше 1000 символов.';
                break;
            case '-29' :
                $f_res = 'При передаче рекламного Viber-сообщения не указаны все три обязательных параметра (изображение, текст кнопки, ссылку на сайт).';
                break;
            case '-30' :
                $f_res = 'Ссылка на сайт в Viber-сообщении не проходит проверку на подлинность.';
                break;
            case '-31' :
                $f_res = 'Недопустимый формат изображения в Viber-сообщении (допустимы только jpg, jpeg, png).';
                break;
            case '-32' :
                $f_res = 'В каскадной рассылке Viber+SMS указано некорректное значение отправителя SMS.';
                break;
            case '-33' :
                $f_res = 'В каскадной рассылке Viber+SMS указан некорректно текст SMS.';
                break;
            case '-34' :
                $f_res = 'Не найден уникальный номер Viber-сообщения.';
                break;
            case '-35' :
                $f_res = 'Вы превысили максимальное количество SMS по API PLAIN, установленное вами на странице «SMS-рассылка» → «Рассылка по API» → блок «Ограничения по количеству на отправку SMS по API PLAIN»';
                break;
            case '-36' :
                $f_res = 'Вы превысили максимальное количество SMS по API PLAIN на 1 номер абонента, установленное вами на странице «SMS-рассылка» → «Рассылка по API» → блок «Ограничения по количеству на отправку SMS по API PLAIN»';
                break;
            case '-37' :
                $f_res = 'Вы превысили максимальное количество SMS по API PLAIN на 1 номер с одинаковым текстом SMS, установленное вами на странице «SMS-рассылка» → «Рассылка по API» → блок «Ограничения по количеству на отправку SMS по API PLAIN»';
                break;
            case '-100' :
                $f_res = 'Количество абонентов не равно количеству текстов SMS, которые переданы. Надо либо передавать 1 текст сообщения, либо количество равное количеству абонентов';
                break;
            case '-101' :
                $f_res = 'Количество абонентов не равно количеству шаблоново SMS, которые переданы. Надо либо передавать 1 шаблон, либо количество равное количеству абонентов';
                break;

        }

        return $f_res;

    }

    public function setModeApi($api_mode)
    {

        switch ($api_mode) {

            case 'xml' :
                $this->api_mode = 'xml';
                break;
            default :
                $this->api_mode = 'json';
                break;

        }

    }

    public function setWebhookUrl($url)
    {
        $this->webhook_url = $url;

        return true;
    }

    public function setSubscribeName($name)
    {
        $this->subscribe_name = strip_tags($name);

        return true;
    }

    public function setUrl($url)
    {
        $this->api_url = $url;

        return true;
    }

    public function setSenderSMS($sender)
    {
        $this->sender_SMS = $sender;

        return $this;
    }

    public function setSenderViber($sender)
    {
        $this->sender_viber = $sender;

        return $this;
    }

    public function getSenderSMS()
    {
        return $this->sender_SMS;
    }

    public function getSenderViber()
    {
        return $this->sender_viber;
    }

    public function setVendor($vendor)
    {
        $this->vendor = $vendor;

        return true;
    }

}