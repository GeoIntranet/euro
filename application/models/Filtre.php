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

        $data = $db->fetchAll($sql);

        return $data;
    }

    public function select(){
        global $db ;
        
        $sql = $db
            ->select()
            ->from('ec_filtres')
            ->join('ec_products_multilingual', 'ec_filtres.product_m_id = ec_products_multilingual.id',
                [
                    'title','text','id_product',
                    'carac_1','carac_2','carac_3','carac_4','carac_5','carac_6','search'
                ])
            ->joinLeft(
                'ec_images_relations',
                ' ec_products_multilingual.id_product = ec_images_relations.id_item ',['id_item']
            )
            ->joinLeft('ec_images', 'ec_images_relations.id_image = ec_images.id',['id_img' => 'id','filename','path_folder','format'])
            ->where('ec_images_relations.id_module=7')
            ->where('ec_images_relations.image_cover =1')
        ;


       return  $sql;
    }
}