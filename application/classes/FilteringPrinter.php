<?php

class Genius_Class_FilteringPrinter
{
    public $session;
    public $result;
    private $post;

    /**
     * FilteringArticle constructor.
     */
    public function __construct($post)
    {
        $this->post = $post;
        $this->result = [];
    }

    public function setSession($session)
    {
        $this->session = $session;
        return $this;
    }

    public function handle()
    {
        $this->session->inputPrinter['dpi'] = $this->post['dpi'];
        $this->session->inputPrinter['gamme'] = $this->post['gamme'];
        $this->session->inputPrinter['width'] = $this->post['width'];
        $this->session->inputPrinter['opt'] = $this->post['opt'];
        $this->session->inputPrinter['use'] = $this->post['use'];
        $int = array_flip($this->post['interface']);
        $this->session->inputPrinter['interface'] = $int;


        return $this;
    }

    public function search()
    {
        $model = new Genius_Model_Filtre();
        global $db;

        $model = $model ->select();

        if($this->post['dpi'] == 200) $model = $model->where('200dpi = 1');
        if($this->post['dpi'] == 300) $model = $model->where('300dpi = 1');
        if($this->post['dpi'] == 600) $model = $model->where('600dpi = 1');

        if($this->post['width'] == 2) $model = $model->where('2p = 1');
        if($this->post['width'] == 4) $model = $model->where('4p = 1');
        if($this->post['width'] == 5) $model = $model->where('5p = 1');
        if($this->post['width'] == 6) $model = $model->where('6p = 1');
        if($this->post['width'] == 8) $model = $model->where('8p = 1');

        if($this->post['gamme'] == 'portative') $model = $model->where('portable = 1');
        if($this->post['gamme'] == 'bureau') $model = $model->where('bureau = 1');
        if($this->post['gamme'] == 'si') $model = $model->where('s_indu = 1');
        if($this->post['gamme'] == 'i') $model = $model->where('indu = 1');

        if($this->post['use'] == 'tt') $model = $model->where('tt = 1');
        if($this->post['use'] == 'dt') $model = $model->where('dt = 1');
        if($this->post['use'] == 'both') $model = $model->where('dt = 1')->where('tt = 1');

        if($this->post['opt'] == 'tear') $model = $model->where('tear = 1');
        if($this->post['opt'] == 'peel') $model = $model->where('peel = 1');
        if($this->post['opt'] == 'cut') $model = $model->where('cutter = 1');

        if(isset($this->session->printer['interface']['serie']))  $model = $model->where('serie = 1') ;
        if(isset($this->session->printer['interface']['usb']))  $model = $model->where('usb = 1') ;
        if(isset($this->session->printer['interface']['eth']))  $model = $model->where('eth = 1') ;
        if(isset($this->session->printer['interface']['wifi']))  $model = $model->where('wifi = 1') ;
        if(isset($this->session->printer['interface']['parra']))  $model = $model->where('parra = 1') ;

        $this->result = $db->query($model)->fetchAll();

       return  $this;
    }

    public function setResult()
    {
        $this->session->resultPrinter = $this->result;
    }


}