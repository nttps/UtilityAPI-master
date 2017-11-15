<?php

@session_start();
error_reporting(E_ERROR | E_PARSE);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_POST)), true);
} else {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_GET)), true);
}


$controller = new uiGalleyController();
switch ($info[func]) {
    case "dataTable":
        echo $controller->dataTable($info);
        break;
    case "delete":
        echo $controller->delete($info[id]);
        break;
    case "deleteAll":
        echo $controller->deleteAll($info);
        break;
    case "getInfo":
        echo $controller->getInfo($info[id]);
        break;
    case "edit":
        echo $controller->edit($info);
        break;
    case "add":
        echo $controller->add($info);
        break;
}

class uiGalleyController {

    public function dataTable() {
        include '../service/uiGalleryService.php';
        $service = new uiGalleryService();
        $_dataTable = $service->dataTable();
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

    public function delete($seq) {
        include '../service/uiGalleryService.php';
        include '../common/upload.php';
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $db->conn();
        $service = new uiGalleryService();

        // delete file temp
        $this->deleteTempFile($db);
        // delete file temp

        $arr_img = $service->SelectById($db, $seq);
        if ($service->delete($db, $seq)) {
            $upload = new upload();
            $upload->Initial_and_Clear();
            $upload->set_path("../upload/gallery/");
            foreach ($arr_img as $key => $value) {
                if ($arr_img[$key]['s_img_p1'] != NULL && $arr_img[$key]['s_img_p1'] != "") {
                    $upload->add_FileName($arr_img[$key]['s_img_p1']);
                }
            }

            if (count($upload->get_Filename()) > 0) {
                if ($upload->deleteFile()) {
                    $db->commit();
                    echo $_SESSION['cd_0000'];
                } else {
                    $db->rollback();
                    echo $_SESSION['cd_2001'];
                }
            } else {
                $db->commit();
                echo $_SESSION['cd_0000'];
            }
        } else {
            $db->rollback();
            echo $_SESSION['cd_2001'];
        }
    }

    public function deleteAll($info) {
        if ($info[data] == NULL) {
            echo $_SESSION['cd_2005'];
        } else {
            include '../service/uiGalleryService.php';
            require_once('../common/ConnectDB.php');
            include '../common/upload.php';
            include '../common/Utility.php';
            $util = new Utility();
            $db = new ConnectDB();
            $db->conn();
            $service = new uiGalleryService();
            // delete file temp
            $this->deleteTempFile($db);
            // delete file temp
            $query = $util->arr2strQuery($info[data], "I");
            $arr_img = $service->SelectByArray($db, $query);
            if ($service->deleteAll($db, $query)) {
                $upload = new upload();
                $upload->Initial_and_Clear();
                $upload->set_path("../upload/gallery/");
                foreach ($arr_img as $key => $value) {
                    if ($arr_img[$key]['s_img_p1'] != NULL && $arr_img[$key]['s_img_p1'] != "") {
                        $upload->add_FileName($arr_img[$key]['s_img_p1']);
                    }
                }
                if (count($upload->get_Filename()) > 0) {
                    if ($upload->deleteFile()) {
                        $db->commit();
                        echo $_SESSION['cd_0000'];
                    } else {
                        $db->rollback();
                        echo $_SESSION['cd_2001'];
                    }
                } else {
                    $db->commit();
                    echo $_SESSION['cd_0000'];
                }
            } else {
                $db->rollback();
                echo $_SESSION['cd_2001'];
            }
        }
    }

    public function getInfo($seq) {
        include '../service/uiGalleryService.php';
        $service = new uiGalleryService();
        $_dataTable = $service->getInfo($seq);
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

    public function edit($info) {
        if ($this->isValid($info)) {
            include '../service/uiGalleryService.php';
            include '../common/upload.php';
            require_once('../common/ConnectDB.php');
            $db = new ConnectDB();
            $db->conn();
            $service = new uiGalleryService();
            $doc = new upload();
            $doc->set_path("../upload/gallery/");

            // delete file temp
            $this->deleteTempFile($db);
            // delete file temp


            if ($info[i_type] == "1") {
                //START CASE:1
                if ($_FILES["s_img_p1"]["error"] == 4) {
                    if ($service->edit($db, $info, $info[tmp_img_p1], NULL)) {
                        $db->commit();
                        echo $_SESSION['cd_0000'];
                    } else {
                        $db->rollback();
                        echo $_SESSION['cd_2001'];
                    }
                } else if ($_FILES["s_img_p1"]["error"] == 0) {
                    $doc->add_FileName($_FILES["s_img_p1"]);
                    $flg = $doc->AddFile();
                    if ($flg) {
                        $tmpDoc = $doc->get_FilenameResult();
                        if ($service->edit($db, $info, $tmpDoc[0], NULL)) {
                            $db->commit();
                            echo $_SESSION['cd_0000'];
                        } else {
                            $db->rollback();
                            $doc->clearFileAddFail();
                            echo $_SESSION['cd_2001'];
                        }
                    } else {
                        echo $doc->get_errorMessage();
                    }
                }
                //END CASE:1
            } else if ($info[i_type] == "2") {
                //START CASE:2
                if ($_FILES["s_img_p1"]["error"] == 4 && $_FILES["s_img_p2"]["error"] == 4) {
                    if ($service->edit($db, $info, $info[tmp_img_p1], $info[tmp_img_p2])) {
                        $db->commit();
                        echo $_SESSION['cd_0000'];
                    } else {
                        $db->rollback();
                        echo $_SESSION['cd_2001'];
                    }
                } else if ($_FILES["s_img_p1"]["error"] == 0 && $_FILES["s_img_p2"]["error"] == 4) {
                    $doc->add_FileName($_FILES["s_img_p1"]);
                    $flg = $doc->AddFile();
                    if ($flg) {
                        $tmpDoc = $doc->get_FilenameResult();
                        if ($service->edit($db, $info, $tmpDoc[0], $info[tmp_img_p2])) {
                            $db->commit();
                            echo $_SESSION['cd_0000'];
                        } else {
                            $db->rollback();
                            $doc->clearFileAddFail();
                            echo $_SESSION['cd_2001'];
                        }
                    } else {
                        echo $doc->get_errorMessage();
                    }
                } else if ($_FILES["s_img_p1"]["error"] == 4 && $_FILES["s_img_p2"]["error"] == 0) {
                    $doc->add_FileName($_FILES["s_img_p2"]);
                    $flg = $doc->AddFile();
                    if ($flg) {
                        $tmpDoc = $doc->get_FilenameResult();
                        if ($service->edit($db, $info, $info[tmp_img_p1], $tmpDoc[0])) {
                            $db->commit();
                            echo $_SESSION['cd_0000'];
                        } else {
                            $db->rollback();
                            $doc->clearFileAddFail();
                            echo $_SESSION['cd_2001'];
                        }
                    } else {
                        echo $doc->get_errorMessage();
                    }
                } else if ($_FILES["s_img_p1"]["error"] == 0 && $_FILES["s_img_p2"]["error"] == 0) {
                    $doc->add_FileName($_FILES["s_img_p1"]);
                    $doc->add_FileName($_FILES["s_img_p2"]);
                    $flg = $doc->AddFile();
                    if ($flg) {
                        $tmpDoc = $doc->get_FilenameResult();
                        if ($service->edit($db, $info, $tmpDoc[0], $tmpDoc[1])) {
                            $db->commit();
                            echo $_SESSION['cd_0000'];
                        } else {
                            $db->rollback();
                            $doc->clearFileAddFail();
                            echo $_SESSION['cd_2001'];
                        }
                    } else {
                        echo $doc->get_errorMessage();
                    }
                }
                //END CASE:2
            }
        }
    }

    public function add($info) {
        if ($this->isValid($info)) {
            include '../service/uiGalleryService.php';
            include '../common/upload.php';
            require_once('../common/ConnectDB.php');
            $doc = new upload();
            $doc->set_path("../upload/gallery/");
            $db = new ConnectDB();
            $db->conn();
            $service = new uiGalleryService();

            // delete file temp
            $this->deleteTempFile($db);
            // delete file temp


            if ($info[i_type] == "1") {
                $doc->add_FileName($_FILES["s_img_p1"]);
                $flg = $doc->AddFile();
                if ($flg) {
                    $tmpDoc = $doc->get_FilenameResult();
                    if ($service->add($db, $info, $tmpDoc[0], NULL)) {
                        $db->commit();
                        echo $_SESSION['cd_0000'];
                    } else {
                        $db->rollback();
                        $doc->clearFileAddFail();
                        echo $_SESSION['cd_2001'];
                    }
                } else {
                    echo $doc->get_errorMessage();
                }
            } else if ($info[i_type] == "2") {
                $doc->add_FileName($_FILES["s_img_p1"]);
                $doc->add_FileName($_FILES["s_img_p2"]);
                $flg = $doc->AddFile();
                if ($flg) {
                    $tmpDoc = $doc->get_FilenameResult();
                    if ($service->add($db, $info, $tmpDoc[0], $tmpDoc[1])) {
                        $db->commit();
                        echo $_SESSION['cd_0000'];
                    } else {
                        $db->rollback();
                        $doc->clearFileAddFail();
                        echo $_SESSION['cd_2001'];
                    }
                } else {
                    echo $doc->get_errorMessage();
                }
            }
        }
    }

    public function isValid($info) {
        $intReturn = FALSE;
        $return2099 = $_SESSION['cd_2099'];
        $return2003 = $_SESSION['cd_2003'];
        include '../common/Utility.php';
        $util = new Utility();


        if ($info[i_type] == "1") {

            if ($util->isEmpty($info[s_src_media])) {
                $return2099 = eregi_replace("field", $_SESSION['lb_ui_sv_src'], $return2099);
                echo $return2099;
            } else if ($util->isEmpty($info[i_index])) {
                $return2099 = eregi_replace("field", $_SESSION['lb_ui_index'], $return2099);
                echo $return2099;
            } else if (!is_numeric($info[i_index])) {
                $return2003 = eregi_replace("field", $_SESSION['lb_ui_index'], $return2003);
                echo $return2003;
            } else if ($util->isEmpty($info[s_desc_th])) {
                $return2099 = eregi_replace("field", $_SESSION['lb_ui_desc_th'], $return2099);
                echo $return2099;
            } else if ($util->isEmpty($info[s_desc_en])) {
                $return2099 = eregi_replace("field", $_SESSION['lb_ui_desc_en'], $return2099);
                echo $return2099;
            } else if (($_FILES["s_img_p1"]["error"] == 4 || $_FILES["s_img_p1"] == NULL ) && $info[func] == "add") {
                echo $_SESSION['cd_2207'];
            } else {
                $intReturn = TRUE;
            }
        } else if ($info[i_type] == "2") {
            if ($util->isEmpty($info[i_index])) {
                $return2099 = eregi_replace("field", $_SESSION['lb_ui_index'], $return2099);
                echo $return2099;
            } else if (!is_numeric($info[i_index])) {
                $return2003 = eregi_replace("field", $_SESSION['lb_ui_index'], $return2003);
                echo $return2003;
            } else if ($util->isEmpty($info[s_desc_th])) {
                $return2099 = eregi_replace("field", $_SESSION['lb_ui_desc_th'], $return2099);
                echo $return2099;
            } else if ($util->isEmpty($info[s_desc_en])) {
                $return2099 = eregi_replace("field", $_SESSION['lb_ui_desc_en'], $return2099);
                echo $return2099;
            } else if (($_FILES["s_img_p1"]["error"] == 4 || $_FILES["s_img_p1"] == NULL ) && $info[func] == "add") {
                echo $_SESSION['cd_2207'];
            } else if (($_FILES["s_img_p2"]["error"] == 4 || $_FILES["s_img_p2"] == NULL ) && $info[func] == "add") {
                echo $_SESSION['cd_2207'];
            } else {
                $intReturn = TRUE;
            }
        }
        return $intReturn;
    }

    public function deleteTempFile($db) {
        $temp = new upload();
        $svTemp = new uiGalleryService();
        $temp->set_path("../upload/gallery/");
        $_dataTemp = $svTemp->getInfoFile($db);
        foreach ($_dataTemp as $key => $value) {
            if ($_dataTemp[$key]['img'] != "") {
                $temp->add_FileName($_dataTemp[$key]['img']);
            }
        }
        $temp->deleteFileNoTemp();
    }

}
