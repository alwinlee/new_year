$(document).ready(function() 
{
    // init value of auto checkin
    var autocheckin = localStorage.getItem("newyearautocheckin");
    if (autocheckin=="yes"){
        $('#autocheckin').prop('checked', true);
    }else{
        $('#autocheckin').prop('checked', false);
    }
    
    $('#auto-checkin-idx').val(0);

    $('#checkinsearch').click(function(){
        searchMember();
    });

    $("#keyword").on('input',function() 
    {
        if(isBarcode()==false){
            return ;
        }
        searchMember();
    });		

    $('#autocheckin').on('click',function(){
        if ($('#autocheckin').is(':checked')){
            localStorage.setItem("newyearautocheckin", "yes");
        }else{
            localStorage.setItem("newyearautocheckin", "no");
        }
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

function searchMember()
{
    $('#auto-checkin-idx').val(0);
    keyword=$('#keyword').val();
    if (keyword.length <=0){
        //$('#previous-keyword').val('');
        return;
    }
    $('#previous-keyword').val(keyword);
    
    newyear.query.findLiveinMember(keyword, function(data){
        if(data['code']<=0){stud=[];mlive=[];flive=[];showtable(stud,mlive,flive);}
        else{
            bBarcode = isBarcode();
            showtable(data['member'],data['mlivearea'],data['flivearea']);
        }                     
    },function(data){
        table='<div class="alert alert-danger" role="alert">查詢失敗！</div>';
        $('#searchdata').html(table); 
    });
}

function isBarcode()
{
    keyword=$('#keyword').val();
    if(keyword.length != 13){return false;}
    
    var strValid="0123456789";
    var bBarcode=true;
    for (i=0;i<keyword.length;i++)     
    {
        j=strValid.indexOf(keyword.charAt(i));
        if (j<0){bBarcode=false;break;}
        //if (i==0&&j>4){bBarcode=false;break;}
    }
    return bBarcode; 
}

function hideModal()
{
    $('#statusReport').modal('hide');
    $('#statusCancel').modal('hide');
    $('#keyword').focus();
    $('#keyword').focus();
}

function autoCheckin()
{
    var idx = parseInt($('#auto-checkin-idx').val());
    if (idx <= 0 || idx > 50000){
        return;
    }
    memberCheckin(idx, 1,true);
}

function gettableex(data,mlive,flive)
{
    table='<table style="font-size:18px;" class="table table-bordered">';
    table+='<thead><tr>';
    table+='<th class="text-center">姓名/班級電話/組別/住宿</th><th class="text-center" colspan="2">調整住宿區</th>';
    table+='</tr></thead>';    

    table+='<tbody>';    
    for(i=0;i<data.length;i++)
    {
        idx=data[i]['id'];
        table+='<tr>';

        area="北區";
        if(data[i]['area']=='B'){area="中區";}
        else if(data[i]['area']=='C'){area="雲嘉";}
        else if(data[i]['area']=='D'){area="園區";}
        else if(data[i]['area']=='E'){area="南區";}
        else if(data[i]['area']=='F'){area="海外";}
        part=data[i]['classroom'];
        if (part==''){
            part=data[i]['classother'];
        }
        sexdesc="女";
        if (data[i]['sex']=="M"){
            sexdesc="男";
        }
        table+='<td class="text-center" style="vertical-align: middle;color:blue;">'+data[i]['name']+' ('+sexdesc+')</td>';
        
        // 住宿選單  alert alert-danger
        table+='<td rowspan="4" class="text-center" style="vertical-align: middle;width=160px;">';
        table+='<select class="form-control" id="liveroom_'+idx+'">';
        table+='<option value="0"> 不住宿 </option>';
        if (data[i]['sex']=="F"){
            for(w=0;w<flive.length;w++){
                remainsize=parseInt(flive[w]['maxsize'])-parseInt(flive[w]['usesize']);
                if (remainsize<=0){remainsize=0;continue;}
                useby="無";
                if(flive[w]['usesubgroup']!=""){useby=flive[w]['usesubgroup'];}
                usebygroup="";
                if(flive[w]['usegroup']!=""){usebygroup='['+flive[w]['usegroup']+']';}
                desc=flive[w]['room']+'('+flive[w]['building']+'-剩餘空位：'+remainsize+', 使用中組別：'+useby+usebygroup+')';
                table+='<option value="'+flive[w]['room']+'"> '+desc+' </option>';
            }
        } else {
            for(w=0;w<mlive.length;w++){
                remainsize=parseInt(mlive[w]['maxsize'])-parseInt(mlive[w]['usesize']);
                if (remainsize<=0){remainsize=0;continue;}
                useby="無";
                if(mlive[w]['usesubgroup']!=""){useby=mlive[w]['usesubgroup'];}
                usebygroup="";
                if(mlive[w]['usegroup']!=""){usebygroup='['+mlive[w]['usegroup']+']';}
                desc=mlive[w]['room']+'('+mlive[w]['building']+'-剩餘空位：'+remainsize+', 使用中組別：'+useby+usebygroup+')';
                table+='<option value="'+mlive[w]['room']+'"> '+desc+' </option>';
            }
        }
        table+='</select>';
        //table+='----------------------';
        table+='</td>';

        //儲存
        table+='<td  rowspan="4" class="text-center" style="vertical-align: middle;">';
        table+='<button type="button" id="livein_'+idx+'" class="btn btn-lg btn-success livein" idx="'+idx+'">儲 存</button></td>';
        table+='</tr>';
        
        table+='<tr><td class="text-center" style="vertical-align: middle;">'+area+'-'+part+'-'+data[i]['tel']+'</td></tr>';
        table+='<tr><td class="text-center" style="vertical-align: middle;">'+data[i]['group']+"-"+data[i]['subgroup']+' 小組</td></tr>';        
        if (data[i]['livewhere'] == ""){
            table+='<tr><td class="text-center" style="vertical-align: middle;"> - </td></tr>';
        } else {
            table+='<tr><td class="text-center" style="vertical-align: middle;color:red;">'+data[i]['livewhere']+'</td></tr>';
        }

        table+='<tr><td colspan="4" class="text-center" style="vertical-align: middle;"></td></tr>';
    
    }    
    table+='</tbody>';    
    table+='</table>';
    
    return table;
}
function showtable(data,mlive,flive)
{
    if(data.length<=0){
        table='<div class="alert alert-danger" role="alert">學員資料不存在，請重新設定查詢條件！</div>';
        $('#searchdata').html(table);        
        return;
    }
    table = gettableex(data,mlive,flive);

    $('#searchdata').html(table);
    $('.livein').click(function(event) 
    {
        var idx=$(this).attr('idx');
        var livewhere=$('#liveroom_'+idx).val();
        memberLivein(idx,livewhere);
    });
}

function memberLivein(idx, livewhere)
{
   newyear.livein.setLivein(idx,livewhere,function(data){
        keyword=$('#keyword').val();
        if (keyword==""){keyword=$('#previous-keyword').val();}
            if (data['code']<=0){
                table='<div class="alert alert-danger" role="alert">住宿變更失敗！</div>';
                $('#searchdata').html(table);
            } else {
                newyear.query.findLiveinMember(keyword, function(data){
                    if(data['code']<=0){stud=[];mlive=[];flive=[];showtable(stud,mlive,flive);}
                    else{
                        showtable(data['member'],data['mlivearea'],data['flivearea']);
                        if (livewhere=="0"){
                            $('#statusCancel').modal('show'); 
                        }else{
                            $('#statusReport').modal('show');                    
                        }
                        tm=1500;
                        setTimeout(hideModal, tm);
                        $('#keyword').val('');
                        $('#keyword').focus();
                    }
                },function(data){
                    table='<div class="alert alert-danger" role="alert">查詢失敗！</div>';
                    $('#searchdata').html(table); 
                });
            }        
    },function(data){
         table='<div class="alert alert-danger" role="alert">設定失敗！</div>';
         $('#searchdata').html(table); 
    });
}