var wsUri = WEB_SOCKET_URL;
var output;

 function init()  {
   connectWebSocket();
 }

 function connectWebSocket()  {
   websocket = new WebSocket(wsUri);
   websocket.onopen = function(evt) { onOpen(evt) };
   websocket.onclose = function(evt) { onClose(evt) };
   websocket.onmessage = function(evt) { onMessage(evt) };
   websocket.onerror = function(evt) { onError(evt) };
 }

 function onOpen(evt)  {
   writeToScreen("CONNECTED");
   console.log("CONNECTED");
 }

 function onClose(evt)  {
   writeToScreen("DISCONNECTED");
   networkConnection();
   console.log("DISCONNECTED");
 }

 function onMessage(evt)  {
	var json = JSON.parse(evt.data);
	console.log(evt);
	if(json.action=="drawresult"){
		console.log(json);
		//$('#preDrawTime').html(json.drawTime);
		var jsonTime = json.drawTime;
		var time = jsonTime.split(':');
		var drawTime = jsonTime+' AM';
		if(time[0] >=12 ){
			if(time[0] >12){
				time1 = ( time[0] % 12 );
				drawTime = time1+':'+time[1]+' PM';
			}else{
				drawTime = jsonTime+' PM';
			}
		}
		$('.preDrawTime').html(drawTime);
		 $.each(json.winNumber, function (name, value) {
			 $.each(this, function (key, val) {
				 if(name=='andar'){
					 $('#ra_'+key).html(val);
					 $('.ra_'+key).html(val);
				 }
				 if(name=='bahar'){
					 //$('#rb_'+key).html(val);
					 $('.rb_'+key).html(val);
				 }
				 if(name=='double'){
					 $('#rb_'+key).html(val);
				 	 $('#rd_'+key).html(val);
					 $('.rd_'+key).html(val);
				 }
			 });
		      
		});
		startInterval();
	}
	
	if(json.action=="AckResponse"){
//		console.log(json.action);
	}
	
//	console.log("RECEIVE"+evt.data);
 }

 function onError(evt) {
	console.log(evt);
 }

 function doSend(message) {
   websocket.send(message);
   console.log("SENT: " + message);
 }

 //var count=30;
 function writeToScreen(message) {
	if(message=="DISCONNECTED"){
		setTimeout(function(){ init(); networkConnection(); }, 1000);
	}
	if(message=="CONNECTED"){
	}
 }
 
 
var drawStart = $('#drawName').val();
if(drawStart != undefined && drawStart != ""){
	window.addEventListener("load", init, false);
	setInterval(function(){ 
		activeWS()
	}, 3000);
}
function activeWS(){
	var msg = {action: "AckRequest"};
	doSend(JSON.stringify(msg));
	
}
 
 var countTime =10;
 var  interval;
 function startTimeCounting( ) {
	$('#timer').hide();
	$('#timer1').show();
	$('#countTimer').show();
	updateUserBalance();
     interval=	setInterval("stopCountDown()", 1000);
 }

 function stopCountDown( ) {
	countTime=countTime-1;
   if (countTime == 0) {
		var el = $('#small-dialog2');
		if (el.length) {
			$.magnificPopup.close({
				items: {
					src: el
				},
				type: 'inline'
			});
		}
		countTime =10;
		clearInterval(interval);
		$("#countTimer").html("10 <small>sec</small>");
		 return;
   }
   $("#countTimer").html(countTime+" <small>sec</small>");
 }
 
function startInterval(){
	var el = $('#small-dialog2');
	if (el.length) {
	    $.magnificPopup.open({
	        items: {
	            src: el
	        },
	        type: 'inline'
	    });
	}
	
	$('#timer').show();
	$('#timer1').hide();
	$('#countTimer').hide();
	animateInfo();
	//updateUserBalance();
	setTimeout(function(){ startTimeCounting(); }, 3000);
}



