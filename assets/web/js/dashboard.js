
  function submitData(){
	  $('.random_num').removeClass('active');
	   $('.random_number').val('');
		var flag =0;
		var res = '';
			$('#double_default input, #single_bhahar input').each(function() {
				var input =Number($(this).val());
				if(input !='' && input !=0){
					flag = 1;
				}
		    })
		    if(flag==0){
		    	$('#msg').html('Please enter game quantity').fadeIn();
		    	setTimeout( function() {
					$("#msg").fadeOut();
				}, 2000 );
		    	return false;
		    }
			//$("#loading").addClass('overlay');
		//	$('#ticketForm').submit();
			//return false;
		 if(flag==1){
			 $("#loading").addClass('overlay');
			 $("#loading-img").show();
			 $('#msg').html('');
			 $("#buy").addClass('disabled');
			var pdata2 = $('#ticketForm').serialize();
			$.ajax({
				type: "POST",
				url: BASE_URL+"/rajarani/web/ticketprocess",
				data: pdata2,
				dataType: "json",
				success: function(res) {
					$("#loading").removeClass('overlay');
					$("#loading-img").hide();
					clearInputValue();
					if(res.msg=="success") {
						$('#userBalance').html(res.bal);
						$('#success-msg').html('Tickets bought successfully!').fadeIn();
						setTimeout( function() {
							$("#success-msg").fadeOut();
						}, 4000 );
					}else if(res.msg=="expired") {
						location.reload();
					}else{
						$('#msg').html(res.msg).fadeIn();
						setTimeout( function() {
							$("#msg").fadeOut();
						}, 4000 );
					}

				},
		        error: function(XMLHttpRequest, textStatus, errorThrown) {
		            if (XMLHttpRequest.readyState == 4) {
		                // HTTP error (can be checked by XMLHttpRequest.status and XMLHttpRequest.statusText)
		            	$("#msg").show().html('Please connect network and reload a page').removeClass('alert-success').addClass('alert-danger');
						//location.reload();
		            }
		            else if (XMLHttpRequest.readyState == 0) {
		                // Network error (i.e. connection refused, access denied due to CORS, etc.)
		            	$("#msg").show().html('Please connect network and reload a page').removeClass('alert-success').addClass('alert-danger');
						//location.reload();

		            }
		            else {
		            	$("#msg").show().html('Please connect network and reload a page').removeClass('alert-success').addClass('alert-danger');
						//location.reload();
		            }
		        },
				complete: function() {
//					me2.data('requestRunning', false);
				}
			});
			return false;
		}
	}


$( document ).ready(function() {

	/**  inspect and right click not working */
	document.addEventListener('contextmenu', event => event.preventDefault());
	$(document).keydown(function(event){
		var keycode = (event.keyCode ? event.keyCode : event.which);
		//$("#keydownCode").val(keycode);
		//alert(keycode);
		if(keycode==32 || (keycode>=112 && keycode<=123)) {
			event.preventDefault();
		}

		if(keycode==123) { //F12 Result
			return false;
		}
	}); 

	// Get the element with id="defaultOpen" and click on it
	document.getElementById("defaultOpen").click();
	/*If no games then here disabld input fields*/
	var drawID = $('#drawID').val();
	if(drawID==''){
		 $("#double_1 :input, #single_1 :input, #buy ").prop("disabled", true);
	}

   $('.form :input').keypress(function (e) { //digits only allowed
		if (e.which != 8 && e.which != 0 && ((e.which < 48) || (e.which > 57))) {
			return false;
		}
	});
   $('#single_1 :input').bind("keyup", function() {
		 var id =  $(this).attr("id");
		 var cls =  $(this).attr("class");
		 var val = cls.split("_");
		 var drawPrice = $('#drawPrice').val();
	     var sum = 0;

	     //Sum up
	     $("."+cls).each(function() {
	    	 var value = Number($(this).val());
	    	 if(value==0 ){
	    		 $(this).val('');
	    		 //return false;
	    	 }
	         sum += Number($(this).val());
	     })

	     var val = sum * drawPrice;
	     $("#"+cls+"_qty").html( sum );
	     $("#"+cls+"_amt").html( val );
	     totalSingle();
	});

   $('#double_1 :input').bind("keyup", function() {
		 var id =  $(this).attr("id");
		 var cls =  $(this).attr("class");

		 if($( this ).hasClass( "random_sel_blink" )){
			 var val = cls.split(" ");
			 cls = val[0];
		 }

		 var drawPrice = $('#drawPrice').val();
	     var sum = 0;
	     //Sum up
	     $("."+cls).each(function() {
	    	 var value = Number($(this).val());
	    	 if(value==0 ){
	    		 $(this).val('');
	    		 //return false;
	    	 }
	         sum += Number($(this).val());
	     })

	     var val = sum * drawPrice;
	     $("#"+cls+"_qty").html( sum );
	     $("#"+cls+"_amt").html( val );
	     totalDouble(cls);
	});



});

