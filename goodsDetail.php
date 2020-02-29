<?php
  $URL="http://localhost:8080";
  //1. 设置允许访问的服务器,其它服务器是不允许获取该数据的
  header("Access-Control-Allow-Origin:*");  
  // header('Expires:Thu , 10   Feb  2020 20:08:33 GMT');
  header('Content-length:131');
header('Content-type: text/javascript');
header('HTTP/1.1 200 OK');

// header("Content-Type: application/json");

include_once("mysql.php");
$mysql= new  MyMysql("surpermall","goods_detail");
$imgs= new  MyMysql("surpermall","goods_imgs");


 
      
//展示首页   show()
    if(isset($_GET["page"])){
        $pop=$mysql->show('pop');
        $new=$mysql->show('new');
        $sell=$mysql->show('sell');
   
        $data=[
                'pop'=>$pop,
                'new'=>$sell,
                'sell'=>$new,
              
        ];
        $data=json_encode($data);

        echo $data;
  }
      


    

// 详情页
if(isset($_GET["id"])){    
            $data=$mysql->getGoodsDetail($_GET["id"],"goods_detail");
          // 1.获取图片id
               $id=$data[0]["img_id"];
               //获取相关图片
      
          $goodsImgs=$imgs->getGoodsImgs($id,"goods_imgs");
          $data=[
               "goods_detail"=>$data,
                "topImgs"=>$goodsImgs
          ];
             $data=json_encode($data);
          echo  $data;
    
                   
}
   