function animateInfo() {
	setInterval(function() {
		animation();
	}, 100)
	
	
//	var count = 00;
// 	$(".flip--top, .flip--bottom").text(count);
// 	$(".flip--next, .flip--back").text(count + 1);
// 	$(".flip--back").on('webkitAnimationIteration oanimationiteration msAnimationIteration animationiteration', function() {
// 	   setInterval(function() {
// 			count++
// 			if(count==9){
// 			count = 00;
// 			}
// 			$(".flip--top, .flip--bottom").text(count);
// 			$(".flip--next, .flip--back").text(count + 1);
// 		}, 1000)
//  });

}

 function animation(){
	 $("#top, #bottom").html(Math.floor((Math.random() * 9) + 1));
	 $("#next, #back").html(Math.floor((Math.random() * 9) + 1));

	 $("#top1, #bottom1").html(Math.floor((Math.random() * 9) + 1));
	 $("#next1, #back1").html(Math.floor((Math.random() * 9) + 1));

	 $("#top2, #bottom2").html(Math.floor((Math.random() * 9) + 1));
	 $("#next2, #back2").html(Math.floor((Math.random() * 9) + 1));
	 
	 $("#top3, #bottom3").html(Math.floor((Math.random() * 9) + 1));
	 $("#next3, #back3").html(Math.floor((Math.random() * 9) + 1));
	 
	 $("#top4, #bottom4").html(Math.floor((Math.random() * 9) + 1));
	 $("#next4, #back4").html(Math.floor((Math.random() * 9) + 1));
	 
	 $("#top5, #bottom5").html(Math.floor((Math.random() * 9) + 1));
	 $("#next5, #back5").html(Math.floor((Math.random() * 9) + 1));
	 
	 $("#top6, #bottom6").html(Math.floor((Math.random() * 9) + 1));
	 $("#next6, #back6").html(Math.floor((Math.random() * 9) + 1));
	 
	 $("#top7, #bottom7").html(Math.floor((Math.random() * 9) + 1));
	 $("#next7, #back7").html(Math.floor((Math.random() * 9) + 1));
	 
	 $("#top8, #bottom8").html(Math.floor((Math.random() * 9) + 1));
	 $("#next8, #back8").html(Math.floor((Math.random() * 9) + 1));
	 
	 $("#top9, #bottom9").html(Math.floor((Math.random() * 9) + 1));
	 $("#next9, #back9").html(Math.floor((Math.random() * 9) + 1));
	 
	 $("#top10, #bottom10").html(Math.floor((Math.random() * 9) + 1));
	 $("#next10, #back10").html(Math.floor((Math.random() * 9) + 1));
	 
	 $("#top11, #bottom11").html(Math.floor((Math.random() * 9) + 1));
	 $("#next11, #back11").html(Math.floor((Math.random() * 9) + 1));

	 $("#top12, #bottom12").html(Math.floor((Math.random() * 9) + 1));
	 $("#next12, #back12").html(Math.floor((Math.random() * 9) + 1));

	 $("#top13, #bottom13").html(Math.floor((Math.random() * 9) + 1));
	 $("#next13, #back13").html(Math.floor((Math.random() * 9) + 1));
	 
	 $("#top14, #bottom14").html(Math.floor((Math.random() * 9) + 1));
	 $("#next14, #back14").html(Math.floor((Math.random() * 9) + 1));
	 
	 $("#top15, #bottom15").html(Math.floor((Math.random() * 9) + 1));
	 $("#next15, #back15").html(Math.floor((Math.random() * 9) + 1));
	 
	 $("#top16, #bottom16").html(Math.floor((Math.random() * 9) + 1));
	 $("#next16, #back16").html(Math.floor((Math.random() * 9) + 1));
	 
	 $("#top17, #bottom17").html(Math.floor((Math.random() * 9) + 1));
	 $("#next17, #back17").html(Math.floor((Math.random() * 9) + 1));
	 
	 $("#top18, #bottom18").html(Math.floor((Math.random() * 9) + 1));
	 $("#next18, #back18").html(Math.floor((Math.random() * 9) + 1));
	 
	 $("#top19, #bottom19").html(Math.floor((Math.random() * 9) + 1));
	 $("#next19, #back19").html(Math.floor((Math.random() * 9) + 1));
}    
 
 
 var count = 10;

 function startCounting( ) {
     	setInterval("countDown()", 1000);
 }

 function countDown( ) {
    count=count-1;
   if (count <= 0) {
 	  window.location.href = "home.php";
 	 return;
   }
   $("#timer").html(count);
 }
 
 var connection =true;
 function networkConnection(){
	 if(connection==true){
		 connection=false
		 $('body').html('<div id="confirmation" style="display:block"><div class="confirm_1"><div class="" style="color: #fff; margin: 0% 0 5% 0;">Network Disconnected Page Reload at <span id="timer">10</span> secs</div><a href="home.php" id="" class="yes_btn">Reload</a></div></div>');
		 $('#confirmation').show();
		 startCounting();
	 }
	 
	 
	 //$('#ndrawLeftTime').countdown('pause');
	 	/*var xhr = new XMLHttpRequest();
	    var file = "images/logo.png";
	    var randomNum = Math.round(Math.random() * 10000);
	    xhr.open('HEAD', file + "?rand=" + randomNum, true);
	    xhr.send();
	    xhr.addEventListener("readystatechange", processRequest, false);
	 
	    function processRequest(e) {
	      if (xhr.readyState == 4) {
	        if (xhr.status >= 200 && xhr.status < 304) {
	          //  	alert("connection exists!");
	        }
	        else {
	        	
	          //alert("connection doesn't exist!");
	          $('#confirmation').show();
	          	var r = confirm("Please connect network and reload a page otherwise doesn't work");
				if (r == true) {
				  window.location.href = "index.php";
				}
	        }
	      } else if (xhr.readyState == 0) {
              // Network error (i.e. connection refused, access denied due to CORS, etc.)
	    	  $('#confirmation').show();
          }
	    }*/
	    
	/* $.ajax({
	        type: 'GET',
	        url: 'http://www.google.com',
	        success: function(data) {
	        },
	        error: function(XMLHttpRequest, textStatus, errorThrown) {
	            if (XMLHttpRequest.readyState == 4) {
	                // HTTP error (can be checked by XMLHttpRequest.status and XMLHttpRequest.statusText)
	            }
	            else if (XMLHttpRequest.readyState == 0) {
	                // Network error (i.e. connection refused, access denied due to CORS, etc.)
	            	$("#msg").show().html('Please connect network and reload a page').removeClass('alert-success').addClass('alert-danger');
	            	
	            }
	            else {
	                // something weird is happening
	            }
	        }
		        
		    });*/
 }
 
 function updateUserBalance(){
	 var drawID = $('#future').val();
	 $.ajax({
			type : "GET",
			url : "userbalance_update.php?id="+drawID,
			dataType:"json",
			success : function(res) {
				if(res.SESSION == 0){
					window.location.href = "home.php";
				}else{
					$('#userBalance').html(res.USER_BAL);
					$('#nxtdrawTime').html(res.nxtDrawTime);
					if(res.NXT_SEL==''){
						$('#future').html('').hide();
					}else{
						$('#future').html(res.NXT_SEL);
					}
				}
			},
			error: function(xhr, textStatus, errorThrown) {
				
				if (xhr.readyState == 4) {
					if (xhr.status >= 200 && xhr.status < 304) {
					  //  	alert("connection exists!");
					}
					else {
					  $("#loading").addClass('overlay');
					  $("#msg").show().html('Please connect network and reload a page').removeClass('alert-success').addClass('alert-danger');
					  location.reload();
					}
			  } else if (xhr.readyState == 0) {
				    // Network error (i.e. connection refused, access denied due to CORS, etc.)
	              $("#loading").addClass('overlay');
	   	          $("#msg").show().html('Please connect network and reload a page').removeClass('alert-success').addClass('alert-danger');
				   location.reload();
			  }
				  
	            
	        }
	 });
	 
 }
