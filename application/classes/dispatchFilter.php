<?php

/**
 * Permet de savoir ce que l'utilisateur veut chercher : douchette / pda / imprimante couleur etc...
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

        var_dump($this->session->search);

    }

    /**
     * Recherche du resultat article en fonction de la section
     */
    public function result()
    {
        if($this->session->search == 'search_thermique') $this->thermiqueResult();
        if($this->session->search == 'search_douchette') $this->douchetteResult();
        if($this->session->search == 'search_terminal') $this->terminalResult();
    }

    /**
     * Nous donne les input renseigner par l'utilisateur
     * @return mixed
     */
    public function getInput()
    {
        //Imprimante
        if ($this->session->search == 'search_thermique') return $this->session->inputThermique;
        if ($this->session->search == 'search_badgeuse') return $this->session->inputPrinter;
        if ($this->session->search == 'search_etiquette_couleur') return $this->session->inputEtiquetteCouleur;
        if ($this->session->search == 'search_laser') return $this->session->inputLaser;
        if ($this->session->search == 'search_matricielle') return $this->session->inputMatricielle;

        //Terminal
        if ($this->session->search == 'search_terminal') return $this->session->inputTerminal;
        if ($this->session->search == 'search_pda') return $this->session->inputPda;
        if ($this->session->search == 'search_embarque') return $this->session->inputembarque;
        if ($this->session->search == 'search_poignet') return $this->session->inputPoignet;

        //Douchette
        if ($this->session->search == 'search_douchette') return $this->session->inputDouchette;
        if ($this->session->search == 'search_scanner_ring') return $this->session->inputRing;
        if ($this->session->search == 'search_scanner_fixe') return $this->session->inputScannerFixe;

        //poste de travail
        if ($this->session->search == 'search_pc') return $this->session->inputPc;
        if ($this->session->search == 'search_portable') return $this->session->inputPortable;
        if ($this->session->search == 'search_platine') return $this->session->inputPlatine;

    }

    /**
     * Nous retourne le resultat
     * @return mixed
     */
    public function getResult()
    {
        //Imprimante
        if ($this->session->search == 'search_thermique') return $this->session->resultThermique;
        if ($this->session->search == 'search_badgeuse') return $this->session->resultBadgeuse;
        if ($this->session->search == 'search_etiquette_couleur') return $this->session->resultEtiquetteCouleur;
        if ($this->session->search == 'search_laser') return $this->session->resultLaser;
        if ($this->session->search == 'search_matricielle') return $this->session->resultMatricielle;

        //Terminal
        if ($this->session->search == 'search_terminal') return $this->session->resultTerminal;
        if ($this->session->search == 'search_pda') return $this->session->resultPda;
        if ($this->session->search == 'search_embarque') return $this->session->resultembarque;
        if ($this->session->search == 'search_poignet') return $this->session->resultPoignet;

        //Douchette
        if ($this->session->search == 'search_douchette') return $this->session->resultDouchette;
        if ($this->session->search == 'search_scanner_ring') return $this->session->resultRing;
        if ($this->session->search == 'search_scanner_fixe') return $this->session->resultScannerFixe;

        //poste de travail
        if ($this->session->search == 'search_pc') return $this->session->resultPc;
        if ($this->session->search == 'search_portable') return $this->session->resultPortable;
        if ($this->session->search == 'search_platine') return $this->session->resultPlatine;
    }

    /**
     * Recherche resultat filtrer pour les imprimante
     */
    private function thermiqueResult()
    {

        if($this->session->resultThermique === []) return $this->session->resultThermique;

        if($this->session->resultThermique === null) {
            global $db;
            $result = new Genius_Model_Filtre();
            $result = $result->select();
            $result = $db->query($result)->fetchAll();
            $this->session->resultThermique = $result;
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
            $this->session->search = 'search_thermique';
    }
}