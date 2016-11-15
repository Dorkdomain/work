(function($) {
    var delUrl        = $('input[name=delUrl]').val(),
        delAllUrl     = $('input[name=delAllUrl]').val(),
        obj_thead     = $('.table_base > thead'),
        obj_tbody     = $('.table_base > tbody'),
        obj_check     = $('.table_base .checker'),
        obj_check_ipt = obj_tbody.find('input[name=select]'),
        obj_check_all = obj_thead.find('input[name=select_all]'),
        submitData    = {};
    submitData[$('[name=csrf-param]').attr('content')] = $('[name=csrf-token]').attr('content');

    /*复选框start*/
    obj_check.hover(function(){
        $(this).addClass('hover');
    },function(){
        $(this).removeClass('hover');
    });

    obj_check.click(function(){
        var _checkbox = $(this).find('input[name^=select]'),
            isChecked = _checkbox[0].checked;
        _checkbox.parent()[ isChecked ? 'addClass' : 'removeClass' ]('checked');
        if(_checkbox.hasClass('select-on-check-all')){
            $.each(obj_check_ipt,function(){
                $(this)[0].checked = isChecked ? true : false;
                $(this).parent()[ isChecked ? 'addClass' : 'removeClass' ]('checked');
            })
        }
        ifAllCheck();
        checkToIpt();
    });

    $('.bottomBtn > #selectall').click(function(){
        obj_check_all.click();
    });

    $('.bottomBtn > #export').click(function(){
        if(confirm('您确定要删除选中项吗？')){
            var ids = $('.bottomBtn > #selected').val();
            if(ids){
                doAjax(
                    delAllUrl,
                    {ids: ids},
                    function(json){
                        if(json.status){
                            location.reload(true);
                        }else{
                            alert(json.msg);
                        }
                    }
                );
            }
        }
    });

    function ifAllCheck(){
        var allCheck  = true
        $.each(obj_check_ipt,function(){
            if( !$(this)[0].checked ){
                allCheck = false;
                return;
            }
        })
        obj_check_all[0].checked = allCheck;
        obj_check_all.parent()[ allCheck ? 'addClass' : 'removeClass' ]('checked');
    }

    function checkToIpt(){
        var selectedTemp = [];
        $.each(obj_check_ipt,function(){
            if( $(this)[0].checked ){
                selectedTemp.push( $(this).parents('tr:first').attr('data-key') );
            }
        });
        $('.bottomBtn > #selected').val( selectedTemp.join(',') );
    }
    /*复选框end*/

    $('.table_base.del').click(function(){ // 点击删除
        alert(111);
        if(confirm('您确定要删除此项吗？')){
            submitData['id'] = $(this).parents('tr:first').attr('data-key');
            doAjax(
                delUrl,
                submitData,
                function(json){
                    if(json.status){
                        location.reload(true);
                    }else{
                        alert(json.msg);
                    }
                }
            );
        }
    });

    function renderTmp(item, tmp) { // 渲染值
        return tmp.replace( /\{.+?\}/g, function($1) { return item[$1.slice(1, -1)] ? item[$1.slice(1, -1)] : ''; });
    }

    function trBC(){ // tr背景颜色间隔
        obj_tbody.find('td').css('background-color','#ffffff');
        obj_tbody.find('tr:visible').each(function(key,val){
            if(key%2 == 0){
                $(val).find('td').css('background-color','#f9f9f9');
            }
        });
    }

    function doAjax(url,data,sucFn){
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: data,
            success: sucFn,
            error: function(){
                alert('交互错误');
            }
        });
    }

})/**
 * Created by liyu on 2016/11/13/0013.
 */
