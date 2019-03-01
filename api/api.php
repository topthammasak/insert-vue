<?php
error_reporting(~E_NOTICE);
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers:{$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
header('Content-Type: application/json');
include('ConnectDB.php');
$module= $_GET['module'];
if(!empty($module) && $module == 'year-total'){
    $dataIn = [];
    $dataOut = [];
    $requestPost = json_decode(file_get_contents('php://input')); 
    $s_year = $requestPost->s_year;
    $e_year = $requestPost->e_year;
    if(empty($s_year) || empty($e_year)){
        echo json_encode(array('status'=>false,'message'=>'กรุณาเลือกปีค่ะ'));
        exit();
    }
    // IN
    $sql="SELECT COUNT(history_id) as total ,DATE_FORMAT(time, '%Y') as time  FROM scipk_history WHERE `status` = 1 AND YEAR(time) >= '".$s_year."' AND YEAR(time) <= '".$e_year."' GROUP BY year(time)";
     //echo $sql; exit();
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $dataIn[] = [
                'total' => $row["total"],
                'time' => $row["time"]
            ];
        }
    } 
    // OUT
    $sql="SELECT COUNT(history_id) as total ,DATE_FORMAT(time, '%Y') as time  FROM scipk_history WHERE `status` = -1 AND YEAR(time) >= '".$s_year."' AND YEAR(time) <= '".$e_year."' GROUP BY year(time)";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $dataOut[] = [
                'total' => $row["total"],
                'time' => $row["time"]
            ];
        }
    } 
    echo json_encode(array('status'=>true,'dataIn'=>$dataIn,'dataOut'=>$dataOut));
    exit();
}else if(!empty($module) && $module == 'month-total'){
    $dataIn = [];
    $dataOut = [];
    $requestPost = json_decode(file_get_contents('php://input')); 
    $s_month = $requestPost->s_month;
    $e_month = $requestPost->e_month;
    if(empty($s_month) || empty($e_month)){
        echo json_encode(array('status'=>false,'message'=>'กรุณาเลือกเดือนค่ะ'));
        exit();
    }
    $s_month = date("m", strtotime($s_month));
    $e_month = date("m", strtotime($e_month));
    $year1 = explode("-",$requestPost->s_month);
    $year2 = explode("-",$requestPost->e_month);
    // IN
    $sql="SELECT COUNT(history_id) as total ,DATE_FORMAT(time, '%m') as time  FROM scipk_history WHERE `status` = 1 AND  MONTH(time) >= '".$s_month."' AND MONTH(time) <= '".$e_month."'  AND YEAR(time) >= '".$year1[0]."'  AND YEAR(time) <= '".$year2[0]."' GROUP BY month(time)";
    //echo $sql; exit();
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $dataIn[] = [
                'total' => $row["total"],
                'time' => $row["time"]
            ];
        } 
    } 
    // OUT
    $sql="SELECT COUNT(history_id) as total ,DATE_FORMAT(time, '%m') as time  FROM scipk_history WHERE `status` = -1 AND  MONTH(time) >= '".$s_month."' AND MONTH(time) <= '".$e_month."'  AND YEAR(time) >= '".$year1[0]."'  AND YEAR(time) <= '".$year2[0]."' GROUP BY month(time)";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $dataOut[] = [
                'total' => $row["total"],
                'time' => $row["time"]
            ];
        }
    } 
    echo json_encode(array('status'=>true,'dataIn'=>$dataIn,'dataOut'=>$dataOut));
    exit();
}else if(!empty($module) && $module == 'day-total'){
    $dataIn = [];
    $dataOut = [];
    $requestPost = json_decode(file_get_contents('php://input')); 
    $s_date = $requestPost->s_date;
    $e_date = $requestPost->e_date;
    if(empty($s_date) || empty($e_date)){
        echo json_encode(array('status'=>false,'message'=>'กรุณาเลือกวันที่ค่ะ'));
        exit();
    }
    $s_date = date("Y-m-d", strtotime($s_date));
    $e_date = date("Y-m-d", strtotime($e_date));
    // IN
    $sql="SELECT COUNT(history_id) as total ,DATE_FORMAT(time, '%Y-%m-%d') as time FROM scipk_history WHERE `status` = 1 AND DATE_FORMAT(time, '%Y-%m-%d') >= '".$s_date."' AND DATE_FORMAT(time, '%Y-%m-%d') <= '".$e_date."' GROUP BY day(time)";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $dataIn[] = [
                'total' => $row["total"],
                'time' => $row["time"]
            ];
        }
    } 
    // OUT
    $sql="SELECT COUNT(history_id) as total ,DATE_FORMAT(time, '%Y-%m-%d') as time FROM scipk_history WHERE `status` = -1 AND DATE_FORMAT(time, '%Y-%m-%d') >= '".$s_date."' AND DATE_FORMAT(time, '%Y-%m-%d') <= '".$e_date."' GROUP BY day(time)";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $dataOut[] = [
                'total' => $row["total"],
                'time' => $row["time"]
            ];
        }
    } 
    echo json_encode(array('status'=>true,'dataIn'=>$dataIn,'dataOut'=>$dataOut));
    exit();
}else if(!empty($module) && $module == 'duringday'){
    $dataIn = [];
    $dataOut = [];
    $requestPost = json_decode(file_get_contents('php://input')); 
    $s_duringday= $requestPost->s_duringday;
    $e_duringday = $requestPost->e_duringday;
    if(empty($s_duringday) || empty($e_duringday)){
        echo json_encode(array('status'=>false,'message'=>'กรุณาเลือกวันที่ค่ะ'));
        exit();
    }
    $s_duringday = date("Y-m-d H:i:s", strtotime($s_duringday));
    $e_duringday = date("Y-m-d H:i:s", strtotime($e_duringday));
    
    // IN
    $sql="SELECT COUNT(history_id) as total , time FROM scipk_history  WHERE `status` = 1 AND time >= '".$s_duringday."' AND time <= '".$e_duringday."' GROUP BY HOUR(time)";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $dataIn[] = [
                'total' => $row["total"],
                'time' => $row["time"]
            ];
        }
    } 
   
    // OUT
    $sql="SELECT COUNT(history_id) as total , time FROM scipk_history  WHERE `status` = -1 AND time >= '".$s_duringday."' AND time <= '".$e_duringday."' GROUP BY HOUR(time)";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $dataOut[] = [
                'total' => $row["total"],
                'time' => $row["time"]
            ];
        }
    } 
    echo json_encode(array('status'=>true,'dataIn'=>$dataIn,'dataOut'=>$dataOut));
    exit();
}else if(!empty($module) && $module == 'login'){
    $requestPost = json_decode(file_get_contents('php://input')); 
    $email = $requestPost->email;
    $password = $requestPost->password;
    
    if(!empty($email) && !empty($password)){
        $password = md5($password);
        $sql="SELECT * FROM users WHERE email = '".$email."'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $sql="SELECT * FROM users WHERE password = '".$password."'";
            $result = $conn->query($sql);
            if($result->num_rows > 0){
                $row = $result->fetch_assoc();
                 echo json_encode(array('status'=>true,'data'=>$row));
                 exit();
            }
            echo json_encode(array('status'=>false,'message'=>'รหัสผ่านไม่ถูกต้องค่ะ'));
            exit();
        }else{
            echo json_encode(array('status'=>false,'message'=>'ไม่มีผู้ใช้นี้ค่ะ'));
            exit();
        }
    }
    echo json_encode(array('status'=>false,'message'=>'กรุณากรอก email และ password ค่ะ'));
    exit();
    
}else if(!empty($module) && $module == 'register'){
    $requestPost = json_decode(file_get_contents('php://input')); 
   $firstname = $requestPost->firstname;
   $lastname = $requestPost->lastname;
   $email = $requestPost->email;
   $password = $requestPost->password;
   $date = date('Y-m-d');
   if(!empty($firstname) && !empty($lastname) && !empty($email) && !empty($password)){
    $password = md5($password);
    $sql="SELECT * FROM users WHERE email = '".$email."'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        echo json_encode(array('status'=>false,'message'=>'email นี้มีผู้ใช้แล้วค่ะ'));

    } else {
        $firstname = mb_convert_encoding($firstname, "UTF-8");
        $lastname = mb_convert_encoding($lastname, "UTF-8");
       // save your data
       $sql = "INSERT INTO users (firstname,lastname,email,password,created_at) VALUES ('" . $firstname. "',
        '" . $lastname . "','" . $email . "','" . $password. "','" .$date. "')";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(array('status'=>true,'message'=>'สมัครเรียบร้อยค่ะ'));
        } else {
            echo json_encode(array('status'=>false,'message'=>'Error' . $sql . $conn->error));
        }
        exit();
    }
   }else{
    echo json_encode(array('status'=>false,'message'=>'กรุณากรอกข้อมูลให้ครบถ้วนค่ะ'));
    exit();
   }
}else{
    echo json_encode(array('ms'=>'not api'));
}

$conn->close();
?>