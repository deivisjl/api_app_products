<?php

/**
 * Abstracción del repositorio de sesiones
 */
interface ISessionsRepository {
    public function createSession($authorization);
}