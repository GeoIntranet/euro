<?php
/**
 * Created by PhpStorm.
 * User: gvalero
 * Date: 22/08/2017
 * Time: 14:55
 */

class Genius_Class_FilteringPrinter
{
    public $session;

    private $input;

    /**
     * FilteringArticle constructor.
     */
    public function __construct($input)
    {
        $this->input = $input;
    }

    public function setSession($session)
    {
        $this->session = $session;
        return $this;
    }

    public function handle()
    {
        $this->session->printer['dpi'] = $this->input['dpi'];
        $this->session->printer['gamme'] = $this->input['gamme'];
        $this->session->printer['opt'] = $this->input['opt'];
        $this->session->printer['use'] = $this->input['use'];
        $int = array_flip($this->input['interface']);
        $this->session->printer['interface'] = $int;

        return $this;
    }

    public function search()
    {
        $model = new Genius_Model_Filtre();
        $art = $model::getArticles();
        var_dump($art);
        die();
    }
}