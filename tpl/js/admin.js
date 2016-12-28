$(function () {
    $tableData = $(".table tbody");
    listNews();

    function listNews() {
        $.ajax({
            type:'GET',
            url:'../controller/NewsController.php?do=list',
            dataType:'json',
            success:function (text) {
                //渲染数据之前，先情空列表
                $tableData.empty();
                text.forEach(function (item,index) {
                    var obj = JSON.parse(item);  //将JSON字符串转成Object
                    var $tdId = $("<td>").html(obj.news_id);
                    var $tdTitle = $("<td>").html(obj.news_title.slice(0,8));
                    var $tdContent = $("<td>").html(obj.news_content.slice(0,8));
                    var $tdMark = $("<td>").html(obj.news_mark);
                    var $tdTime = $("<td>").html(obj.post_time);
                    var $tdType = $("<td>").html(obj.news_classification);
                    var $editBtn = $("<button>").addClass("btn btn-primary btn-xs").html("编辑");
                    var $delBtn = $("<button>").addClass("btn btn-danger btn-xs").html("删除");
                    var $tdOperator = $("<td>").append($editBtn,$delBtn);
                    var $tr = $("<tr>");
                    $tr.append($tdId,$tdTitle,$tdContent,$tdMark,$tdTime,$tdType,$tdOperator);
                    $tableData.append($tr);
                });
            }
        })
    }

    //事件委托
    var newsId = null;
    $(".table").on('click','.btn-danger',function () {
        $("#delModal").modal("show");
        newsId = $(this).parent().prevAll().eq(5).html();
    });
    //删除确认，向后台发送数据
    $("#confirmBtn").on('click',function () {
        $.ajax({
            type:'GET',
            url:'../controller/NewsController.php?do=del',
            data:{'newsId':newsId},
            dataType:'json',
            success:function (data) {  //数据成功返回之后的回调函数
                console.log(data);
                listNews(); //让新闻列表再次渲染
            }
        });
        $("#delModal").modal("hide");
    })

    //添加文章
    //点击添加文章 调用添加文章的模态框
    $("#add").click(function () {
        $("#addModal").modal("show");
    });
    //点击模态框添加文章按钮 向后台发送数据
    $("#addBtn").click(function () {
        var newsJson = {
            "newsId":"",
            "newsTitle":$("#addNewsTitle").val(),
            "newsContent":$("#addNewsContent").val(),
            "newsMark":$("#addNewsMark").val(),
            "newsClassify":$("#addNewsType").val()
        }
        $.ajax({
            type:"POST",
            url:"../controller/add.php",
            data:newsJson,
            dataType:"json",
            success:function (data){
              console.log(data);
                $("#addModal").modal("hide");  //关闭模态框
                listNews();
            }
        });
    });

    //编辑新闻，事件委托打开模态框 加载数据
    $("#dataTable").on('click','.btn-primary',function (){
        $("#editModal").modal("show");
        newsId =  $(this).parent().prevAll().eq(5).html();
        console.log(newsId);
        $.ajax({
            type:"GET",
            url:"../controller/findRow.php",
            data:{"newsId":newsId},
            dataType:"json",
            success:function (data){
                $("#editNewsTitle").val(data.news_title);
                $("#editNewsContent").val(data.news_content);
                $("#editNewsMark").val(data.news_mark);
                $("#editNewsType").val(data.news_classification);
            }
        });
    });
    $("#editBtn").click(function () {
        var newsJson = {
            "newsId":newsId,
            "newsTitle":$("#editNewsTitle").val(),
            "newsContent":$("#editNewsContent").val(),
            "newsMark":$("#editNewsMark").val(),
            "newsClassify":$("#editNewsType").val()
        }
        $.ajax({
            type:"POST",
            url:"../controller/add.php",
            data:newsJson,
            dataType:"json",
            success:function (data){
                console.log(data);
                $("#editModal").modal("hide");  //关闭模态框
                listNews();
            }
        });
    });


    //点击


});
