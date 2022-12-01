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
    
    $('#confirm-data-information-ok').click(function(event){
        $('#confirm-data-information').html("");
    }); 

    $('#basic-testdata').click(function(event){
        applyTest();
    });
    
    $('#basic-demo').click(function(event){
        //$('#confirm-insert').modal('show');
        var json = inputdata(0);
        newyear.addin.checkdup(0,json, function(data){
             alert(data);
        },function(data){
             alert('Error');
        });
    }); 
    
    $('#btn-force-submit').click(function(event) 
    {
        if (!checkinputdata()){$('#confirm-insert').modal('hide'); return;}        
        var json = inputdata(1);
        newyear.addin.insert(0,json, function(data){
            $('#confirm-insert').modal('hide');
            if(data['code']<=0){                
                $('#confirm-data-information').html('報名失敗!!!<br><br>(錯誤碼 : '+data['code']+'-'+data['desc']+')');
                $('#confirm-data').modal('show');
                setTimeout(hideConfirmDataModal, 3000);
            }else{
                $('#confirm-data-information').html('報名成功!!!<br><br>(姓名 : '+json['data']['name']+', 組別：'+json['data']['group']+'-'+json['data']['subgroup']+')');
                $('#confirm-data').modal('show');
                setTimeout(hideConfirmDataModal, 3000);
                cleantable();
            }
            $('#confirm-insert').modal('hide');
        },function(data){
            $('#confirm-insert').modal('hide');
            $('#confirm-data-information').html('報名失敗!!!<br><br>功能異常');
            $('#confirm-data').modal('show');
        });
    }); 
    
    $('#basic-submit').click(function(event) 
    {
        if (!checkinputdata()){return;}
        var json = inputdata(0);        
        newyear.addin.checkdup(0,json, function(data){
             if(data['code']>=1){ // duplication
                var msg = json['data']['name']+'已經報名<br>姓名：'+json['data']['name']+'<br>電話：'+json['data']['tel'];
                if (json['data']['classother']=="0"||json['data']['classother']=="-"){
                    msg += '<br>母班班級：'+json['data']['classroom'];
                }else{
                    msg += '<br>母班班級或其他身份：'+json['data']['classother'];
                }
                msg += '<br>是否仍要報名？';
                $('#confirm-insert-data-information').html(msg);
                $('#confirm-insert').modal('show');
             }else{
                 insertdata(json);                 
             }
        },function(data){
             
        });
    });
});

function insertdata(json)
{
    newyear.addin.insert(0,json, function(data){
        if(data['code']<=0){
            $('#confirm-data-information').html('報名失敗!!!<br><br>(錯誤碼 : '+data['code']+'-'+data['desc']+')');
            $('#confirm-data').modal('show');
            setTimeout(hideConfirmDataModal, 3000);
        }else{
            $('#confirm-data-information').html('報名成功!!!<br><br>(姓名 : '+json['data']['name']+', 組別：'+json['data']['group']+'-'+json['data']['subgroup']+')');
            $('#confirm-data').modal('show');
            setTimeout(hideConfirmDataModal, 3000);
            cleantable();    
        }
    },function(data){
        $('#confirm-data-information').html('報名失敗!!!<br><br>功能異常');
        $('#confirm-data').modal('show');
    });
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
    var classother=$('#basic-clsserialex').val(); //其他身份
    
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
    if (classarea==""){
        if (classother=="0"){
            errmsg+="教室<br>";
        }
    }

    if (classother=="0"){
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
    id="NULL";
    barcode="";
    name=$('#basic-name').val();
    tel=$('#basic-tel').val();
    sex=$('#basic-sex').val();
    age=parseInt($('#basic-age').val()); //年齡
    area=$('#basic-area').val();
    classarea=$('#basic-classarea').val();
    
    classroomid=$('#basic-clsarea').val()+$('#basic-clsyear').val()+$('#basic-clsserial').val()+$('#basic-clsid').val();
    classroom=$('#basic-clsarea option:selected').text()+$('#basic-clsyear option:selected').text()+$('#basic-clsserial option:selected').text()+$('#basic-clsid option:selected').text();
    if (classroom=="----"){
        classroom="";
    }
    classother=$('#basic-clsserialex option:selected').text();
    group=$('#basic-group option:selected').text();
    subgroup=$('#basic-subgroup option:selected').text();

    if (classarea==""){
        if (classother!="0"){
            classarea=classother;
        }
    }

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

    var json={result:result,data:{id:id, barcode:barcode,name:name,tel:tel,sex:sex,
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
/*   
{
  result:true,
  data:{
    id:""
    barcode:"",
    name:"李駿宏",
    tel:"0911111222",
    sex:"M",
    age:42,
    area:"D",
    classarea:"高雄學苑",
    classroom:"南10善001",
    classroomid:"E104001",
    group:"祕書大組",
    subgroup:"報名報到",
    join:"0000000011",
    live:"0000000000",
    livewhere:"",
    liveroom:"",
    type:"",
    notify:0,
    specialcase:"",
    request:"",
    trafficgo:"AC",
    trafficbase:"AC",
    pay:0,
    trafficself:1,
    joinclean:"0000000000",
    trafficclean:"AC",
    memo:"",
    applydate:"1970-01-01",
    applyby:"",
    checkin:"0000000000",
    dup:0,
    invalidate:0,
  }
}
*/    
}

function cleantable()
{
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
    $('#basic-clsserialex').change();
    
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

function applyTest()
{
    $('#basic-name').val('李駿宏');
    $('#basic-tel').val('0911222333');
    $('#basic-sex').val('M');
    $('#basic-age').val('42');
    $('#basic-area').val('E');    
    $('#basic-classarea').val('學苑');

    $('#basic-clsarea').val('E');
    $('#basic-clsyear').val('10');
    $('#basic-clsserial').val('4');
    $('#basic-clsid').val('001');
    
    $('#basic-clsserialex').val('0');
  
    $('#basic-group').val('1');
    $('#basic-group').val("1").change();
    //$('#basic-subgroup').val('1');    
    //$('#basic-subgroup option[value=1]').attr('selected','selected');    
    $('#basic-subgroup option:contains(' + "會計" + ')').attr('selected', 'selected');
    //$('#basic-subgroup option:contains(' + "報名報到" + ')').each(function(){
    //    if ($(this).text() == "報名報到") {
    //        $(this).attr('selected', 'selected');
    //        return true;
    //    }
    //    return true;
    //});   
    
    $('#basic-join1').prop('checked', true);
    $('#basic-join2').prop('checked', true);
    $('#basic-join3').prop('checked', false);
    $('#basic-join4').prop('checked', false);

    $('#basic-live1').prop('checked', true);
    $('#basic-live2').prop('checked', false);
    $('#basic-live3').prop('checked', false);
    
    $('#basic-type').val('0');
    $('#basic-nofity').val('2');
    $('#basic-specialcase').val('無法搬重物');
    $('#basic-request').val('總統套房');    
    
    $('#basic-trafficgo').val('AC');
    $('#basic-trafficback').val('AC');
    $('#basic-pay').prop('checked', true);
    $('#basic-trafficself').prop('checked', false);
    
    $('#basic-joinclean1').prop('checked', true);
    $('#basic-joincleantraffic').val('AC');
    $('#basic-memo').val('這是測試資料');    
}

function hideConfirmDataModal()
{
    $('#confirm-data').modal('hide');
}


