$(document).ready(function() 
{
    $('#basic-clsserialex').find('option').remove();
    $('#basic-clsserialex').append('<option selected="selected" value="0">-</option>');
    var clsotheritem = $('#clsother').val();
    var partsclsotherArray = clsotheritem.split(';');
    for(i=0;i<partsclsotherArray.length;i++){
        if (partsclsotherArray[i]==""){continue;}
        $('#basic-clsserialex').append('<option value='+(i+1)+'>'+partsclsotherArray[i]+'</option>');
    }

    $('#basic-group').on('change', function () {
        var subgroup=$('#basic-group').val();
        if (subgroup>0){
            var item = $('#subgroup'+subgroup).val();
            var partsArray = item.split(';');
            $('#basic-subgroup').find('option').remove();
            $('#basic-subgroup').append('<option selected="selected" value=0>-</option>');
            for(i=0;i<partsArray.length;i++){
                if (partsArray[i]==""){
                    continue;
                }
                $('#basic-subgroup').append('<option value='+(i+1)+'>'+partsArray[i]+'</option>');
            }
        }else{
            $('#basic-subgroup').find('option').remove();
            $('#basic-subgroup').append('<option selected="selected" value=0>-</option>');
        }       
    });
    
    $('.classroom').on('change', function () {    
        $('#basic-clsserialex').val('0');
    });
    
    $('#basic-clsserialex').on('change', function () {    
        $('.classroom').val('0');
    });

    $('#datagrid').hide();
    $('#editinsearch').click(function(){
        searchmember();
    });
    
    // update memeber data
    $('#btn-force-submit').click(function(event) 
    {
        if (!checkinputdata()){$('#confirm-insert').modal('hide'); return;}        
        var json = inputdata(1);
        newyear.addin.insert(0,json, function(data){
            $('#confirm-insert').modal('hide');
            if(data['code']<=0){                
                $('#confirm-data-information').html('資料更新失敗!!!<br><br>(錯誤碼 : '+data['code']+'-'+data['desc']+')');
                $('#confirm-data').modal('show');
                setTimeout(hideConfirmDataModal, 3000);
            }else{
                $('#confirm-data-information').html('資料更新成功!!!<br><br>(姓名 : '+json['data']['name']+', 組別：'+json['data']['group']+'-'+json['data']['subgroup']+')');
                $('#confirm-data').modal('show');
                setTimeout(hideConfirmDataModal, 3000);
                cleantable();
            }
            $('#confirm-insert').modal('hide');
        },function(data){
            $('#confirm-insert').modal('hide');
            $('#confirm-data-information').html('資料更新失敗!!!<br><br>回傳內容異常。)');
            $('#confirm-data').modal('show');
        });
    }); 
    
    $('#basic-submit').click(function(event) 
    {
        if (!checkinputdata()){return;}
        var json = inputdata(0);
        
        var serial=parseInt($('#basic-serial').val());
        if (serial<=0){alert("資料異常!!!"); return;}
        var orijson = $('#memberid_'+serial).data('key');
        if (orijson==null){alert("原始資料異常!!!"); return ;}
        
        //JSON.encode(json)===JSON.encode(orijson)
        if (compareData(json['data'],orijson)){
            $('#confirm-data-information').html('無資料更新!!!');
            $('#confirm-data').modal('show');
            setTimeout(hideConfirmDataModal, 2000);
            return ;
        }
        updatedata(json['data'],orijson);
    });

    $('#btn-remove-submit').click(function(event) 
    {        
        var idx=parseInt($('#basic-deleteid').val());
        var serial=parseInt($('#basic-deleteserial').val());
        //alert("btn-remove-submit : "+idx);
        var userdata = $('#memberid_'+serial).data('key');
        if (userdata==null){
            $('#confirm-remove').modal('hide');
            $('#confirm-data-information').html('資料刪除失敗!!!<br><br>功能異常!!!');
            $('#confirm-data').modal('show');
            return ;
        }
        if (parseInt(userdata['id'])!=parseInt(idx)){
            $('#confirm-remove').modal('hide');
            $('#confirm-data-information').html('資料刪除失敗!!!<br><br>功能異常!!!');
            $('#confirm-data').modal('show');
            return ;
        }

        var jdata={userdata:userdata};
        newyear.editin.disable(0,jdata, function(data){
            $('#confirm-remove').modal('hide');
            if(data['code']<=0){
                $('#confirm-data-information').html('資料刪除失敗!!!<br><br>(錯誤碼 : '+data['code']+'-'+data['desc']+')');
                $('#confirm-data').modal('show');
                setTimeout(hideConfirmDataModal, 3000);
            }else{
                $('#confirm-data-information').html('資料刪除成功!!!<br><br>(姓名 : '+userdata['name']+', 組別：'+userdata['group']+'-'+userdata['subgroup']+')');
                $('#confirm-data').modal('show');
                setTimeout(hideConfirmDataModalAndResearch, 2000);
                //searchmember();
            }
            $('#basic-deleteid').val(0);
            $('#basic-deleteserial').val(0);            
        },function(data){
            $('#confirm-remove').modal('hide');
            $('#confirm-data-information').html('資料刪除失敗!!!<br><br>功能異常!!!');
            $('#confirm-data').modal('show');
        });
    });

    $('#btn-remove-cancel').click(function(event) 
    {
        $('#basic-deleteid').val(0);
        $('#basic-deleteserial').val(0);
    });
});

