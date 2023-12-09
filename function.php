<?php
function getUsers($connect){
    $users = mysqli_query($connect, "SELECT * FROM `users`");
    $userList = [];
    while($user = mysqli_fetch_assoc($users)){
        $userList[] = $user;
    }
    return json_encode($userList);
}

function getUser($connect, $id){
    $user = mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '$id'");
    if(mysqli_num_rows($user) == 0){
        http_response_code(404);
        $res = [
           "status" => false,
           "message" => 'User not found' 
        ];
        return json_encode($res);
    } else {
        $user = mysqli_fetch_assoc($user);
        return json_encode($user);
    }
}

function addUser($connect, $data){
    $surname = $data['surname'];
    $name = $data['name'];
    $age = $data['age'];
    $login = $data['login'];
    $pass = $data['password'];
    mysqli_query($connect, "INSERT INTO `users`(`Surname`, `Name`, `Age`,`Login`,`Password`) VALUES ('$surname','$name','$age','$login','$pass')");
    http_response_code(201);
    $res = [
        "status" => true,
        "userId" => mysqli_insert_id($connect)
    ];
    return json_encode($res);
}

function updateUser($connect, $id, $data){
    $age = $data['age'];
    mysqli_query($connect, "UPDATE `users` SET `Age` = '$age' WHERE `users`.`id` = $id;");
    http_response_code(200);
    $res = [
        "status" => true,
        "message" => "User is updated"
    ];
    return json_encode($res);
}

function deleteUser($connect, $id){
    mysqli_query($connect, "DELETE FROM users WHERE `users`.`id` = $id;");
    http_response_code(200);
    $res = [
        "status" => true,
        "message" => "User is deleted"
    ];
    return json_encode($res);
}

function authorizationUser($connect, $data){
    $login = $data['login'];
    $pass = $data['pass'];
    mysqli_query($connect, "SELECT `id`, `Surname`, `Name`, `Age`, `Login`, `Password` FROM `users` WHERE `Password` = '$pass' AND `Login` = '$login'");
    if(mysqli_num_rows($user) == 0){
        http_response_code(401);
        $res = [
           "status" => false,
           "message" => 'User is not registered' 
        ];
        return json_encode($res);
    } else {
        http_response_code(200);
        $res = [
            "status" => true,
            "message" => "Authorization successful"
        ];
    }
    return json_encode($res);
}
?>