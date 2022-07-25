<?php

require_once 'UsersStore.php';
require_once 'domain/Role.php';


/**
 * Implementación de fuente de datos para usuarios desde MySQL
 */
class SqlUsersDataSource implements UsersStore {

    private $_mysqlHandler;


    public function __construct(PDO $mysqlHandler) {
        $this->_mysqlHandler = $mysqlHandler;
    }


    public function save(User $user) {
        try {
            $stm = "INSERT INTO " . User::TABLE_NAME_USER . "(" .
                User::COLUMN_EMAIL . "," .
                User::COLUMN_USER_NAME . "," .
                User::COLUMN_HASH_PASSWORD . "," .
                User::EMPLOYEE_EMP_NO . "," .
                User::COLUMN_ROLE_ID . "," .
                User::COLUMN_TOKEN . ")" .
                " VALUES(?,?,?,?,?,?)";

            $prepareStm = $this->_mysqlHandler->prepare($stm);

            $prepareStm->bindParam(1, $user->getEmail());
            $prepareStm->bindParam(2, $user->getUsername());
            $prepareStm->bindParam(3, $user->getPassword());
            $prepareStm->bindParam(4, $user->getEmployeeEmpNo());
            $prepareStm->bindParam(5, $user->getRoleId());
            $prepareStm->bindParam(6, $user->getToken());

            return $prepareStm->execute();
        } catch (PDOException $e) {
            $message = $e->getMessage();
            throw new ApiException(500, ERROR_SERVER_DATABASE . ": $message");
        }
    }

    public function checkPermissionOverResource($token, $action, $resource) {
        try {
            $userTable = User::TABLE_NAME_USER;
            $roleTable = Role::TABLE_NAME_ROLE;
            $rolePermissionTable = Role::TABLE_NAME_ROLE_PERMISSION;
            $permissionTable = Role::TABLE_NAME_PERMISSION;
            $resourceTable = Role::TABLE_NAME_RESOURCE;

            $userRoleId = User::COLUMN_ROLE_ID;
            $id = Role::COLUMN_ID;
            $permissionId = Role::COLUMN_PERMISSION_PERMISSION_ID;
            $resourceId = Role::COLUMN_PERMISSION_RESOURCE_ID;
            $actionCol = Role::COLUMN_PERMISSION_ACTION;
            $locationCol = Role::COLUMN_RESOURCE_LOCATION;
            $tokenCol = User::COLUMN_TOKEN;

            $stm =
                "select $userTable.$id " .
                "from $userTable " .
                "inner join $roleTable " .
                "on $userTable.$userRoleId = $roleTable.$id " .
                "inner join $rolePermissionTable " .
                "on $roleTable.$id = $rolePermissionTable.$userRoleId " .
                "inner join $permissionTable " .
                "on $rolePermissionTable.$permissionId = $permissionTable.$id " .
                "inner join $resourceTable " .
                "on $permissionTable.$resourceId = $resourceTable.$id " .
                "where $userTable.$tokenCol= ? and $permissionTable.$actionCol= ? " .
                "and $resourceTable.$locationCol=?";


            $prepareStm = $this->_mysqlHandler->prepare($stm);

            $prepareStm->bindParam(1, $token);
            $prepareStm->bindParam(2, $action);
            $prepareStm->bindParam(3, $resource);

            if ($prepareStm->execute()) {
                return $prepareStm->fetch();
            } else {
                throw new ApiException(500, ERROR_SERVER_DATABASE . " : " . $prepareStm->errorInfo()[1]);
            }

        } catch (PDOException $e) {
            throw new ApiException(500, ERROR_SERVER_DATABASE . " : " . $e->getMessage());
        }
    }
}