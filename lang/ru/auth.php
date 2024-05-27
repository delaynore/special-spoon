<?php

use function Laravel\Prompts\form;

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed' => 'Неверные учетные данные.',
    'password' => 'Предоставленный пароль неверный.',
    'throttle' => 'Слишком много попыток входа. Пожалуйста, попробуйте еще раз через :seconds секунд.',
    'confirm' => 'Подтвердить',
    'confirm-password' => [
        'title' => 'Это действие требует подтверждения. Введите ваш пароль.',
        'password' => [
            'label' => 'Пароль',
            'placeholder' => '••••••••',
        ]
    ],
    'forgot-password' => [
        'title' => 'Забыли пароль?',
        'description' => 'Не волнуйтесь! Просто введите свой адрес электронной почты, и мы пришлем вам код для сброса пароля!',
        'email' => [
            'label' => 'Ваш email',
            'placeholder' => 'example@mail.ru',
        ],
        'button' => 'Сбросить пароль',
    ],
    'login' => [
        'title' => 'Вход',
        'no-account' => 'Нет аккаунта?',
        'to-register' => 'Зарегистрироваться',
        'button-login' => 'Войти',
        'remember' => 'Запомнить меня',
        'forgot-password' => 'Забыли пароль?',
        'password' => [
            'label' => 'Пароль',
            'placeholder' => '••••••••',
        ],
        'email' => [
            'label' => 'Ваш email',
            'placeholder' => 'example@mail.ru',
        ],
    ],
    'register' => [
        'title' => 'Регистрация',
        'have-account' => 'Уже есть аккаунт?',
        'to-login' => 'Войти',
        'button-register' => 'Зарегистрироваться',
        'name' => [
            'label' => 'Имя',
            'placeholder' => 'Ваше прекрасное имя',
        ],
        'password' => [
            'label' => 'Пароль',
            'placeholder' => '••••••••',
        ],
        'confirm-password' => [
            'label' => 'Пароль',
            'placeholder' => '••••••••',
        ],
        'email' => [
            'label' => 'Ваш email',
            'placeholder' => 'example@mail.ru',
        ],
    ],
    'reset-password' => [
        'title' => 'Сброс пароля',
        'password' => [
            'label' => 'Пароль',
            'placeholder' => '••••••••',
        ],
        'confirm-password' => [
            'label' => 'Пароль',
            'placeholder' => '••••••••',
        ],
        'email' => [
            'label' => 'Ваш email',
            'placeholder' => 'example@mail.ru',
        ],
        'button' => 'Сбросить пароль',
    ],
    'verify' => [
        'main-message'=> 'Спасибо за регистрацию! Прежде чем начать, могли бы вы подтвердить свой адрес электронной почты, нажав на ссылку, которую мы только что отправили вам? Если вы не получили письмо, мы с радостью отправим вам еще одно.',
        'confirm-send' => 'На адрес электронной почты, который вы указали при регистрации, выслана новая ссылка для подтверждения.',
        'again' => 'Отправить письмо с подтверждением повторно',
        'logout' => 'Выйти',
    ]
];
