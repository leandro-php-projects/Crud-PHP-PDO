<?php

require realpath(dirname(__FILE__)).'\class\crud.php';


$data = array('nome'=> 'Leandro Santana65465456451651651','cpf'=> '308.989.228-888');

$id = crud::save('cliente',$data);
echo $id;