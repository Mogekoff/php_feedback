# PHP Feedback
## Входное задание на программу сетевого IT-университета ПГНИУ на программу "PHP. Разработка на фреймворке Laravel"

Проект представляет собой простое приложение на языке программирования PHP в виде Rest-API сервиса.
* Реализовано на чистом PHP  8.0.8 (последняя версия на 11.09.2021)
* Точкой входа является файл **index.html**. Задана в конф. файле **nginx.conf**
* Предусмотрен конф. файл с данными для БД - **credential.json**
* Предусмотрен ответ от бекенда в формате JSON

Стек технологий: HTML/CSS, PHP 8.0.8, PostgreSQL, Nginx, Docker

### Формат принимаемых данных:

На точке входа приложения у пользователя запрашиваются три поля: E-mail, номер телефона и сообщение.

1) **E-mail** должен быть синтаксически верен. Обязательно к заполнению. Правильность написанного e-mail'a проверяется на 
бэкенде регулярным 
выражением: `/^\w+@\w+\.\w+$/`

2) **Номер телефона** аналогично e-mail'у должен быть задан синтактически правильно. Обязательно к заполнению. 
   Принимается строкой без пробелов, скобок и дефисов. Может начинаться на +7, 7, 8. Проверяется 
рег. выражением: `/^\+7\d{10}$|^[7-8]\d{10}$/`

3) **Сообщение** может содержать от 0 до 1000 символов включительно. Необязательно к заполнению. Для исключения 
SQL-инъекций обрабатывается следующими функциями PHP: `htmlspecialchars()`, `stripslashes()`, `trim()`, `pg_escape_string()`.
Последняя из модуля для работы с базой данных PostgreSQL.

### Формат ответа от бекенда:
Ответ в виде строки JSON с тремя полями:
1) **status** - краткий статус транзакции. Два значения - OK, ERROR
2) **status_code** - код ответа. Три значения: 200, 422 (сервер принял запрос, но принятые данные неудовлетворительные), 
   500 (ошибка на стороне сервера, напр. не удалось связаться с БД)
3) **status_text** - подробное описание статуса транзакции

Пример ответа бэкенда на правильно составленный запрос (вх. данные: 88005553535, email@example.com, Hello World!)
```json
{
  "status": "OK",
  "status_code": 200,
  "status_text": "Запрос получен и сохранен."
}
```
Пример ответа на неправильный запрос (вх. данные: 12345, email@example.com, Hello World!)
```json
{
  "status": "ERROR",
  "status_code": 422,
  "status_text": "Номер телефона указан в неправильном формате."
}
```
Остальные варианты ответов можно посмотреть в коде в файле **message.php**

### Установка:
Для начала на целевой машине установите пакеты docker, docker-compose, git:
```bash
sudo apt install git docker docker-compose
```
Далее, необходимо клонировать этот репозиторий и зайти в его папку:
```bash
git clone https://github.com/Mogekoff/php_feedback && cd php_feedback
```
Затем, необходимо запустить цепочку контейнеров с помощью программы docker-compose:
```bash
sudo docker-compose up
```

Далее, можно будет открыть в браузере адрес http://localhost и воспользоваться приложением.

### Примечания:
1) В проекте используется СУБД PostgreSQL. Она устанавливается docker-compose'ром. Дамп таблицы находится в файле
   **database_dump.sql**. При первом запуске СУБД она восстанавливает свою структуру из этого дампа.
2) Необходимые модули и расширения PHP для работы с PostgreSQL уже включены в образ PHP в файле **Dockerfile**
3) В проекте используется сервер Nginx. Он уже настроен на работу на localhost на 80-м порту. Точкой входа в нем 
   прописан файл **index.html**
4) При желании, можно удостовериться в правильности записи данных в БД. Она доступна по адресу localhost:5432 через 
   программы psql или PgAdmin (скачиваются с оф. сайта https://www.postgresql.org) Данные для аутентификации 
   находятся в файле **credential.json**
5) Подключение к базе данных производится в файле db.php. Там же во 2-й строчке выключен вывод ошибок PHP.