function serverTime() {
	var time = null;
	$.ajax({url: BASE_URL+'/rajarani/web/getdbtime',
		async: false, dataType: 'text',
		success: function(text) {
			//time = new Date(text);
			// create Date object for current location India
			offset = '+5.5';
			d = new Date(text);
			// convert to msec
			// add local time zone offset 
			// get UTC time in msec
			utc = d.getTime() + (d.getTimezoneOffset() * 60000);
			// create new Date object for different city
			// using supplied offset
			time = new Date(utc + (3600000*offset));
			console.log(time);
		}, error: function(http, message, exc) {
			time = new Date();
		}
	});
	return time;
}



function liftOff() {
	var curDrawIDNext = $('#drawID').val();
	$('#ndrawLeftTime span').removeClass('text_blink');
	$.ajax({
		type:"POST",
		url:BASE_URL+"/rajarani/web/nextdrawtime/"+curDrawIDNext,
		dataType: "json",
		success:function(response) {
			if(response.status =="available") {
				$('#drawID').val(response.DRAW_ID);
				$('#drawName').val(response.DRAW_NUMBER);
				$('#drawPrice').val(response.DRAW_PRICE);
				$('#drawDateTime').val(response.DRAW_STARTTIME);
				$('#drawNumber').html(response.GAME_NO);
				$('#userBalance').html(response.USER_BAL);
//				$('#preDrawNumb').html(response.PREV_DRAW_NO);
//				$('#preDrawTime').html(response.PREV_DRAW_TIME);
				//$('.future1').removeClass('text-success');
				if(response.NXT_SEL==''){
					$('#future').html('').hide();
				}else{
					$('#future').html(response.NXT_SEL);
				}
//				$('#sDrawName,#dDrawName,#tDrawName').html(drawTimeRes[5]);
//				$('#sDrawPrice,#dDrawPrice,#tDrawPrice').html(drawTimeRes[3]);
//				$('#nxtdrawDate').html(response.NXT_DRAW_DATE);
				$('#nxtdrawTime').html(response.NXT_DRAW_TIME);
				var drawCountDownTime=response.COUNT_DOWN.split(",");
				var shortly = new Date();
				shortly = new Date(drawCountDownTime[0],drawCountDownTime[1],drawCountDownTime[2],drawCountDownTime[3],drawCountDownTime[4],drawCountDownTime[5]);
				$('#ndrawLeftTime').countdown('option', {until: shortly,serverSync: serverTime, format: 'HMS', padZeroes: true, compact: true,onExpiry: liftOff});
			} else {
				if(response.NXT_SEL==''){
					$('#future').html('').hide();
				}else{
					$('#future').html(response.NXT_SEL);
				}
				$('#nxtdrawTime').html("--:--");
//				alert(response.status);
				$('#msg').html(response.status).fadeIn();
				setTimeout( function() {
					$("#msg").fadeOut();
				}, 4000 );
			}
		},
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            if (XMLHttpRequest.readyState == 4) {
                // HTTP error (can be checked by XMLHttpRequest.status and XMLHttpRequest.statusText)
            	//$("#msg").show().html('Please connect network and reload a page').removeClass('alert-success').addClass('alert-danger');
            }
            else if (XMLHttpRequest.readyState == 0) {
                // Network error (i.e. connection refused, access denied due to CORS, etc.)
            	$("#loading").addClass('overlay');
            	$("#msg").show().html('Please connect network and reload a page').removeClass('alert-success').addClass('alert-danger');
				location.reload();

            }
        }
	});
	return false;
}

/*using clear button*/
function clearInput(){
   // var r = confirm("Do you want clear over all data");
    //if (r == true) {
    	$('.form :input').removeClass('random_sel_blink');
    	$('#single_andar input, #single_bhahar input').each(function() {
    	       $(this).val('');
    	})
	    $('#double_default input').each(function() {
	        $(this).val('');
	    })
    	clearQty();
    	clearAmt();
   // }

}

