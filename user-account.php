<?php
    require_once 'connect.php';

    session_start();
    $errors=[];

    if($_SERVER['REQUEST_METHOD']==='POST'&&isset($_POST['signup'])){
        $email=filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
        $name=$_POST['name'];
        $password=$_POST['password'];
        $confirm_password=$_POST['confirm_password'];
        $created_at=date('Y-m-d H:i:s');

        if(!filter_var($email,FILTER_VALIDATE_EMAIL))
        {
            $errors['email']='Invalid email format';
        }
        if(empty($name)){
            $errors['name']='Name is Required';
        }
        if(strlen($password)<6){
            $errors['password']='Password must be at least 6 characters long';
        }
        if($password!=$confirm_password){
            $errors['confirm_password']='Passwords do not match';
        }
        $stmt=$pdo->prepare('SELECT * FROM users WHERE email=:email');
        $stmt->execute(['email'=>$email]);
        if($stmt->fetch()){
            $errors['email']='Email already exists';
        }

        if(!empty($errors)){
            $_SESSION['errors']=$errors;
            header('Location:register.php');
            exit();
        }

        $hashedPassword=password_hash($password,PASSWORD_BCRYPT);
        $stmt=$pdo->prepare('INSERT INTO users (email,password,name,created_at) VALUES(:email,:password,:name,:created_at)');

        $stmt->execute([
            'email'=> $email,
            'password'=> $password,
            'name'=>$name,
            'created_at'=>$created_at

        ]);
        header(Location:login.php);



    }
?>