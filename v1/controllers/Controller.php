<?php

/**
 * Punto de entrada para los controladores
 */
interface Controller
{
    function getAction(Request $request);

    function postAction(Request $request);

    function putAction(Request $request);

    function deleteAction(Request $request);

}