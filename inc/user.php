<?php
    //Connection Database
    $conn = new mysqli('localhost', 'root', '', 'vue_crud2');

    //Get all fetch data
    $data = json_decode(file_get_contents('php://input'));

    $action = 'read';
    if(isset($_GET['action'])){
        $action = $_GET['action'];
    }

    /**
     * Show All of Users Data
     */
    if($action == 'read'){
        $data = $conn->query("SELECT * FROM users ORDER BY id DESC");

        $all_users = [];
        while( $user = $data->fetch_assoc() ){
            array_push($all_users, $user);
        }
        echo json_encode($all_users);
    }

    /**
     * User Data Insert
     */
    if($action == 'create'){
        //File Proccess
        $file_name      = $_FILES['photo']['name'];
        $file_name_tmp  = $_FILES['photo']['tmp_name'];

        //Upload Profile Photo
        move_uploaded_file($file_name_tmp, '../photo/users/' . $file_name);

        //Get All Value
        $name   = $_POST['name'];
        $email  = $_POST['email'];
        $cell   = $_POST['cell'];
        
        //Insert data into table
        $conn->query("INSERT INTO users (name, email, cell, photo) VALUES ('$name', '$email', '$cell', '$file_name')");
    }

    /**
     * User Data Delete
     */
    if($action == 'delete'){
        //Get ID
        $id = $_GET['id'];

        //Delete Data
        $data = $conn->query("DELETE FROM users WHERE id='$id'");
    }

    /**
     * Single User Data View
     */
    if($action == 'single'){
        //Get ID
        $id = $_GET['id'];

        //Get Single User Data
        $data = $conn->query("SELECT * FROM users WHERE id='$id'");

        $single_user_data = $data -> fetch_assoc();
        echo json_encode($single_user_data);
    }

    /**
     * Search User
     */
    if($action == 'search'){
        //Get ID
        $search = $_GET['s'];

        //Get Search User Data
        $data = $conn->query("SELECT * FROM users WHERE name LIKE '%$search%'");
        
        $search_result = [];
        while( $result = $data -> fetch_assoc() ){
            array_push($search_result, $result);
        }

        echo json_encode($search_result);
      
    }
    