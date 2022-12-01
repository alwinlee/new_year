$(document).ready(function() 
{
    $('#search').click(function(){        
        keyword=$('#keyword').val();        
        ucamp.query.findStudent(keyword, function(data){
            if(data['code']<=0){stud=[];showtable(stud);}
            else{showtable(data['student']);}                     
        },function(data){
            table='<div class="alert alert-danger" role="alert">查詢失敗！</div>';
            $('#searchdata').html(table); 
        });
    });
});

function showtable(data)
{
    if(data.length<=0)
    {
        table='<div class="alert alert-danger" role="alert">學生資料不存在，請重新設定查詢條件！</div>';
        $('#searchdata').html(table);        
        return;
    }
    
    table='<table class="table table-hover table-bordered">';
    table+='<thead><tr>';
    table+='<th class="text-center">報到</th><th class="text-center">錄取編號</th><th class="text-center">姓名</th><th class="text-center">電話</th><th class="text-center">學校</th><th class="text-center">科系</th>';
    table+='</tr></thead>';    

    table+='<tbody>';    
    for(i=0;i<data.length;i++)
    {
        table+='<tr>';
        if (data[i]['checkin']==1){
            table+='<td class="text-center alert alert-success" style="vertical-align: middle;">是</td>';            
        }else{
            table+='<td class="text-center alert alert-danger" style="vertical-align: middle;">否</td>';
        }        
        
        table+='<td class="text-center" style="vertical-align: middle;">'+data[i]['sn']+'</td>';
        table+='<td class="text-center" style="vertical-align: middle;">'+data[i]['name']+'</td>';
        table+='<td class="text-center" style="vertical-align: middle;">'+data[i]['cp']+'</td>';
        table+='<td class="text-center" style="vertical-align: middle;">'+data[i]['school']+'</td>';
        table+='<td class="text-center" style="vertical-align: middle;">'+data[i]['major']+'</td>';         
        table+='</tr>';        
    }    
    table+='</tbody>';
    
    table+='</table>';
    $('#searchdata').html(table);   
}


