<?php
/**
 * Created by PhpStorm.
 * User: gvalero
 * Date: 22/08/2017
 * Time: 14:50
 */

class Genius_Model_Filtre
{
    public static function getArticles() {
        global $db;

        $sql = "
		SELECT *
		FROM ec_filtres 
		";
        $data = $db->fetchRow($sql);
        return $data;
    }
}