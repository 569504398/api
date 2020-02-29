<?php
  $URL="http://localhost:8080";
  // 设置允许访问的服务器,其它服务器是不允许获取该数据的
  header("Access-Control-Allow-Origin:*");  
include_once("mysql.php");
$mysql= new  MyMysql("test","weibo");


//插入数据   add($content)
  if(isset($_GET["content"])){
           $data=$mysql->add($_GET["content"]);
          $data= json_encode($data);
            echo $data;
  }


// 删除数据     delete($id)
        if(isset($_GET["id"])&&isset($_GET["biaoji"])){
            $data=$mysql->delete($_GET["id"]);
            $data= json_encode($data);
            echo $data;
        }
        // echo "<pre>";
        // $date=$mysql->show();
        // print_r($date);
//展示数据     show()
    if(isset($_GET["page"])){
        $data=  json_encode($mysql->show());
        echo $data;
  }
        
//改数据  updateCai($cai, $id)
if(isset($_GET["id"])&&isset($_GET["cai"])){
    $data=$mysql->updateCai($_GET["cai"],$_GET["id"]);
    $data= json_encode($data);
    echo $data;
}

//改数据  updateding($ding, $id)
if(isset($_GET["id"])&&isset($_GET["ding"])){
    $data=$mysql->updateding($_GET["ding"],$_GET["id"]);
    $data= json_encode($data);
    echo $data;
}


// getPages($per_count)  获取页数
if(isset($_GET["per_count"])&&isset($_GET["current_page"])){    
            $pages=$mysql->getPages($_GET["per_count"],$_GET["current_page"]);
             $data=json_encode($pages);
             echo $data;
}
   

