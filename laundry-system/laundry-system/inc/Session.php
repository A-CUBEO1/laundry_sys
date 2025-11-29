<?php
if(session_status() == PHP_SESSION_NONE) session_start();

class Session {

    public static function requireAdmin(){
        if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin'){
            header("Location: ../index.php");
            exit;
        }
    }

    public static function requireCashier(){
        if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'cashier'){
            header("Location: ../index.php");
            exit;
        }
    }

    public static function requireGuest(){
        if(isset($_SESSION['user_id'])){
            if($_SESSION['role']==='admin') header("Location: admin/dashboard.php");
            else header("Location: cashier/home.php");
            exit;
        }
    }
}
?>
