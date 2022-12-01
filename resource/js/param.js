$(document).ready(function() 
{
    // 統計數據功能：錄取人數，確認參加人數，報到人數，男女學員人數，總報到率(報到人數/確認參加人數)
    $('#datagrid').hide();
    
    // Load data 
    LoadParam();
    
    $('#param-submit').click(function(){
        var json=inputdata();
        newyear.param.update(0,json, function(data){
            if(data['code']<=0){                
                $('#confirm-param-information').html('設定失敗!!!<br><br>(錯誤碼 : '+data['code']+'-'+data['desc']+')');
                $('#confirm-param').modal('show');
                setTimeout(hideConfirmDataModal, 2000);
            }else{
                $('#confirm-param-information').html('設定成功!!!');
                $('#confirm-param').modal('show');
                setTimeout(hideConfirmDataModal, 2000);
                LoadParam();
            }
        },function(data){
            $('#confirm-param-information').html('設定失敗!!!<br><br>功能異常');
            $('#confirm-param').modal('show');
        });
    });
});

function LoadParam()
{
    newyear.param.query('*',function(data){
        if(data['code']>0){
            for(i=0;i<data['data'].length;i++){
                if(data['data'][i]['main']=="善法實踐"&&data['data'][i]['sub']=="大組"){
                    $('#group11S').val(data['data'][i]['valS']);
                    $('#group11R').val(data['data'][i]['valR']);
                }
                if(data['data'][i]['main']=="善法實踐"&&data['data'][i]['sub']=="平安麵"){
                    $('#group12S').val(data['data'][i]['valS']);
                    $('#group12R').val(data['data'][i]['valR']);
                }
                if(data['data'][i]['main']=="善法實踐"&&data['data'][i]['sub']=="企業善法"){
                    $('#group13S').val(data['data'][i]['valS']);
                    $('#group13R').val(data['data'][i]['valR']);
                }
                if(data['data'][i]['main']=="善法實踐"&&data['data'][i]['sub']=="美食展"){
                    $('#group14S').val(data['data'][i]['valS']);
                    $('#group14R').val(data['data'][i]['valR']);
                }
                if(data['data'][i]['main']=="善法實踐"&&data['data'][i]['sub']=="傳心小組"){
                    $('#group15S').val(data['data'][i]['valS']);
                    $('#group15R').val(data['data'][i]['valR']);
                }
            }
        }
    },function(data){
        $('#confirm-param-information').html('取資料失敗!!!<br><br>功能異常');
        $('#confirm-param').modal('show');
    });
}

function inputdata()
{
    result=true;
    id="NULL";
    var group11S=$('#group11S').val();
    var group11R=$('#group11R').val();
    var group12S=$('#group12S').val();
    var group12R=$('#group12R').val();
    var group13S=$('#group13S').val();
    var group13R=$('#group13R').val();
    var group14S=$('#group14S').val();
    var group14R=$('#group14R').val();
    var group15S=$('#group15S').val();
    var group15R=$('#group15R').val();

    var json={result:result,data:{id:id,group11S:group11S,group11R:group11R,
                                  group12S:group12S,group12R:group12R,
                                  group13S:group13S,group13R:group13R,
                                  group14S:group14S,group14R:group14R,
                                  group15S:group15S,group15R:group15R
    }};
    return json;//JSON.stringify(json); // '{"name":"binchen"}'
}

function hideConfirmDataModal()
{
    $('#confirm-param').modal('hide');
}