<head>
    <title>无线脉搏上传数据监控</title>
    <script src="js/echarts.js"></script>
    <script src="js/jquery-3.3.1.js"></script>
</head>
<body>
    <h2>心跳传感器上传数据</h2>
    <div id="first" style="height:600px"></div>
    <script type="text/javascript">
              var  myChart = echarts.init(document.getElementById('first'));
              var option = {
                    tooltip: {
                        show:true
                    },
                    legend: {
                       data:['心跳']
                    },
                    xAxis : [
                        {
                            type : 'category',
                            data : (function(){
                                    var arr=[];
                                        $.ajax({
                                        type : "post",
                                        async : false, //同步执行
                                        url : "dateget.php",
                                        data : {},
                                        dataType : "json", //返回数据形式为json
                                        success : function(result) {
                                        if (result) {
                                              console.log(result);
                                               for(var i=0;i<result.length;i++){
                                                  console.log(result[i].updatetime);
                                                  arr.push(result[i].updatetime);
                                                }
                                        }

                                    },
                                    error : function(errorMsg) {
                                        alert("sorry，请求数据失败");
                                        myChart.hideLoading();
                                    }
                                   })
                                   return arr;
                                })()
                        }
                    ],
                    yAxis : [
                        {
                            type : 'value'
                        }
                    ],
                    series : [
                        {
                            "name":"心跳",
                            "type":"bar",
                            "data":(function(){
                                        var arr=[];
                                        $.ajax({
                                        type : "post",
                                        async : false, //同步执行
                                        url : "dateget.php",
                                        data : {},
                                        dataType : "json", //返回数据形式为json
                                        success : function(result) {
                                        if (result) {
                                               for(var i=0;i<result.length;i++){
                                                  console.log(result[i].heartdate);
                                                  arr.push(result[i].heartdate);
                                                }
                                        }
                                    },
                                    error : function(errorMsg) {
                                        alert("sorry，请求数据失败");
                                        myChart.hideLoading();
                                    }
                                   })
                                  return arr;
                            })()

                        }
                    ]
                };
                // 为echarts对象加载数据
                myChart.setOption(option);
            // }
    </script>
    
     <h2>血氧传感器上传数据</h2>
    <div id="second" style="height:600px"></div>
    <script type="text/javascript">
              var  myChart = echarts.init(document.getElementById('second'));
              var option = {
                    tooltip: {
                        show:true
                    },
                    legend: {
                       data:['血氧']
                    },
                    xAxis : [
                        {
                            type : 'category',
                            data : (function(){
                                    var arr=[];
                                        $.ajax({
                                        type : "post",
                                        async : false, //同步执行
                                        url : "dateget2.php",
                                        data : {},
                                        dataType : "json", //返回数据形式为json
                                        success : function(result) {
                                        if (result) {
                                              console.log(result);
                                               for(var i=0;i<result.length;i++){
                                                  console.log(result[i].updatetime);
                                                  arr.push(result[i].updatetime);
                                                }
                                        }

                                    },
                                    error : function(errorMsg) {
                                        alert("sorry，请求数据失败");
                                        myChart.hideLoading();
                                    }
                                   })
                                   return arr;
                                })()
                        }
                    ],
                    yAxis : [
                        {
                            type : 'value'
                        }
                    ],
                    series : [
                        {
                            "name":"血氧",
                            "type":"bar",
                            "data":(function(){
                                        var arr=[];
                                        $.ajax({
                                        type : "post",
                                        async : false, //同步执行
                                        url : "dateget2.php",
                                        data : {},
                                        dataType : "json", //返回数据形式为json
                                        success : function(result) {
                                        if (result) {
                                               for(var i=0;i<result.length;i++){
                                                  console.log(result[i].heartdate);
                                                  arr.push(result[i].heartdate);
                                                }
                                        }
                                    },
                                    error : function(errorMsg) {
                                        alert("sorry，请求数据失败");
                                        myChart.hideLoading();
                                    }
                                   })
                                  return arr;
                            })()

                        }
                    ]
                };
                // 为echarts对象加载数据
                myChart.setOption(option);
            // }
    </script>
</body>