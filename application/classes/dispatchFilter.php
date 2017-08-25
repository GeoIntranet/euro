<?php

/**
 * @property array result
 */
class Genius_Class_dispatchFilter
{

    /**
     * Genius_Class_dispatchFilter constructor.
     */
    public function __construct($session)
    {
        $this->session = $session;
        $this->setDefaultFiltre();
    }

    /**
     * Recherche du resultat article en fonction de la section
     */
    public function result()
    {
        if($this->session->search == 'p') $this->printerResult();
        if($this->session->search == 'd') $this->douchetteResult();
        if($this->session->search == 't') $this->terminalResult();
    }

    /**
     * Nous donne les input renseigner par l'utilisateur
     * @return mixed
     */
    public function getInput()
    {
        if ($this->session->search == 'p') return $this->session->inputPrinter;
        if ($this->session->search == 'd') return $this->session->inputDouchette;
        if ($this->session->search == 't') return $this->session->inputTerminal;

    }

    /**
     * Nous retourne le resultat
     * @return mixed
     */
    public function getResult()
    {
        if ($this->session->search == 'p') return $this->session->resultPrinter;
        if ($this->session->search == 'd') return $this->session->resultDouchette;
        if ($this->session->search == 't') return $this->session->resultTerminal;
    }

    /**
     * Recherche resultat filtrer pour les imprimante
     */
    private function printerResult()
    {
        if($this->session->resultPrinter === []) return $this->session->resultPrinter;

        if($this->session->resultPrinter === null) {
            global $db;
            $result = new Genius_Model_Filtre();
            $result = $result->select();
            $result = $db->query($result)->fetchAll();
            $this->session->resultPrinter = $result;
        }

    }

    /**
     *  Recherche resultat filtrer pour les douchette
     */
    private function douchetteResult()
    {
        if($this->session->resultDouchette === []) return $this->session->resultDouchette;

        if($this->session->resultDouchette === null) {
            global $db;
            $result = new Genius_Model_FiltreDouchette();
            $result = $result->select();
            $result = $db->query($result)->fetchAll();
            $this->session->resultDouchette = $result;
        }
    }

    /**
     *  Recherche resultat filtrer pour les Terminaux
     * @return string
     */
    private function terminalResult()
    {
        if($this->session->resultTerminal === []) return $this->session->resultTerminal;

        if($this->session->resultTerminal === null) {
            global $db;
            $result = new Genius_Model_FiltreTerminal();
            $result = $result->select();
            $result = $db->query($result)->fetchAll();
            $this->session->resultTerminal = $result;
        }
    }

    /**
     * mise par defaut la section sur Imprimante
     */
    private function setDefaultFiltre()
    {
        isset($this->session->search)
            ?
            $this->session->search
            :
            $this->session->search = 'p';
    }
}