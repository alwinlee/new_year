$.ajaxSetup({
	global : true,
      async: true,
	dataType : "json",
	contentType : 'application/json',
	cache : false
});

var rest = {
	restUrl : "../api/",
	statusCode : {
		400 : function() {
			// alert(action_paremeter_invalid);
		},
		401 : function() {
			//alert("会话已失效，请登入系统");
			msgbox("会话已失效，请重新登入系统...如果页面没有跳转请点击确定登入系统",'info',2000,function(){location.replace('login.html');});
			
		},
		402 : function() {
			msgbox("<h4>你的系统授权已过期,请联系你的服务商更新授权</h4><table>"+
					"<tr><td>用户名:</td><td><input id='user'/></td></tr>"+
					"<tr><td>密钥:</td><td><input id='key'/></td></tr></table><a onclick=\"fiwo.auth.activate($('#user').val(),$('#key').val())\" class='btn btn-success btn-lg'>激活</a>",'error');
			
		},
		403 : function(data) {
			msgbox("你没有权限这么做,有疑问请联系管理员!<br><b>"+data.responseText+"</b>",'error',2000);
		},
		500 : function(fail) {
			if (fail && $.isFunction(fail)) {
			}
		},
		204 : function(fail) {
			if (fail && $.isFunction(fail)) {
			}
		}
	},
	get : function(path, success, fail) {
		var url = rest.restUrl + path;
		$.ajax({
			type : "GET",
			url : url,
			success : function(data) {
				if ( $.isFunction(success)) {
					success(data);
				}
			},
			error : function(XMLHttpRequest, textStatus, errorThrown) {

				if (fail && $.isFunction(fail)) {
					fail(textStatus);
				} else {
					// alert(textStatus);
				}
			},
			statusCode : rest.statusCode
		});
	},
	put : function(path, data, success, fail) {
		var url = rest.restUrl + path;
		$.ajax({
			type : "PUT",
			url : url,
			data : rest.json2str(data),
			success : function(data) {
				if ($.isFunction(success)) {
					success(data);
				}
			},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				if ($.isFunction(fail)) {
					fail(XMLHttpRequest.responseText);
				}else{
					console.log(XMLHttpRequest);
					msgbox(XMLHttpRequest.responseText,'error')
				}
			},
			statusCode : rest.statusCode
		});
	},
	del : function(path, success, fail) {
		var url = rest.restUrl + path;
		$.ajax({
			type : "DELETE",
			url : url,
			success : function() {
				if ($.isFunction(success)) {
					success();
				}
			},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				if (fail && $.isFunction(fail)) {
					fail(XMLHttpRequest.responseText);
				}
			},
			statusCode : rest.statusCode
		});
	},
	post : function(path, data, success, fail) {
		var url = rest.restUrl + path;
            var jdata = JSON.stringify(data);
		$.ajax({
			type : "POST",
			url : url,
			dataType : "json",
			contentType : 'application/json; charset=utf-8',
			data : jdata,//rest.json2str(data),
			success : function(data) {
				if ( $.isFunction(success)) {
					success(data);
				}
			},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				if (fail && $.isFunction(fail)) {
					fail(XMLHttpRequest.responseText);
				}
			},
			statusCode : rest.statusCode
		});
	},
	json2str : function(o) {
		var arr = [];
		var fmt = function(s) {
			if (typeof s == 'object' && s != null)
				return rest.json2str(s);
			return /^(string|number)$/.test(typeof s) ? "'" + s + "'" : s;
		};
		for ( var i in o)
			arr.push("'" + i + "':" + fmt(o[i]));
		return '{' + arr.join(',') + '}';
	}
};
var newyear = {
	auth : {
		login : function(account, password, callback, failback) {
			rest.post('auth/login.php', {
				user : {
					'account' : account,
					'password' : password
				}
			}, callback, failback);
		},
		logout : function(callback) {
			rest.del('auth/logout.php', callback);
		}
	},query:{
		findMember : function(keyword,callback, failback){
			rest.post('search/querymember.php', {keyword:keyword}, callback, failback);
		},
		findCheckinMember : function(keyword,callback, failback){
			rest.post('search/querycheckinmember.php', {keyword:keyword}, callback, failback);
		},
		findPrevCheckinMember : function(keyword,callback, failback){
			rest.post('search/queryprevcheckinmember.php', {keyword:keyword}, callback, failback);
		},findLiveinMember : function(keyword,callback, failback){
			rest.post('search/findliveinmember.php', {keyword:keyword}, callback, failback);
		}
        
	},checkin:{
            setCheckin : function(id, checkin,callback, failback){
                rest.post('checkin/checkin.php', {id:id, checkin:checkin}, callback, failback);
            },
            setPrevCheckin : function(id, checkin,callback, failback){
                rest.post('checkin/prevcheckin.php', {id:id, checkin:checkin}, callback, failback);
            },
            noAuthCheck : function(id, checkin, go, callback, failback){
                rest.post('checkin/checknoAuth.php', {id:id, checkin:checkin, go:go}, callback, failback);
            }
      },livein:{
            setLivein : function(id,where,callback, failback){
                rest.post('livein/livein.php', {id:id, livewhere:where}, callback, failback);
            }
	},statistic:{
		calcFee : function(type,callback, failback){
			rest.post('statistic/calcfee.php', {type:type}, callback, failback);
		},
		updateFee : function(type,callback, failback){
			rest.post('statistic/updatefee.php', {type:type}, callback, failback);
		}		
	},addin:{
		insert : function(id,data,callback, failback){
			rest.post('addin/insert.php', data, callback, failback);
		},
		checkdup : function(id,data,callback, failback){
			rest.post('addin/checkdup.php', data, callback, failback);
		}
	},editin:{
		update : function(id,data,callback, failback){
			rest.post('editin/update.php', data, callback, failback);
		},
		checkdup : function(id,data,callback, failback){
			rest.post('editin/checkdup.php', data, callback, failback);
		},
		disable : function(id,data,callback, failback){
			rest.post('editin/disable.php', data, callback, failback);
		}
	},param:{
		update : function(id,data,callback, failback){
			rest.post('param/update.php', data, callback, failback);
		},
		query : function(keyword,callback, failback){
			rest.post('param/query.php',{keyword:keyword},callback, failback);
		}
	},version:{
		getVersion: function(callback){
			rest.get('version',callback);
		}
	}
};