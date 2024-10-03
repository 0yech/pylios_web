<?php

function db_query($query, $parameters)
{    
    $db = new PDO("sqlite:elios.sqlite");

    $stmt = $db->prepare($query);
    $stmt->execute($parameters);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}

function db_execute($query, $parameters)
{
    $db = new PDO("sqlite:elios.sqlite");

    $stmt = $db->prepare($query);
    $stmt->execute($parameters);
}

?>