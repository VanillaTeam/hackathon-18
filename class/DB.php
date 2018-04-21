<?php
/**
 * File: DB.php
 *
 * @copyright 2018 Vanilla
 * @author Vanilla Team
 * @version 0.1
 * @package Hackathon
 *
 */

class DB
{	
	private $mysqli_ = null;
	
	// Конструктор
	public function __construct($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME)
	{
		// Подключение к бд
		$this->mysqli_ = new mysqli($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);		
		if ($this->mysqli_->connect_error) {
			throw new Exception('Ошибка подключения ' . $this->mysqli_->connect_errno . ': ' . $this->mysqli_->connect_error);
		}
		
		// Изменение набора символов на utf8
		if (!$this->mysqli_->set_charset('utf8')) {
			throw new Exception('Ошибка при загрузке набора символов utf8: ' . $this->mysqli_->error);
		}
	}
	
	// Деструктор
	public function __destruct() 
	{
		// Отключнение от бд
		$this->mysqli_->close();
	}
	
	// Экранирование строки
	private function Esc_($str)
	{
		if (get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		$str = $this->mysqli_->real_escape_string($str);

		return $str;
	}
	
	// Запрос с результатом в виде массива
	private function ArrayQuery_($query) 
	{
		if ($mysqli_result = $this->mysqli_->query($query)) {
			$result = [];
			while($row = mysqli_fetch_array($mysqli_result, MYSQLI_ASSOC)) {
				array_push($result, $row);
			}			
			$mysqli_result->close();
			return $result;
		}
		else {
			global $CONSOLE;
			$CONSOLE->Error('Ошибка выполнения запроса ' . $query . '\n' . $this->mysqli_->errno . ': ' . $this->mysqli_->error);
			return [];
		}
	}
	
	// Запрос с результатом в виде массива первых $top строчек
	private function TopArrayQuery_($query, $top) 
	{
		if ($mysqli_result = $this->mysqli_->query($query)) {
			$result = [];
			for ($i = 0; $i < $top; ++$i) {
				$row = mysqli_fetch_array($mysqli_result, MYSQLI_ASSOC);
				if ($row) {
					array_push($result, $row);
				}
				else {
					break;
				}
			}
			$mysqli_result->close();
			return $result;
		}
		else {
			global $CONSOLE;
			$CONSOLE->Error('Ошибка выполнения запроса ' . $query . '\n' . $this->mysqli_->errno . ': ' . $this->mysqli_->error);
			return [];
		}
	}
	
	// Запрос на получение первой сроки
	private function RowQuery_($query) 
	{
		if ($mysqli_result = $this->mysqli_->query($query)) {
			$result = mysqli_fetch_array($mysqli_result, MYSQLI_ASSOC);
			$mysqli_result->close();
			return $result;
		}
		else {
			global $CONSOLE;
			$CONSOLE->Error('Ошибка выполнения запроса ' . $query . '\n' . $this->mysqli_->errno . ': ' . $this->mysqli_->error);
			return [];
		}
	}
	
	// Запрос с результатом 'выполнено' или 'не выполнено'
	private function BoolQuery_($query) 
	{
		if ($this->mysqli_->query($query)) {
		    return $this->mysqli_->affected_rows;
		}
		else {
			global $CONSOLE;
			// Запись уже существует (при INSERT)
			if ($this->mysqli_->errno !== 1062) {
				$CONSOLE->Error('Ошибка выполнения запроса ' . $query . '\n' . $this->mysqli_->errno . ': ' . $this->mysqli_->error);
			}
			return false;
		}
	}
	
	// Добавление пользователя
	public function AddUser($login, $password, $name, $inn, $email, $phone, $address)
	{
		$ip = $_SERVER['REMOTE_ADDR'];
		$login = $this->Esc_($login);
		$password = $this->Esc_($password);
		$name = $this->Esc_($name);
		$inn = $this->Esc_($inn);
		$email = $this->Esc_($email);
		$phone = $this->Esc_($phone);
		$address = $this->Esc_($address);
		return $this->BoolQuery_("INSERT INTO `users` (`ip`, `created`, `login`, `password`, `name`, `inn`, `email`, `phone`, `address`) " .
			"VALUES (INET_ATON('$ip'), NOW(), '$login', '$password', '$name', '$inn', '$email', '$phone', '$address');");
	}
	
	// Получение ID пользователя
	public function GetUserID($login, $password = NULL)
	{
		$login = $this->Esc_($login);
		if (isset($password)) {
		    $password = $this->Esc_($password);
		    $row = $this->RowQuery_("SELECT `id` FROM `users` WHERE `login` = '$login' AND `password` = '$password';");
		}
		else {
		    $row = $this->RowQuery_("SELECT `id` FROM `users` WHERE `login` = '$login';");
		}
		if (isset($row['id'])) {
			return $row['id'];
		}
		else {
			return false;
		}
	}

	// Получение данных пользователя
	public function GetUser($id)
	{
		$id = $this->Esc_($id);
		return $this->RowQuery_("SELECT `login`, `name`, `inn`, `email`, `phone`, `address` FROM `users` WHERE `id` = $id;");
	}

	// Получение денег пользователя
	public function GetUserMoney($id)
	{
		$id = $this->Esc_($id);
		$row = $this->RowQuery_("SELECT `money` FROM `users` WHERE `id` = $id;");
		if (isset($row['money'])) {
			return $row['money'];
		}
		else {
			return false;
		}
	}

	// Обновление пользователя
	public function UpdateUser($id, $login, $name, $inn, $email, $phone, $address)
	{
		$id = $this->Esc_($id);
		return $this->BoolQuery_("UPDATE `users` SET " . trim(
		    (isset($login) ? "`login` = '" . $this->Esc_($login) . "', " : '') .
		    (isset($name) ? "`name` = '" . $this->Esc_($name) . "', " : '') .
		    (isset($inn) ? "`inn` = '" . $this->Esc_($inn) . "', " : '') .
		    (isset($email) ? "`email` = '" . $this->Esc_($email) . "', " : '') .
		    (isset($phone) ? "`phone` = '" . $this->Esc_($phone) . "', " : '') .
		    (isset($address) ? "`address` = '" . $this->Esc_($address) . "', " : '') .
		    '', ', ') . " WHERE `id` = $id;");
	}

	// Обновление денег пользователя
	public function UpdateUserMoney($id, $money)
	{
		$id = $this->Esc_($id);
		return $this->BoolQuery_("UPDATE `users` SET `money` = '" . $this->Esc_($money) . "' WHERE `id` = $id;");
	}
	
	// Обновление пароля пользователя
	public function UpdateUserPassword($id, $password) 
	{
		$id = $this->Esc_($id);
		$password = $this->Esc_($password);
		return $this->BoolQuery_("UPDATE `users` SET `password` = '$password' WHERE `id` = $id;");
	}
	
	// Удаление пользователя
	public function RemoveUser($id) 
	{
		$id = $this->Esc_($id);
		return $this->BoolQuery_("DELETE FROM `users` WHERE `id` = $id;");
	}

	// Добавление команды
    public function AddCommand($mask, $description, $type, $extra)
    {
        $mask = $this->Esc_($mask);
        $description = $this->Esc_($description);
        $type = $this->Esc_($type);
        $extra = $this->Esc_($extra);
        return $this->BoolQuery_("INSERT INTO `commands` (`mask`, `description`, `type`, `extra`) " .
            "VALUES ('$mask', '$description', $type, '$extra');");
    }

    // Получить команды
    public function GetCommands()
    {
        return $this->ArrayQuery_("SELECT `id`, `mask`, `description`, `type`, `extra` FROM `commands`");
    }

    // Получить команду
    public function GetCommand($id)
    {
        $id = $this->Esc_($id);
        return $this->RowQuery_("SELECT `mask`, `description`, `type`, `extra` FROM `commands` WHERE `id` = $id");
    }

    // Обновление команды
    public function UpdateCommand($id, $mask, $description, $type, $extra)
    {
        $id = $this->Esc_($id);
        $mask = $this->Esc_($mask);
        $description = $this->Esc_($description);
        $type = $this->Esc_($type);
        $extra = $this->Esc_($extra);
        return $this->BoolQuery_("UPDATE `commands` SET " . trim(
                (isset($mask) ? "`mask` = '" . $this->Esc_($mask) . "', " : '') .
                (isset($description) ? "`description` = '" . $this->Esc_($description) . "', " : '') .
                (isset($type) ? "`type` = " . $this->Esc_($type) . ", " : '') .
                (isset($extra) ? "`extra` = '" . $this->Esc_($extra) . "', " : '') .
                '', ', ') . " WHERE `id` = $id;");
    }

    // Удаление команды
    public function RemoveCommand($id)
    {
        $id = $this->Esc_($id);
        return $this->BoolQuery_("DELETE FROM `commands` WHERE `id` = $id;");
    }

    // Получить help
	public function GetBotHelp()
	{
        return $this->ArrayQuery_("SELECT `mask`, `description` FROM `commands`;");
	}

	// Получить информацию о команде
	public function GetMsgInfo($msg)
	{
        $msg = $this->Esc_($msg);
        return $this->RowQuery_("SELECT `mask`, `type`, `extra` FROM " .
            "(SELECT '$msg' as `msg`) as `founded` LEFT JOIN `commands` ON `msg` RLIKE `mask`");
	}

	// Добавление карты
	public function AddCard($user_id, $type, $max)
	{
		$user_id = $this->Esc_($user_id);
		$type = $this->Esc_($type);
		$max = $this->Esc_($max);
		return $this->BoolQuery_("INSERT INTO `cards` (`user_id`, `type`, `max`) " .
			"VALUES ($user_id, '$type', '$max');");
	}

	// Получение данных карт
	public function GetCards($user_id)
	{
		$user_id = $this->Esc_($user_id);
        return $this->ArrayQuery_("SELECT `id`, `type`, `spent`, `max`, `blocked` FROM `cards` WHERE `user_id` = $user_id;");
	}

	// Получение данных карты
	public function GetCard($id)
	{
		$id = $this->Esc_($id);
        return $this->RowQuery_("SELECT `user_id`, `type`, `spent`, `max`, `blocked` FROM `cards` WHERE `id` = $id;");
	}

	// Обновление карты
	public function UpdateCard($id, $user_id, $type, $spent, $max, $blocked)
	{
		$id = $this->Esc_($id);
		$user_id = $this->Esc_($user_id);
		return $this->BoolQuery_("UPDATE `cards` SET " . trim(
		    (isset($type) ? "`type` = '" . $this->Esc_($type) . "', " : '') .
		    (isset($spent) ? "`spent` = " . $this->Esc_($spent) . ", " : '') .
		    (isset($max) ? "`max` = " . $this->Esc_($max) . ", " : '') .
		    (isset($blocked) ? "`blocked` = " . $this->Esc_($blocked) . ", " : '') .
		    '', ', ') . " WHERE `id` = $id AND `user_id` = $user_id;");
	}

	// Удаление карты
	public function RemoveCard($id)
	{
		$id = $this->Esc_($id);
		return $this->BoolQuery_("DELETE FROM `cards` WHERE `id` = $id;");
	}

	// Добавление машины
	public function AddCar($user_id, $model, $number, $mileage)
	{
		$user_id = $this->Esc_($user_id);
		$model = $this->Esc_($model);
		$number = $this->Esc_($number);
		$mileage = $this->Esc_($mileage);
		return $this->BoolQuery_("INSERT INTO `cars` (`user_id`, `model`, `number`, `mileage`) " .
			"VALUES ($user_id, '$model', '$number', '$mileage');");
	}

	// Получение данных машин
	public function GetCars($user_id)
	{
		$user_id = $this->Esc_($user_id);
        return $this->ArrayQuery_("SELECT `id`, `model`, `number`, `mileage` FROM `cars` WHERE `user_id` = $user_id;");
	}

	// Получение данных машины
	public function GetCar($id)
	{
		$id = $this->Esc_($id);
        return $this->RowQuery_("SELECT `user_id`, `model`, `number`, `mileage` FROM `cars` WHERE `id` = $id;");
	}

	// Обновление машины
	public function UpdateCar($id, $user_id, $model, $number, $mileage)
	{
		$id = $this->Esc_($id);
		$user_id = $this->Esc_($user_id);
        return $this->BoolQuery_("UPDATE `cars` SET " . trim(
		    (isset($model) ? "`model` = '" . $this->Esc_($model) . "', " : '') .
		    (isset($number) ? "`number` = '" . $this->Esc_($number) . "', " : '') .
		    (isset($mileage) ? "`mileage` = " . $this->Esc_($mileage) . ", " : '') .
		    '', ', ') . " WHERE `id` = $id AND `user_id` = $user_id;");
	}

	// Удаление машины
	public function RemoveCar($id)
	{
		$id = $this->Esc_($id);
		return $this->BoolQuery_("DELETE FROM `cars` WHERE `id` = $id;");
	}

	// Добавление водителя
	public function AddDriver($user_id, $name, $passport)
	{
		$user_id = $this->Esc_($user_id);
		$name = $this->Esc_($name);
		$passport = $this->Esc_($passport);
		return $this->BoolQuery_("INSERT INTO `drivers` (`user_id`, `name`, `passport`) " .
			"VALUES ($user_id, '$name', '$passport');");
	}

	// Получение данных водителей
	public function GetDrivers($user_id)
	{
		$user_id = $this->Esc_($user_id);
        return $this->ArrayQuery_("SELECT `id`, `name`, `passport` FROM `drivers` WHERE `user_id` = $user_id;");
	}

	// Получение данных водителя
	public function GetDriver($id)
	{
		$id = $this->Esc_($id);
        return $this->RowQuery_("SELECT `user_id`, `name`, `passport` FROM `drivers` WHERE `id` = $id;");
	}

	// Обновление водителя
	public function UpdateDriver($id, $user_id, $name, $passport)
	{
		$id = $this->Esc_($id);
		$user_id = $this->Esc_($user_id);
        return $this->BoolQuery_("UPDATE `drivers` SET " . trim(
		    (isset($name) ? "`name` = '" . $this->Esc_($name) . "', " : '') .
		    (isset($passport) ? "`passport` = '" . $this->Esc_($passport) . "', " : '') .
		    '', ', ') . " WHERE `id` = $id AND `user_id` = $user_id;");
	}

	// Удаление водителя
	public function RemoveDriver($id)
	{
		$id = $this->Esc_($id);
		return $this->BoolQuery_("DELETE FROM `drivers` WHERE `id` = $id;");
	}
}
?>