<?php
header('Content-type: json/application');
require 'connect.php';
require 'function.php';
$method = $_SERVER['REQUEST_METHOD'];
$q = $_GET['q'];
$params = explode('/', $q);
$type = $params[0];
$id = $params[1];

if($method == 'GET'){
  if($type == 'users'){
    if(isset($id)){
      getUsers($connect);
    } else {
      getUser($connect,$id);
    }
  }
} 

if($method == 'POST'){
  if($type == 'authorization'){
    authorizationUser($connect,$_POST);
  }
}

if($method == 'POST'){
  if($type == 'users'){
    addUser($connect,$_POST);
  }
}

if($method == 'PATH'){
  if($type == 'users'){
    if(isset($id)){
      $data = file_get_contents('php://input');
      $data = json_decode($data, true);
      updateUser($connect, $id, $data);
    } else {
      getUser($connect,$id);
    }
  }
}

if($method == 'DELETE'){
  if($type == 'users'){
    if(isset($id)){
      deleteUser($connect, $id);
    }
  }
}

?>