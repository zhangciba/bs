<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
    <meta charset='utf-8'/>
        <link rel='stylesheet' href='/bs/Public/lib/pintuer/pintuer.css'/>
            <style type='text/css'>
    .s-input{

                text-align:center;
                    }
                        .msg{
                                    text-align:center;
                                            color:#f00;
                                                    font-size:20px;
                                                        }
                                                            </style>
                                                                <script src="/bs/Public/lib/pintuer/jquery.js"></script>
                                                                    <script type='text/javascript'>
    $(function(){   
                    $('#s-search').click(function(e){
                                    var sid = $('#s-input').val();
                                                if(sid.trim()!=''){
                                                                $.post("<?php echo U('Admin/User/student_handler');?>",{type:'view',user:sid},function(r){
                                                                                        //r = JSON.parse(r);
                                                                                        console.log(r);
                                                                                                            $('tbody').children(':not(.th)').remove();
                                                                                                                                if(r!=null){
                                                                                                                                                        var i=0;
                                                                                                                                                                                $('tbody').append("<tr><td><button class='button bg-main bindkt' data-id='"+r[i].user+"'>确认</button></td><td>"+r[i].user+"</td><td>"+(r[i].name||'-')+"</td><td>"+(r[i].status=='1'?'正常':'禁用')+"</td><td>"+(r[i].class||'-')+"</td></tr>");
                                                                                                                                                                                                    }else{
                                                                                                                                                                                                                            $('tbody').append('<tr><td>无任何搜索结果。</td></tr>');
                                                                                                                                                                                                                                                }
                                                                                                                                                                                                                                                                });
                                                                            }
                                                                                    });
                            
                            //绑定课题
                            $('tbody').on('click','.bindkt',function(e){
                                            var ktid = <?php echo ($ktId); ?>;
                                                            sid =$(e.target).attr('data-id');
                                                                        $.post("<?php echo U('Admin/Bs/xt');?>",{ktid:ktid,sid:sid},function(r){
                                                                                                $('.msg').html(r.msg);
                                                                                                            });
                                                                                });
                                });
    </script>
    </head>


    <body>
    <div class="s-search">
        <div style="s-input">                                                         
                <input class="input" id='s-input' style="width:60%;float:left;border-radius:0px" placeholder="请输入学号搜索学生">                                                                                                                 
                        <button type="submit" id='s-search' class="button bg-main" style="margin-left:10px">搜索</button>
                    </div>
                    <table class="table table-hover search-result-table">
                            <tbody>
                                <tr class="th"><th>操作</th><th>账号</th><th>姓名</th><th>状态</th><th>班级</th></tr>
                                </tbody>
                            </table>
                            <p class='msg'></p>                                                                                                                                                                                                                                                </div>

                        </body>

                        </html>