function searchmember()
{
    $("#memberdetaildata").hide();
    cleantable();
    if($('#datagrid').is(":visible")==false){
        $('#datagrid').show();
    }
    type=0;
    var columns=[{"sTitle": "選取","mData": "radio","aTargets": [0]}
                 ,{"sTitle": "姓名","mData": "name","aTargets": [1]}
                 ,{"sTitle": "性別","mData": "sexdesc","aTargets": [2]}
                 ,{"sTitle": "電話","mData": "tel","aTargets": [3]}
                 ,{"sTitle": "母班班級","mData": "classroomdesc","aTargets": [4]}
                 ,{"sTitle": "區別","mData": "areadesc","aTargets": [5]}
                 ,{"sTitle": "教室","mData": "classarea","aTargets": [6]}
                 ,{"sTitle": "義工大組","mData": "group","aTargets": [7]}
                 ,{"sTitle": "義工小組","mData": "subgroup","aTargets": [8]}
                 ,{"sTitle": "刪除","mData": "remove","aTargets": [9]}
                 ,{"sTitle": "打掃報到單","mData": "cleaninvoice","aTargets": [10]}
                 ,{"sTitle": "正行報到單","mData": "invoice","aTargets": [11]}
                 ];
    drawDataTable(columns,type);
}

function updatedata(json, orijson)
{
    orijson['radio']="";
    var jdata={newjson:json,orijson:orijson};
    newyear.editin.update(0,jdata, function(data){
        if(data['code']<=0){
            $('#confirm-data-information').html('資料更新失敗!!!<br><br>(錯誤碼 : '+data['code']+'-'+data['desc']+')');
            $('#confirm-data').modal('show');
            setTimeout(hideConfirmDataModal, 3000);
        }else{
            $('#confirm-data-information').html('資料更新成功!!!<br><br>(姓名 : '+json['name']+', 組別：'+json['group']+'-'+json['subgroup']+')');
            $('#confirm-data').modal('show');
            setTimeout(hideConfirmDataModalAndResearch, 2000);
            //searchmember();
        }
    },function(data){
        $('#confirm-data-information').html('報名失敗!!!<br><br>功能異常!!!');
        $('#confirm-data').modal('show');
    });
}

