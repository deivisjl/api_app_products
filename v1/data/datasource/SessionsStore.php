<?php

/**
 * Abstracción para el almacén de sesiones
 */
interface SessionsStore {

    public function login($email, $password);

}