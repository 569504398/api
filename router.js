// 路由层

let express = require("express")
let jwt = require("jsonwebtoken")
let fs = require("fs")
let students = require("./model/login.js")

//路由容器
let router = express.Router()

//首页
router.get("/student", function (req, res) {
      students.find(function (error, data) {
            if (error) {
                  return res.status(500).send(error)
            }
            let rule = {
                  id: 1,
                  name: "liuyi"
            }
            jwt.sign(rule, 'Bearer ', {
                  expiresIn: 3600
            }, function (err, token) {
                  if (err) throw err;
                  res.json({
                        status: 0,
                        msg: 'Bearer ' + token
                  })
            });
            //服务器端渲染这里是将数据与相应的模板进行绑 定，渲染好htMl页面后返回

      });

})

//登录
router.post("/login", function (req, res) {
      //获取表单数据，传递到model层进行处理
      let form = req.body
      students.find(form, function (error, data) {
            if (error) {
                  return res.status(500).send(error)
            } else if (data) {
                  //生成token值,并通过json响应给客户端 
                  jwt.sign(data, 'Bearer ', {
                        expiresIn: 3600
                  }, function (err, token) {
                        if (err) throw err;
                        res.json({
                              status: 200,
                              msg: "登录成功",
                              token: 'Bearer ' + token
                        })
                  });
            } else {
                  res.json({
                        status: 400,
                        msg: "用户名或密码不存在"
                  })
            }
      });

})

//获取分页列表   127.0.0.1:7000/users?perCount=2&currentPage=1
router.get("/users", function (req, res) {
      let form = req.query
      students.getUser(form, function (err, data) {
            if (err) {
                  return res.status(500).json({
                        img: "请求失败",
                        status: 500
                  })
            }
            data.status = 200,
                  data.img = "请求成功"
            res.json(data)
      })
})

//修改状态    http://127.0.0.1:7000/users/2/state/2
router.put("/users/:uid/state/:type", function (req, res) {
      let id = req.params.uid
      let status = req.params.type
      students.UpdateStatus({
            id,
            status
      }, function (err) {
            if (err) {
                  return res.status(500).json({
                        img: "设置状态失败",
                        status: 500
                  })
            }
            res.json({
                  img: "设置状态成功",
                  status: 200
            })
      })
})


//添加用户信息
router.post("/users", function (req, res) {
      students.addUser(req.body, function (err) {
            if (err) {
                  return res.status(500).json({
                        "img": "添加用户失败",
                        "status": 500
                  })
            }
            res.json({
                  img: "添加用户成功",
                  status: 201
            })
      })
})

//修改用户操作
router.put("/users/:id", function (req, res) {
      req.body.id = parseInt(req.params.id)
      students.editUser(req.body, function (err) {
            if (err) {
                  return res.status(500).json({
                        "img": "修改用户失败",
                        "status": 500
                  })
            }
            res.json({
                  img: "修改用户成功",
                  status: 200
            })
      })

})

//删除用户信息
router.delete("/users/:id",function(req,res){
        students.deleteUser(req.params.id,function(err){
              if(err){
                  return res.status(500).json({
                        "img": "修改用户失败",
                        "status": 500
                  })
              }
              res.json({
                  img: "修改用户成功",
                  status: 200
            })
        })
         
})

//添加页
router.get("/student/new", function (req, res) {
      res.render('new.html')
})


//处理添加请求
router.post("/student/new", function (req, res) {
      students.insert(req.body, function (error) {
            if (error) {
                  res.status(500).send("server error")
            }
            return res.redirect("/student")
      })
})

//修改页
router.get("/student/edit", function (req, res) {

      students.findById(req.query.id, function (error, student) {
            if (error) {
                  res.status(500).send("server error")
            }
            res.render("edit.html", {
                  student: student
            })
      })
})

//处理修改页

router.post("/student/edit", function (req, res) {
      students.update(req.body, function (error, obj) {
            if (error) {
                  res.status(500).send("server error")
            }
            res.redirect("/student")

      })
})

router.get("/student/delete", function (req, res) {
      students.deleteById(req.query.id, function (error, data) {
            if (error) {
                  res.status(500).send("server error")
            }
            // res.send(data)
            res.redirect("/student")
      })
})



module.exports = router