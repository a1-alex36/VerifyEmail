<?php


namespace Otus\Hw7\Emails;


class VerifyEmail
{
    const OPTIONS = [
            "isValid" => true,
            "isDNS" => false,
            "addRegularExp" => null,
        ];

    public array $options;

    public function __construct($options = [])
    {
        //var_dump($options);
        //$this->options = [...self::OPTIONS, ...$options];
        $this->options = array_merge(self::OPTIONS, $options);
    }

    public function verifyEmail($email, $options = []) : bool
    {
        //print_r($options);
        //print_r($this->options);
        //die;
        $temp_options = array_merge($this->options, $options);
        //$email
        var_dump($temp_options);
        $res = false;
        foreach ($temp_options as $option => $value) {
            //var_dump($option); var_dump($value);
            if ($value === true) {
                //echo "+" . $option . PHP_EOL;
                //var_dump($option);
                if (!$this->$option(trim($email))) { // call as string method
                    echo 'NO-' . $option . ' -- '. $email;
                    return false;
                }
            }
            /*
            if ($option["isDNS"] === true) {
                if (!$this->isDNS($email)) {
                    return false;
                }
                //$res = $this->isDNS($email);
            }*/
        }
        // dop exp
        //var_dump($temp_options["addRegularExp"]); die;
            if ($temp_options["addRegularExp"] !== null) {
                if (!$this->addRegularExp(trim($email), $temp_options["addRegularExp"])) {
                    return false;
                }
                //$res = ;
            }
            //return false;

        return true;
    }

    private function isValid($email) : bool
    {
        //var_dump(($email)); die;
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }

    private function isDNS($email) : bool
    {
        $domain = substr(strrchr($email, "@"), 1);
        echo $domain;
        $res = getmxrr($domain, $mx_records, $mx_weight);
        if (false == $res || 0 == count($mx_records) || (1 == count($mx_records) && ($mx_records[0] == null  || $mx_records[0] == "0.0.0.0" ) ) ){
//Проверка не пройдена - нормальные mx-записи не обнаружены
            //echo "No MX for domain: $domain";
            return false;
        } else {
//Проверка пройдена, живая MX-запись на домене есть, и почта на нём работает
            //echo "It seems that we have qualify MX-records for domain: $domain";
            return true;
        }
    }

    private function addRegularExp($email, $exp) : bool
    {
        if (preg_match($exp, $email)) {
            //echo "Адрес указан корректно.";
            return true;
        } else {
            //echo "Адрес указан не правильно.";
            return false;
        }
    }
}