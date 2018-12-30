<?php  
header("Content-type:text/html;charset=utf-8");//字符编码设置  
header('Access-Control-Allow-Origin:*');
$servername = "132.232.108.50";  
$username = "root";  
$password = "root";  
$dbname = "test";  


$default_action = 'list';
$action = isset($_GET['action'])?$_GET['action']:$default_action;
// 创建连接  
$con =mysqli_connect($servername, $username, $password, $dbname);
switch ($action) {
    case 'list':
        $sql = "SELECT * FROM test.employ e LEFT JOIN test.department d ON e.department_id = d.id";
        $result = mysqli_query($con,$sql);  
        if (!$result) {
            printf("Error: %s\n", mysqli_error($con));
            exit();
        }
        $jarr = array();
        while ($rows=mysqli_fetch_array($result)){
            $count=count($rows);//不能在循环语句中，由于每次删除 row数组长度都减小  
            for($i=0;$i<$count;$i++){  
                unset($rows[$i]);//删除冗余数据  
            }
            array_push($jarr,$rows);
        }
        echo $str=json_encode($jarr, JSON_UNESCAPED_UNICODE);//将数组进行json编码
        break;
    case 'delete':
        $userid = $_GET['userid'];
        $sql = "delete FROM test.employ where userid= $userid";
        $result = mysqli_query($con,$sql);  
        if (!$result) {
            printf("Error: %s\n", mysqli_error($con));
            exit();
        }
        echo 1;//将数组进行json编码
        break;
    case 'update':
        // 1. 获取前端user json数据
        $user = $_GET['user'];
        // 2. 将json转成php能识别的数组格式；
        $userjson = json_decode($user, true);
        // 3. 将每个数据定义出来 准备sql；
        $userid = $userjson['userid'];
        $username =  (string)$userjson['username'];
        $phone = $userjson['phone'];
        $age = $userjson['age'];
        $department_id = $userjson['departmentid'];
        // 4. 定义sql；
        $sql = "UPDATE employ SET username='$username', phone=$phone, age=$age, department_id=$department_id WHERE userid = $userid";
        echo $sql;
        $result = mysqli_query($con,$sql);  
        if (!$result) {
            printf("Error: %s\n", mysqli_error($con));
            exit();
        }
        echo 1;//将数组进行json编码
        break;
    case 'add':
        $user = $_GET['user'];
        // 2. 将json转成php能识别的数组格式；
        $userjson = json_decode($user, true);
        // 3. 将每个数据定义出来 准备sql；
        $userid = $userjson['userid'];
        $username =  (string)$userjson['username'];
        $phone = $userjson['phone'];
        $age = $userjson['age'];
        $department_id = $userjson['departmentid'];
        // 4. 定义sql；
        $sql = "insert into employ (userid, username,phone,age,department_id) values ($userid,'$username',$phone,$age,$department_id)";
        echo $sql;
        $result = mysqli_query($con,$sql);  
        if (!$result) {
            printf("Error: %s\n", mysqli_error($con));
            exit();
        }
        echo 1;//将数组进行json编码
        break;
}
if($con){
    mysqli_close($con);
}
?>