<?php
/**
 * Created by PhpStorm.
 * User: Flying
 * Date: 2016/9/27
 * Time: 19:10
 */
class  MyMysql
{
            protected  $mysql_server_name;
            protected $mysql_username;
            protected $mysql_password;
            protected $mysql_database;
            protected $mysql_table;   
             protected $mysqli;
                   
         public   function __construct($database,$table) {
                        $this->mysql_server_name="localhost"      ;       //      "localhost" ;//改成自己的mysql数据库服务器
                        $this->mysql_username="root"   ;      //"root";//改成自己的mysql数据库用户名
                        $this->mysql_password="123456"  ; //  "//123456";//改成自己的mysql数据库密码
                        $this->mysql_database=$database;    //"test";//改成自己的mysql数据【库】名
                        $this->mysql_table=$table; //  "weibo";//改成自己的mysql数据【表】名
                    $this->mysqli = new mysqli($this->mysql_server_name, $this->mysql_username, $this->mysql_password); 
                    if(mysqli_connect_errno()){
                            echo "数据库连接失败";
                   }
                
                 $res=$this->mysqli->select_db($this->mysql_database);
                        if($this->mysqli->errno){
                               echo "操作数据库错误";
                        }
        }
    

                       
           /** 删除 数据库 */
           public    function deleteDatabase(){
            $sql_delete_db = "drop database $this->mysql_database";
                    if ($this->mysqli->query($sql_delete_db) === true) {
                        printf("delete db4 ok");
                    } else {
                        printf("delete db4 failed: %s\n", $mysqli->connect_error);
                    }
        }  
    
    
                    /**
                     * 创建数据库：db4
                     */
                   public function createDatabase(){
                        $sql_create_db = "create database $this->mysql_database";
                        if ($this->mysqli->query($sql_create_db) === true) {
                            println("create db4 ok");
                        } else {
                            println("create db4 failed:" . $this->mysqli->error);
                        }
                }
    
                    /**
             * 创建数据表；person
             */
           public function  createTable(){
    
                $sql_create_table = "create table $this->mysql_table(id int NOT NULL AUTO_INCREMENT,PRIMARY KEY(id),content varchar(15) not null default '',time int not null default 0,cai int not null default 0,ding int not null default 0)";
                    if ($this->mysqli->query($sql_create_table) === true) {
                        println("create table ok");
                    } else {
                        println("create table failed:" . $mysqli->error);
                    }
            }
    
    
            /**
             * 从表（person）中删除数据；
             */
    
           public  function  delete($id){
                $sql_delete = "delete from $this->mysql_table where id= $id";
                    if ($this->mysqli->query($sql_delete) === true) {
                            return  ["statu"=>1];
                    } else {
                            return ["statu"=>0];
                    }
            }
    
    
            /**
             * 在表（person）中插入新数据；
             *  
             */
             public   function add($content){
                        //只要使用this或者外部new 对象,就会调用构造函数
                               $time=time();
                              //外层双引号能解释变量
                            $sql_inset = "insert into $this->mysql_table (content,time) value ('$content',$time)";
                            if ($this->mysqli->query($sql_inset) === true) {
                                    //每次成功插入可用
                                $id=mysqli_insert_id($this->mysqli);
                                            return  ["statu"=>1,"id"=>$id];
                            } else {
                                            return  ["statu"=>0,"sql"=>$sql_inset];
                            }
                }
                
           
                    /**
                     * 从表（person）中查询数据；
                     */
              public   function show($type){
                        // 测试可以看出当传入的是字符串时,替换变量后,引号消失需要引变量
                        $sql_select = "select * from  $this->mysql_table  where  type='$type'";
                        // $sql_select = "select * from  $this->mysql_table ";
                           
                                if ($result = $this->mysqli->query($sql_select)) {
                                    // printf("Select returned %d rows.\n", $result->num_rows);
                                    $arr=[];
                                    //从结果集获取一个关联数组   mysqli_fetch_row()
                                        //结果集获取一行关联数组
                                    while ($row=mysqli_fetch_assoc($result)) {
                                                    $arr[]=$row;
                                    }
                                            
                                            return  $arr;
       
                            $result->close();
                        }
                        echo   $this->mysql_table."这个表不存在";
             }
            
      
            /**
             * 更新表（person）中数据；
             */
                public    function updateCai($cai, $id){
                        $sql_update = "update $this->mysql_table set   cai = $cai    where id=$id";
                                if ($this->mysqli->query($sql_update) === true) {
                                           return  ["statu"=>1];
                                } else {
                                        return  ["statu"=>0];
                                /**
                                 * 关闭连接
                                 */
                                $mysqli->close();
                    }
                }
                public    function updateDing($ding, $id){
                        $sql_update = "update $this->mysql_table set   ding = $ding    where id=$id";
                                if ($this->mysqli->query($sql_update) === true) {
                                            return  ["statu"=>1];  
                                } else {
                                           return  ["statu"=>0];
                                }
                                /**
                                 * 关闭连接
                                 */
                                $this->mysqli->close();
                    }
            
                        //获取页数,参数每页的数据
                    public function getPages($per_count,$current_page, $table,$type)
                    {
                            $a=[];
                             $sql=" select  count(*)  from    $table  where type='$type' ";

                             //获取启始位置
                               $start= ($current_page-1)*$per_count;
                          $sql2=   "select * from  $this->mysql_table  where type='$type'   limit  $start, $per_count  ";
                                    if($result=$this->mysqli->query($sql2)){
                                        // mysqli_result Object ( [current_field] => 0 [field_count] => 5 [lengths] => [num_rows] => 4 [type] => 0 )
                                       while($res = mysqli_fetch_assoc($result)){        
                                                    $a[]=$res;
                                                   
                                       };     
                                            
                                    }
                              
                             if($result=$this->mysqli->query($sql)){
                                         $res = mysqli_fetch_assoc($result);
                                         $pages=1;
                                         //总记录
                                        $sum= $res['count(*)'];
                                    
                                        if($sum<=$per_count){
                                              $b=  ["sum"=>$sum,"pages"=>1 ];
                                        }
                                       if(($sum%$per_count)!=0){
                                                $pages=ceil($sum/$per_count);
                                                
                                                $b=  ["sum"=>$sum,"pages"=>$pages ];
                                       }else{
                                               
                                                $b = ["sum"=>$sum,"pages"=>$sum/$per_count ];
                                       }
                                       
                                   
                             }else{
                                      echo "0";
                             }
                                         $arr[]=$a;
                                         $arr[]=$b;
                                     return  $arr;
                            }

                        //获取商品详情  1,"goods_imgs"
             public     function getGoodsDetail($id,$table){
                          $arr=[];
                           $sql=" select  * from    $table  where goods_id=$id";
                                  if($result=$this->mysqli->query($sql)){
                                     while($res = mysqli_fetch_assoc($result)){        
                                                  $arr[]=$res;
                                                 
                                     };                       
                                 }
                    // return  $sql;
                    return  $arr;
            }
         //获取商品图片
            public     function getGoodsImgs($id,$table){
                $arr=[];
                 $sql=" select  * from    $table  where imgs_id=$id";
                        if($result=$this->mysqli->query($sql)){
                           while($res = mysqli_fetch_assoc($result)){        
                                        $arr[]=$res;
                                       
                           };                       
                       }
          // return  $sql;
          return  $arr;
  }


    
    public function test()
        {
            echo     $this->mysql_username;
        }
       
}

            // $a=new MyMysql();
            // $b=$a->getPages(2,1);
            //     echo "</pre>";
            //     print_r($b);
        

        

       



