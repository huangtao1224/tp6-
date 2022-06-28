function ajax_load(path){
    var htmls;
    $.ajax({
        type: "post",
        url: path,
        data: '',
        async:false,
        dataType:"html",
        success: function(html){
            htmls=html;
        }
    });
    return htmls;
}
function ajax_list(path,data){
    var htmls;
    $.ajax({
        type: "post",
        url: path,
        data: data,
        async:false,
        dataType:"json",
        success: function(msg){
            htmls = msg;
        }
    });
    return htmls;
}

/*删除*/
function member_del(obj,url,id,type_id=''){
    layer.confirm('确认要删除吗？',function(index){
        var data = {id:id,type_id:type_id};
        var msg = ajax_list(url,data);
        if(msg.code==200){
            $(obj).parents("tr").remove();
            layer.msg(msg.msg,{icon:1,time:1000},function () {
                window.location.reload();
            });
        }else{
            layer.msg(msg.msg,{icon:2,time:1000});
        }
    });
}
/*内容删除*/
function content_del(obj,url,id,type_id,classify_id){
    layer.confirm('确认要删除吗？',function(index){
        var data = {id:id,type_id:type_id,classify_id:classify_id};
        var msg = ajax_list(url,data);
        console.log(msg);return false;
        if(msg.code==200){
            $(obj).parents("tr").remove();
            layer.msg(msg.msg,{icon:1,time:1000},function () {
                window.location.reload();
            });
        }else{
            layer.msg(msg.msg,{icon:2,time:1000});
        }
    });
}
//登陆
function link_login() {
    var username = $.trim($("input[name='username']").val());
    var password = $.trim($("input[name='password']").val());
    var code = $.trim($("input[name='code']").val());


    if(!username){
        layer.msg('请输入用户名', {icon: 2});
        return false;
    }
    if(!password){
        layer.msg('请输入用密码', {icon: 2});
        return false;
    }

    if(code){
        var htm = ajax_load("/admin/index/code?verify="+code);
        if(htm==1){
            layer.msg('验证码错误', {icon: 2});
            return false;
        }
    }else{
        layer.msg('请输入验证码', {icon: 2});
        return false;
    }

    $.post('/admin/login/login_save',{
        username:username,
        password:password
    },function(data){
        if(data=='1'){
            location.href="/admin";
        }else{
            layer.msg(data, {icon: 2});
        }
    })
}

