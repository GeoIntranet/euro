<?php

class Admin_SeoController extends Genius_AbstractController {

    public function init() {
        $ajaxContext = $this->_helper->getHelper('AjaxContext');
        $ajaxContext->addActionContext('getseo', 'html');
        $ajaxContext->initContext();
    }

    public function indexAction() {
        $this->view->headTitle()->append('Seo');
        $this->view->inlineScript()->prependFile(THEMES_ADMIN_URL . 'js/pages-index.js', 'text/javascript');
    }

    public function modifyAction() {
        $this->view->headTitle()->append('Edit Seo');

        global $params;
        global $siteconfig;
        $languages = Genius_Model_Language::getLanguages();

        $this->view->do = $do = $this->view->escape($this->_getParam('do'));
        $seo = array();

        switch ($do) {
            case 'edit':
                $id = (int) $this->_getParam('id');
                $where = " id=$id ";
                $seo = Genius_Model_Seo::getSeoById($id);
                if ($_POST) {
                    /*
                     * 3 steps :
                     * 1. update genius_pages
                     * 2. update genius_pages_categories
                     * 3. update genius_pages_multilingual
                     */

                    $id = (int) $_POST['Seo']['id'];

                    // 1. update genius_pages
                    $data_seo = array(
                        'update_time' => date('Y-m-d H:i:s')
                    );
                    Genius_Model_Global::update(TABLE_PREFIX . 'seo', $data_seo, " id=$id ");

                    // 2. update genius_seo_multilingual
                    if (!empty($languages)) {
                        foreach ($languages as $k => $item) {
                            $nom_page = Genius_Class_Utils::idml($_POST['Seo'], 'nom_page_' . $item['abbreviation'], $_POST['Seo']['nom_page_' . DEFAULT_LANG_ABBR]);
                            $meta_titre = Genius_Class_Utils::idml($_POST['Seo'], 'meta_titre_' . $item['abbreviation'], $_POST['Seo']['meta_titre_' . DEFAULT_LANG_ABBR]);
                            $meta_keyword = Genius_Class_Utils::idml($_POST['Seo'], 'meta_keyword_' . $item['abbreviation'], $_POST['Seo']['meta_keyword_' . DEFAULT_LANG_ABBR]);
                            $meta_description = Genius_Class_Utils::idml($_POST['Seo'], 'meta_description_' . $item['abbreviation'], $_POST['Seo']['meta_description_' . DEFAULT_LANG_ABBR]);
                            $title_noscript = Genius_Class_Utils::idml($_POST['Seo'], 'title_noscript_' . $item['abbreviation'], $_POST['Seo']['title_noscript_' . DEFAULT_LANG_ABBR]);
                            $h1_noscript = Genius_Class_Utils::idml($_POST['Seo'], 'h1_noscript_' . $item['abbreviation'], $_POST['Seo']['h1_noscript_' . DEFAULT_LANG_ABBR]);
                            $h2_noscript = Genius_Class_Utils::idml($_POST['Seo'], 'h2_noscript_' . $item['abbreviation'], $_POST['Seo']['h2_noscript_' . DEFAULT_LANG_ABBR]);

                            $id_language = $item['id'];

                            $data_seo_multilingual = array(
                                'nom_page' => $nom_page
                                , 'meta_titre' => $meta_titre
                                , 'meta_keyword' => $meta_keyword
                                , 'meta_description' => $meta_description
                                , 'title_noscript' => $title_noscript
                                , 'h1_noscript' => $h1_noscript
                                , 'h2_noscript' => $h2_noscript
                            );
                            Genius_Model_Global::update(TABLE_PREFIX . 'seo_multilingual', $data_seo_multilingual, " id_seo=$id AND id_language=$id_language ");
                        }
                    }

                    $this->_redirect('/admin/seo');
                }

                break;

            case 'add':

                if ($_POST) {

                    /*
                     * 3 steps :
                     * 1. insert in genius_pages
                     * 2. insert in genius_pages_categories
                     * 3. insert in genius_pages_multilingual
                     */

                    // 1. insert in genius_pages
                    $data_seo = array(
                        'create_time' => date('Y-m-d H:i:s')
                        , 'update_time' => date('Y-m-d H:i:s')
                    );
                    Genius_Model_Global::insert(TABLE_PREFIX . 'seo', $data_seo);
                    $lastId = Genius_Model_Global::lastId();


                    // 3. insert in genius_pages_multilingual
                    if (!empty($languages)) {
                        foreach ($languages as $k => $item) {
                            $nom_page = Genius_Class_Utils::idml($_POST['Seo'], 'nom_page_' . $item['abbreviation'], $_POST['Seo']['nom_page_' . DEFAULT_LANG_ABBR]);
                            $meta_titre = Genius_Class_Utils::idml($_POST['Seo'], 'meta_titre_' . $item['abbreviation'], $_POST['Seo']['meta_titre_' . DEFAULT_LANG_ABBR]);
                            $meta_keyword = Genius_Class_Utils::idml($_POST['Seo'], 'meta_keyword_' . $item['abbreviation'], $_POST['Seo']['meta_keyword_' . DEFAULT_LANG_ABBR]);
                            $meta_description = Genius_Class_Utils::idml($_POST['Seo'], 'meta_description_' . $item['abbreviation'], $_POST['Seo']['meta_description_' . DEFAULT_LANG_ABBR]);
                            $title_noscript = Genius_Class_Utils::idml($_POST['Seo'], 'title_noscript_' . $item['abbreviation'], $_POST['Seo']['title_noscript_' . DEFAULT_LANG_ABBR]);
                            $h1_noscript = Genius_Class_Utils::idml($_POST['Seo'], 'h1_noscript_' . $item['abbreviation'], $_POST['Seo']['h1_noscript_' . DEFAULT_LANG_ABBR]);
                            $h2_noscript = Genius_Class_Utils::idml($_POST['Seo'], 'h2_noscript_' . $item['abbreviation'], $_POST['Seo']['h2_noscript_' . DEFAULT_LANG_ABBR]);

                            $id_language = $item['id'];

                            $data_seo_multilingual = array(
                                'id_seo' => $lastId
                                , 'id_language' => $item['id']
                                ,'nom_page' => $nom
                                , 'meta_titre' => $meta_titre
                                , 'meta_keyword' => $meta_keyword
                                , 'meta_description' => $meta_description
                                , 'title_noscript' => $title_noscript
                                , 'h1_noscript' => $h1_noscript
                                , 'h2_noscript' => $h2_noscript
                            );
                            Genius_Model_Global::insert(TABLE_PREFIX . 'seo_multilingual', $data_seo_multilingual);
                        }
                    }

                    $this->_redirect('/admin/seo');
                }

                break;

            default:
                break;
        }

        $this->view->seo = $seo;
    }

