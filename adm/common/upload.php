<?php

@session_start();
error_reporting(E_ERROR | E_PARSE);
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of upload
 *
 * @author HCCTH
 */
class upload {

    private $_path = "";
    private $_Filename = array();
    private $_FilenameResult = array();
    private $_minSizeImg = 1;
    private $_maxSizeImg = 10240000;
    private $_minSizeDoc = 50;
    private $_maxSizeDoc = 20480000;
    private $_imgType = array("png", "PNG", "jpg", "JPG");
    private $_docType = array("pdf", "PDF");
    private $_errorMessage = "";

    function Initial_and_Clear() {
        $this->_Filename = array();
        $this->_FilenameResult = array();
        $this->_errorMessage = "";
    }

    function get_errorMessage() {
        return $this->_errorMessage;
    }

    function set_errorMessage($_errorMessage) {
        $this->_errorMessage = $_errorMessage;
    }

    function add_FileName($fileAdd) {
        array_push($this->_Filename, $fileAdd);
    }

    function add_FileNameResult($fileAdd) {
        array_push($this->_FilenameResult, $fileAdd);
    }

    function get_path() {
        return $this->_path;
    }

    function get_Filename() {
        return $this->_Filename;
    }

    function set_path($_path) {
        $this->_path = $_path;
    }

    function set_Filename($_Filename) {
        $this->_Filename = $_Filename;
    }

    function get_imgType() {
        return $this->_imgType;
    }

    function get_docType() {
        return $this->_docType;
    }

    function set_imgType($_imgType) {
        $this->_imgType = $_imgType;
    }

    function set_docType($_docType) {
        $this->_docType = $_docType;
    }

    function get_minSizeImg() {
        return $this->_minSizeImg;
    }

    function get_maxSizeImg() {
        return $this->_maxSizeImg;
    }

    function get_minSizeDoc() {
        return $this->_minSizeDoc;
    }

    function get_maxSizeDoc() {
        return $this->_maxSizeDoc;
    }

    function set_minSizeImg($_minSizeImg) {
        $this->_minSizeImg = $_minSizeImg;
    }

    function set_maxSizeImg($_maxSizeImg) {
        $this->_maxSizeImg = $_maxSizeImg;
    }

    function set_minSizeDoc($_minSizeDoc) {
        $this->_minSizeDoc = $_minSizeDoc;
    }

    function set_maxSizeDoc($_maxSizeDoc) {
        $this->_maxSizeDoc = $_maxSizeDoc;
    }

    function get_FilenameResult() {
        return $this->_FilenameResult;
    }

    function set_FilenameResult($_FilenameResult) {
        $this->_FilenameResult = $_FilenameResult;
    }

    function deleteFile() {
        $resultStatus = FALSE;
        mkdir($this->_path . "temp/", 0777, true);
        $flgCopy = TRUE;
        $flgDelete = TRUE;
        foreach ($this->_Filename as $value) {
            if (copy($this->_path . $value, $this->_path . "temp/" . $value) != 1) {
                // $flgCopy = FALSE;
            }
        }

        foreach ($this->_Filename as $value) {
            if (!unlink($this->_path . $value)) {
                $flgDelete = FALSE;
            }
        }
        if (!$flgDelete) {
            foreach ($this->_Filename as $value) {
                copy($this->_path . "temp/" . $value, $this->_path . $value);
                unlink($this->_path . "temp/" . $value);
            }


            rmdir($this->_path . "temp/");
        } else {
            foreach ($this->_Filename as $value) {
                unlink($this->_path . "temp/" . $value);
            }
            rmdir($this->_path . "temp/");
            $resultStatus = TRUE;
        }




        return (bool) $resultStatus;
    }

    function deleteFileNoTemp() {
        $_tmpInfo = $this->getFileInDIR();
        foreach ($_tmpInfo as $key => $_valueTmpInfo) {
            $flgDelete = TRUE;
            foreach ($this->_Filename as $value) {
                if ($_tmpInfo[$key]['file'] == $value) {
                    $flgDelete = FALSE;
                }
            }
            if ($flgDelete) {
                unlink($this->_path . $_tmpInfo[$key]['file']);
            }
        }
    }

    function getFileInDIR() {
        $listFile = array();
        if (is_dir($this->_path)) {
            if ($dh = opendir($this->_path)) {
                while (($file = readdir($dh)) !== false) {
                    $tmp = array(
                        'file' => $file
                    );
                    $listFile[] = $tmp;
                }
                closedir($dh);
            }
        }
        return $listFile;
    }

    function AddFile() {
        $resultStatus = FALSE;
        $img = FALSE;
        $doc = FALSE;
        $seq = 1;
        foreach ($this->_Filename as $value) {
            if (!is_null($value) && $value != "") {

                $temp = explode(".", $value["name"]);
                $tmpFileName = date('YmdHis') . $seq++ . '.' . end($temp);
                $newfilename = $this->_path . $tmpFileName;
                $this->add_FileNameResult($tmpFileName);
                foreach ($this->_imgType as $typeImg) {
                    if ($typeImg == end($temp)) {
                        $img = TRUE;
                    }
                }
                foreach ($this->_docType as $typeDoc) {
                    if ($typeDoc == end($temp)) {
                        $doc = TRUE;
                    }
                }

                if ($img) {
                    $size = $value["size"];
                    if ($size < $this->_minSizeImg || $size > $this->_maxSizeImg) {
                        $this->_errorMessage = $_SESSION['cd_2211'];
                        $this->clearDataInFilenameResult($tmpFileName);
                        return (bool) $resultStatus = FALSE;
                    }
                }

                if ($doc) {
                    $size = $value["size"];
                    if ($size < $this->_minSizeDoc || $size > $this->_maxSizeDoc) {
                        $this->_errorMessage = $_SESSION['cd_2212'];
                        $this->clearDataInFilenameResult($tmpFileName);
                        return (bool) $resultStatus = FALSE;
                    }
                }

                if (!$img && !$doc) {
                    $this->_errorMessage = $_SESSION['cd_2210'];
                    $this->clearDataInFilenameResult($tmpFileName);
                    return (bool) $resultStatus = FALSE;
                }

                if (move_uploaded_file($value["tmp_name"], $newfilename)) {
                    $this->_errorMessage = "";
                    $resultStatus = TRUE;
                } else {
                    $this->_errorMessage = $_SESSION['cd_2001'];
                    $this->clearDataInFilenameResult($tmpFileName);
                    return (bool) $resultStatus = FALSE;
                }
            }
        }
        return (bool) $resultStatus;
    }

    function clearDataInFilenameResult($tmp) {
        foreach ($this->_FilenameResult as $key => $value) {
            if ($tmp == $value) {
                unset($this->_FilenameResult[$key]);
            }
        }
    }

    function clearFileAddFail() {
        $flgDelete = TRUE;
        if ($this->_FilenameResult != NULL) {
            foreach ($this->_FilenameResult as $value) {
                if (!unlink($this->_path . $value)) {
                    $flgDelete = FALSE;
                }
            }
        }
        return (bool) $flgDelete;
    }

}
