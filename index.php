<?php

echo "DEBUG DI PROVA";

require_once("lib/sql.php");
require_once("lib/graph.php");

$temp = getCurTemp();



?>



<!doctype html>
<html><head>
    <meta charset="utf-8">
    <title>BLOCKS - Bootstrap Dashboard Theme</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Carlos Alvarez - Alvarez.is">

    <!-- Le styles -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">
    <link href="assets/css/font-style.css" rel="stylesheet">
    <link href="assets/css/flexslider.css" rel="stylesheet">
    
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>

    <style type="text/css">
      body {
        padding-top: 60px;
      }
    </style>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">

  	<!-- Google Fonts call. Font Used Open Sans & Raleway -->
	<link href="http://fonts.googleapis.com/css?family=Raleway:400,300" rel="stylesheet" type="text/css">
  	<link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">

<script type="text/javascript">
$(document).ready(function () {

    $("#btn-blog-next").click(function () {
      $('#blogCarousel').carousel('next')
    });
     $("#btn-blog-prev").click(function () {
      $('#blogCarousel').carousel('prev')
    });

     $("#btn-client-next").click(function () {
      $('#clientCarousel').carousel('next')
    });
     $("#btn-client-prev").click(function () {
      $('#clientCarousel').carousel('prev')
    });
    
});

 $(window).load(function(){

    $('.flexslider').flexslider({
        animation: "slide",
        slideshow: true,
        start: function(slider){
          $('body').removeClass('loading');
        }
    });  
});

</script>


    
  </head>
  <body>
  
  	<!-- NAVIGATION MENU -->

    <div class="navbar-nav navbar-inverse navbar-fixed-top">
        <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.html"><img src="assets/img/logo30.png" alt=""> BLOCKS Dashboard</a>
        </div> 
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li class="active"><a href="index.html"><i class="icon-home icon-white"></i> Home</a></li>
              <li><a href="manager.html"><i class="icon-folder-open icon-white"></i> File Manager</a></li>
              <li><a href="calendar.html"><i class="icon-calendar icon-white"></i> Calendar</a></li>
              <li><a href="tables.html"><i class="icon-th icon-white"></i> Tables</a></li>
              <li><a href="login.html"><i class="icon-lock icon-white"></i> Login</a></li>
              <li><a href="user.html"><i class="icon-user icon-white"></i> User</a></li>

            </ul>
          </div><!--/.nav-collapse -->
        </div>
    </div>

    <div class="container">

	  <!-- FIRST ROW OF BLOCKS -->     
      <div class="row">

      <!-- PLANT PROFILE BLOCK -->
        <div class="col-sm-3 col-lg-3">
      		<div class="dash-unit">
	      		<dtitle>Plant Profile</dtitle>
	      		<hr>
				<div class="thumbnail">
					<img src="assets/img/face80x80.jpg" alt="Marcel Newman" class="img-circle">
				</div><!-- /thumbnail -->
				<h1>Classe Virtuale 2014</h1>
				<h3>Angeli, Italia</h3>
				<br>
					<div class="info-user">
						<span aria-hidden="true" class="li_user fs1"></span>
						<span aria-hidden="true" class="li_settings fs1"></span>
						<span aria-hidden="true" class="li_mail fs1"></span>
						<span aria-hidden="true" class="li_key fs1"></span>
					</div>
				</div>
        </div>

      
        	<!-- History all data - CAROUSEL FLEXSLIDER -->     
        <div class="col-sm-6 col-lg-6">
      		<div class="dash-unit">
	      		<dtitle>Dati ultimo periodo</dtitle>
	      		<hr>

	            <div class="flexslider">
					<ul class="slides">
						<li><div id="cont-history-charts" style="height:280px"></div></li>
						<li><img src="assets/img/slide02.png" alt="slider"></li>
					</ul>
            </div>
			</div>
        </div>
        
        <div class="col-sm-3 col-lg-3">


      <!-- LOCAL TIME BLOCK -->
      		<div class="half-unit">
	      		<dtitle>Ora locale</dtitle>
	      		<hr>
		      		<div class="clockcenter">
			      		<digiclock>12:45:25</digiclock>
		      		</div>
			</div>

      <!-- Last Update UPTIME -->
			<div class="half-unit">
	      		<dtitle>Ultimo aggiornamento</dtitle>
	      		<hr>
	      		<div class="cont">
					<p><img src="assets/img/up.png" alt=""> <bold>Up</bold> | 356ms.</p>
				</div>
			</div>

        </div>
      </div><!-- /row -->
      
      
	  <!-- SECOND ROW OF BLOCKS -->     
      <div class="row">
       

    <!-- Attual Light BLOCK -->   
    <div class="col-sm-3 col-lg-3">  
      		<div class="half-unit">
	      		<dtitle>Luce attuale</dtitle>
	      		<hr>
	      		<div class="cont">
      			<p><bold>388</bold></p>
      			<p><img src="assets/img/up-small.png" alt=""> 412 Max. | <img src="assets/img/down-small.png" alt=""> 89 Min.</p>
	      		</div>
      		</div>
      	<!-- Attual Temperature BLOCK -->  
      		<div class="half-unit">
	      		<dtitle>Temperatura attuale</dtitle>
	      		<hr>
	      		<div class="cont">
      			<p><bold><?php echo $temp; ?></bold></p>
      			<p><img src="assets/img/up-small.png" alt=""> 412 Max. | <img src="assets/img/down-small.png" alt=""> 89 Min.</p>
	      		</div>
      		</div>
      	</div>
