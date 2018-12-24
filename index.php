<?php  
header("Content-type:text/html;charset=utf-8");//字符编码设置  
header('Access-Control-Allow-Origin:*');
$servername = "132.232.108.50";  
$username = "root";  
$password = "root";  
$dbname = "test";  

// 创建连接  
$con =mysqli_connect($servername, $username, $password, $dbname);  

// 检测连接  
if($_GET['id']){
    $id = $_GET['id'];
    $sql = "SELECT * FROM metro where id = $id";
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
}
mysqli_close($con);
?>