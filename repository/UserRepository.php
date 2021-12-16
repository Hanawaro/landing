<?php

include_once ROOT . '/components/Database.php';

class UserRepository
{

    public const PHOTO_DEFAULT_PATH = ROOT . '/assets/img/users/';
    public const PHOTO_DEFAULT_NAME = 'default.png';

    static public function get($login)
    {
        $db = Database::get();
        $stmt = $db->prepare("SELECT * FROM users WHERE login=:login");
        $stmt->execute(array(':login' => $login));

        return $stmt->fetch();
    }

    static public function getAll()
    {
        $db = Database::get();
        $stmt = $db->prepare("SELECT * FROM users");
        $stmt->execute();

        return $stmt->fetchAll();
    }

    static public function create($user): bool
    {
        $db = Database::get();
        $stmt = $db->prepare(
            "INSERT users (login, email, password, first_name, second_name, last_name, photo)" .
            "VALUES (:login, :email, :password, :first_name, :second_name, :last_name, :photo)"
        );

        $passwordHash = md5(md5($user[LOGIN_TAG]) . md5($user[PASSWORD_TAG]));

        $photoName = null;
        if (isset($user[PHOTO_TAG])) {
            $fileExt = explode('.', $user[PHOTO_TAG]['name']);
            $fileActualExt = strtolower(end($fileExt));

            $photoName = uniqid('', true) . '.' . $fileActualExt;
        } else {
            $photoName = UserRepository::PHOTO_DEFAULT_NAME;
        }

        $stmt->bindParam(':login', $user[LOGIN_TAG]);
        $stmt->bindParam(':email', $user[EMAIL_TAG]);
        $stmt->bindParam(':password', $passwordHash);
        $stmt->bindParam(':first_name', $user[FIRST_NAME_TAG]);
        $stmt->bindParam(':second_name', $user[SECOND_NAME_TAG]);
        $stmt->bindParam(':last_name', $user[LAST_NAME_TAG]);
        $stmt->bindParam(':photo', $photoName);

        $result = $stmt->execute();

        if ($result && isset($user[PHOTO_TAG])) {
            move_uploaded_file($user[PHOTO_TAG]['tmp_name'], UserRepository::PHOTO_DEFAULT_PATH . $photoName);
        }

        return $result;
    }

    static public function update($user): bool
    {
        $db = Database::get();

        $stmt = $db->prepare(
            "UPDATE users SET 
                   reset_value = :reset_value, reset_date = :reset_date, email = :email, password = :password,
                   first_name = :first_name, second_name = :second_name, last_name = :last_name, photo = :photo
                   WHERE login = :login");

        $photoName = null;
        if (ProfileRepository::exist())
            $photoName = ProfileRepository::get(PHOTO_TAG);
        else
            $photoName = $user[PHOTO_TAG];

        $stmt->bindParam(':login', $user[LOGIN_TAG]);
        $stmt->bindParam(':reset_value', $user[RESET_VALUE_TAG]);
        $stmt->bindParam(':reset_date', $user[RESET_DATE_TAG]);
        $stmt->bindParam(':email', $user[EMAIL_TAG]);
        $stmt->bindParam(':password', $user[PASSWORD_TAG]);
        $stmt->bindParam(':first_name', $user[FIRST_NAME_TAG]);
        $stmt->bindParam(':second_name', $user[SECOND_NAME_TAG]);
        $stmt->bindParam(':last_name', $user[LAST_NAME_TAG]);
        $stmt->bindParam(':photo', $photoName);

        $result = $stmt->execute();

        if ($result && isset($user[PHOTO_TAG]['name'])) {
            move_uploaded_file($user[PHOTO_TAG]['tmp_name'], UserRepository::PHOTO_DEFAULT_PATH . $photoName);
        }

        return $result;
    }

    static public function remove($login): bool
    {
        return false;
    }

    static public function isLoginReserved($login): bool
    {
        $db = Database::get();

        $stmt = $db->prepare("SELECT id FROM users WHERE login=:login");
        $stmt->execute(array(':login' => $login));
        $result = $stmt->fetchAll();

        return !empty($result);
    }

    static public function isEmailReserved($email): bool
    {
        $db = Database::get();

        $stmt = $db->prepare("SELECT id FROM users WHERE email=:email");
        $stmt->execute(array(':email' => $email));
        $result = $stmt->fetchAll();

        return !empty($result);
    }
}