/*using clear submit success*/
function clearInputValue(){
	$('.form :input').removeClass('random_sel_blink');
	$('#single_andar input, #single_bhahar input').each(function() {
       $(this).val('');
    })
    $('#double_default input').each(function() {
        $(this).val('');
    })

	clearQty();
	clearAmt();
}
function clearQty(){

	 /** total div set empty */
    $('#single_qty').html('');
	$('#single_total').html('');
	$('#double_qty').html('');
	$('#double_total').html('');
	$('#tkt_qty').val('');

	$('#andhar_qty_div div').each(function() {
        var id= $(this).attr('id');
        $('#'+id).html(0);
    })
    $('#bahar_qty_div div').each(function() {
        var id= $(this).attr('id');
        $('#'+id).html(0);
    })

	/*$('#bahar_che_qty').html(0);
	$('#bahar_sup_qty').html(0);
	$('#bahar_del_qty').html(0);
	$('#bahar_bha_qty').html(0);
	$('#bahar_dia_qty').html(0);
	$('#bahar_luk_qty').html(0);

	$('#andar_san_qty').html(0);
	$('#andar_che_qty').html(0);
	$('#andar_sup_qty').html(0);
	$('#andar_del_qty').html(0);
	$('#andar_bha_qty').html(0);
	$('#andar_dia_qty').html(0);
	$('#andar_luk_qty').html(0);


	$('#san_qty').html(0);
	$('#che_qty').html(0);
	$('#sup_qty').html(0);
	$('#del_qty').html(0);
	$('#bha_qty').html(0);
	$('#dia_qty').html(0);
	$('#luk_qty').html(0);
	$("."+cls).each(function() {
        sum += Number($(this).val());
//         console.log($(this).val());
    })*/
}

function clearAmt(){
	$('#andhar_amt_div div').each(function() {
        var id= $(this).attr('id');
        $('#'+id).html(0);
    })

	$('#bahar_amt_div div').each(function() {
        var id= $(this).attr('id');
        $('#'+id).html(0);
    })

    /* $('#double_qty_amt tr > td').each(function() {
        var id= $(this).attr('id');
        $('#'+id).html(0);
    }) */

	$('.double_qty_div').html(0);
	$('.double_amt_div').html(0);

	/* $('#san_amt').html(0);
	$('#che_amt').html(0);
	$('#sup_amt').html(0);
	$('#del_amt').html(0);
	$('#bha_amt').html(0);
	$('#dia_amt').html(0);
	$('#luk_amt').html(0);
	$('#bha_new1').html(0);
	$('#dia_new2').html(0);
	$('#luk_new3').html(0);
	$('#single_amt').val('');
	$('#double_amt').val(''); */
}

function totalSingle(){
var val=sum=0;
	$(".single_amt_div").each(function() {
	   	 var value = Number($(this).text());
	   	 val += value;
    })

    $(".single_qty_div").each(function() {
	   	 var value1 = Number($(this).text());
	   	sum += value1;
    })


    $('#single_qty').html(sum);
	$('#single_total').html(val);
 //   console.log('single qty'+sum);
}

function totalDouble(cls){
	var val=sum=0;
	$(".double_amt_div").each(function() {
	   	 var value = Number($(this).text());
	   	 val += value;
    })

    $(".double_qty_div").each(function() {
	   	 var value1 = Number($(this).text());
	   	sum += value1;
    })

    $('#double_qty').html(sum);
	$('#double_total').html(val);

	//console.log('double qty'+sum);
}


/* function drawpriceSingle(cls){
	var drawPrice1 = $('#drawPrice_1').val();
	var drawPrice2 = $('#drawPrice_2').val();
	var drawPrice3 = $('#drawPrice_3').val();
	var drawPrice4 = $('#drawPrice_4').val();
	var drawPrice5 = $('#drawPrice_5').val();
	var drawPrice6 = $('#drawPrice_6').val();
	var drawPrice7 = $('#drawPrice_7').val();
	var drawPrice8 = $('#drawPrice_8').val();
	var drawPrice9 = $('#drawPrice_9').val();
	var drawPrice10 = $('#drawPrice_10').val();

	var drawPrice = 0;
	 if(cls=="san")
		 drawPrice = drawPrice1;
	 if(cls=="che")
		 drawPrice = drawPrice2;
	 if(cls=="sup")
		 drawPrice = drawPrice3;
	 if(cls=="del")
		 drawPrice = drawPrice4;
	 if(cls=="bha")
		 drawPrice = drawPrice5;
	 if(cls=="dia")
		 drawPrice = drawPrice6;
	 if(cls=="luk")
		 drawPrice = drawPrice7;
	 if(cls=="new1")
		 drawPrice = drawPrice8;
	 if(cls=="new2")
		 drawPrice = drawPrice9;
	 if(cls=="new3")
		 drawPrice = drawPrice10;

	 return drawPrice;
}


function drawpriceDouble(cls){
	var drawPrice1 = $('#drawPrice_1').val();
	var drawPrice2 = $('#drawPrice_2').val();
	var drawPrice3 = $('#drawPrice_3').val();
	var drawPrice4 = $('#drawPrice_4').val();
	var drawPrice5 = $('#drawPrice_5').val();
	var drawPrice6 = $('#drawPrice_6').val();
	var drawPrice7 = $('#drawPrice_7').val();
	var drawPrice8 = $('#drawPrice_8').val();
	var drawPrice9 = $('#drawPrice_9').val();
	var drawPrice10 = $('#drawPrice_10').val();

	var drawPrice = 0;
	 if(cls=="sangam")
		 drawPrice = drawPrice1;
	 if(cls=="chetak")
		 drawPrice = drawPrice2;
	 if(cls=="super")
		 drawPrice = drawPrice3;
	 if(cls=="deluxe")
		 drawPrice = drawPrice4;
	 if(cls=="bhagya")
		 drawPrice = drawPrice5;
	 if(cls=="diamond")
		 drawPrice = drawPrice6;
	 if(cls=="lucky")
		 drawPrice = drawPrice7;
	  if(cls=="new1")
		 drawPrice = drawPrice8;
	 if(cls=="new2")
		 drawPrice = drawPrice9;
	 if(cls=="new3")
		 drawPrice = drawPrice10;
	// console.log(drawPrice);
	 return drawPrice;
}*/

