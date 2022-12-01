$(document).ready(function() 
{
    $('#login').click(function(){
        /*newyear..test.getInfo(function(data){
            alert('success');
        },function(data){
            alert('failed');
        });*/
        //location.replace('http://127.0.0.1/newyear./pages/main.php');
        //alert('press');
        //window.location='http://127.0.0.1/newyear./pages/main.php';
        account=$('#account').val();
        password=$('#password').val();
        newyear.auth.login(account, password, function(data){            
            if(data['code']==1){
                window.location.href='./main.php';
            }else{
                window.location.href='./login.html';
            }            
        },function(data){
            location.replace('../pages/login.html');
        });
    });
    
    $('#logout').click(function(){
        alert('logout');
        /*
        newyear..auth.logout(function(data){
            alert('logout');            
        },function(data){
            location.replace('../pages/login.html');
        });*/
    });    

});
