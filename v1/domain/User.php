<?php


/**
 * Entidad de negocios para los 'usuarios'
 */
class User {


    private $id;
    private $email;
    private $username;
    private $password;
    private $employeeEmpNo;
    private $roleId;
    private $token;


    public function __construct($id, $email, $username, $password, $employeeEmpNo, $roleId, $token) {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->employeeEmpNo = $employeeEmpNo;
        $this->roleId = $roleId;
        $this->token = $token;
        $this->email = $email;
    }

    public static function fromRequestParams($requestParams) {

        if (!isset($requestParams[self::COLUMN_EMAIL])||
            !isset($requestParams[self::COLUMN_USER_NAME]) ||
            !isset($requestParams[self::COLUMN_HASH_PASSWORD]) ||
            !isset($requestParams[self::EMPLOYEE_EMP_NO]) ||
            !isset($requestParams[self::COLUMN_ROLE_ID])
        ) {
            return null;
        }

        $email = $requestParams[self::COLUMN_EMAIL];
        // ¿El email tiene patrón estándar?
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            return null;
        }

        $username = $requestParams[self::COLUMN_USER_NAME];
        $password = $requestParams[self::COLUMN_HASH_PASSWORD];
        $employeeEmpNo = $requestParams[self::EMPLOYEE_EMP_NO];
        $roleId = $requestParams[self::COLUMN_ROLE_ID];

        $newUser = new User(0, $email, $username, $password, $employeeEmpNo, $roleId, null);

        // Proteger password
        $newUser->hashPassword($password);

        return $newUser;
    }

    public static function fromRawObject($rawObject) {
        $id = $rawObject[self::COLUMN_ID];
        $email = $rawObject[self::COLUMN_EMAIL];
        $userName = $rawObject[self::COLUMN_USER_NAME];
        $hashPassword = $rawObject[self::COLUMN_HASH_PASSWORD];
        $employeeEmpNo = $rawObject[self::EMPLOYEE_EMP_NO];
        $roleId = $rawObject[self::COLUMN_ROLE_ID];
        $token = $rawObject[self::COLUMN_TOKEN];
        return new User($id, $email, $userName, $hashPassword, $employeeEmpNo, $roleId, $token);
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function hashPassword($password) {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function verifyHashPassword($password) {
        return password_verify($password, $this->password);
    }

    public function getEmployeeEmpNo() {
        return $this->employeeEmpNo;
    }

    public function setEmployeeEmpNo($employeeEmpNo) {
        $this->employeeEmpNo = $employeeEmpNo;
    }

    public function getRoleId() {
        return $this->roleId;
    }

    public function setRoleId($roleId) {
        $this->roleId = $roleId;
    }

    public function getToken() {
        return $this->token;
    }

    public function setToken($token) {
        $this->token = $token;
    }

    public function toArray() {
        return array(
            self::COLUMN_ID => $this->id,
            self::COLUMN_EMAIL => $this->email,
            self::COLUMN_USER_NAME => $this->username,
            self::COLUMN_EMPLOYEE_EMP_NO => $this->employeeEmpNo,
            self::COLUMN_ROLE_ID => $this->roleId,
            self::COLUMN_TOKEN => $this->token
        );
    }

    // Contrato para el esquema de la tabla user
    const TABLE_NAME_USER = 'user';

    const COLUMN_ID = 'id';
    const COLUMN_EMAIL = 'email';
    const COLUMN_USER_NAME = 'username';
    const COLUMN_HASH_PASSWORD = 'hash_password';
    const COLUMN_EMPLOYEE_EMP_NO = 'employee_emp_no';
    const EMPLOYEE_EMP_NO = 'employee_emp_no';
    const COLUMN_ROLE_ID = 'role_id';
    const COLUMN_TOKEN = "token";

}