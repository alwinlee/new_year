$(document).ready(function() 
{
    $('#checkinsearch').click(function(){
        keyword=$('#keyword').val();        
        ucamp.query.findStudent(keyword, function(data){
            if(data['code']<=0){stud=[];showtable(stud);}
            else{showtable(data['student'],data['trafficitem']);}                     
        },function(data){
            table='<div class="alert alert-danger" role="alert">查詢失敗！</div>';
            $('#searchdata').html(table); 
        });
    });
    
    $('.checkin').on('click',function(){
         var idx=$(this).attr('idx');
         alert(idx+'-報到');
    });
    
    $(document).on('click', "button.btn btn-success checkin", function(event) {
        //event.preventDefault();
        var idx=$(this).attr('idx');
        alert(idx+'-報到');
    });
    
    $('.checkout').click(function(){
         var idx=$(this).attr('idx');
         alert(idx+'-取消');
    });    
});

function hideModal()
{
    $('#statusReport').modal('hide');
    $('#statusCancel').modal('hide');    
}

function showtable(data, trafficitem)
{
    if(data.length<=0)
    {
        table='<div class="alert alert-danger" role="alert">學生資料不存在，請重新設定查詢條件！</div>';
        $('#searchdata').html(table);        
        return;
    }
    
    table='<table class="table table-hover table-bordered">';
    table+='<thead><tr>';
    //table+='<th>報到</th><th>錄取編號</th><th>姓名</th><th>電話</th><th>學校</th><th colspan="2" class="text-center">登錄</th>';
    table+='<th class="text-center">報到</th><th class="text-center">姓名(錄取編號)/學校/去程交通</th><th class="text-center">登錄</th>';
    table+='</tr></thead>';    

    table+='<tbody>';    
    for(i=0;i<data.length;i++)
    {
        idx=data[i]['id'];
        //if(i%2==0){table+='<tr class="info">';}
        //else{table+='<tr>';}
        table+='<tr>';
        
        if (data[i]['checkin']==1){
            table+='<td rowspan="3" class="text-center alert alert-success" style="vertical-align: middle;">是</td>';            
        }else{
            table+='<td rowspan="3" class="text-center alert alert-danger" style="vertical-align: middle;">否</td>';
        }


        table+='<td class="text-center" style="vertical-align: middle;">'+data[i]['name']+' - '+data[i]['sn']+'</td>';
        //table+='<td>'+data[i]['cp']+'</td>';
        //table+='<td class="text-center" style="vertical-align: middle;">'+data[i]['school']+'</td>';
        
        /*
        realgo=data[i]['realgo'];
        table+='<td style="vertical-align: middle;"><select class="form-control input-sm trafficitem-go" id="gotraffic'+idx+'" idx="'+idx+'" odata="'+realgo+'" ogo="'+data[i]['go']+'">';//+data[i]['realgo']+'</td>';
        for(z=0;z<trafficitem.length;z++){
            selected="";
            if(trafficitem[z]==realgo){selected="selected";}
            table+='<option value="'+trafficitem[z]+'" '+selected+'>'+trafficitem[z]+'</option>';
        }
        table+='</select></td>';
        */
        
        //if(i%2==0){table+='<td  rowspan="3" class="text-center info" style="vertical-align: middle;">';}
        //else{table+='<td  rowspan="3" class="text-center" style="vertical-align: middle;">';}
        table+='<td  rowspan="3" class="text-center" style="vertical-align: middle;">';
        table+='<button type="button" class="btn btn-success checkin" idx="'+idx+'">報到</button><br><br>';
        table+='<button type="button" class="btn btn-danger checkout" idx="'+idx+'">取消</button></td>';
        //table+='<td class="text-center" style="vertical-align: middle;"><button type="button" class="btn btn-danger checkout" idx="'+idx+'">取消</button></td>';
        
        //if (data[i]['checkin']==0){table+='<td class="text-center"><button type="button" class="btn btn-success checkin" idx="'+idx+'">報到</button></td>';}
        //else{table+='<td class="text-center"><button type="button" class="btn btn-default" disabled>報到</button></td>';}        
        //if (data[i]['checkin']!=0){table+='<td class="text-center"><button type="button" class="btn btn-danger checkout" idx="'+idx+'">取消</button></td>';}
        //else{table+='<td class="text-center"><button type="button" class="btn btn-default" disabled>取消</button></td>';}
                
        table+='</tr>';
        
        table+='<tr><td class="text-center" style="vertical-align: middle;">'+data[i]['school']+'</td></tr>';

        table+='<tr>';
        realgo=data[i]['realgo'];
        table+='<td style="vertical-align: middle;"><select class="form-control input-sm trafficitem-go" id="gotraffic'+idx+'" idx="'+idx+'" odata="'+realgo+'" ogo="'+data[i]['go']+'">';//+data[i]['realgo']+'</td>';
        for(z=0;z<trafficitem.length;z++){
            selected="";
            if(trafficitem[z]==realgo){selected="selected";}
            table+='<option value="'+trafficitem[z]+'" '+selected+'>'+trafficitem[z]+'</option>';
        }
        table+='</select></td>';        
        
        table+='<tr>';        
        
    }    
    table+='</tbody>'; 
    
    table+='</table>';
    $('#searchdata').html(table);

    $('.checkin').click(function(event) 
    {
        var idx=$(this).attr('idx');
        var go=$('#gotraffic'+idx).val();
        if (go==""){
            $('#statusDataError').modal('show');            
            return;
        }
        ucamp.checkin.noAuthCheck(idx,1,go,function(data){
            keyword=$('#keyword').val();        
            ucamp.query.findStudent(keyword, function(data){
                if(data['code']<=0){stud=[];showtable(stud);}
                else{
                    showtable(data['student'],data['trafficitem']);
                    $('#statusReport').modal('show');
                    setTimeout(hideModal, 1500)
                }
            },function(data){
                table='<div class="alert alert-danger" role="alert">查詢失敗！</div>';
                $('#searchdata').html(table); 
            });                 
        },function(data){
             
        });
    });
    
    $('.checkout').click(function(event) 
    {
        var idx=$(this).attr('idx');
        var ogodata=$('#gotraffic'+idx).attr('ogo');
        ucamp.checkin.noAuthCheck(idx,0,ogodata,function(data){
            keyword=$('#keyword').val();        
            ucamp.query.findStudent(keyword, function(data){
                if(data['code']<=0){stud=[];showtable(stud);}
                else{
                    showtable(data['student'],data['trafficitem']);
                    $('#statusCancel').modal('show');
                    setTimeout(hideModal, 1500)                    
                }                     
            },function(data){
                table='<div class="alert alert-danger" role="alert">查詢失敗！</div>';
                $('#searchdata').html(table); 
            });                 
        },function(data){
             
        });
    });
    
}


