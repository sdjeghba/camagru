<?php

class Form {

    public static function check_username(string $username) : bool {
        if (strlen($username > 10))
            return FALSE;
        return TRUE;
    }

    public static function check_mail(string $email) : bool {
        $reg = "/^[a-z\'0-9]+([._-][a-z\'0-9]+)*@([a-z0-9]+([._-][a-z0-9]+))+$/";

        if (preg_match($reg, $email)) {
            $array = explode('@', $email);
            if (checkdnsrr(end($array), 'MX'))
                return TRUE;
            else
                return FALSE;
        }
        return FALSE;
    }

    public static function confirm_pwd(string $pwd1, string $pwd2) : bool {
        if ($pwd1 === $pwd2)
            return TRUE;
        return FALSE;
    }
}
?>