<?php

require realpath(dirname(__FILE__)).'\class\crud.php';


$data = array('nome'=>'teste');

$id = crud::delete('cliente',$data);
echo $id;