# задача
/task.txt

-------

**запуск**

`docker-compose up -d`

в браузере http://localhost:8082/

-------
<b> примечания</b>

нет репо в гите
использован прием по настройкам - метода в классе 

подробности как работает в файле index.php

<b>рефакторинг</b>

- в Ифах убрать Элсы. ретурны только оставить
- коменты убрать лишние
- принты убрать все
- клиентский код в класс. и между ними связь через DI
- вывод ИПшников в отдельный метод
- эксепшены - для функции ДНС наверное только

<b>доработки</b>
- режим отладки продумать - типо флаг тестовый вызов. с выводом ошибок
- доп расширения - черный/белый список доменов
- доп расширения универсальными правилами - тип, значение
- - символы которые нельзя, символы
- - символы которые обязательно должны быть, символы
- - логи как смотреть