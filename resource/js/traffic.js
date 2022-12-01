$(document).ready(function() 
{
    $('#trafficsearch').click(function(){
        keyword=$('#keyword').val();        
        ucamp.query.findStudent(keyword, function(data){
            if(data['code']<=0){stud=[];showtable(stud);}
            else{showtable(data['student'],data['trafficitem'],data['trafficfee']);}                     
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

    $('#showmodal').click(function(event) 
    {
        //alert('show dialog');
        
        $('#statusReport').modal('show');
        setTimeout(hideModal, 800)
    });    
});

function hideModal()
{
    $('#statusReport').modal('hide');   
}

function showtable(data,trafficitem,trafficfee)
{
    if(data.length<=0)
    {
        table='<div class="alert alert-danger" role="alert">學生資料不存在，請重新設定查詢條件！</div>';
        $('#searchdata').html(table);        
        return;
    }
    var traffitem="";
    var trafffee="";
    for(z=0;z<trafficitem.length;z++){
        if(traffitem!=""){traffitem+=";";}
        if(trafffee!=""){trafffee+=";";}        
        traffitem+=trafficitem[z];
        trafffee+=trafficfee[z];
    }
    $('#traffitem').val(traffitem);
    $('#trafffee').val(trafffee);
    
    table='<table class="table table-hover table-bordered">';
    table+='<thead><tr>';
    table+='<th class="text-center">報到</th><th class="text-center">錄取編號</th><th class="text-center">姓名</th>';
    table+='<th class="text-center">原回程交通</th><th class="text-center">變更回程為</th>';
    //table+='<th class="text-center">車資(退補)</th>';
    table+='<th class="text-center">變更</th>';
    table+='</tr></thead>';

    table+='<tbody>';
    for(i=0;i<data.length;i++)
    {
        idx=data[i]['id'];
        table+='<tr>';
        if (data[i]['checkin']==1){
            table+='<td class="text-center alert alert-success" style="vertical-align: middle;">是</td>';            
        }else{
            table+='<td class="text-center alert alert-danger" style="vertical-align: middle;">否</td>';
        }
        table+='<td class="text-center" style="vertical-align: middle;">'+data[i]['sn']+'</td>';
        table+='<td class="text-center" style="vertical-align: middle;">'+data[i]['name']+'</td>';
        //table+='<td class="text-center">'+data[i]['cp']+'</td>';
        //table+='<td class="text-center" style="vertical-align: middle;">'+data[i]['school']+'</td>';
        
        realback=data[i]['realback'];
        table+='<td class="text-center vcenter" style="vertical-align: middle;">'+data[i]['back']+'</td>';        
        table+='<td class="text-center" style="vertical-align: middle;"><select class="form-control trafficitem-back" id="backtraffic'+idx+'" idx="'+idx+'" odata="'+realback+'">';//+data[i]['realgo']+'</td>';
        for(z=0;z<trafficitem.length;z++){
            selected="";
            if(trafficitem[z]==realback){selected="selected";}
            table+='<option value="'+trafficitem[z]+'" '+selected+'>'+trafficitem[z]+'</option>';
        }
        table+='</select></td>';
        //var fee=calcfee(data[i]['go'],data[i]['back'],data[i]['realgo'],data[i]['realback'],parseInt(data[i]['pay']),trafficitem,trafficfee);
        //table+='<td class="text-center traffinfo" style="vertical-align: middle;" id="trafficinfo'+idx+'" ogo="'+data[i]['go']+'" oback="'+data[i]['back']+'" orealgo="'+data[i]['realgo']+'" orealback="'+data[i]['realback']+'" opay="'+data[i]['pay']+'">'+fee+'</td>';        
        table+='<td class="text-center" style="vertical-align: middle;"><button type="button" class="btn btn-default update" id="savetraffic'+idx+'" idx="'+idx+'" disabled>儲存</button></td>';               
        table+='</tr>';        
    }    
    table+='</tbody>';
    
    table+='</table>';
    $('#searchdata').html(table);

    $('.trafficitem-go').on('change', function ()
    {
        var idx=$(this).attr('idx');
        checktrafficitem(idx)
    });
    
    $('.trafficitem-back').on('change', function ()
    {
        var idx=$(this).attr('idx');
        checktrafficitem(idx)
    });
    
    $('.update').click(function(event) 
    {
        var idx=$(this).attr('idx');
        var godata="NULL";//$('#gotraffic'+idx).val();
        var backdata=$('#backtraffic'+idx).val();
        
        ucamp.traffic.setTraffic(idx, godata, backdata, function(data){
            //if(data['code']!=1){
            //    alert('更新失敗');
            //}
            if(data['code']==1)
            {
                traffitem=$('#traffitem').val();
                trafffee=$('#trafffee').val();
                var trafficitem = traffitem.split(';');
                var trafficfee = trafffee.split(';');
 
                var opay=$('#trafficinfo'+idx).attr("opay"); 
                var ogo=$('#trafficinfo'+idx).attr("ogo");
                var oback=$('#trafficinfo'+idx).attr("oback");
                var orealgo=$('#trafficinfo'+idx).attr("orealgo");
                
                $('#trafficinfo'+idx).attr("orealback", backdata);
                var orealback=backdata;
                
                var fee=calcfee(ogo,oback,orealgo,orealback,parseInt(opay),trafficitem,trafficfee);
                $('#trafficinfo'+idx).text(fee);
                // reset odata
                //$('#gotraffic'+idx).attr("odata",godata);
                $('#backtraffic'+idx).attr("odata",backdata);
                
                $('#savetraffic'+idx).removeClass('btn-default');
                $('#savetraffic'+idx).removeClass('btn-success');
                $('#savetraffic'+idx).addClass('btn-default');
                $('#savetraffic'+idx).prop('disabled',true);
                
                $('#statusReport').modal('show');
                setTimeout(hideModal, 800)
            }else{
                keyword=$('#keyword').val();
                ucamp.query.findStudent(keyword, function(data){
                    if(data['code']<=0){stud=[];showtable(stud);}
                    else{showtable(data['student'],data['trafficitem'],data['trafficfee']);}
                },function(data){
                    table='<div class="alert alert-danger" role="alert">更新後查詢失敗！</div>';
                    $('#searchdata').html(table);
                });                
            }

        },function(data){
             table='<div class="alert alert-danger" role="alert">更新失敗！</div>';
             $('#searchdata').html(table);
        });
    });    
}

function checktrafficitem(idx)
{
    //var ogodata=$('#gotraffic'+idx).attr('odata');
    var obackdata=$('#backtraffic'+idx).attr('odata');
    var backdata=$('#backtraffic'+idx).val(); 
    //var godata=$('#gotraffic'+idx).val();    
    if(obackdata!=backdata){
        $('#savetraffic'+idx).prop('disabled',false);
        $('#savetraffic'+idx).removeClass('btn-default');
        $('#savetraffic'+idx).removeClass('btn-success');
        $('#savetraffic'+idx).addClass('btn-success');
    }else{
        $('#savetraffic'+idx).removeClass('btn-default');
        $('#savetraffic'+idx).removeClass('btn-success');
        $('#savetraffic'+idx).addClass('btn-default');        
        $('#savetraffic'+idx).prop('disabled',true);        
    }
    
    traffitem=$('#traffitem').val();
    trafffee=$('#trafffee').val();
    var trafficitem = traffitem.split(';');
    var trafficfee = trafffee.split(';');

    var opay=$('#trafficinfo'+idx).attr("opay"); 
    var ogo=$('#trafficinfo'+idx).attr("ogo");
    var oback=$('#trafficinfo'+idx).attr("oback");
    var orealgo=$('#trafficinfo'+idx).attr("orealgo");
    
    $('#trafficinfo'+idx).attr("orealback", backdata);
    var orealback=backdata;
    
    //var fee=calcfee(ogo,oback,orealgo,orealback,parseInt(opay),trafficitem,trafficfee);
    //$('#trafficinfo'+idx).text(fee);    
}

//計算退補費用
function calcfee(go,realgo,back,realback,paid,trafficitem,trafficfee)
{
    var gofee=0;
    var backfee=0;
    var realgofee=0;
    var realbackfee=0;
    
    for(ww=0;ww<trafficitem.length;ww++){
        if(go==trafficitem[ww]){gofee=parseInt(trafficfee[ww]);}
        if(back==trafficitem[ww]){backfee=parseInt(trafficfee[ww]);}
        if(realgo==trafficitem[ww]){realgofee=parseInt(trafficfee[ww]);}
        if(realback==trafficitem[ww]){realbackfee=parseInt(trafficfee[ww]);}
        if(gofee>0&&backfee>0&&realgofee>0&&realbackfee>0){
            break;
        }
    }
    var diff = 0;
    if((go!=realgo)||(back!=realback))
    {
        if(paid<(realgofee+realbackfee)){//(paid-(realgofee+realbackfee))<0
            diff=(realgofee+realbackfee)-paid;//+:補費用
        }else{
            diff=0;
        }
    }
    else
    {
        if((gofee+backfee)==(paid*2)){
            diff=(gofee+backfee)*-1;//-:退費用
        }else if (paid<(gofee+backfee)){
            diff=((gofee+backfee)-paid);//+:補費用
        }else{
            diff=0;
        }        
    }
    return diff;
    /*
    如果 (去程或回程其中有一樣變更) 
    {
        如果((已繳金額)-(去程確定金額+回程確定金額)) < 0
        {
            補費用  : ((去程確定金額+回程確定金額) - (已繳金額));
        }
        否則
        {
            什麼事都沒發生; (PS : 不用補繳也不用退費);
        }        
    } 
    否則 
    {
        如果 ((已繳金額)-(原去程金額+原回程金額) > 0 且剛好 = (原去程金額+原回程金額))
        {
            退費用:(原去程金額+原回程金額);
        }
        否則 如果 ((已繳金額)-(原去程金額+原回程金額) < 0)
        {
            補費用:((已繳金額)-(原去程金額+原回程金額));
        }
        否則
        {
            什麼事都沒發生;
        }
    }*/    

    
    
}



