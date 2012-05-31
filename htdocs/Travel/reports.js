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
			   
			   if(reportType=='1'){
			   
			   }else if(reportType=='2'){
			   
			   }
			   
			   
		$("#generateMonthlyReports").click(function(){
		if(monthlyReportsYear==''){
		Notifier.warning("Please select a year");
		return;
		}
		
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
		
		if(checkedlist==''){
		Notifier.warning("Please select a month");
		return;
		}
		//alert(checkedlist);
		//alert(monthlyReportsYear);
		
			$.ajax({
			type: "POST",
			url: "fetchMonthlyReports.php",
			data: { months: checkedlist, year: monthlyReportsYear, reportType: 'monthly' },
			}).done(function(data) { 
			//addalert(data);
			//alert(data);
					$('#reportsContents').html(data);		
					setupPagination($('#reportsContents'),$('#reportRecordsPaginationElement'),$('#current_ReportsRecords_page'),$('#show_ReportsRecords_per_page'));
					 $('#reportRecordsPaginationElement a').click(function(e) {
					 e.preventDefault();
					 });
					//	$('#reportsContents').html(data);
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
	if($('#datepicker').val()==''||$('#datepicker1').val()==''){
	Notifier.warning("Please select a date");
	return;
	}
	if(reportUserName==''){
	Notifier.warning("Please select a user");
	return;
	}
	
			//alert($('#reportUserName').val());
		$.ajax({
		type: "POST",
		url: "fetchReports.php",
		data: { travelType: reportsTravelType,	fromDate: $('#datepicker').val(),toDate: $('#datepicker1').val(), reportUserName: reportUserName, 'reportType': 'excelReport'  },
		}).done(function(data) { 
		//alert(data);
		
		$('#reportsContents').html(data);
		setupPagination($('#reportsContents'),$('#reportRecordsPaginationElement'),$('#current_ReportsRecords_page'),$('#show_ReportsRecords_per_page'));
				
		 $('#reportRecordsPaginationElement a').click(function(e) {
		 e.preventDefault();
		 });

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
		
	$("#generateRegularExcel").click(function(){
	//x	alert();
	//	 $('#target').submit();
		 
	if(reportUserName==''){
	Notifier.warning("Please select appropriate value");
	return;
	}
	var str='fetchExcelReports.php?travelType='+reportsTravelType+'&fromDate='+$("#datepicker").val()+'&toDate='+$("#datepicker1").val()+'&reportUserName='+reportUserName+'&reportType=excelReport';
	window.location.href=str;
	//$(this).attr('href',str);

		
		});
		
	$("#generateMonthlyExcel").click(function(){
		 
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
		});
		 
	var str='fetchMonthlyReportsExcel.php?months='+checkedlist+'&year='+monthlyReportsYear+'&reportType=monthly' ;
	//$(this).attr('href',str);
	window.location.href=str;
		
		});
	

		$("#generateReportsButton").click(function(){
//alert($('#reportUserName').val());

if($('#datepicker').val()==''||$('#datepicker1').val()==''){
Notifier.warning("Please select a date");
return;
}
	if(reportUserName==''){
	Notifier.warning("Please select a user");
	return;
	}
		$.ajax({
		type: "POST",
		url: "fetchReports.php",
		data: { travelType: reportsTravelType,	fromDate: $('#datepicker').val(),toDate: $('#datepicker1').val(), reportUserName: reportUserName, 'reportType': 'excelReport'  },
		}).done(function(data) { 
		//alert(data);
		
		$('#reportsContents').html(data);
		setupPagination($('#reportsContents'),$('#reportRecordsPaginationElement'),$('#current_ReportsRecords_page'),$('#show_ReportsRecords_per_page'));
	   	$('#reportRecordsPaginationElement a').click(function(e) {
		 e.preventDefault();
		 });
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
			//alert(data);
			
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
				setupPagination($('#userRecordBody'),$('#userRecordsPaginationElement'),$('#current_UserRecords_page'),$('#show_UserRecords_per_page'));
				setupPagination($('#supervisorRecordBody'),$('#supervisorRecordsPaginationElement'),$('#current_SupervisorRecords_page'),$('#show_SupervisorRecords_per_page'));
				
				$('#userRecordsPaginationElement a').click(function(e) {
				 e.preventDefault();
				 });
				 $('#supervisorRecordsPaginationElement a').click(function(e) {
				 e.preventDefault();
				 });
		
				}
				if(pageName=='settings'){
				//alert('settings it is');
				M7();
				$( "#newSupervisor").autocomplete({
					source: "searchSupervisor.php",
					
				});
			

				}
				if(pageName=='reports'){
				//alert('reports');
				M7();
			
				 $('#reportRecordsPaginationElement a').click(function(e) {
				 e.preventDefault();
				 });
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
					$("#generateRegularExcel").attr('style','display:block');
					$("#generateMonthlyExcel").attr('style','display:none');
					ChangereportType('regular');
					}else if(value=='2'){
					$('#reportsContents').html('');
					$("#1").toggleClass('NFh');
					$("#2").toggleClass('NFh');
					
					$("#generateRegularExcel").attr('style','display:none');
					$("#generateMonthlyExcel").attr('style','display:block');
					ChangereportType('monthly');
					//alert(value);					
					}
}			