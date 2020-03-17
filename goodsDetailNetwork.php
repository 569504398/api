<?php
  $URL="http://localhost:8080";
  // 设置允许访问的服务器,其它服务器是不允许获取该数据的
  header("Access-Control-Allow-Origin:*");  
include_once("mysql.php");
$mysql= new  MyMysql("surpermall","goods_detail_network");



      
//展示数据     show()
    if(isset($_GET["page"])){
        $pop=$mysql->show('pop');
        $new=$mysql->show('new');
        $sell=$mysql->show('sell');
    
        $data=[
                'pop'=>$pop,
                'new'=>$sell,
                'sell'=>$new
        ];
        $data=json_encode($data);

        echo $data;
  }
      


    

// getPages($per_count)  获取页数
if(isset($_GET["id"])){    
            $data=$mysql->getGoodsDetail($_GET["id"],"goods_detail_network");
             $data=json_encode($data);
             echo $data;        
}
   

