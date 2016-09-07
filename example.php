<?php

require_once("config.php");

require_once("classes/enom.class.php");

/*
 * For a list of commands, please read this documentation: https://www.enom.com/api/API%20topics/api_Command_Categories.htm
 * 
 * $params = array();
 * $enom->call('Command', $params); 
 * Params usage: $enom->call('GetDNS', array('SLD' => 'enom', 'TLD' => '.com'));
 */

try {
    $enom = new Enom();
    $results = $enom->call('GetDomains', array());
} catch (Exception $e) {
    die($e->getMessage());
}

echo '<pre>';
print_r($results);
echo '</pre>';
