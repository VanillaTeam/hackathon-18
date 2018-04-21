<?php
function score() {
    global $DB;
    $count = $DB->GetUserMoney($_SESSION['logged_user']);
    return 'У Вас ' . $count . ' рублей на счету.';
}
function help() {
    global $DB;
    $result = $DB->GetBotHelp();
    $str = '';
    foreach ($result as $row) {
        $str .= str_replace('{?[0-9]+}?', '<b><i><число></i></b>', $row['mask']) .
        ': ' . $row['description'] . '</p><p class="bot-msg">';
    };
    return substr($str, 0, count($str)-20);

}
function card($params) {
    if (!isset($params[0])) {
        return 'Не задан номер карты!';
    }
    else if (!isset($params[1])) {
        return 'Не задан лимит!';
    }
    else {
        global $DB;
        if ($DB->UpdateCard($params[0], $_SESSION['logged_user'], NULL, NULL, $params[1])) {
            return 'Лимит карты ' . $params[0] . ' изменен на ' . $params[1] . ' рублей.';
        }
        else {
            return 'Карта не найдена!';
        }
    }
}
function block_card($params) {
    if(!isset($params[0])) {
        return 'Не задан номер карты';
    }
    global $DB;
    if ($DB->UpdateCard($params[0], $_SESSION['logged_user'], NULL, NULL, NULL, 1) ) {
        return 'Карта ' . $params[0] . ' успешно заблокирована.';
    }
    else {
        return 'Карта не найдена или не может быть заблокирована!';
    }
}

function unblock_card($params) {
    if(!isset($params[0])) {
        return 'Не задан номер карты';
    }
    global $DB;
    if ($DB->UpdateCard($params[0], $_SESSION['logged_user'], NULL, NULL, NULL, 0)) {
        return 'Карта ' . $params[0] . ' успешно разблокирована.';
    }
    else {
        return 'Карта не найдена или не может быть разблокирована!';
    }
}

function notifications_off() {
    return 'СМС-уведомления успешно отключены.';
}

function notifications_on() {
    return 'СМС-уведомления успешно подключены.';
}
?>
