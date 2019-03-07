<?php

namespace app\models;

use app\core\db\Model;

/**
 * Class User
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property int $created_at
 */
class User extends Model
{
    public static function table()
    {
        return "users";
    }

    public static function fields()
    {
        return ['id', 'username', 'password', 'created_at'];
    }

    public function save()
    {
        if (empty($this->id)) {
            $this->created_at = time();
        }
        return parent::save();
    }

    public function validatePassword($password)
    {
        return password_verify($password, $this->password);
    }

    public static function checkAuth($username, $password)
    {
        $user = self::findOne('username = :username', [':username' => $username]);
        if (!$user) {
            return false;
        }

        if (!$user->validatePassword($password)) {
            return false;
        }

        return true;
    }
}
