<?php

class Index_model extends Model {

    public function __construct($link) {

        $this->setDBConnect($link);
    }

    function getRegion() {
        $res = mysqli_query($this->getDBConnect(),"SELECT * FROM t_koatuu_tree WHERE ter_type_id=0");
        if (!$res) {
            die('Неверный запрос: ' . mysqli_error($this->getDBConnect()));
            return null;
        }

        while ($row = mysqli_fetch_assoc($res)) {
            $result['region'][] = $row;
        }

        return $result;
    }


    function setUser($login, $pass, $email) {
        $flag_valid = true;
        /* проверка email */
        if (!(filter_var($email, FILTER_VALIDATE_EMAIL) && count($email) <= 50)) {
            $flag_valid = false;
        } else {
            /* Проверка login */
            $pattern = "/[\]\[\{\}:;\<\>\/\?\.,`~!@\=\+\#\$%\^&\*\(\)\'\"\\\\]/";
            if (!(!preg_match($pattern, $login) && strlen($login) >= 3 && strlen($login) <= 20)) {
                $flag_valid = false;
            } else {
                /* Проверка пароля */
                if (!(strlen($pass) >= 6 && strlen($pass) <= 20)) {
                    $flag_valid = false;
                }
            }
        }

        if ($flag_valid) {
            /* $res = mysql_query("SELECT * FROM users WHERE user_id=" . mysql_real_escape_string($id)); */
            $flag_user = mysql_query("SELECT * FROM users WHERE login='" . mysql_real_escape_string($login) . "' OR email='" . mysql_real_escape_string($email) . "'");
            if (!$flag_user) {
                die('Неверный запрос: ' . mysql_error());
                return null;
            } else {
                if (mysql_fetch_array($flag_user)) {
                    die('User exist: ' . __LINE__);
                    return null;
                }
            }
            $where = "'" . mysql_real_escape_string($login) . "','" . mysql_real_escape_string($pass) . "','" . mysql_real_escape_string($email) . "'";
            $res = mysql_query("INSERT INTO users (login,pass,email) VALUES (" . $where . ")");
            if (!$res) {
                die('Неверный запрос: ' . mysql_error());
                return null;
            }

            return mysql_insert_id();
        }
    }



    function setUserActive($id) {
        $res = mysql_query("UPDATE users SET hash=NULL, active=1" . " WHERE user_id=" . mysql_real_escape_string($id));
        if (!$res) {
            die('Неверный запрос: ' . mysql_error());
            return null;
        }

        return true;
    }

    function isUserRegistration($login, $pass) {
        $flag_valid = true;

        /* Проверка login */
        $pattern = "/[\]\[\{\}:;\<\>\/\?\.,`~!@\=\+\#\$%\^&\*\(\)\'\"\\\\]/";
        if (!(!preg_match($pattern, $login) && strlen($login) >= 3 && strlen($login) <= 20)) {
            $flag_valid = false;
        } else {
            /* Проверка пароля */
            if (!(strlen($pass) >= 6 && strlen($pass) <= 20)) {
                $flag_valid = false;
            }
        }




        if ($flag_valid) {

            $where = " login='" . mysql_real_escape_string($login) . "' AND pass='" . mysql_real_escape_string($pass) . "' AND active=1";
            $res = mysql_query("SELECT * FROM users WHERE " . $where);
            if (!$res) {
                die('Неверный запрос: ' . mysql_error());
                return null;
            }
            $row = mysql_fetch_array($res);
            if (isset($row['user_id']) && !empty($row['user_id'])) {
                return array(
                    'user_id' => $row['user_id'],
                    'active' => $row['active'],
                    'email' => $row['email'],
                    'hash' => $row['hash'],
                    'login' => $row['login']
                );
            } else {
                return false;
            }
        }
    }

}
