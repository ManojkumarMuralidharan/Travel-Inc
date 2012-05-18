function ChangereportType(reportType)
{
//alert('comes');
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.open("POST","reports.php",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("reportType="+reportType);
	xmlhttp.onreadystatechange=function(){
		 if (xmlhttp.readyState==4){
			  if (xmlhttp.status==200 || window.location.href.indexOf("http")==-1){
			   document.getElementById("reportsDisplay").innerHTML=xmlhttp.responseText;
			
		$( "#datepicker" ).datepicker({
			showOn: "button",
			buttonImage: "Images/calendar.gif",
			buttonImageOnly: true
		});
		$( "#datepicker1" ).datepicker({
			showOn: "button",
			buttonImage: "Images/calendar.gif",
			buttonImageOnly: true
		});
	
			   NFInit();
			  }
		  else{
		   alert("An error has occured making the request")
		  }
		 }
	 }
}
function ChangePage(pageName)
{
//alert('PageChange');
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.open("POST","changePage.php",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("page="+pageName);
	xmlhttp.onreadystatechange=function(){
		 if (xmlhttp.readyState==4){
			  if (xmlhttp.status==200 || window.location.href.indexOf("http")==-1){
			   document.getElementById("pageContent").innerHTML=xmlhttp.responseText;
			
	
			   NFInit();
			  }
		  else{
		   alert("An error has occured making the request")
		  }
		 }
	 }
}
function changeReport(value){
					
					if(value=='1'){
					//alert(value);
					$("#1").toggleClass('NFh');
						
					$("#2").toggleClass('NFh');
					ChangereportType('regular');
					}else if(value=='2'){
					$("#1").toggleClass('NFh');
					$("#2").toggleClass('NFh');
					ChangereportType('monthly');
					//alert(value);					
					}
}			