    public function deleteAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        $id = (int) $this->_getParam('id');
        $where = " id=$id ";
        $return = Genius_Model_Global::delete(TABLE_PREFIX . 'seo', $where);

        echo 1;
    }

    public function massdeleteAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        if (!empty($_POST['massdeleteitems'])) {
            foreach ($_POST['massdeleteitems'] as $k => $item) {
                $id = (int) $item['value'];
                $where = " id=$id ";
                $return = Genius_Model_Global::delete(TABLE_PREFIX . 'seo', $where);
            }
        }

        echo 1;
    }

    public function getseoAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
		$env = APPLICATION_ENV;
		$config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', $env, true);
		$con = mysqli_connect($config->db->params->host, $config->db->params->username, $config->db->params->password,$config->db->params->dbname);
        $aColumns =
                array(
                    's.id'
                    , 'sm.nom_page'
                    , 's.update_time'
        );

        /*
         * Paging
         */
        $sLimit = "";
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $sLimit = "LIMIT " . intval($_GET['iDisplayStart']) . ", " . intval($_GET['iDisplayLength']);
        }

        /*
         * Ordering
         */
        $sOrder = "";
        if (isset($_GET['iSortCol_0'])) {
            $sOrder = "ORDER BY  ";
            for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
                if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
                    $sOrder .= $aColumns[intval($_GET['iSortCol_' . $i])] . " " . ($_GET['sSortDir_0'] === 'asc' ? 'ASC' : 'DESC') . ", ";
                }
            }

            $sOrder = substr_replace($sOrder, "", -2);
            if ($sOrder == "ORDER BY") {
                $sOrder = "";
            }
        }

        /*
         * Filtering
         */
        $sWhere = "";
        if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
            $sWhere = "WHERE (";
            for ($i = 0; $i < count($aColumns); $i++) {
                $sWhere .= $aColumns[$i] . " LIKE '%" . mysqli_real_escape_string($con, $_GET['sSearch']) . "%' OR ";
            }
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ')';
        }

        /* Individual column filtering */
        for ($i = 0; $i < count($aColumns); $i++) {
            if (isset($_GET['bSearchable_' . $i]) && $_GET['bSearchable_' . $i] == "true" && $_GET['sSearch_' . $i] != '') {
                if ($sWhere == "") {
                    $sWhere = "WHERE ";
                } else {
                    $sWhere .= " AND ";
                }
                $sWhere .= $aColumns[$i] . " LIKE '%" . mysqli_real_escape_string($con, $_GET['sSearch_' . $i]) . "%' ";
            }
        }

        /* Get default id_language value */
        $sWhere .= (trim($sWhere) != "") ? " AND (sm.id_language=" . DEFAULT_LANG_ID . ") " : " WHERE (sm.id_language=" . DEFAULT_LANG_ID . ") ";

        /*
         * SQL queries
         * Get data to display
         */
        $sQuery = "
			SELECT 
				SQL_CALC_FOUND_ROWS s.id
				,IF(s.update_time='0000-00-00 00:00:00' OR s.update_time IS NULL, '', DATE_FORMAT(s.update_time,'%d %b %Y %Hh %imn')) AS update_time
				,sm.nom_page
				
			FROM " . TABLE_PREFIX . "seo s
			LEFT JOIN " . TABLE_PREFIX . "seo_multilingual sm ON s.id=sm.id_seo
			$sWhere
			$sOrder
			$sLimit
		";
        $rResult = Genius_Model_Global::query($sQuery);
        $total = Genius_Model_Global::query("SELECT FOUND_ROWS()");
        $iFilteredTotal = $total[0]['FOUND_ROWS()'];
        $iTotal = $total[0]['FOUND_ROWS()'];

        /*
         * Output
         */
        $output = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iFilteredTotal,
            "aaData" => array()
        );
        if (!empty($rResult)) {
			$i=1;
			
            foreach ($rResult as $k => $item) {
                $row = array();
                //$row[0] = '<input type="checkbox" class="styled" value="' . $item['id'] . '" name="checked[]" />';
                $row[0] = $i;
                $row[1] = $item['nom_page'];
                $row[2] = $item['update_time'];

                $id = $item['id'];
                $url_edit = '/admin/seo/modify/do/edit/id/' . $item['id'];

                $actions = '<ul class="table-controls acenter">';
                $actions .= '<li><a title="" class="tip" href="' . $url_edit . '" data-original-title="Edit item"><i class="icon-pencil"></i></a> </li>';
                //$actions .= '<li><a title="" class="tip delete" id="' . $id . '" style="cursor: pointer" data-original-title="Delete item"><i class="ico-trash"></i></a> </li>';
                $actions .= '</ul>';

                $row[3] = $actions;

                $output['aaData'][] = $row;
                $i++;
            }
        }

        echo json_encode($output);
    }

}