function drawDataTable(columns, type) 
{
    var oTable = $('#searchdata').html('<table id="datagrid" class="table table-striped table-bordered" cellspacing="0" width="100%"></table>').children('table').dataTable({
        "processing":true,
        "serverSide":true,
        "bPaginate":true,
        "bFilter":false,
        "aoColumnDefs": columns,
        "ordering":false,
        "pageLength":2,
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

    keyword=$('#keyword').val();
    var url="../api/search/querymember.php";
    var data={data:{keyword:keyword,draw:draw,start:start,length:len}};
    var jdata = JSON.stringify(data);
    $.ajax({
        type:"POST",
        url:url,
        data:jdata,
        async: true,
	  dataType : "json",
	  contentType : 'application/json; charset=utf-8',
        success:function(data){
            updatecell(data["data"]); // update cell to show the selection radio
            fnCallback(data);
            storeData(data["data"]);
            $("#memberdetaildata").hide();
            cleantable();
            
            $('.del_memberdata').click(function(){
                $('#confirm-remove-data-information').html("請確認是否刪除義工資料？");
                $('#basic-deleteid').val(0);
                $('#basic-deleteserial').val(0); 
                var idx=$(this).attr('idx');
                var serial=$(this).attr('serial');
                var orijson = $('#memberid_'+serial).data('key');
                var msg="請確認是否刪除義工資料？ <br>";
                msg+="姓名："+orijson['name']+"<br>";
                msg+="電話："+orijson['tel']+"<br>";
                msg+="班級："+orijson['classroom']+"<br>";
                $('#confirm-remove-data-information').html(msg);
                $('#basic-deleteid').val(idx);
                $('#basic-deleteserial').val(serial);                
                $('#confirm-remove').modal('show');
            });

            $('.clean_invoice_memberdata').click(function(){
                var idx=$(this).attr('idx');
                var parameter="";
                parameter+='<input type="hidden" name="idx" value="'+idx+'" />"';
                $('<form action="../api/invoice/print-clean.php" method="post">'+parameter+'</form>').appendTo('body').submit().remove();
            });

            $('.invoice_memberdata').click(function(){
                var idx=$(this).attr('idx');
                var parameter="";
                parameter+='<input type="hidden" name="idx" value="'+idx+'" />"';
                $('<form action="../api/invoice/print-register.php" method="post">'+parameter+'</form>').appendTo('body').submit().remove();
            });

            $('.memberdata').click(function(){
                //isChecked=$(this).is(':checked');
                var idx=$(this).attr('idx');
                var serial=$(this).attr('serial');                
                for(i=1;i<=2;i++){
                    if (i == serial){continue;}
                    $('#memberid_'+i).prop('checked',false);
                }
                showtable(serial, idx);
            });           
        }
    });
}

function storeData(data)
{
   for(i=0;i<data.length;i++)
   {    
        serial=(i+1);
        $('#memberid_'+serial).data('key',data[i]);
   }
}
function updatecell(data)
{
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
       
       if (data[i]['classroom']==''||data[i]['classroomid']=='0000'){
           data[i]['classroomdesc']=data[i]['classother'];
       } else {
           data[i]['classroomdesc']=data[i]['classroom'];
       }
       
       tag='<div align=\"center\"><input type=\"radio\"';
       tag+='class=\"form-control mx-radio memberdata\" id=\"memberid_'+serial+'\" idx='+idx;
       tag+=' serial='+serial+' /> </div>';
       data[i]['radio']=tag;

       tag='<div align=\"center\"><button type=\"button\" class=\"btn btn-danger btn-block del_memberdata\" ';
       tag+='id=\"del_memberid_'+serial+'\" idx='+idx+' serial='+serial+' >刪除</button></div>';
       data[i]['remove']=tag;
       
       if (data[i]['joinclean']=="0000000001") {
           tag='<div align=\"center\"><button type=\"button\" class=\"btn btn-primary btn-block clean_invoice_memberdata\" ';
           tag+='id=\"clean_invoice_memberid_'+serial+'\" idx='+idx+' serial='+serial+' >列印</button></div>';
           data[i]['cleaninvoice']=tag;           
       } else {
           data[i]['cleaninvoice']=""; 
       }

       tag='<div align=\"center\"><button type=\"button\" class=\"btn btn-primary btn-block invoice_memberdata\" ';
       tag+='id=\"invoice_memberid_'+serial+'\" idx='+idx+' serial='+serial+' >列印</button></div>';
       data[i]['invoice']=tag;
    }
}

function cleantable()
{
    $('#basic-serial').val(0);
    $('#basic-id').val(0);
    $('#basic-deleteid').val(0);
    $('#basic-deleteserial').val(0);    
    $('#basic-name').val('');
    $('#basic-tel').val('');
    $('#basic-sex').val('0');
    $('#basic-age').val('0');
    $('#basic-area').val('0');    
    $('#basic-classarea').val('');

    $('#basic-clsarea').val('0');
    $('#basic-clsyear').val('0');
    $('#basic-clsserial').val('0');
    $('#basic-clsid').val('0');

    $('#basic-clsserialex').val('0');
    //$('#basic-clsserialex').change();

    $('#basic-group').val('0');
    $('#basic-group').val("0").change();
    
    $('#basic-join1').prop('checked', false);
    $('#basic-join2').prop('checked', false);
    $('#basic-join3').prop('checked', false);
    $('#basic-join4').prop('checked', false);

    $('#basic-live1').prop('checked', false);
    $('#basic-live2').prop('checked', false);
    $('#basic-live3').prop('checked', false);
    
    $('#basic-type').val('0');
    $('#basic-nofity').val('0');
    $('#basic-specialcase').val('');
    $('#basic-request').val('');
    
    $('#basic-trafficgo').val('');
    $('#basic-trafficback').val('');
    $('#basic-pay').prop('checked', false);
    $('#basic-trafficself').prop('checked', false);
    
    $('#basic-joinclean1').prop('checked', false);
    $('#basic-joincleantraffic').val('');
    $('#basic-memo').val('');
}

function showtable(serial, idx)
{
    cleantable();
    $("#memberdetaildata").show('fast');
    var json = $('#memberid_'+serial).data('key');
    if (json==null){
        return ;
    }
    $('#basic-serial').val(serial);
    $('#basic-id').val(json['id']); 
    $('#basic-name').val(json['name']);
    
    $('#basic-tel').val(json['tel']);
    $('#basic-sex').val(json['sex']);
    $('#basic-age').val(json['age']);
    $('#basic-area').val(json['area']);    
    $('#basic-classarea').val(json['classarea']);

    var classroomid=json['classroomid'];
    if (classroomid=="0000" || classroomid.length < 7){
        clsarea="0";clsyear="0";clsserial="0";clsid="0";
    }else{
        clsarea=classroomid[0];
        clsyear=classroomid[1];
        clsyear+=classroomid[2];
        clsserial=classroomid[3];
        clsid=classroomid[4]+classroomid[5]+classroomid[6];
    }

    $('#basic-clsarea').val(clsarea);
    $('#basic-clsyear').val(clsyear);
    $('#basic-clsserial').val(clsserial);
    $('#basic-clsid').val(clsid);
    
    var clsother=json['classother'];
    if (clsother!=""&&clsother!="0"&&clsother!="-") {
        var va="0";
        var clsotheritem = $('#clsother').val();
        var partsclsotherArray = clsotheritem.split(';');
        for(i=0;i<partsclsotherArray.length;i++){
            if (partsclsotherArray[i]==clsother){
                va=(i+1)+'';break;
            }               
        }
        $('#basic-clsserialex').val(va);
        //$('#basic-clsserialex option:contains(' + clsother + ')').attr('selected', 'selected');
        //$('#basic-clsserialex option[text="'+clsother+'"]').attr("selected","selected");
    }    

    var group='0';
    var subgroup=json['subgroup'];
    if (json['group']=='秘書大組'){group='1';}
    if (json['group']=='教育大組'){group='2';}
    if (json['group']=='庶務大組'){group='3';}
    if (json['group']=='總務大組'){group='4';}
    if (json['group']=='善法實踐'){group='5';}
    if (json['group']=='大會'){group='6';}
    
    $('#basic-group').val(group);
    $('#basic-group').val(group).change();    
    $('#basic-subgroup option:contains(' + subgroup + ')').attr('selected', 'selected');

    var grouptype=json['type'];//$('#basic-type').val(json['type']);
    $('#basic-type').val(grouptype);//$('#basic-type option:contains(' + grouptype + ')').attr('selected', 'selected');

    $('#basic-join1').prop('checked', json['join1']==1 ? true : false);
    $('#basic-join2').prop('checked', json['join2']==1 ? true : false);
    $('#basic-join3').prop('checked', json['join3']==1 ? true : false);
    $('#basic-join4').prop('checked', json['join4']==1 ? true : false);

    $('#basic-live1').prop('checked', json['live1']==1 ? true : false);
    $('#basic-live2').prop('checked', json['live2']==1 ? true : false);
    $('#basic-live3').prop('checked', json['live3']==1 ? true : false);

    $('#basic-nofity').val(json['notify']);
    $('#basic-specialcase').val(json['specialcase']);
    $('#basic-request').val(json['request']);
    
    $('#basic-trafficgo').val(json['trafficgo']);
    $('#basic-trafficback').val(json['trafficback']);
    $('#basic-pay').prop('checked', json['pay']==1 ? true : false);
    $('#basic-trafficself').prop('checked', json['trafficself']==1 ? true : false);
    
    $('#basic-joinclean1').prop('checked', json['joinclean']==1 ? true : false);
    $('#basic-joincleantraffic').val(json['trafficclean']);
    $('#basic-memo').val(json['memo']);
}

/* *
*  check the user inpurt data
* */
function checkinputdata() {
    var errmsg="";
    var name=$('#basic-name').val(); // 姓名
    var tel=$('#basic-tel').val(); //電話

    var sex=$('#basic-sex').val(); //性別
    var area=$('#basic-area').val(); //區域
    var classarea=$('#basic-classarea').val(); //教室

    var clsarea=$('#basic-clsarea').val(); //母班班別 -區域
    var clsyear=$('#basic-clsyear').val(); //母班班別 -年度
    var clsserial=$('#basic-clsserial').val(); //母班班別 -系列
    var clsid=$('#basic-clsid').val(); //母班班別 -班級序號
    
    var clsother=$('#basic-clsserialex').val(); //其他身份
    // 義工組別
    var group=$('#basic-group').val(); // 大組別
    var subgroup=$('#basic-subgroup').val(); // 小組別
    var grouptext=$('#basic-group option:selected').text();
    var subgrouptext=$('#basic-subgroup option:selected').text();
    
    // 參加日期 & 住宿日期
    var join1=0;//$('#basic-join1').val(); // 參加第1天
    var join2=0;//$('#basic-join2').val(); // 參加第2天
    var join3=0;//$('#basic-join3').val(); // 參加第3天
    var join4=0;//$('#basic-join4').val(); // 參加第4天

    var live1=0;//$('#basic-live1').val(); // 住宿第1天
    var live2=0;//$('#basic-live2').val(); // 住宿第2天
    var live3=0;//$('#basic-live3').val(); // 住宿第3天
    
    if ($('#basic-join1').is(':checked')){join1=1;}
    if ($('#basic-join2').is(':checked')){join2=1;}
    if ($('#basic-join3').is(':checked')){join3=1;}
    if ($('#basic-join4').is(':checked')){join4=1;}

    if (name==""){errmsg+="姓名<br>";} // if (errmsg!=""){errmsg+=",";}
    if (tel==""){errmsg+="電話<br>";}
    if (sex=="0"){errmsg+="性別<br>";}
    if (area=="0"){errmsg+="區別<br>";}        
    if (classarea==""){errmsg+="教室<br>";}
    if (clsother=="0"){
        if (clsarea=="0"||clsyear=="0"||clsserial=="0"||clsid=="0"){errmsg+="母班班別(或其他身份)<br>";}
    }

    if (group=="0"){errmsg+="義工大組<br>";}
    if (subgroup=="0"){errmsg+="義工小組<br>";}    
    if (join1==0&&join2==0&&join3==0&&join4==0){errmsg+="參與日期<br>";}

    if (errmsg!=""){
        //table='<div class="alert alert-danger" role="alert">未填寫'+errmsg+'！</div>';
        $('#confirm-data-information').html("以下資料未填寫： <br>"+errmsg);
        //$('#errmsg').text('未填寫'+errmsg+'!!!');
        $('#confirm-data').modal('show');
        //setTimeout(hideConfirmDataModal, 3000);
        return false;
    }

    if (phoneFormat(tel)==false){
        $('#confirm-data-information').html("電話格式錯誤： <br>範例 : 0911222333 或 079876543 或 079876543#123");
        $('#confirm-data').modal('show');
        //setTimeout(hideConfirmDataModal, 3000);
        return false;
    }
    return true;
}

function phoneFormat(strPhone)
{
    if (strPhone.length < 9){return false;} // 字數夠才檢查

    var nFirstZeroPos=-1;
    var nExtPos=-1;

    var strValid="0123456789#";
    var bVaildNumber=true;
    for (i=0;i<strPhone.length;i++)     
    {
        j=strValid.indexOf(strPhone.charAt(i));
        if (j<0){bVaildNumber=false;break;}
        if (j==0){if (nFirstZeroPos<0){nFirstZeroPos=i;}}
        if (j==10){if (nExtPos >=0){bVaildNumber=false;break;}nExtPos=i;}  // (
    }

    if (bVaildNumber==false){return false;}    
    if (nFirstZeroPos>1||nFirstZeroPos<0){return false;}
    if (nExtPos>0){
        if (nExtPos<9){return false;}
        if (nExtPos>=(strPhone.length-1)){return false;}
    }
    return true;
}

function inputdata(dup)
{
    result=true;
    memberid=$('#basic-id').val();
    if (parseInt(memberid)<=0){
        alert("資料異常");
        return "";
    }
    barcode="";
    name=$('#basic-name').val();
    tel=$('#basic-tel').val();
    sex=$('#basic-sex').val();
    age=parseInt($('#basic-age').val()); //年齡
    area=$('#basic-area').val();
    classarea=$('#basic-classarea').val();
    classroomid=$('#basic-clsarea').val()+$('#basic-clsyear').val()+$('#basic-clsserial').val()+$('#basic-clsid').val();
    classroom=$('#basic-clsarea option:selected').text()+$('#basic-clsyear option:selected').text()+$('#basic-clsserial option:selected').text()+$('#basic-clsid option:selected').text();
    if ($('#basic-clsarea option:selected').text()=="-" || $('#basic-clsyear option:selected').text()=="-"||
        $('#basic-clsserial option:selected').text()=="-" || $('#basic-clsid option:selected').text()=="-"){
        classroom="";
    }
    classother=$('#basic-clsserialex option:selected').text();
    group=$('#basic-group option:selected').text();
    subgroup=$('#basic-subgroup option:selected').text();

    join="000000";
    join1=0;join2=0;join3=0;join4=0;join5=0;join6=0;join7=0;join8=0;join9=0;joinx=0;
    if ($('#basic-join4').is(':checked')){join+="1";join4=1;}else{join+="0";}
    if ($('#basic-join3').is(':checked')){join+="1";join3=1;}else{join+="0";}
    if ($('#basic-join2').is(':checked')){join+="1";join2=1;}else{join+="0";}
    if ($('#basic-join1').is(':checked')){join+="1";join1=1;}else{join+="0";}
    
    live="0000000"; 
    live1=0;live2=0;live3=0;live4=0;live5=0;live6=0;live7=0;live8=0;live9=0;livex=0;    
    if ($('#basic-live3').is(':checked')){live+="1";live3=1;}else{live+="0";}
    if ($('#basic-live2').is(':checked')){live+="1";live2=1;}else{live+="0";}
    if ($('#basic-live1').is(':checked')){live+="1";live1=1;}else{live+="0";}
    
    livewhere="";
    liveroom="";
    type=$('#basic-type option:selected').val();//.text();//$('#basic-type').val();
    notify=$('#basic-nofity').val();
    specialcase=$('#basic-specialcase').val();
    request=$('#basic-request').val();
    trafficgo=$('#basic-trafficgo').val();
    trafficback=$('#basic-trafficback').val();
    pay=0; if ($('#basic-pay').is(':checked')){pay=1;}
    trafficself=0;if ($('#basic-trafficself').is(':checked')){trafficself=1;}
    joinclean="000000000";
    if ($('#basic-joinclean1').is(':checked')){joinclean+="1";}else{joinclean+="0";}
    
    trafficclean=$('#basic-joincleantraffic').val();
    memo=$('#basic-memo').val();
    applydate=$('#basic-date').val();
    applyby=$('#basic-apply').val();
    checkin=0;
    checkin1=0;checkin2=0;checkin3=0;checkin4=0;checkin5=0;checkin6=0;checkin7=0;checkin8=0;checkin9=0;checkinx=0;
    duplication=dup;
    invalidate=0;

    var json={result:result,data:{id:memberid, barcode:barcode,name:name,tel:tel,sex:sex,
              age:age,area:area,classarea:classarea,classroom:classroom,classroomid:classroomid,classother:classother,
              group:group,subgroup:subgroup,join:join,join1:join1,join2:join2,join3:join3,join4:join4,
              join5:join5,join6:join6,join7:join7,join8:join8,join9:join9,joinx:joinx,live:live,live1:live1,
              live2:live2,live3:live3,live4:live4,live5:live5,live6:live6,live7:live7,live8:live8,live9:live9,
              livex:livex,livewhere:livewhere,liveroom:liveroom,type:type,notify:notify,specialcase:specialcase,
              request:request,trafficgo:trafficgo,trafficback:trafficback,pay:pay,trafficself:trafficself,
              joinclean:joinclean,trafficclean:trafficclean,memo:memo,applydate:applydate,
              applyby:applyby,checkin:checkin,checkin1:checkin1,checkin2:checkin2,checkin3:checkin3,
              checkin4:checkin4,checkin5:checkin5,checkin6:checkin6,checkin7:checkin7,checkin8:checkin8,
              checkin9:checkin9,checkinx:checkinx,duplication:duplication,invalidate:invalidate      
    }};
    return json;//JSON.stringify(json); // '{"name":"binchen"}'
}

function compareData(jsonNew,jsonOri)
{
    if (jsonNew['name']!=jsonOri['name']){return false;}
    if (jsonNew['tel']!=jsonOri['tel']){return false;}
    if (jsonNew['sex']!=jsonOri['sex']){return false;}
    if (jsonNew['age']!=jsonOri['age']){return false;}
    if (jsonNew['area']!=jsonOri['area']){return false;}
    if (jsonNew['classarea']!=jsonOri['classarea']){return false;}
    if (jsonNew['classroom']!=jsonOri['classroom']){return false;}
    if (jsonNew['classroomid']!=jsonOri['classroomid']){return false;}
    if (jsonNew['classother']!=jsonOri['classother']){return false;}
    if (jsonNew['group']!=jsonOri['group']){return false;}
    if (jsonNew['subgroup']!=jsonOri['subgroup']){return false;}
    if (jsonNew['join']!=jsonOri['join']){return false;}
    if (jsonNew['join1']!=jsonOri['join1']){return false;}
    if (jsonNew['join2']!=jsonOri['join2']){return false;}
    if (jsonNew['join3']!=jsonOri['join3']){return false;}
    if (jsonNew['join4']!=jsonOri['join4']){return false;}
    if (jsonNew['join5']!=jsonOri['join5']){return false;}
    if (jsonNew['join6']!=jsonOri['join6']){return false;}
    if (jsonNew['join7']!=jsonOri['join7']){return false;}
    if (jsonNew['join8']!=jsonOri['join8']){return false;}
    if (jsonNew['join9']!=jsonOri['join9']){return false;}
    if (jsonNew['joinx']!=jsonOri['joinx']){return false;}
    if (jsonNew['live']!=jsonOri['live']){return false;}    
    if (jsonNew['live1']!=jsonOri['live1']){return false;}
    if (jsonNew['live2']!=jsonOri['live2']){return false;}
    if (jsonNew['live3']!=jsonOri['live3']){return false;}
    if (jsonNew['live4']!=jsonOri['live4']){return false;}
    if (jsonNew['live5']!=jsonOri['live5']){return false;}
    if (jsonNew['live6']!=jsonOri['live6']){return false;}
    if (jsonNew['live7']!=jsonOri['live7']){return false;}
    if (jsonNew['live8']!=jsonOri['live8']){return false;}
    if (jsonNew['live9']!=jsonOri['live9']){return false;}
    if (jsonNew['livex']!=jsonOri['livex']){return false;}    
    if (jsonNew['livewhere']!=jsonOri['livewhere']){return false;}
    if (jsonNew['liveroom']!=jsonOri['liveroom']){return false;}
    if (jsonNew['type']!=jsonOri['type']){return false;}
    if (jsonNew['notify']!=jsonOri['notify']){return false;}
    if (jsonNew['specialcase']!=jsonOri['specialcase']){return false;}
    if (jsonNew['request']!=jsonOri['request']){return false;}
    if (jsonNew['trafficgo']!=jsonOri['trafficgo']){return false;}
    if (jsonNew['trafficback']!=jsonOri['trafficback']){return false;}
    if (jsonNew['pay']!=jsonOri['pay']){return false;}
    if (jsonNew['trafficself']!=jsonOri['trafficself']){return false;}
    if (jsonNew['joinclean']!=jsonOri['joinclean']){return false;}
    if (jsonNew['trafficclean']!=jsonOri['trafficclean']){return false;}
    if (jsonNew['memo']!=jsonOri['memo']){return false;}
    //if (jsonNew['applydate']!=jsonOri['applydate']){return false;}
    //if (jsonNew['applyby']!=jsonOri['applyby']){return false;}
    if (jsonNew['checkin']!=jsonOri['checkin']){return false;}
    if (jsonNew['checkin1']!=jsonOri['checkin1']){return false;}
    if (jsonNew['checkin2']!=jsonOri['checkin2']){return false;}
    if (jsonNew['checkin3']!=jsonOri['checkin3']){return false;}
    if (jsonNew['checkin4']!=jsonOri['checkin4']){return false;}
    if (jsonNew['checkin5']!=jsonOri['checkin5']){return false;}
    if (jsonNew['checkin6']!=jsonOri['checkin6']){return false;}
    if (jsonNew['checkin7']!=jsonOri['checkin7']){return false;}
    if (jsonNew['checkin8']!=jsonOri['checkin8']){return false;}
    if (jsonNew['checkin9']!=jsonOri['checkin9']){return false;}
    if (jsonNew['checkinx']!=jsonOri['checkinx']){return false;}
    return true;
}

function hideConfirmDataModalAndResearch()
{
    $('#confirm-data').modal('hide');
    searchmember();
}

function hideConfirmDataModal()
{
    $('#confirm-data').modal('hide');
}