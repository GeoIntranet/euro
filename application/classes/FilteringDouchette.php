<?php


/**
 * Class Genius_Class_FilteringDouchette
 */
class Genius_Class_FilteringDouchette
{
    public $result;
    private $post;

    /**
     * Genius_Class_FilteringTerminal constructor.
     *
     * @param $input
     */
    public function __construct($post)
    {
        $this->post = $post;
        $this->result = [];
    }

    /**
     * @param $session
     * @return $this
     */
    public function setSession($session)
    {
        $this->session = $session;
        return $this;
    }

    /**
     * @return $this
     */
    public function handle()
    {
        $int = array_flip($this->post['interface']);

        $this->session->inputDouchette['type'] = $this->post['type'];
        $this->session->inputDouchette['laser'] = $this->post['laser'];
        $this->session->inputDouchette['gamme'] = $this->post['gamme'];
        $this->session->inputDouchette['interface'] = $int;

        return $this;
    }

    /**
     * @return mixed
     */
    public function search()
    {
        global $db;
        $model = new Genius_Model_FiltreDouchette();
        $model = $model->select();

        if($this->post['laser'] == '1std') $model = $model->where('1std = 1');
        if($this->post['laser'] == '1ext') $model = $model->where('1ext = 1');
        if($this->post['laser'] == '1lg') $model = $model->where('1lg = 1');
        if($this->post['laser'] == '2std') $model = $model->where('2std = 1');
        if($this->post['laser'] == '2lg') $model = $model->where('2lg = 1');

        

        $result = $db->query($model)->fetchAll();
        $this->result = $result;
        
        return $this;
    }

    public function setResult()
    {
        $this->session->resultDouchette = $this->result;
    }
}