<?php

require_once "../vendor/autoload.php";

use Otus\Hw7\Emails\VerifyEmail;

echo "77788_8 <pre>";
/*
 * итого
 * при обращении к http://localhost:8082/
 * меняется сервер каждый раз. т.к. по умолчанию Раунт РОбин вариант балансировки
 *

 как должно работать при обращении к
 * http://localhost:8085/  http://localhost:8086/  - не должны быть доступны. для этого не открываем порты в докер композ файле.

к этим портам доступ только внутри сети. за это отвечает настройка нжинкса бекендов - listen 8085;  listen 8086;

вопрос по сервису пхп. получается он всеравно один. php:9000; ТОДО ????
к нему все бекенды нжинксы обращаются, хотя их несколько
можно поднимать второй видимо с таким же волюмом
может быть тут поможет скалирование - несколько однаковых пхп сервисов.
но как его замутиить в докер композе как настройку, а не как в команде запуска.
или нжинкс и пхп делать на одном сервисе/контейнере. +по юникс сокету их связь

логи пишутся в обратном порядке. - сперва ответ от самого дальнего сервиса, потом выше, потом самый высокий
пхп - бекенд - балансер
----------------------------

- реализация фальтрации емейл встроенной в пхп функцией по валидации адреса
функция filter_var с ключем FILTER_VALIDATE_EMAIL
https://www.opennet.ru/docs/RUS/inet_server/servers_glava2_4.html

- реализация фальтрации емейл встроенной в пхп функцией по наличию МХ записи у домена
getmxrr — Получает записи MX, соответствующие переданному доменному имени хоста

варианты использования:
//опции по умолчанию
$obj = new VerifyEmail();
$obj->verifyEmail($email)

//опции по умолчанию, но возможен отдельный вызов с другими опциями
$obj = new VerifyEmail();
$obj->verifyEmail($email, $option)

//опции кастомные на весь объект, на все вызовы. все время жизни объекта
$obj = new VerifyEmail($option);
$obj->verifyEmail($email)

//опции кастомные на весь объект, на все вызовы. все время жизни объекта
// + отдельный вызов с другими кастромными опциями
$obj = new VerifyEmail($option);
$obj->verifyEmail($email, $option)
-------------------------------

 * */
echo "SERVER = " . $_SERVER["SERVER_ADDR"] . ":" . $_SERVER["SERVER_PORT"] . PHP_EOL . PHP_EOL;

//var_dump($_SERVER);

$file = "../emails.txt"; //  path
//file_get_contents — Читает содержимое файла в строку
//$emails = file_get_contents($file);
//file — Читает содержимое файла и помещает его в массив
$emails = file($file);
//print_r($emails); die;
$isValidEmails = [];
$isNotValidEmails = [];

// dop regular. до @ нельзя цифру 9
$myRegularExp = '/^(?:[a-z0-8]+(?:[-_.]?[a-z0-8]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i';
$option = ["isValid" => true,
            "isDNS" => false,
            "addRegularExp" => $myRegularExp];

$obj = new VerifyEmail();
//$obj = new VerifyEmail($option);

foreach ($emails as $email) {
    if(!$obj->verifyEmail($email, $option)) {
        $isNotValidEmails[] = $email;
        //echo $email . " --" . PHP_EOL;
    } else {
        $isValidEmails[] = $email;
        //echo $email . " ++" . PHP_EOL;
    }
}

//get email from file
$listEmails = [$isValidEmails, $isNotValidEmails];

var_dump($listEmails);