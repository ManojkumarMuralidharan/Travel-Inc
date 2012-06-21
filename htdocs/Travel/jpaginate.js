
function setupPagination(parentElement,PaginationElement,currentPage,showPerPage){

//how much items per page to show  
			var show_per_page = 5;  
			
			//getting the amount of elements inside content div  
			var number_of_items = $(parentElement).children().size(); 
		//	alert(number_of_items);	
			//calculate the number of pages we are going to have  
			var number_of_pages = Math.ceil(number_of_items/show_per_page);  
			
		  //set the value of our hidden input fields  
			$(currentPage).val(0);  
			$(showPerPage).val(show_per_page);  
      
	var navigation_html = '<span name="prev" class="prev disabled"><< prev</span>';  
    var current_link = 0;  
    while(number_of_pages > current_link){  
        navigation_html += '<a href="#" OnClick="go_to_page(this,'+$(parentElement).attr("id")+','+$(PaginationElement).attr("id")+','+$(currentPage).attr("id")+','+$(showPerPage).attr("id")+');" longdesc="' + current_link +'" >'+ (current_link + 1) +'</a>';  
        current_link++;  
    }  
	navigation_html += '<a href="#" name="next" class="next" OnClick="next(this,'+$(parentElement).attr("id")+','+$(PaginationElement).attr("id")+','+$(currentPage).attr("id")+','+$(showPerPage).attr("id")+');">next >></a>  ';
//	alert(navigation_html);
    $(PaginationElement).html(navigation_html);  
	//$('#paginationElement a:first').replaceWith('<a href="#" class="current" OnClick="go_to_page(0);">1</a>');
    $(PaginationElement).find('a:first').addClass('current');
	$(PaginationElement).find('a:first').attr('style','background-color:#60C8F2;color:white;');
	
	$(parentElement).children().css('display', 'none');  
	
	$(parentElement).children().slice(0, show_per_page).css('display', '');  
	
	
}


function next(el,parentElement,paginationElement,currentPage,showPerPage){  
	
    new_page = parseInt($(currentPage).val()) + 1;  
    //if there is an item after the current active link run the function  
    if($(el).parent().find('.current').next('a').length==true&&($(el).parent().find('.current').next('a').attr('name')!="next")){  
		
		//$(el).removeClass('disabled');
        go_to_page($(el).parent().find('.current').next('a'),parentElement,paginationElement,currentPage,showPerPage);  
    }else{
		$(el).replaceWith('<span class="disabled next" name="next" ><< Next</span>');
	}
  
}  


function previous(el,parentElement,paginationElement,currentPage,showPerPage){  
  
    new_page = parseInt($(currentPage).val()) - 1;  
    //if there is an item before the current active link run the function  
    if($(el).parent().find('.current').prev('a').length==true&&($(el).parent().find('.current').prev('a').attr('name')!="prev")){  
		
		//$(el).removeClass('disabled');
        go_to_page($(el).parent().find('.current').prev('a'),parentElement,paginationElement,currentPage,showPerPage);  
    }else{
		$(el).replaceWith('<span class="disabled prev" name="prev" > Prev>> </span>');
	}
  
}  
  

function go_to_page(el,parentElement,paginationElement,currentPage,showPerPage){  
    
    //get the number of items shown per page  
    var show_per_page = parseInt($(showPerPage).val());  
  
    //get the element number where to start the slice from  
    start_from = $(el).attr('longdesc') * show_per_page;  
  
    //get the element number where to end the slice  
    end_on = start_from + show_per_page;  
  
    //hide all children elements of content div, get specific items and show them  
    $(parentElement).children().css('display', 'none').slice(start_from, end_on).css('display', '');  
  
	$(paginationElement).children("a").attr("class", "");
	$(paginationElement).children("a").attr('style','background-color:white;color:#60C8F2;');
	$(el).attr('class','current');
	$(el).attr('style','background-color:#60C8F2;color:white;');
    
    //update the current page input field  
    $(currentPage).val($(el).attr('longdesc'));  
	
	if($(el).next('a').length==true&&($(el).parent().find('.current').next('a').attr('name')!="next")){  
	//alert($(el).parent().find('.current').next('a').attr('name'));
		$(paginationElement).find('.next').replaceWith('<a href="#" name="next" OnClick="next(this,'+$(parentElement).attr("id")+','+$(paginationElement).attr("id")+','+$(currentPage).attr("id")+','+$(showPerPage).attr("id")+');">next >></a>  ');
	}else{
		$(el).next('a').replaceWith('<span class="disabled next" name="next" ><< Next</span>');
	}
	if($(el).prev('a').length==true&&($(el).parent().find('.current').prev('a').attr('name')!="prev")){  
	$(paginationElement).find('.prev').replaceWith('<a href="#" name="prev" OnClick="previous(this,'+$(parentElement).attr("id")+','+$(paginationElement).attr("id")+','+$(currentPage).attr("id")+','+$(showPerPage).attr("id")+');">prev >></a>  ');
	}else{
		$(el).prev('a').replaceWith('<span class="disabled prev" name="prev" ><< Prev</span>');
	}
}  