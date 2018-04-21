<?php
/**
 * File: db.php
 *
 * @copyright 2018 Vanilla
 * @author Vanilla Team
 * @version 0.1
 * @package Hackathon
 *
 */

// Вывод числа (включая 0)
function i2s($int) {
    return ($int == 0 ? '0' : $int);
}

// Вывод значения bool
function b2s($bool) {
    return ($bool ? 'Да' : 'Нет');
}

// Добавление пользователя
echo 'Пользователь создан: '.b2s(           $DB->AddUser('test', 'pass',
    'name', '1234567890', 'email@mail.ru', '9269211023', 'г. Москва, Кремль')                           ).'<br>';
echo 'Создать повторно: '.b2s(              $DB->AddUser('test', 'pass',
    'name', '1234567890', 'email@mail.ru', '9269211023', 'г. Москва, Кремль')                           ).'<br>';

// Проверка логина / пароль
echo 'Правильные данные: '.b2s(             $DB->GetUserID('test', 'pass')                              ).'<br>';
echo 'Неправильный пароль: '.b2s(           $DB->GetUserID('test', 'pass2')                             ).'<br>';
echo 'Неправильный логин: '.b2s(            $DB->GetUserID('test2', 'pass')                             ).'<br>';

// Обновление пароля
echo 'ID пользователя: '.i2s( $id =         $DB->GetUserID('test')                                      ).'<br>';
echo 'ID никого: '.i2s(                     $DB->GetUserID('test2')                                     ).'<br>';
echo 'Обновили пользователя: '.b2s(         $DB->UpdateUser($id, 'name',
    '0987654321', 'new@mail.ru', '9053332211', 'г. Москва, ул. Тест')                                   ).'<br>';
echo 'Обновили пароль: '.b2s(               $DB->UpdateUserPassword($id, 'pass2')                       ).'<br>';
echo 'Старый пароль: '.b2s(                 $DB->GetUserID('test', 'pass')                              ).'<br>';
echo 'Новый пароль: '.b2s(                  $DB->GetUserID('test', 'pass2')                             ).'<br>';

// Удалить пользователя
echo 'Удалить пользователя: '.b2s(          $DB->RemoveUser($id)                                        ).'<br>';
echo 'Повторное удаление: '.b2s(            $DB->RemoveUser($id)                                        ).'<br>';
echo 'Проверить последний пароль: '.b2s(    $DB->GetUserID('test', 'pass2')                             ).'<br>';

// API сообщений
echo 'Список команд:<br>';
$commands = $DB->GetBotHelp();
foreach ($commands as $command) {
    echo $command['mask'] . '; ' . $command['description'] . '<br>';
}

echo 'Информация о команде: ';
$command = $DB->GetMsgInfo('пополнить счет на 500');
echo $command['mask'] . '; ' . $command['type'] . '; ' . $command['extra'] . '<br>';

echo 'Информация о команде: ';
$command = $DB->GetMsgInfo('изменить лимит карты 1234 на 100');
echo $command['mask'] . '; ' . $command['type'] . '; ' . $command['extra'] . '<br>';

$DB->AddCard(53, 1, 100);

?>