$(document).ready(function() 
{
    // 統計數據功能：錄取人數，確認參加人數，報到人數，男女學員人數，總報到率(報到人數/確認參加人數)
    $('#datagrid').hide();
    $('#list').click(function(){
        if($('#datagrid').is(":visible")==false){
            $('#datagrid').show();
        }
        var type=$('#exporttype').val();
        if (type==0){return;}
        if (type==1){ // 修改
            var columns=[{"sTitle": "姓名","mData": "name","aTargets": [0]},
                         {"sTitle": "帳號","mData": "account","aTargets": [1]},
                         {"sTitle": "等級","mData": "level","aTargets": [2]},
                         {"sTitle": "義工新增","mData": "auth1","aTargets": [3]},
                         {"sTitle": "義工修改","mData": "auth2","aTargets": [4]},
                         {"sTitle": "義工報到","mData": "auth3","aTargets": [5]},
                         {"sTitle": "---","mData": "auth4","aTargets": [6]},
                         {"sTitle": "---","mData": "auth5","aTargets": [7]},
                         {"sTitle": "---","mData": "auth6","aTargets": [8]},
                         {"sTitle": "---","mData": "auth7","aTargets": [9]},
                         {"sTitle": "效期","mData": "expire","aTargets": [10]},
                         {"sTitle": "儲存","mData": "save","aTargets": [11]}];
        }else if (type==2){ // 刪除
            var columns=[{"sTitle": "姓名","mData": "name","aTargets": [0]},
                         {"sTitle": "帳號","mData": "account","aTargets": [1]},
                         {"sTitle": "等級","mData": "level","aTargets": [2]},
                         {"sTitle": "權限表","mData": "auth","aTargets": [3]},
                         {"sTitle": "效期","mData": "auth","aTargets": [4]},
                         {"sTitle": "刪除","mData": "save","aTargets": [5]}];
        }
        drawDataTable(columns,type);        
        
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
    var url="../api/authmanage/authuser.php";
    var type=$('#exporttype').val();
    var data={data:{draw:draw,start:start,length:len,type:type}};
    var jdata = JSON.stringify(data);
    $.ajax({
        type:"POST",
        url:url,
        data:jdata,
        async: true,
	  dataType : "json",
	  contentType : 'application/json; charset=utf-8',
        success:function(data){
            updatecell(data["data"],type);
            fnCallback(data);
        }
    });
}

function updatecell(data, type)
{
    if (type==1){
        for(i=0;i<data.length;i++)
        {
            check=(data[i]['auth'][0]==1)? "checked":"";
            tag='<input type=\"checkbox\" class=\"form-control mx-checkbox\" id=\"auth1_'+(i+1)+'\" '+check+' >';
            data[i]['auth1']=tag;
            
            check=(data[i]['auth'][1]==1)? "checked":"";
            tag='<input type=\"checkbox\" class=\"form-control mx-checkbox\" id=\"auth2_'+(i+1)+'\" '+check+' >';
            data[i]['auth2']=tag;           

            check=(data[i]['auth'][2]==1)? "checked":"";
            tag='<input type=\"checkbox\" class=\"form-control mx-checkbox\" id=\"auth3_'+(i+1)+'\" '+check+' >';
            data[i]['auth3']=tag;

            check=(data[i]['auth'][3]==1)? "checked":"";
            tag='<input type=\"checkbox\" class=\"form-control mx-checkbox\" id=\"auth4_'+(i+1)+'\" '+check+' >';
            data[i]['auth4']=tag;
            
            check=(data[i]['auth'][4]==1)? "checked":"";
            tag='<input type=\"checkbox\" class=\"form-control mx-checkbox\" id=\"auth5_'+(i+1)+'\" '+check+' >';
            data[i]['auth5']=tag;            
            
            check=(data[i]['auth'][5]==1)? "checked":"";
            tag='<input type=\"checkbox\" class=\"form-control mx-checkbox\" id=\"auth6_'+(i+1)+'\" '+check+' >';
            data[i]['auth6']=tag;
            
            check=(data[i]['auth'][6]==1)? "checked":"";
            tag='<input type=\"checkbox\" class=\"form-control mx-checkbox\" id=\"auth7_'+(i+1)+'\" '+check+' >';
            data[i]['auth7']=tag;
            

            tag='<button type=\"button\" class=\"btn btn-danger member\" id=\"member_'+(i+1)+'\" idx='+data[i]['idx']+'>儲存</button>';
            //tag='<div align=\"center\"><input type=\"button\"';
            //tag+='class=\"form-control class="member" id=\"member_'+(i+1)+'\" idx='+data[i]['idx'];
            //tag+=' /> </div>';
            data[i]['save']=tag;
        }
    }
    
    
   for(i=0;i<data.length;i++)
   {
       idx=data[i]['id'];
       serial=(i+1);
       if (data[i]['sex']=='M'){data[i]['sexdesc']='男';}
       else{data[i]['sexdesc']='女';}

       if (data[i]['area']=='A'){data[i]['area']='北區';}
       else if (data[i]['area']=='A'){data[i]['areadesc']='北區';}
       else if (data[i]['area']=='B'){data[i]['areadesc']='中區';}
       else if (data[i]['area']=='C'){data[i]['areadesc']='雲嘉';}
       else if (data[i]['area']=='D'){data[i]['areadesc']='園區';}       
       else if (data[i]['area']=='E'){data[i]['areadesc']='南區';}
       else if (data[i]['area']=='F'){data[i]['areadesc']='海外';}
       else{data[i]['areadesc']='?';}
       
       //tag='<div align=\"center\"><input type=\"radio\"';
       //tag+='class=\"form-control mx-radio memberdata\" id=\"memberid_'+serial+'\" idx='+idx;
       //tag+=' serial='+serial+' /> </div>';
       //data[i]['radio']=tag;
    }
}
