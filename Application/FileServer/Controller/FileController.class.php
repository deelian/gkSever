<?php

namespace FileServer\Controller;

class FileController extends FileStoreController {

    private $XS;
    private $XI;
    private $XSS;

    public function __construct()
    {
        parent::__construct();
    }

    public function storeFile()
    {
        echo 1212;
    }

}