function addData(){
 var data = $("#HiddenData").val();
 var inputData = $("#inputData").val();
 $('#'+data).val(inputData);
 $('#loginParentId').show();
 $('#input_container').hide();
}


function genUniqueRandNumbers(start,end,count) {
	var arr = []
	while(arr.length < count){
		var randomnumber=Math.ceil(Math.random()*(end-start)+start)
	  	var found=false;
	  	for(var i=0;i<arr.length;i++){
			if(arr[i]==randomnumber){
				found=true;break
			}
	  	}
	  	if(!found)arr[arr.length]=randomnumber;
	}
	return arr;
}

function textLength(value){
   var maxLength = 2;
   if(value.length > maxLength) {return false;}else{ return true; }
}

function randomPickRowNumber(start, end){
	//$('#tkt_qty').val('');
	$('#random_number').val('');
	if(ticketQty() == 0){
		return false;
	}
	var tktQty = $('#tkt_qty').val();
	var activeId = $('#activeClass').val();
	var id = activeId.split("_");

	$("#"+activeId+" input").removeClass('random_sel_blink');

	if(id[0]!="") {
		for(var i=start;i<=end;i++){
			$("#"+id[0]+"_"+i).addClass('random_sel_blink').val(tktQty);
		}
		updateDoubleRowTotalQty(id[0]);
	}
}

function randomPickEndedNumber(value){
	$('#random_number').val('');
	if(ticketQty() == 0){
		return false;
	}
	var tktQty = $('#tkt_qty').val();

	//$('#tkt_qty').val('');
	var activeId = $('#activeClass').val();
	$("#"+activeId+" input").removeClass('random_sel_blink');

	var id = activeId.split("_");
	$("."+id[0]+"_qty").html( 0 );
    $("."+id[0]+"_amt").html( 0 );
	if(id[0]!="") {
		for(var i=0;i<100;i++){
		  var isEndsWithZero =i%10;
		  if(isEndsWithZero == value)  {
			$("#"+id[0]+"_"+i).addClass('random_sel_blink').val(tktQty);
		  }
		}
		updateDoubleRowTotalQty(id[0]); //new
	}
}


function randomPick(value){
	if(ticketQty() == 0){
		return false;
	}
	var tktQty = $('#tkt_qty').val();
	var activeId = $('#activeClass').val();
	var id = activeId.split("_");
	if( value=='' || value==0 || !textLength(value) ){
		$('#msg').html('Please Enter Random Number').fadeIn();
		setTimeout( function() {
			$("#msg").fadeOut();
		}, 2000 );
		$('#random_number').val('');
		$("#"+activeId+" input").val('').removeClass('random_sel_blink');
		updateDoubleRowTotalQty(id[0]);
		return false;
	}

	/*class active */
		$('.random_num').removeClass('active');
		//$(thisIs).addClass('active');
	/*class active end */
	if( textLength(value) ){
		var getRandNumbers=genUniqueRandNumbers(0,99,value);

		$("#"+activeId+" input").val('').removeClass('random_sel_blink');
		if(getRandNumbers!="" && id[0]!="") {
			for(r=0;r<value;r++) {
				$("#"+id[0]+"_"+Number(getRandNumbers[r]).toString()).val(tktQty);
				$("#"+id[0]+"_"+Number(getRandNumbers[r]).toString()).addClass('random_sel_blink');
			}
			updateDoubleRowTotalQty(id[0]);
		}
	}
}

