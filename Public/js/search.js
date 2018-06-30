
///开始定义全局内容
var i = $("input[name=key]");
var fouce_li_num = -1;///默认没有选择任何下拉内容
var width_ = i.css('width');//这里设置的是搜索框的宽度，目的为了与下面的列表宽度相同
// var top_ = i.offset().top;
var li_color = "#fff";//默认的下拉背景颜色
var li_color_ = "#CCC";//当下拉选项获取焦点后背景颜色
$(function(){

    $('.msg').click(function () {
        layer.prompt({title: 'Your Name', formType: 1}, function(name, index){
            layer.close(index);
            layer.prompt({title: 'Your Message', formType: 2}, function(text, index){
                layer.close(index);
                $.post(
                    SubMsg,
                    {
                        name: name,
                        message: text
                    },
                    function(data, textStatus, xhr) {
                        layer.msg(data.msg)
                });
            });
        });
    });

    $("#input-709").fileinput({
        uploadUrl: SubUrl,
        uploadAsync: true,
        showPreview: false,
        allowedFileExtensions: ['torrent'],
        maxFileCount: 5,
        elErrorContainer: '#kv-error-1'
    }).on('filebatchpreupload', function(event, data, id, index) {
        $('#kv-success-1').html('<h4>SysInformation!</h4><ul></ul>').hide();
    }).on('fileuploaded', function(event, data, id, index) {
        if(data.jqXHR.responseJSON.code == 200){
            var fname = data.files[index].name;
            $('#kv-success-1 ul').append("<strong>Uploaded "+fname+" successfully!</strong><br>Now you can find it from the search Cp");
            $('#kv-success-1').fadeIn('slow');
            setTimeout("$('#kv-success-1').fadeOut('slow')",5000)
        }else if(data.jqXHR.responseJSON.code == 504){
            $('#kv-success-1 ul').append("<strong>"+data.jqXHR.responseJSON.msg+" Is Forbidden!!!</strong>");
            $('#kv-success-1').fadeIn('slow');
            setTimeout("$('#kv-success-1').fadeOut('slow')",5000)
        }
    });

    i.keyup(function(event){
        var keycode = event.keyCode;
        if(delkeycode(keycode))return;
        var key_ = $(this).val();//获取搜索值
        // var top_ = $(this).offset().top;//获搜索框的顶部位移
        var left_ = $(this).offset().left;//获取搜索框的左边位移
        if(keycode==13){
            //enter search
            if(fouce_li_num>=0){
                $(this).val($.trim($("#foraspcn >li:eq("+fouce_li_num+")").text()));
                fouce_li_num=-1;
            }else{
                /////当没有选中下拉表内容时 则提交form 这里可以自定义提交你的搜索
            }
            $("#foraspcn").hide();
        }else if(keycode==40){
            //单击键盘向下按键
            fouce_li_num++;
            var li_allnum = $("#foraspcn >li").css("background-color",li_color).size();
            if(fouce_li_num>=li_allnum&&li_allnum!=0){
                //当下拉选择不为空时
                fouce_li_num=0;
            }else if(li_allnum==0){fouce_li_num--;return;}
            $("#foraspcn >li:eq("+fouce_li_num+")").css("background-color",li_color_);
        }else if(keycode==38){
            //点击键盘向上按键
            fouce_li_num--;
            var li_allnum = $("#foraspcn >li").css("background-color",li_color).size();
            if(fouce_li_num<0&&li_allnum!=0){
                //当下拉选择不为空时
                fouce_li_num=li_allnum-1;
            }else if(li_allnum==0){fouce_li_num++;return;}
            $("#foraspcn >li:eq("+fouce_li_num+")").css("background-color",li_color_);
        }else{
            //进行数据查询，显示查询结果
            fouce_li_num=-1;
            $("#foraspcn").empty();
            ///ajax调用 这里使用的是 测试内容
//                ajax_demo();
            ajax_getdata(key_);//如果使用ajax去前面的demo和//
            //赋值完毕后进行显示
            $("#foraspcn").show("slow").css({"left":""+ left_});
        }
    });
    //当焦点从搜索框内离开则，隐藏层
    $("body").click(function(){ $("#foraspcn").hide(); });
    $("#foraspcn").css({"width":""+width_,"position":"absolute","z-index":"999","list-style":"none","display":"none"});//这里设置列下拉层的样式，默认为隐藏的
});
//定义非开始运行函数
function delkeycode(keycode){
    //去除了不必要的按键反应，当比如删除，f1 f2等按键时，则返回
    var array = new Array();
    array =[16,19,20,27,33,34,35,36,45,46,91,112,113,114,115,116,117,118,119,120,121,122,123,145,192];
    for(i=0;i<array.length;i++){
        if(keycode==array[i]){return true;break;}
    }
    return false;
}

function ajax_getdata(key){
    $.post(
        "/Api/Relsearch/getRel",
        {"kw":key},//ajax 的post不能提交中文提交，在动作页面进行获取后需要解码，注意字符格式，然后搜索后返回
        function(data){
            data_array = data.data.lists;
            for(i=0;i<data_array.length;i++) {
                $("#foraspcn").append("<li class='form-control searh_list_d' style='margin-top:0px;font-size:18px; width:"+width_+"px;'>"+data_array[i]+"</li>");
            }
            $("#foraspcn >li").mouseover(function(){$(this).css("background-color",li_color_);});
            $("#foraspcn >li").mouseout(function(){$(this).css("background-color",li_color);});
            $("#foraspcn >li").click(function(){$("input[name=key]").val($.trim($(this).text()));$(this).parent().hide();});
        }
    );
}