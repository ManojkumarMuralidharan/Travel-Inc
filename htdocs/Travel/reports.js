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
		$("#generateMonthlyReports").click(function(){
		var checkedlist='';
		$(":checkbox").each(function() {
		if(this.value!='all'){
			if(this.checked==true){
			checkedlist+=this.value+';';
			}
		 }else if(this.value=='all'){
		 if(this.checked==true){
			 checkedlist='1;2;3;4;5;6;7;8;9;10;11;12;';
			}
		
		 }
		
		
		//	checkedlist.=this.name;
			//checkedlist.=';';
		
		//alert(this.value);
		/* this.checked = true;
		   this.checked = false; // or, to uncheck
		   this.checked = !this.checked; // or, to toggle*/
		});	
		alert(checkedlist);
		//alert(monthlyReportsYear);
		
			$.ajax({
			type: "POST",
			url: "fetchMonthlyReports.php",
			data: { months: checkedlist, year: monthlyReportsYear, reportType: 'monthly' },
			}).done(function(data) { 
			//alert(data);
					$('#reportsContents').html(data);		
					
						$('#reportsContents').html(data);
					$(".reportCommentsDisplay").click(function(){
					$("#1").hide();
					$("#2").hide();
					$(".NFCheck").hide();
					$(".NFCheck NFh").hide();
					$(".NFSelect").hide();
					$('#popupCommentsTitle').text('Comments');
				//	alert($(this).attr('id'));
				
					$.ajax({
					type: "POST",
					url: "fetchComments.php",
					data: { id: $(this).attr('id'), type: 'comments'  },
					}).done(function(data) { 
				//	alert(data);
			
					if(data=='fail')
					Notifier.error('User creation failed');
					else
					$('#reports_comments').text(data);
					
					});
			
			
			
					//centering with css
					centerPopup('reportComments');
					//load popup
					loadPopup('reportComments');
					});
			
			
			
			if(data=='fail')
			Notifier.error('User creation failed');
			});
		});
		
		
		
	
		
	$("#generateReportsButton").click(function(){
			//alert($('#reportUserName').val());
		$.ajax({
		type: "POST",
		url: "fetchReports.php",
		data: { travelType: reportsTravelType,	fromDate: $('#datepicker').val(),toDate: $('#datepicker1').val(), reportUserName: reportUserName, 'reportType': 'excelReport'  },
		}).done(function(data) { 
		//alert(data);
		
		$('#reportsContents').html(data);
			$(".reportCommentsDisplay").click(function(){
			$("#1").hide();
			$("#2").hide();
				$("#travelTypeLocal").hide();
			$("#travelTypeInternational").hide();
			$("#travelTypeBoth").hide();
			$(".NFSelect").hide();
			$('#popupCommentsTitle').text('Comments');
		//	alert($(this).attr('id'));
		
			$.ajax({
			type: "POST",
			url: "fetchComments.php",
			data: { id: $(this).attr('id'), type: 'comments'  },
			}).done(function(data) { 
		//	alert(data);
	
			if(data=='fail')
			Notifier.error('User creation failed');
			else
			$('#reports_comments').text(data);
			
			});
	
	
	
		//centering with css
		centerPopup('reportComments');
		//load popup
		loadPopup('reportComments');
		});
		
		/*if(data=='recordexists'){
		Notifier.warning('Duplicate record');
		Notifier.warning('Please Update already existing record');
		}else if(data=='success'){
		Notifier.success('Request submitted');
		}else if(data=='fail')
		disablePopup();
		Notifier.error('User creation failed');*/
		});
		
		});	
		
		
		M7();
	$("#99").click(function(){
		$('#reportsContents').html('');
	});	
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
				//NFFix();
		
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
					$('#securityQuesSelect').attr('value',securityQuestionId );
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
		

		$("#generateReportsButton").click(function(){
			alert($('#reportUserName').val());
		$.ajax({
		type: "POST",
		url: "fetchReports.php",
		data: { travelType: reportsTravelType,	fromDate: $('#datepicker').val(),toDate: $('#datepicker1').val(), reportUserName: reportUserName, 'reportType': 'excelReport'  },
		}).done(function(data) { 
		//alert(data);
		
		$('#reportsContents').html(data);
			$(".reportCommentsDisplay").click(function(){
			$("#1").hide();
			$("#2").hide();
			$("#travelTypeLocal").hide();
			$("#travelTypeInternational").hide();
			$("#travelTypeBoth").hide();
			$(".NFSelect").hide();
			$('#popupCommentsTitle').text('Comments');
		//	alert($(this).attr('id'));
		
			$.ajax({
			type: "POST",
			url: "fetchComments.php",
			data: { id: $(this).attr('id'), type: 'comments'  },
			}).done(function(data) { 
			alert(data);
			
			if(data=='fail')
			Notifier.error('User creation failed');
			else
			$('#reports_comments').text(data);
			
			});
	
	
	
		//centering with css
		centerPopup('reportComments');
		//load popup
		loadPopup('reportComments');
		});
		/*if(data=='recordexists'){
		Notifier.warning('Duplicate record');
		Notifier.warning('Please Update already existing record');
		}else if(data=='success'){
		Notifier.success('Request submitted');
		}else if(data=='fail')
		disablePopup();
		Notifier.error('User creation failed');*/
		});
		
		});	
		
		
		
	$("#99").click(function(){
		$('#reportsContents').html('');
	});	
	
		
			if(pageName=='home'){
			//alert('home it is');
				M7();
				}
				if(pageName=='settings'){
				//alert('settings it is');
				M7();
				$( "#newSupervisor").autocomplete({
					source: "searchSupervisor.php",
					
				});


				}
				if(pageName=='reports'){
				alert('reports');
				M7();
				}
		//	selects(reportUserSelect);
			   NFInit();
	//NFFix();
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
					$('#reportsContents').html('');
					$("#1").toggleClass('NFh');
						
					$("#2").toggleClass('NFh');
					ChangereportType('regular');
					}else if(value=='2'){
					$('#reportsContents').html('');
					$("#1").toggleClass('NFh');
					$("#2").toggleClass('NFh');
					ChangereportType('monthly');
					//alert(value);					
					}
}			