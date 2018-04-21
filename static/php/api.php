<?php
require_once '../../config.php';
require_once 'functions.php';

//////func/////

function strpos_all($haystack, $needle) {
    $offset = 0;
    $allpos = array();
    while (($pos = strpos($haystack, $needle, $offset)) !== FALSE) {
        $offset   = $pos + 1;
        $allpos[] = $pos;
    }
    return $allpos;
}
function splitText($regularExpr, $text) {
    return preg_split($regularExpr, $text, -1, PREG_SPLIT_NO_EMPTY);
}
function getContentFromMsg($text, $msg) {
    $result = [$msg];
    for ($i = 0; $i < count($text); $i++)
    {
        $temp = explode($text[$i], end($result), 2);

        if (empty($temp[0])) {
            $result[count($result) - 1] = $temp[1];
        }
        else if (empty($temp[1])) {
            $result[count($result) - 1] = $temp[0];
        }
        else {
            $result[count($result) - 1] = $temp[0];
            array_push($result, $temp[1]);
        }
    }
    return $result;
}

function substituteValues ($values, $message) {
    $numOfValues = substr_count($message, '$');
    str_replace('0', $values[0], $message);
    for ($i = 0; $i < $numOfValues; $i++) {
        $message = str_replace('$'.$i, $values[$i], $message);
    }
    return $message;
}
//////main//////


if(!isset($_GET['msg'])){
    echo 'Некорректный запрос';
    return;
}
$msg = mb_strtolower($_GET['msg']);
$data = $DB->GetMsgInfo($msg);
if (!isset($data['type'])) {
    $result['type'] = 2;
    $result['extra'] = 'Команда не найдена!';
    echo json_encode($result);
}
//1 type
else if($data['type'] == 1){
    $parsedMaskText = splitText('/\{[^\}]*\}\?/', $data['mask']);
    $values = getContentFromMsg($parsedMaskText, $msg);
    $address = substituteValues($values, $data['extra']);

    $result['type'] = 1;
    $result['extra'] = $address;
    echo json_encode($result);
}
// 2 type
else if($data['type'] == 2){
    $parsedMaskText = splitText('/\{[^\}]*\}\?/', $data['mask']);
    $values = getContentFromMsg($parsedMaskText, $msg);
    $address = substituteValues($values, $data['extra']);
    $params = explode('&', $address);
    $name = array_shift($params);

    $result['type'] = 2;
    $result['extra'] = $name($params);
    echo json_encode($result);
}
?>