<!-- DONUT CHART:Umidity terrain BLOCK -->
        <div class="col-sm-3 col-lg-3">
      		<div class="dash-unit">
		  		<dtitle>Umidità terreno</dtitle>
		  		<hr>
	        	<div id="load"></div>
	        	<h2>45%</h2>
			</div>
        </div>

      <!-- DONUT CHART:Umidity air BLOCK -->
        <div class="col-sm-3 col-lg-3">
      		<div class="dash-unit">
		  		<dtitle>Umidità area</dtitle>
		  		<hr>
	        	<div id="space"></div>
	        	<h2>65%</h2>
			</div>
        </div>
        
	  <!-- Cell Level BLOCK -->   
    <div class="col-sm-3 col-lg-3">  
      		<div class="half-unit">
	      		<dtitle>Livello batteria</dtitle>

	      		<div class="cont">
					<p><bold>13</bold> | Pending Tasks</p>
				</div>
		             <div class="progress">
				        <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:60%;"><span class="sr-only">60% Complete</span>
					        
				        </div>
				     </div>
	      		<hr>
      		</div>
      	<!-- Water level BLOCK -->  
      		<div class="half-unit">
	      		<dtitle>Livello acqua</dtitle>
	      		<hr>
	      		<div class="cont">
      			<p><bold>388</bold></p>
	      		</div>
      		</div>
      	</div>

	
        
	  
      </div><!-- /row -->
     
 
	  <!-- THIRD ROW OF BLOCKS -->     
      <div class="row">

      	  <!-- LAST MONTH REVENUE -->     
        <div class="col-sm-3 col-lg-3">
      		<div class="dash-unit">
	      		<dtitle>Last Month Revenue</dtitle>
	      		<hr>
	      		<div class="cont">
					<p><bold>$879</bold> | <ok>Approved</ok></p>
					<br>
					<p><bold>$377</bold> | Pending</p>
					<br>
					<p><bold>$156</bold> | <bad>Denied</bad></p>
					<br>
					<p><img src="assets/img/up-small.png" alt=""> 12% Compared Last Month</p>

				</div>

			</div>
        </div>
      	<!-- GRAPH CHART - lineandbars.js file -->     
        <div class="col-sm-3 col-lg-3">
      		<div class="dash-unit">
      		<dtitle>Other Information</dtitle>
      		<hr>
			    <div class="section-graph">
			      <div id="importantchart"></div>
			      <br>
			      <div class="graph-info">
			        <i class="graph-arrow"></i>
			        <span class="graph-info-big">634.39</span>
			        <span class="graph-info-small">+2.18 (3.71%)</span>
			      </div>
			    </div>
			</div>
        </div>
      	 <div class="col-sm-3 col-lg-3">
       <!-- MAIL BLOCK -->
      		<div class="dash-unit">
      		<dtitle>Inbox (1)</dtitle>
      		<hr>
      		<div class="framemail">
    			<div class="window">
			        <ul class="mail">
			            <li>
			                <i class="unread"></i>
			                <img class="avatar" src="assets/img/photo01.jpeg" alt="avatar">
			                <p class="sender">Adam W.</p>
			                <p class="message"><strong>Working</strong> - This is the last...</p>
			                <div class="actions">
			                    <a><img src="http://png-1.findicons.com/files//icons/2232/wireframe_mono/16/undo.png" alt="reply"></a>
			                    <a><img src="http://png-1.findicons.com/files//icons/2232/wireframe_mono/16/star_fav.png" alt="favourite"></a>
			                    <a><img src="http://png-4.findicons.com/files//icons/2232/wireframe_mono/16/tag.png" alt="label"></a>
			                    <a><img src="http://png-4.findicons.com/files//icons/2232/wireframe_mono/16/trash.png" alt="delete"></a>
			                </div>
			            </li>
			            <li>
			                <i class="read"></i>
			                <img class="avatar" src="assets/img/photo02.jpg" alt="avatar">
			                <p class="sender">Dan E.</p>
			                <p class="message"><strong>Hey man!</strong> - You have to taste ...</p>
			                <div class="actions">
			                    <a><img src="http://png-1.findicons.com/files//icons/2232/wireframe_mono/16/undo.png" alt="reply"></a>
			                    <a><img src="http://png-1.findicons.com/files//icons/2232/wireframe_mono/16/star_fav.png" alt="favourite"></a>
			                    <a><img src="http://png-4.findicons.com/files//icons/2232/wireframe_mono/16/tag.png" alt="label"></a>
			                    <a><img src="http://png-4.findicons.com/files//icons/2232/wireframe_mono/16/trash.png" alt="delete"></a>
			                </div>
			            </li>
			            <li>
			                <i class="read"></i>
			                <img class="avatar" src="assets/img/photo03.jpg" alt="avatar">
			                <p class="sender">Leonard N.</p>
			                <p class="message"><strong>New Mac :D</strong> - So happy with ...</p>
			                <div class="actions">
			                    <a><img src="http://png-1.findicons.com/files//icons/2232/wireframe_mono/16/undo.png" alt="reply"></a>
			                    <a><img src="http://png-1.findicons.com/files//icons/2232/wireframe_mono/16/star_fav.png" alt="favourite"></a>
			                    <a><img src="http://png-4.findicons.com/files//icons/2232/wireframe_mono/16/tag.png" alt="label"></a>
			                    <a><img src="http://png-4.findicons.com/files//icons/2232/wireframe_mono/16/trash.png" alt="delete"></a>
			                </div>
			            </li>
			            <li>
			                <i class="read"></i>
			                <img class="avatar" src="assets/img/photo04.jpg" alt="avatar">
			                <p class="sender">Peter B.</p>
			                <p class="message"><strong>Thank you</strong> - Finally I can ...</p>
			                <div class="actions">
			                    <a><img src="http://png-1.findicons.com/files//icons/2232/wireframe_mono/16/undo.png" alt="reply"></a>
			                    <a><img src="http://png-1.findicons.com/files//icons/2232/wireframe_mono/16/star_fav.png" alt="favourite"></a>
			                    <a><img src="http://png-4.findicons.com/files//icons/2232/wireframe_mono/16/tag.png" alt="label"></a>
			                    <a><img src="http://png-4.findicons.com/files//icons/2232/wireframe_mono/16/trash.png" alt="delete"></a>
			                </div>
			            </li>
			        </ul>
    			</div>
			</div>
		</div><!-- /dash-unit -->
    </div><!-- /span3 -->
      	<div class="col-sm-3 col-lg-3">
	  
	  <!-- BARS CHART - lineandbars.js file -->     
      		<div class="half-unit">
	      		<dtitle>Stock Information</dtitle>
	      		<hr>
	      		<div class="cont">
	      		 <div class="info-aapl">
			        <h4>AAPL</h4>
			        <ul>
			          <li><span class="orange" style="height: 37.5%"></span></li>
			          <li><span class="orange" style="height: 47.5%"></span></li>
			          <li><span class="orange" style="height: 70%"></span></li>
			          <li><span class="orange" style="height: 85%"></span></li>
			          <li><span class="green" style="height: 75%"></span></li>
			          <li><span class="green" style="height: 50%"></span></li>
			          <li><span class="green" style="height: 15%"></span></li>
			        </ul>
			      </div>
			      </div>
      		</div>

	  <!-- TO DO LIST -->     
      		<div class="half-unit">
	      		<dtitle>To Do List</dtitle>
	      		<hr>
	      		<div class="cont">
					<p><bold>13</bold> | Pending Tasks</p>
				</div>
		             <div class="progress">
				        <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:60%;"><span class="sr-only">60% Complete</span>
					        
				        </div>
				     </div>
      		</div>
      	</div>

      	<div class="col-sm-3 col-lg-3">

	  
      		
	  <!-- PAGE VIEWS BLOCK -->     
      		<div class="half-unit">
	      		<dtitle>Page Views</dtitle>
	      		<hr>
	      		<div class="cont">
      			<p><bold>145.0K</bold></p>
      			<p><img src="assets/img/up-small.png" alt=""> 23.88%</p>
	      		</div>
      		</div>
      	</div>

      	<div class="col-sm-3 col-lg-3">
	  <!-- TOTAL SUBSCRIBERS BLOCK -->     
      		<div class="half-unit">
	      		<dtitle>Total Subscribers</dtitle>
	      		<hr>
	      		<div class="cont">
      			<p><bold>14.744</bold></p>
      			<p>98 Subscribed Today</p>
	      		</div>
      		</div>
      		
	  <!-- FOLLOWERS BLOCK -->     
      		<div class="half-unit">
	      		<dtitle>Twitter Followers</dtitle>
	      		<hr>
	      		<div class="cont">
      			<p><bold>17.833 Followers</bold></p>
      			<p>@SomeUser</p>
	      		</div>
      		</div>
      	</div>

	  <!-- LATEST NEWS BLOCK -->     
      	<div class="col-sm-3 col-lg-3">
      		<div class="dash-unit">
	      		<dtitle>Latest News</dtitle>
	      		<hr>
				<div class="info-user">
					<span aria-hidden="true" class="li_news fs2"></span>
				</div>
				<br>
      			<div class="text">
      				<p><b>Alvarez.is:</b> A beautiful new Dashboard theme has been realised by Carlos Alvarez. Please, visit <a href="http://alvarez.is">Alvarez.is</a> for more details.</p>
      				<p><grey>Last Update: 5 minutes ago.</grey></p>
      			</div>
      		</div>
      	</div>
      </div><!-- /row -->
      
	  <!-- FOURTH ROW OF BLOCKS -->     
	<div class="row">
	
	  <!-- TWITTER WIDGET BLOCK -->     
		<div class="col-sm-3 col-lg-3">
			<div class="dash-unit">
	      		<dtitle>Twitter Widget</dtitle>
	      		<hr>
				<div class="info-user">
					<span aria-hidden="true" class="li_megaphone fs2"></span>
				</div>
				<br>
		 		<div id="jstwitter" class="clearfix">
					<ul id="twitter_update_list"></ul>
				</div>
				<script src="http://twitter.com/javascripts/blogger.js"></script><!-- Script Needed to load the Tweets -->
				<script src="http://api.twitter.com/1/statuses/user_timeline/wrapbootstrap.json?callback=twitterCallback2&amp;count=1"></script>
				<!-- To show your tweets replace "wrapbootstrap", in the line above, with your user. -->
				<div class="text">
				<p><grey>Show your tweets here!</grey></p>
				</div>
			</div>
		</div>

	  <!-- NOTIFICATIONS BLOCK -->     
		<div class="col-sm-3 col-lg-3">
			<div class="dash-unit">
	      		<dtitle>Notifications</dtitle>
	      		<hr>
	      		<div class="info-user">
					<span aria-hidden="true" class="li_bubble fs2"></span>
				</div>
	      		<div class="cont">
	      			<p><button class="btnnew noty" data-noty-options="{&quot;text&quot;:&quot;This is a success notification&quot;,&quot;layout&quot;:&quot;topRight&quot;,&quot;type&quot;:&quot;success&quot;}">Top Right</button></p>
	      			<p><button class="btnnew noty" data-noty-options="{&quot;text&quot;:&quot;This is an informaton notification&quot;,&quot;layout&quot;:&quot;topLeft&quot;,&quot;type&quot;:&quot;information&quot;}">Top Left</button></p>
	      			<p><button class="btnnew noty" data-noty-options="{&quot;text&quot;:&quot;This is an alert notification with fade effect.&quot;,&quot;layout&quot;:&quot;topCenter&quot;,&quot;type&quot;:&quot;alert&quot;,&quot;animateOpen&quot;: {&quot;opacity&quot;: &quot;show&quot;}}">Top Center (fade)</button></p>
	      		</div>
			</div>
		</div>

	  <!-- SWITCHES BLOCK -->     
		<div class="col-sm-3 col-lg-3">
			<div class="dash-unit">
	      		<dtitle>Switches</dtitle>
	      		<hr>
	      		<div class="info-user">
					<span aria-hidden="true" class="li_params fs2"></span>
				</div>
				<br>
				<div class="switch">
					<input type="radio" class="switch-input" name="view" value="on" id="on" checked="">
					<label for="on" class="switch-label switch-label-off">On</label>
					<input type="radio" class="switch-input" name="view" value="off" id="off">
					<label for="off" class="switch-label switch-label-on">Off</label>
					<span class="switch-selection"></span>
				</div>
				<div class="switch switch-blue">
					<input type="radio" class="switch-input" name="view2" value="week2" id="week2" checked="">
					<label for="week2" class="switch-label switch-label-off">Week</label>
					<input type="radio" class="switch-input" name="view2" value="month2" id="month2">
					<label for="month2" class="switch-label switch-label-on">Month</label>
					<span class="switch-selection"></span>
				</div>
				
				<div class="switch switch-yellow">
					<input type="radio" class="switch-input" name="view3" value="yes" id="yes" checked="">
					<label for="yes" class="switch-label switch-label-off">Yes</label>
					<input type="radio" class="switch-input" name="view3" value="no" id="no">
					<label for="no" class="switch-label switch-label-on">No</label>
					<span class="switch-selection"></span>
				</div>
			</div>
		</div>

	  <!-- GAUGE CHART BLOCK -->     
		<div class="col-sm-3 col-lg-3">
			<div class="dash-unit">
	      		<dtitle>Gauge Chart</dtitle>
	      		<hr>
	      		<div class="info-user">
					<span aria-hidden="true" class="li_lab fs2"></span>
				</div>
				<canvas id="canvas" width="300" height="300">
			</canvas></div>
		</div>
	
	</div><!--/row -->     
      
 	  <!-- FOURTH ROW OF BLOCKS -->     
		<div class="row">

 	  <!-- ACCORDION BLOCK -->     
			<div class="col-sm-3 col-lg-3">
				<div class="dash-unit">
	      		<dtitle>Accordion</dtitle>
	      		<hr>
					<div class="accordion" id="accordion2">
		                <div class="accordion-group">
		                    <div class="accordion-heading">
		                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
		                        Collapsible Group Item #1
		                        </a>
		                    </div>
		                    <div id="collapseOne" class="accordion-body collapse in">
		                        <div class="accordion-inner">
								Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla iaculis mattis lorem.                        
								</div>
		                    </div>
		                </div>
		
		                <div class="accordion-group">
		                    <div class="accordion-heading">
		                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
		                        Collapsible Group Item #2
		                        </a>
		                    </div>
		                    <div id="collapseTwo" class="accordion-body collapse">
		                        <div class="accordion-inner">
								Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla iaculis mattis lorem.                      
								</div>
		                    </div>
		                </div>
		
		                 <div class="accordion-group">
		                    <div class="accordion-heading">
		                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree">
		                        Collapsible Group Item #3
		                        </a>
		                    </div>
		                    <div id="collapseThree" class="accordion-body collapse">
		                        <div class="accordion-inner">
								Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla iaculis mattis lorem.                        
		                        </div>
		                    </div>
		                </div>
		            </div><!--/accordion -->
				</div>
			</div>
			
			<div class="col-sm-3 col-lg-3">

 	  		<!-- LAST USER BLOCK -->     
				<div class="half-unit">
	      		<dtitle>Last Registered User</dtitle>
	      		<hr>
	      			<div class="cont2">
	      				<img src="assets/img/user-avatar.jpg" alt="">
	      				<br>
	      				<br>
	      				<p>Paul Smith</p>
	      				<p><bold>Liverpool, England</bold></p>
	      			</div>
				</div>
				
 	  		<!-- MODAL BLOCK -->     
				<div class="half-unit">
	      		<dtitle>Modal</dtitle>
	      		<hr>
		            <div class="cont">
		                <a href="#myModal" role="button" class="btnnew" data-toggle="modal">Example Modal Window</a>
		            </div>
				</div>
			</div>
			<!-- Modal -->
			  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			    <div class="modal-dialog">
			      <div class="modal-content">
			        <div class="modal-header">
			          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			          <h4 class="modal-title">Modal title</h4>
			        </div>
			        <div class="modal-body">
			          ...
			        </div>
			        <div class="modal-footer">
			          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			          <button type="button" class="btn btn-primary">Save changes</button>
			        </div>
			      </div><!-- /.modal-content -->
			    </div><!-- /.modal-dialog -->
			  </div><!-- /.modal -->
 	  		<!-- FAST CONTACT BLOCK -->     
			<div class="col-sm-3 col-lg-3">
				<div class="dash-unit">
	      		<dtitle>Fast Contact</dtitle>
	      		<hr>
	      		<div class="cont">
                	<form action="#get-in-touch" method="POST" id="contact">
                    	<input type="text" id="contactname" name="contactname" placeholder="Name">
                    	<input type="text" id="email" name="email" placeholder="Email">
                    	<div class="textarea-container"><textarea id="message" name="message" placeholder="Message"></textarea></div>
                    	<input type="submit" id="submit" name="submit" value="Send">
                    </form>
				</div>
				</div>
			</div>

 	  		<!-- INFORMATION BLOCK -->     
			<div class="col-sm-3 col-lg-3">
				<div class="dash-unit">
	      		<dtitle>Block Dashboard</dtitle>
	      		<hr>
	      		<div class="info-user">
					<span aria-hidden="true" class="li_display fs2"></span>
				</div>
				<br>
				<div class="text">
				<p>Block Dashboard created by Basicoh.</p>
				<p>Special Thanks to Highcharts, Linecons and Bootstrap for their amazing tools.</p>
				</div>

				</div>
			</div>

		</div><!--/row -->
     
      
      
	</div> <!-- /container -->
	<div id="footerwrap">
      	<footer class="clearfix"></footer>
      	<div class="container">
      		<div class="row">
      			<div class="col-sm-12 col-lg-12">
      			<p><img src="assets/img/logo.png" alt=""></p>
      			<p>Blocks Dashboard Theme - Crafted With Love - Copyright 2013</p>
      			</div>

      		</div><!-- /row -->
      	</div><!-- /container -->		
	</div><!-- /footerwrap -->


    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="assets/js/bootstrap.js"></script>
	<script type="text/javascript" src="assets/js/lineandbars.js"></script>
    
	<script type="text/javascript" src="assets/js/dash-charts.js"></script>
	<script type="text/javascript" src="assets/js/highstoc-charts.js"></script>
	<script type="text/javascript" src="assets/js/gauge.js"></script>
	
	<!-- NOTY JAVASCRIPT -->
	<script type="text/javascript" src="assets/js/noty/jquery.noty.js"></script>
	<script type="text/javascript" src="assets/js/noty/layouts/top.js"></script>
	<script type="text/javascript" src="assets/js/noty/layouts/topLeft.js"></script>
	<script type="text/javascript" src="assets/js/noty/layouts/topRight.js"></script>
	<script type="text/javascript" src="assets/js/noty/layouts/topCenter.js"></script>
	
	<!-- You can add more layouts if you want -->
	<script type="text/javascript" src="assets/js/noty/themes/default.js"></script>
    <!-- <script type="text/javascript" src="assets/js/dash-noty.js"></script> This is a Noty bubble when you init the theme-->
	<script type="text/javascript" src="assets/js/highcharts1.js"></script>
	<script src="assets/js/jquery.flexslider.js" type="text/javascript"></script>

    <script type="text/javascript" src="assets/js/admin.js"></script>
  
</body></html>