function randomPickNumber(value,thisIs){
	$('#random_number').val('');
	if(ticketQty() == 0){
		return false;
	}
	var tktQty = $('#tkt_qty').val();

	/*class active */
	$('.random_num').removeClass('active');
	$(thisIs).addClass('active');
	/*class active end */

	var activeId = $('#activeClass').val();
	$("#"+activeId+" input").val('').removeClass('random_sel_blink');
	var id = activeId.split("_");
	if(id[0]!="") {
		if( value =='all'){
			for(r=0;r<100;r++) {
				$("#"+id[0]+"_"+r).val(tktQty);
				$("#"+id[0]+"_"+r).addClass('random_sel_blink');
			}
		}

		if( value =='odd'){
			for(r1=0;r1<100;r1++) {
				if ( r1%2 != 0){
					$("#"+id[0]+"_"+r1).val(tktQty);
					$("#"+id[0]+"_"+r1).addClass('random_sel_blink');
				}
			}
		}
		if( value =='even'){
			for(r2=0;r2<100;r2++) {
				if (r2%2 == 0){
					$("#"+id[0]+"_"+r2).val(tktQty);
					$("#"+id[0]+"_"+r2).addClass('random_sel_blink');
				}
			}
		}
		updateDoubleRowTotalQty(id[0]);
	}
}



/* function randomPickEndedNumber(value,thisIs){

	if(ticketQty() == 0){
		return false;
	}

	$('#random_number').val('');
	var tktQty = $('#tkt_qty').val();
	//class active
	$('.random_num').removeClass('active');
	$(thisIs).addClass('active');
	//class active end

	var activeId = $('#activeClass').val();

	$("#"+activeId+" input").val('').removeClass('random_sel_blink');
	var id = activeId.split("_");
	if(id[0]!="") {
		for(var i=0;i<100;i++){
		  var isEndsWithZero =i%10;
		  if(isEndsWithZero == value)  {
			$("#"+id[0]+"_"+i).val(tktQty);
			$("#"+id[0]+"_"+i).addClass('random_sel_blink');
		  }
		}
		updateDoubleRowTotalQty(id[0]);
	}
} */
function updateDoubleRowTotalQty(cls){
    var sum = 0;
    //Sum up
    $("."+cls).each(function() {
    	 var val = Number($(this).val());
    	 if(val==0){
    		 $(this).val('');
    		 //return false;
    	 }
        sum += Number($(this).val());
    })
    var drawPrice = $('#drawPrice').val();

    var val1 = sum * drawPrice;
    $("#"+cls+"_qty").html( sum );
    $("#"+cls+"_amt").html( val1 );
    totalDouble(cls);
}


function openPlayer(evt, cityName) {
	$('.random_num').removeClass('active');
	$('#random_number').val('');
    var i, tabcontent1, tablinks1;
    tabcontent1 = document.getElementsByClassName("tabcontent1");
    for (i = 0; i < tabcontent1.length; i++) {
        tabcontent1[i].style.display = "none";
    }
    tablinks1 = document.getElementsByClassName("tablinks1");
    for (i = 0; i < tablinks1.length; i++) {
        tablinks1[i].className = tablinks1[i].className.replace(" active", "");
    }
    //document.getElementById(cityName).style.display = "block";
    $("#"+cityName).show();
    evt.currentTarget.className += " active";
}

function openCity(evt, cityName) {
	$('.random_num').removeClass('active');
	$('#random_number').val('');

    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    //document.getElementById(cityName).style.display = "block";
    $('#activeClass').val(cityName);
    $('#'+cityName).show();
    evt.currentTarget.className += " active";
}

function ticketQty(){
	var tktQty = $('#tkt_qty').val();
	if( tktQty=='' || isNaN(tktQty) || tktQty==0 || tktQty > 999 ){
		console.log(tktQty);
		if(tktQty=='0'){
			confirmationAlert()
		}else{
			$('#msg').html('Please Enter Tickets Quantity').fadeIn();
			setTimeout( function() {
				$("#msg").fadeOut();
			}, 2000 );
		}

		return 0;
	}
}

function confirmationAlert(){
	var retVal = confirm("Do you want to continue ?");
	if( retVal == true ){
		var activeId = $('#activeClass').val();
		$('#random_number').val('');
		$('#tkt_qty').val('');
		$('.random_num').removeClass('active');
		//$("#"+activeId+" input").val('').removeClass('random_sel_blink');

	  return true;
	}else{
	  return false;
	}
}
