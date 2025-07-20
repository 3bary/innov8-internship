<?php
class User {
    public $id, $fullname, $email, $password, $gender, $hobbies, $country;

    public function __construct($fullname, $email, $password, $gender, $hobbies, $country) {
        $this->fullname = $fullname;
        $this->email = $email;
        $this->password = $password;
        $this->gender = $gender;
        $this->hobbies = $hobbies;
        $this->country = $country;
    }

    public function register($dbConnection) {
        $stmt = $dbConnection->prepare("INSERT INTO users (fullname, email, password, gender, hobbies, country) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $this->fullname, $this->email, $this->password, $this->gender, $this->hobbies, $this->country);
        return $stmt->execute();
    }
    public static function login($dbConnection, $email, $password) {
    $stmt = $dbConnection->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    return $stmt->get_result();
}

}
?>