$(document).ready(function () {
    var tips;
    $('i.bi-question-circle-fill').on({
        mouseenter:function(){
            var that = this;
            tips =layer.tips($(this).attr('lay-tips'),that,{time:0});
        },
        mouseleave:function(){
            layer.close(tips);
        }
    });
    layui.use(['form','laydate','colorpicker','upload'], function(){
        var form = layui.form;
        var laydate = layui.laydate;
        var colorpicker = layui.colorpicker;
        var upload = layui.upload;
        var $ = layui.jquery;

        //时间渲染
        laydate.render({
            type: 'datetime',
            elem: '.layerdate' //指定元素
        });

        //颜色拾取
        colorpicker.render({
            elem : '.coloris',//绑定元素
            color: '#1c97f5',
            done: function(color){
                $($(this)[0].elem).prev().find('input').val(color);
            }
        });

        //类型浮点
        form.on("select(data_type_id)", function(data){
            if(data.value==3){
                $('.decimal_point').removeAttr('style');
            }else{
                $('.decimal_point').css('display','none');
            }
        });

        //类型设置显示、隐藏
        form.on('switch(show)', function (data) {
            var show_id;
            var x = data.elem.checked;//判断开关状态
            var id = $(this).attr('pid');
            if (x == true) {
                show_id = "2";
            } else {
                show_id = "1";
            }
            $.ajax({
                type:'post',
                url:'/admin/type/show_hide',
                data:{id:id,show_id:show_id},
                success:function (msg) {
                    if (x == true) {
                        layer.msg('已显示');
                    } else {
                        layer.msg('已隐藏');
                    }
                }
            })
        })

        //管理员设置启用、禁止
        form.on('switch(user_show)', function (data) {
            var show_id;
            var x = data.elem.checked;//判断开关状态
            var id = $(this).attr('pid');
            if (x == true) {
                show_id = "1";
            } else {
                show_id = "2";
            }
            $.ajax({
                type:'post',
                url:'/admin/Administrator/show_hide',
                data:{id:id,show_id:show_id},
                success:function (msg) {
                    if (x == true) {
                        layer.msg('已启用');
                    } else {
                        layer.msg('已禁用');
                    }
                }
            })
        });

        //功能开关设置启用、禁止
        form.on('switch(function_show)', function (data) {
            var show_id;
            var x = data.elem.checked;//判断开关状态
            var id = $(this).attr('pid');
            if (x == true) {
                show_id = "1";
            } else {
                show_id = "2";
            }
            $.ajax({
                type:'post',
                url:'/admin/Config/show_hide',
                data:{id:id,show_id:show_id},
                success:function (msg) {
                    if (x == true) {
                        layer.msg('已启用');
                    } else {
                        layer.msg('已禁用');
                    }
                }
            })
        });

        //监听选择角色
        form.on('checkbox(role)', function (data) {
            var checkboxs=$(this).parents('#role').find('input[type="checkbox"]');
            if(data.value==1||data.value==2){
                if(data.elem.checked){
                    checkboxs.prop("checked", false).prop('disabled',true);//勾选，其余禁选
                    $(this).prop("checked", true).removeAttr('disabled');
                }else{
                    checkboxs.prop("checked", false).prop('disabled',false);//设置全部复选框选中状态为取消，并可以选中
                }
            }
            form.render('checkbox');
        });

        //自定义验证规则----------管理员必填一种角色
        form.verify({
            otherReq: function(value,item){
                var $ = layui.$;
                var verifyName=$(item).attr('name')
                    , verifyType=$(item).attr('type')
                    ,formElem=$(item).parents('.layui-form')//获取当前所在的form元素，如果存在的话
                    ,verifyElem=formElem.find('input[name='+verifyName+']')//获取需要校验的元素
                    ,isTrue= verifyElem.is(':checked')//是否命中校验
                    ,focusElem = verifyElem.next().find('i.layui-icon');//焦点元素
                if(!isTrue || !value){
                    //定位焦点
                    focusElem.css(verifyType=='radio'?{"color":"#FF5722"}:{"border-color":"#FF5722"});
                    //对非输入框设置焦点
                    focusElem.first().attr("tabIndex","1").css("outline","0").blur(function() {
                        focusElem.css(verifyType=='radio'?{"color":""}:{"border-color":""});
                    }).focus();
                    return '必填项不能为空';
                }
            }
        });

        //内容全选、取消
        form.on('checkbox(choseAll)',function (data) {
            console.log(data.elem.checked);
            $('.child').prop('checked',data.elem.checked);
            form.render('checkbox')
        });
        //内容复选框（子按钮全部选中，全选框自动选中）
        form.on('checkbox(child)',function (data) {
            var flag = true;
            $('.child').each(function (index,item) {
                if(item.checked === false){
                    flag = false;
                }
            });
            $('.choseAll').prop('checked',flag);
            form.render('checkbox')
        });

        //角色权限全选、取消
        $('.perssion_box').each(function () {
            var filter = $(this).find('.allChoose').attr('lay-filter');
            form.on('checkbox('+filter+')', function (data) {
                $("input."+filter+"").each(function () {
                    this.checked = data.elem.checked;
                });
                form.render('checkbox');
            });

        });

        $('.rule_box').each(function () {
            var filter2 = $(this).find('.allChoose2').attr('lay-filter');
            console.log(filter2);
            form.on('checkbox('+filter2+')', function (data) {
                $("input."+filter2+"").each(function () {
                    this.checked = data.elem.checked;
                });
                form.render('checkbox');
            });
        });

        //常用表单提交
        form.on('submit(*)', function(data){
            //获取checkbox数据,组装成数组!!!!!!
            var checkboxObj = {};
            $('input[type="checkbox"]:checked').each(function (index, obj) {
                    let name = $(this).attr('name');
                    let value = $(this).val();
                    if (checkboxObj[name]) {
                        checkboxObj[name].push(value)
                    } else {
                        checkboxObj[name] = [];
                        checkboxObj[name].push(value)
                    }
                }
            );
            let submitData = {
                ...data.field,
                ...checkboxObj
            };
            $.ajax({
                url:$(this).attr('data-url'),
                type:'post',
                data:submitData,
                // dataType:'json',
                success:function (msg) {
                    console.log(msg);
                    // if(msg.code==200){
                    //     layer.msg(msg.msg,{icon:1,time:1000},function () {
                    //         //window.parent.location.reload();
                    //     });
                    // }else{
                    //     layer.msg(msg.msg,{icon:2,time:1000});
                    //     return false;
                    // }
                }
            });
            return false;
        });

        //表单批量修改提交
        form.on('submit(batch_edit_save)', function(data){
            $.ajax({
                url:$(this).attr('data-url'),
                type:'post',
                data:data.field,
                // dataType:'json',
                success:function (msg) {
                    console.log(msg);
                    // if(msg.code==200){
                    //     layer.msg(msg.msg,{icon:1,time:1000},function () {
                    //         window.location.reload();
                    //     });
                    // }else{
                    //     layer.msg(msg.msg,{icon:2,time:1000});
                    //     return false;
                    // }
                }
            });
            return false;
        });

        //导出全选、取消
        form.on('checkbox(xlsChoseAll)',function (data) {
            $('.xlsChild').prop('checked',data.elem.checked);
            form.render('checkbox')
        });
        //导出复选框（子按钮全部选中，全选框自动选中）
        form.on('checkbox(xlsChild)',function (data) {
            var flag = true;
            $('.xlsChild').each(function (index,item) {
                if(item.checked === false){
                    flag = false;
                }
            });
            $('.xlsChoseAll').prop('checked',flag);
            form.render('checkbox')
        });
        //导出
        form.on('select(xls_content)', function(data){
            if(data.value=='1'||data.value=='2'){
                $('.xls_content_box').show();
            }else{
                $('.xls_content_box').hide();
            }
        });
        $('.xls_btn').click(function () {
            let xls_content = $('#xls_content').val();
            let url = $(this).attr('data-url');
            $('form').attr('active',url);
            let field = '';
            let data = '';
            let type_id = $(this).attr('data-type-id');
            $("input:checkbox[name='xlsChild[]']:checked").each(function() {
                field+=($(this).val()+',');
            });
            $("input:checkbox[name='child[]']:checked").each(function() {
                data+=($(this).val()+',');
            });
            if(xls_content==''){
                layer.msg('请选择导出类型');
                return false;
            }
            if((xls_content==1||xls_content==2)&&field==''){
                layer.msg('请选择导出字段');
                return false;
            }
            if(xls_content==1&&data==''){
                layer.msg('请选择导出数据');
                return false;
            }
            $('#exportForm input[name="xls_content"]').val(xls_content);
            $('#exportForm input[name="field"]').val(field);
            $('#exportForm input[name="data"]').val(data);
            $('#exportForm')[0].submit();
        })
    });
    //导入获取上传文件名及大小
    $(".top_up input[type='file']").on("change", function() {
        var items = $(this)[0].files;
        $(this).parents('.top_up').next().html(items[0].name);
    });
    //获取上传文件名及大小
    $(".link_up_size input[type='file']").on("change", function() {
        // if($(this).parents('.link_up_size').hasClass('state')){
        //     layer.confirm('设为默认图片尺寸?', {
        //         btn: ['确定','取消'] //按钮
        //     }, function(index){
        //
        //     })
        // }else{
        //     alert('a');
        // }
        var items = $(this)[0].files;
        // var reader = new FileReader();
        // reader.readAsDataURL(items[0]);
        // reader.onload = function (evt) {
        //     var replaceSrc = evt.target.result;
        //     var imageObj = new Image();
        //     imageObj.src = replaceSrc;
        //     imageObj.onload = function () {
        //         $.ajax({
        //
        //         })
        //         console.log(imageObj.width );
        //         console.log(imageObj.height );
        //         // 执行上传的方法，获取外网路径，上传进度等
        //     };
        // };
        $(this).parents('.link_up_size').next().html(items[0].name);
    });

    //带文件表单上传
    $("#layui-form").submit(function (event) {
        event.preventDefault();
        $.ajax({
            url:$(this).attr('action'),
            type:"POST",
            data:new FormData(this),
            contentType:false,
            processData:false,
            success:function(status){
                console.log(status);
            }
        })
    });
    
    // 栏目多级显示效果
    $('.bi-caret-right-fill').parent('td').click(function () {
        if($(this).attr('status')=='true'){
            $(this).children('.bi-caret-right-fill').css({'transform': 'rotate( 90deg)'});
            $(this).attr('status','false');
            cateId = $(this).parents('tr').attr('cate-id');
            $("tbody tr[fid="+cateId+"]").show();
        }else{
            cateIds = [];
            $(this).children('.bi-caret-right-fill').css({'transform': 'rotate( 0deg)'});
            $(this).attr('status','true');
            cateId = $(this).parents('tr').attr('cate-id');
            getCateId(cateId);
            for (var i in cateIds) {
                $("tbody tr[cate-id="+cateIds[i]+"]").hide().find('.bi-caret-right-fill').css({'transform': 'rotate( 0deg)'}).attr('status','true');
            }
        }
    });
    var cateIds = [];
    function getCateId(cateId) {
        $("tbody tr[fid="+cateId+"]").each(function(index, el) {
            id = $(el).attr('cate-id');
            cateIds.push(id);
            getCateId(id);
        });
    }
});



