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
        $this->session->printer['width'] = $this->input['width'];
        $this->session->printer['opt'] = $this->input['opt'];
        $this->session->printer['use'] = $this->input['use'];
        $int = array_flip($this->input['interface']);
        $this->session->printer['interface'] = $int;

        return $this;
    }

    public function search()
    {
        $model = new Genius_Model_Filtre();
        global $db;

        $model = $model ->select();

        if($this->input['dpi'] == 200) $model = $model->where('200dpi = 1');
        if($this->input['dpi'] == 300) $model = $model->where('300dpi = 1');
        if($this->input['dpi'] == 600) $model = $model->where('600dpi = 1');

        if($this->input['width'] == 2) $model = $model->where('2p = 1');
        if($this->input['width'] == 4) $model = $model->where('4p = 1');
        if($this->input['width'] == 5) $model = $model->where('5p = 1');
        if($this->input['width'] == 6) $model = $model->where('6p = 1');
        if($this->input['width'] == 8) $model = $model->where('8p = 1');

        if($this->input['gamme'] == 'portative') $model = $model->where('portable = 1');
        if($this->input['gamme'] == 'bureau') $model = $model->where('bureau = 1');
        if($this->input['gamme'] == 'si') $model = $model->where('s_indu = 1');
        if($this->input['gamme'] == 'i') $model = $model->where('indu = 1');

        if($this->input['use'] == 'tt') $model = $model->where('tt = 1');
        if($this->input['use'] == 'dt') $model = $model->where('dt = 1');
        if($this->input['use'] == 'both') $model = $model->where('dt = 1')->where('tt = 1');

        if($this->input['opt'] == 'tear') $model = $model->where('tear = 1');
        if($this->input['opt'] == 'peel') $model = $model->where('peel = 1');
        if($this->input['opt'] == 'cut') $model = $model->where('cutter = 1');

        if(isset($this->session->printer['interface']['serie']))  $model = $model->where('serie = 1') ;
        if(isset($this->session->printer['interface']['usb']))  $model = $model->where('usb = 1') ;
        if(isset($this->session->printer['interface']['eth']))  $model = $model->where('eth = 1') ;
        if(isset($this->session->printer['interface']['wifi']))  $model = $model->where('wifi = 1') ;
        if(isset($this->session->printer['interface']['parra']))  $model = $model->where('parra = 1') ;

        $result = $db->query($model)->fetchAll();

       return  $result;
    }
}