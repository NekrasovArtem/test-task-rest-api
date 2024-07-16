# Тестовое задание REST API

Тестовое задание. Задача: реализовать методы REST API на Laravel.

## Оглавление

-   [Установка](#установка)
-   [Документация](#документация)
-   [Обработка ошибок](#обработка-ошибок)

## Установка

<!-- ### Установка на OpenServer

1. Скопируйте проект с репозитория
2. Перейдите в папку проекта
3. Установите зависимости -->

## Документация

### Регистрация пользователя

Запрос регистрации нового пользователя. Принимает параметры:

1.  name - обязательное поле, строка;
2.  surname - обязательное поле, строка;
3.  email - обязательное поле, email, уникальный в бд;
4.  birth_date - обязательное поле, дата, формат даты yyyy-mm-dd;
5.  password - обязательное поле, минимум 8 символов, должен содержать: 1 цифру, 1 маленький и заглавный символ, 1 специальный символ.

Пример запроса:

```sh
curl -X POST http://test-task-rest-api/api/register -d {
    'name': 'Oleg',
    'surname': 'Ivanov',
    'email': 'test@email.com',
    'birth_date': '2000-01-11',
    'password': 'QWErty123$'
}
```

Пример ответа:

```json
{
    "message": "Registration successfuly"
}
```

### Авторизация пользователя

Запрос на авторизацию пользователя. Принимает параметры:

1.  email - обязательное поле, email;
2.  password - Обязательное поле.

В ответе возвращает токен для авторизации.

Пример запроса:

```sh
curl -X POST http://test-task-rest-api/api/auth -d {
    'email': 'test@email.com',
    'password': 'QWErty123$'
}
```

Пример ответа:

```json
{
    "message": "Authorization successfuly",
    "token": "some token"
}
```

### Получение информации о пользователе

Запрос на получение информации о пользователе. Для выполнения запроса необходим Bearer токен авторизованного пользователя.
В ответе возвращает id, имя, фамилию, почту и дату рождения пользователя.

Пример запроса:

```sh
curl -X GET http://test-task-rest-api/api/user -H "Authorization: Bearer <ACCESS_TOKEN>"
```

Пример ответа:

```json
{
    "data": {
        "id": 1,
        "name": "Oleg",
        "surname": "Ivanov",
        "email": "test@example.com",
        "birth_date": "2000-01-11"
    }
}
```

### Изменение информации пользователя

Запрос на изменение информации о пользователе. Принимает параметры: name, surname, birth_date, email, password.
Можно вписать как один параметр, так и все. Для выполнения запроса необходим Bearer токен авторизованного пользователя.

Пример запроса:

```sh
curl -X PUT http://test-task-rest-api/api/user -H 'content-type: application/x-www-form-urlencoded' -H "Authorization: Bearer <ACCESS_TOKEN>" -d {
    'name': 'new name',
    'surname': 'new surname',
    'birth_date': 'new date',
    'email': 'new@example.com'
    'password': 'new password',
}
```

Пример ответа:

```json
{
    "message": "User`s information updated"
}
```

### Удаление пользователя

Запрос на удаление пользователя из бд. Для выполнения запроса необходим Bearer токен авторизованного пользователяю

Пример запроса:

```sh
curl -X DELETE http://test-task-rest-api/api/user -H "Authorization: Bearer <ACCESS_TOKEN>"
```

Пример ответа:

```json
{
    "message": "User deleted"
}
```

## Обработка ошибок

### 403 - Ошибка авторизации

Пример ответа:

```json
{
    "message": "Login failed"
}
```

### 404 - Не найдено

Пример ответа:

```json
{
    "message": "Not found"
}
```

### 422 - Ошибка валидации

Пример ответа:

```json
{
    "message": "Validation error",
    "errors": {
        "some_field": [
            "The some_field field is required"
        ],
        ...
    }
}
```
