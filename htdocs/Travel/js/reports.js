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
		$("#loading").show();
		//alert(checkedlist);
		//alert(monthlyReportsYear);
		
			$.ajax({
			type: "POST",
			url: "fetchMonthlyReports.php",
			data: { months: checkedlist, year: monthlyReportsYear, reportType: 'monthly' },
			}).done(function(data) { 
			//addalert(data);
			//alert(data);
			$("#loading").hide();
					$('#reportsContents').html(data);		
					setupPagination($('#reportsContents'),$('#reportRecordsPaginationElement'),$('#current_ReportsRecords_page'),$('#show_ReportsRecords_per_page'));
					 $('#reportRecordsPaginationElement a').click(function(e) {
					 e.preventDefault();
					 });
					 var text=$('#reportCountHidden').text();
					//alert(text);
					$('#reportCount').text(text);
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
	$("#loading").show();
			//alert($('#reportUserName').val());
		$.ajax({
		type: "POST",
		url: "fetchReports.php",
		data: { travelType: reportsTravelType,	fromDate: $('#datepicker').val(),toDate: $('#datepicker1').val(), reportUserName: reportUserName, 'reportType': 'excelReport'  },
		}).done(function(data) { 
		//alert(data);
		var text=$('#reportCountHidden').text();
		//alert(text);
		$('#reportCount').text(text);
	//	alert(text);
		$("#loading").hide();
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
			   
			   if(pageName=='budget'){
			   
			   
			   }
			   $('.updateBudget').click(function(){
				//alert($(this).parent().parent().parent().parent().find('tr td span').attr('id'));
				$psid=$(this).parent().parent().find('td span').attr('id');
				
				$budget=$(this).parent().parent().find('td input').attr('value')
				//alert($psid);
				
				$.ajax({
				type: "POST",
				url: "updateBudget.php",
				data: { psid: $psid, budget: $budget  },
				}).done(function(data) { 
				//alert(data);
				
				if(data=='fail')
				Notifier.error('User creation failed');
				else
				$('#reports_comments').text(data);
				
				});
				
				
				Notifier.success('Updated');
			   
			   });
			   
				// Setup html5 version
				$("#html4_uploader").pluploadQueue({
					// General settings
					runtimes : 'html4',
					filters : [{title : "Excel files", extensions : "xls"} ],
					 preinit : {
						Init: function(up, info) {
							//log('[Init]', 'Info:', info, 'Features:', up.features);
							//alert('Init');
							$('#html4_uploader_filelist').load('getFiles.php');
							$('#html4_uploader_filelist').attr('style','overflow-y: scroll');
							//$('.plupload_file_action').text('Download');
								
						
						},
						UploadFile: function(up, file) {
							//log('[UploadFile]', file);
							// You can override settings before the file is uploaded
							// up.settings.url = 'upload.php?id=' + file.id;
							// up.settings.multipart_params = {param1 : 'value1', param2 : 'value2'};

						}
					},

					init : {
					Error: function(up, args) {
					// Called when a error has occured
					alert('[error] ', args);
					},
					StateChanged: function(up) {
					// Called when the state of the queue is changed
					//log('[StateChanged]', up.state == plupload.STARTED ? "STARTED" : "STOPPED");
					if(up.state == plupload.STARTED){
					alert("started");
					}
					},

					},
					url : 'testUpload.php'
				});
				
							$('html4_uploader_filelist').click(function(){
							alert($(this));
							});
		
			   
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
		
		
		
		
		
		$("#upload").click(function(){
		//	alert();
		/*	var filename = $("#file").attr('value');
			 $.ajaxFileUpload
        (
            {
                url:'testUpload.php', 
                secureuri:false,
                fileElementId:'file',
                dataType: 'json',
                success: function (data, status)
                {
                    if(typeof(data.error) != 'undefined')
                    {
                        if(data.error != '')
                        {
                            alert(data.error);
                        }else
                        {
                            alert(data.msg);
                        }
                    }
                },
                error: function (data, status, e)
                {
                    alert(e);
                }
            }
        )
        
			*/
		});
		
		
		$("#emailRegularExcel").click(function(){   
		
		if($('#datepicker').val()==''||$('#datepicker1').val()==''){
		Notifier.warning("Please select a date");
		return;
		}
		if(reportUserName==''){
		Notifier.warning("Please select a user");
		return;
		}
		centerPopup('loading');
			//load popup
		loadPopup('loading');
	
		$("#loading").show();

		$.ajax({
		type: "POST",
		url: "sendRegularReports.php",
		data: { travelType: reportsTravelType,	fromDate: $('#datepicker').val(),toDate: $('#datepicker1').val(), reportUserName: reportUserName, 'reportType': 'excelReport'  },
		}).done(function(data) { 
		disablePopup();
		$("#loading").hide();
		if(data=='fail')
			Notifier.error('Sending reports failed');
		});
	
		});
		
		
		
		/*$.ajax({
			type: "POST",
			url: "reportsMail.php",
			data: { reportData: htmlStr  },
			}).done(function(data) { 
			//alert(data);
			
			if(data=='fail')
			Notifier.error('Exporting Reports failed');
			else if(data=='success')
			Notifier.success('Reports Successfully exported');
			
			});
		*/
		//});
		
		
		$("#emailMonthlyExcel").click(function(){   
		
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
		
		});	
		
		if(checkedlist==''){
		Notifier.warning("Please select a month");
		return;
		}
		centerPopup('loading');
			//load popup
		loadPopup('loading');
		$("#loading").show();
		
			$.ajax({
			type: "POST",
			url: "sendMonthlyReports.php",
			data: { months: checkedlist, year: monthlyReportsYear, reportType: 'monthly' },
			}).done(function(data) {
			disablePopup();			
			$("#loading").hide();
			if(data=='fail')
				Notifier.error('Sending reports failed');
			});

		/*	htmlStr = $("#rounded-corner").html(); 
		alert(htmlStr);
		
		$.ajax({
			type: "POST",
			url: "reportsMail.php",
			data: { reportData: htmlStr  },
			}).done(function(data) { 
			//alert(data);
			
			if(data=='fail')
			Notifier.error('Exporting Reports failed');
			else if(data=='success')
			Notifier.success('Reports Successfully exported');
			
			
			});
		*/
		
		});
		
	$("#generateRegularExcel").click(function(){
	//x	alert();
	//	 $('#target').submit();
	if($('#datepicker').val()==''||$('#datepicker1').val()==''){
	Notifier.warning("Please select a date");
	return;
	}
	if(reportUserName==''){
	Notifier.warning("Please select appropriate user");
	return;
	}
	var str='fetchExcelReports.php?travelType='+reportsTravelType+'&fromDate='+$("#datepicker").val()+'&toDate='+$("#datepicker1").val()+'&reportUserName='+reportUserName+'&reportType=excelReport';
	window.location.href=str;
	//$(this).attr('href',str);

		
		});
		
		$("#generateMonthlyConsolidatedExcel").click(function(){
		 
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
		 if(checkedlist==''){
	Notifier.warning("Please select appropriate month");
	return;
	}
	var str='fetchMonthlyConsolidatedReportsExcel.php?months='+checkedlist+'&year='+monthlyReportsYear+'&reportType=monthly' ;
	//$(this).attr('href',str);
	window.location.href=str;
		
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
	if(checkedlist==''){
	Notifier.warning("Please select appropriate month");
	return;
	}
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
		var text=$('#reportCountHidden').text();
		//alert(text);
		$('#reportCount').text(text);
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
				
				if(pageName=='contactus'){
				M7();
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
					$("#generateMonthlyConsolidatedExcel").attr('style','display:none');
					$("#emailMonthlyExcel").attr('style','display:none');
					$("#emailRegularExcel").attr('style','display:block');
					$('#reportCount').text('');
					ChangereportType('regular');
					}else if(value=='2'){
					$('#reportsContents').html('');
					$("#1").toggleClass('NFh');
					$("#2").toggleClass('NFh');
					
					$("#generateRegularExcel").attr('style','display:none');
					$("#generateMonthlyExcel").attr('style','display:block');
					$("#generateMonthlyConsolidatedExcel").attr('style','display:block');
					$("#emailRegularExcel").attr('style','display:none');
					$("#emailMonthlyExcel").attr('style','display:block');
					ChangereportType('monthly');
					$('#reportCount').text('');
					//alert(value);					
					}
}			