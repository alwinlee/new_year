$(document).ready(function () 
{	
    
    $('#testapi').click(function () 
    {
        //alert("Press GO!");
        opsdemo.test.getInfo(function(data) {
            alert("success : "+data[0].who+" "+data[0].what);
        },function(data) {
            alert("error : "+ data);
        });
    });
});
