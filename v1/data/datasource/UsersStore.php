<?php

/**
 * Abstracción para fuentes de datos con usuarios
 */
interface UsersStore {
    public function save(User $user);

    public function checkPermissionOverResource($token, $action, $resource);
}