<?php

/**
 * Entidad de negocio para representar los roles y permisos
 */
class Role {



    private $id;
    private $name;


    public function __construct($id, $name) {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }


    // Contrato de la tabla 'role'
    const TABLE_NAME_ROLE = 'role';
    const TABLE_NAME_ROLE_PERMISSION = "role_permission";
    const TABLE_NAME_PERMISSION = 'permission';
    const TABLE_NAME_RESOURCE = 'resource';

    const COLUMN_PERMISSION_PERMISSION_ID = 'permission_id';
    const COLUMN_PERMISSION_RESOURCE_ID = 'resource_id';
    const COLUMN_PERMISSION_ACTION = 'action';
    const COLUMN_RESOURCE_LOCATION = 'location';

    const COLUMN_ID = 'id';
    const COLUMN_NAME = 'name';

    const NAME_VALUE_ADMIN = 'admin';
    const NAME_VALUE_SALESPERSON = 'salesperson';
    const NAME_VALUE_SUPERVISOR = 'supervisor';

}