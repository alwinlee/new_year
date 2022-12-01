$(document).ready(function() 
{
    // 統計數據功能：錄取人數，確認參加人數，報到人數，男女學員人數，總報到率(報到人數/確認參加人數)
    $('#datagrid').hide();
    $('#list').click(function(){
        if($('#datagrid').is(":visible")==false){
            $('#datagrid').show();
        }
        var type=$('#exporttype').val();
        if (type==0||type==1||type==2||type==13||type==14){
            var columns=[{"sTitle": "姓名","mData": "name","aTargets": [0]},
                         {"sTitle": "性別","mData": "sexdesc","aTargets": [1]},
                         {"sTitle": "電話","mData": "tel","aTargets": [2]},
                         {"sTitle": "母班班級","mData": "classroomdesc","aTargets": [3]},
                         {"sTitle": "區別","mData": "areadesc","aTargets": [4]},
                         {"sTitle": "教室","mData": "classarea","aTargets": [5]},
                         {"sTitle": "義工大組","mData": "group","aTargets": [6]},
                         {"sTitle": "義工小組","mData": "subgroup","aTargets": [7]}];
            drawDataTable(columns,type);
        }else if (type==10||type==20){
            var columns=[{"sTitle": "項目","mData": "item","aTargets": [0]},
                         {"sTitle": "統計值","mData": "value","aTargets": [1]}];        
            drawDataTable(columns,type);
        }else if (type==11||type==12){
            var columns=[{"sTitle": "組別項目","mData": "item","aTargets": [0]},
                         {"sTitle": "報名應到人數","mData": "valueS","aTargets": [1]},
                         {"sTitle": "報名實到人數","mData": "valueR","aTargets": [2]}];        
            drawDataTable(columns,type);
        }
    });
    
    $('#export').click(function(){
        var parameter="";
        var type=$('#exporttype').val();
        var groupkey=$('#groupkey').val();
        //if(type==2||type==3){ // do something first 
        //    ucamp.statistic.updateFee(0, function(data){                
        //    },function(data){
        //    });
        //}
        parameter+='<input type="hidden" name="type" value="'+type+'" />"';
        parameter+='<input type="hidden" name="groupkey" value="'+groupkey+'" />"';
        if (type==0){
            $('<form action="../api/statistic/exportexcel.php" method="post">'+parameter+'</form>').appendTo('body').submit().remove();   
        }else if (type==2){
            $('<form action="../api/statistic/exportexcel-live.php" method="post">'+parameter+'</form>').appendTo('body').submit().remove();   
        }else if (type==1){
            $('<form action="../api/statistic/exportgroupexcel.php" method="post">'+parameter+'</form>').appendTo('body').submit().remove();  
        }else if (type==10){
            $('<form action="../api/statistic/export-statistic-excel.php" method="post">'+parameter+'</form>').appendTo('body').submit().remove();  
        }else if (type==11){
            $('<form action="../api/statistic/export-statistic-prevcheckin-excel.php" method="post">'+parameter+'</form>').appendTo('body').submit().remove();  
        }else if (type==12){
            $('<form action="../api/statistic/export-statistic-checkin-excel.php" method="post">'+parameter+'</form>').appendTo('body').submit().remove();  
        }else if (type==13){
            $('<form action="../api/statistic/export-prevcheckin-group-excel.php" method="post">'+parameter+'</form>').appendTo('body').submit().remove();  
        }else if (type==14){
            $('<form action="../api/statistic/export-checkin-group-excel.php" method="post">'+parameter+'</form>').appendTo('body').submit().remove();  
        }else if (type==20){
            $('<form action="../api/statistic/export-checkin-excel.php" method="post">'+parameter+'</form>').appendTo('body').submit().remove();  
        }
              
    });
});

function drawDataTable(columns, type) 
{
    var oTable = $('#searchdata').html('<table id="datagrid" class="table table-striped table-bordered" cellspacing="0" width="100%"></table>').children('table').dataTable({
        "processing":true,
        "serverSide":true,
        "bPaginate":true,
        "bFilter":false,
        "aoColumnDefs": columns,
        "ordering":false,
        "pageLength":15,
        "lengthMenu":[20,25,50],
        "searching":false,
        "bLengthChange":false,
        "fnServerData":retrieveData,
        //"dom":'<"optoolbar"> frtip',
        "bDestroy": true,
        "language": {
            "processing": "資料查詢中...",
            "emptyTable": "無資料",
            "info": "顯示 _START_ 到 _END_ 條資料 共 _TOTAL_ 條資料",
            "infoEmpty": "無資料!",
            "infoFiltered": "(在 _MAX_ 條資料中查詢)",
            "lengthMenu": "顯示 _MENU_ 條資料",
            "search": "查詢:",
            "zeroRecords": "沒有找到對應的資料",
            "paginate": {
                "previous":"上一頁",
                "next": "下一頁",
                "last": "末頁",
                "first": "首頁"
            }
        }
    });
}

function retrieveData(sSource, aoData, fnCallback)
{
    var draw=0;
    var start=0;
    var len=0;
    for(i=0;i<aoData.length;i++){
        if(aoData[i].name=="draw"){draw=aoData[i].value;}
        if(aoData[i].name=="start"){start=aoData[i].value;}
        if(aoData[i].name=="length"){len=aoData[i].value;}
    }
    
    var register=1;
    var url="../api/statistic/findMember.php";
    var type=$('#exporttype').val();
    var groupkey=$('#groupkey').val();    
    if (type==0||type==1){register=0;url="../api/statistic/findMember.php";}
    if (type==10){register=0;url="../api/statistic/calcStatistic.php";}
    if (type==11||type==12){register=0;url="../api/statistic/calcCheckinStatistic.php";}
    if (type==13){register=0;url="../api/statistic/findPrevMember.php";}
    //alert(url);
    var data={data:{draw:draw,start:start,length:len,register:register,groupkey:groupkey}};
    var jdata = JSON.stringify(data);
    $.ajax({
        type:"POST",
        url:url,
        data:jdata,
        async: true,
	  dataType : "json",
	  contentType : 'application/json; charset=utf-8',
        success:function(data){
            if (type==0||type==1||type==2||type==13||type==14){updatecell(data["data"],type);}
            
            fnCallback(data);
        }
    });
}

function updatecell(data, type)
{
   for(i=0;i<data.length;i++)
   {
       idx=data[i]['id'];
       serial=(i+1);
       if (data[i]['sex']=='M'){data[i]['sexdesc']='男';}
       else{data[i]['sexdesc']='女';}

       if (data[i]['area']=='A'){data[i]['areadesc']='北區';}
       else if (data[i]['area']=='A'){data[i]['areadesc']='北區';}
       else if (data[i]['area']=='B'){data[i]['areadesc']='中區';}
       else if (data[i]['area']=='C'){data[i]['areadesc']='雲嘉';}
       else if (data[i]['area']=='D'){data[i]['areadesc']='園區';}       
       else if (data[i]['area']=='E'){data[i]['areadesc']='南區';}
       else if (data[i]['area']=='F'){data[i]['areadesc']='海外';}
       else{data[i]['areadesc']='?';}
 
       if (data[i]['classroom']==''||data[i]['classroomid']=='0000'){
           data[i]['classroomdesc']=data[i]['classother'];
       } else {
           data[i]['classroomdesc']=data[i]['classroom'];
       } 
       //tag='<div align=\"center\"><input type=\"radio\"';
       //tag+='class=\"form-control mx-radio memberdata\" id=\"memberid_'+serial+'\" idx='+idx;
       //tag+=' serial='+serial+' /> </div>';
       //data[i]['radio']=tag;
    }
}
