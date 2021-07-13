<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<meta name="viewport" content=" width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<title>Auto Wash Send Email</title>
	<style type="text/css">
		
		/* Client-specific Styles */
		
		#outlook a { padding:0; } /* Force Outlook to provide a "view in browser" menu link. */
		.ExternalClass { width:100%; } /* Force Hotmail to display emails at full width */  
		.ExternalClass, 
		.ExternalClass p, 
		.ExternalClass span, 
		.ExternalClass font, 
		.ExternalClass td, 
		.ExternalClass div { line-height: 100%; } 
		/* Force Hotmail to display normal line spacing.  More on that: http://www.emailonacid.com/forum/viewthread/43/ */
		
		/* End reset */
		body, html {
			-webkit-text-size-adjust: none;
			-ms-text-size-adjust: none;
			margin:0; padding:0;
		}
		body {
			background: #fff;
			color: #000;
			font-family: Tahoma, Arial, Helvetica, sans-serif;
			font-size: 14px;
		}
		a {
			text-decoration: none;
			color: #2D87BA;
		}
		a img {
			border: none;
		}
		p {
			margin: 0;
			padding: 0;
		}
		h1 {
			color: #2d87ba;
			font-family: Helvetica, Arial, sans-serif;
			font-size: 20px;
			font-weight: bold;
			text-transform: uppercase;
			line-height: 36px;
			padding-right: 20px;
			margin: 0;
		}
		h2 {
			font-weight: bold;
			font-size: 16px;
			color: #2d87ba;
		}
		.outer {
			background: #fff;
		}
		.spacer {
			font-size: 1px;
			line-height: 1px;
		}
		.sub-header {
			color: #fff;
		}
		.sub-header a {
			color: #fff;
			text-decoration: none;
		}
		.header .social a {
			color: #2d87ba;
			font-family: Arial, Helvetica, sans-serif;
			font-size: 14px;
			line-height: 17px;
		}
		.content, .content p, .content li, .footer td {
			font-size: 14px;
			line-height: 25px;
			font-family: Helvetica, Arial, sans-serif;
			color: #333;
		}
		.content .list th {
			text-align: left;
			font-weight: bold;
			border-bottom: 2px #2d87ba solid;
		}
		
		.content .list td {
			padding: 5px 0;
			border-bottom: 1px #2d87ba solid;
		}
		
		.content .list .grand-total td {
			font-weight: bold;
			border-bottom: 2px #2d87ba solid;
			border-top: 1px #2d87ba solid;
		}
		
		.content .list td.no-line {
			border: 0;
		}
		
		.content .list .line-total,
		.content .list .unit-price,
		.content .list .label {
			text-align: right;
		}
		.content a {
			text-decoration: underline;
			color: #2d87ba;
		}
		.w580 {
			width:580px;
		}
		.w275 {
			width: 275px;
		}
		.widget-header td {
			border-bottom: 5px #2d87ba solid;
		}
		.col-3 img {
			padding-bottom: 10px;
		}
		.button-link, .button-link a, .button-link span {
			color: #fff;
			font-family: Helvetica, Arial, sans-serif;
			font-size: 15px;
			font-weight: bold;
			text-transform: uppercase;
			text-decoration: none;
		}
		
		.button {
			border: 3px solid #dde9ef;
		}
		.footer a {
			color: #2d87ba;
			text-decoration: underline;
		}
		.left-align {
			float: left;
			padding-right: 30px;
			padding-bottom: 20px;
		}
		.right-align {
			float: right;
			padding-left: 30px;
			padding-bottom: 20px;
		}
		@media only screen and (max-width: 600px) {
				table[class=outer] {
					width: 100% !important;
					margin: 0 auto !important;
				}
				table[class=outer] .w30 {
					width: 8% !important;
				}
				table[class=outer] .w580, table[class=outer] td.w275 {
					width: auto !important;
				}
				table[class=outer] .widget.w275 {
					width: 100% !important;
				}
				table[class=outer] .container {
					width: 90% !important;
				}
				table[class=outer] .logo img {
					display: block !important;
					max-width: 100% !important;
					width: 100% !important;
				}
				table[class=outer] .mobile-block {
					display: block !important;
				}
				table[class=outer] .social {
					width: 135px !important;
					float: right !important;
					margin-top: 23px !important;
				}
				table[class=outer] .social img {
					width: 28px !important;
					height: 28px !important;	
				}
				table[class=outer] .social tr {
					display: block !important;
				}
				table[class=outer] .social .mobile-block {
					float: left !important;
					width: 21px !important;
					margin-left: 21px;
				}
				table[class=outer] .cut,
				table[class=outer] .content .list .unit-price,
				table[class=outer] .content .list .code,
				table[class=outer] .content .list .no-line,
				table[class=outer] .content .list .qty {
					display: none !important;
				}
				
				table[class=outer] .content .list .label {
					text-align: left!important;
				}
				
				table[class=outer] .content .list tbody td,
				table[class=outer] .content .list thead th {
					width: 33%!important;
				}
				table[class=outer] .content img {
					display: block !important;
					width: 100% !important;
					max-width: 100% !important;
					float: none !important;
					padding: 0px 0 20px 0 !important;
					margin: 0 !important;
					border: 0 !important;
				}
				table[class=outer] .col-3 .mobile-block {
					margin-bottom: 20px !important;
				}
				table[class=outer] .col-3 td, table[class=outer] .social-wrapper {
					width: 100% !important;
				}
				table[class=outer] .footer .container {
					padding: 0 25px !important;
				}
				table[class=outer] .content .list td.no-line {
					width: 30% !important;
				}
			}
		</style>
</head>
<body style="-webkit-text-size-adjust: none;-ms-text-size-adjust: none;margin: 0;padding: 0;background: #fff;color: #b9b9b9;font-family: Helvetica, Arial, sans-serif;font-size: 14px;">
	<table cellpadding="0" cellspacing="0" width="100%" border="0" class="outer" style="background: #fff;" bgcolor="#ffffff">
		<tr>
			<td bgcolor="#2d87ba" height="10" class="sub-header">
				<table cellpadding="0" cellspacing="0" width="640" border="0" class="container" align="center">
					<tr>
						<td style="font-size: 1px;">&nbsp;</td>
					</tr>
				</table>
			</td>
			<!-- / .sub-header -->
		</tr>
		<tr>
			<td height="30" class="spacer" style="font-size: 1px;line-height: 1px;">&nbsp;</td>
		</tr>
		<tr>
			<td height="87" class="header">
				<table cellpadding="0" cellspacing="0" width="640" border="0" class="container" align="center">
					<tr>
						<td class="spacer w30" width="30" style="font-size: 1px;line-height: 1px;">&nbsp;</td>
						<td>
							<table cellpadding="0" cellspacing="0" width="100%" border="0">
								<tr>
									<td valign="middle" align="left" class="logo mobile-block">
									<img src="{{ asset('admin-assets/dist/images/logo.svg')}}">
									</td>
								</tr>
							</table>
						</td>
						<td class="spacer w30" width="30" style="font-size: 1px;line-height: 1px;">&nbsp;</td>
					</tr>
				</table>
			</td>
			<!-- / .header -->
		</tr>
		<tr>
			<td height="30" class="spacer" style="font-size: 1px;line-height: 1px;">&nbsp;</td>
		</tr>
	</table>
	<table cellpadding="0" cellspacing="0" width="100%" border="0" class="outer" style="background: #f6f9fa;" bgcolor="#f6f9fa">	
		<tr>
			<td class="content" style="font-size: 14px;line-height: 25px;font-family: Helvetica, Arial, sans-serif;color: #333;">
				<table cellpadding="0" cellspacing="0" width="640" border="0" class="container" bgcolor="#f6f9fa" align="center">
					<tr>
						<td class="spacer" height="41" colspan="3" style="font-size: 1px;line-height: 1px;">&nbsp;</td>
					</tr>
					<tr>
						<td class="spacer w30" width="30" style="font-size: 1px;line-height: 1px;">&nbsp;</td>
						<td class="w580" width="580" style="width: 580px;">
							<!-- Main content start -->

							<table class="widget w580" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 580px;">
								<tr class="widget-header">
									<td height="55" style="border-bottom: 5px #2d87ba solid;">
										<h1 style="color: #2d87ba;font-family: Helvetica, Arial, sans-serif;font-size: 20px;font-weight: bold;text-transform: uppercase;line-height: 36px;padding-right: 20px;margin: 0;">Sample Text Formatting</h1>
									</td>
								</tr>
								<tr>
									<td class="spacer" height="20" style="font-size: 1px;line-height: 1px;">&nbsp;</td>
								</tr>
								<tr class="widget-content">
									<td>
										<p style="margin: 0;padding: 0;font-size: 14px;line-height: 25px;font-family: Helvetica, Arial, sans-serif;color: #333;">This template lets you select from a range of <a href="#" style="text-decoration: underline;color: #2d87ba;">different link text and image</a> formatting for your email content. These are just samples of the formatting you can choose from when you add your content in the next step.</p>

										<h2 style="font-weight: bold;font-size: 16px;color: #2d87ba;">This is second level header</h2>

										<p style="margin: 0;padding: 0;font-size: 14px;line-height: 25px;font-family: Helvetica, Arial, sans-serif;color: #333;">This template lets you select from a range of different text and image formatting for your email content. These are just samples of the formatting you can choose from when you add your content in the next step.</p>

										<ul>
											<li style="font-size: 14px;line-height: 25px;font-family: Helvetica, Arial, sans-serif;color: #333;">This template lets you select from </li>
											<li style="font-size: 14px;line-height: 25px;font-family: Helvetica, Arial, sans-serif;color: #333;">Range of different text and image formatting for your email content
												<ul>
													<li style="font-size: 14px;line-height: 25px;font-family: Helvetica, Arial, sans-serif;color: #333;">These are just samples</li>
													<li style="font-size: 14px;line-height: 25px;font-family: Helvetica, Arial, sans-serif;color: #333;">Formatting you can</li>
													<li style="font-size: 14px;line-height: 25px;font-family: Helvetica, Arial, sans-serif;color: #333;">Choose from</li>
												</ul>
											</li>
											<li style="font-size: 14px;line-height: 25px;font-family: Helvetica, Arial, sans-serif;color: #333;">When you add your content in the next step</li>
										</ul>
										<br>
									
										<table cellpadding="0" cellspacing="0" border="0" align="center" class="button" bgcolor="#2d87ba">
											<tr>
												<td class="spacer" width="15" style="font-size: 1px;line-height: 1px;">&nbsp;</td>
												<td valign="middle" align="center" height="43" class="button-link" style="color: #151515;font-family: Helvetica, Arial, sans-serif;font-size: 15px;font-weight: bold;text-transform: uppercase;text-decoration: none;">
													<?php
													$url = asset('');
													?>
													<a href="{{$url}}agent-create-password/{{$all['id']}}"style="text-decoration: none;color: #fff;font-family: Helvetica, Arial, sans-serif;font-size: 15px;font-weight: bold;text-transform: uppercase;"><span style="color: #fff;font-family: Helvetica, Arial, sans-serif;font-size: 15px;font-weight: bold;text-transform: uppercase;text-decoration: none;">Create Password</span></a>
												</td>
												<td class="spacer" width="15" style="font-size: 1px;line-height: 1px;">&nbsp;</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td class="spacer" height="40" style="font-size: 1px;line-height: 1px;">&nbsp;</td>
								</tr>
							</table>
							<!-- / .widget -->
							
							<!-- Main content end -->
						</td>
						<td class="spacer w30" width="30" style="font-size: 1px;line-height: 1px;">&nbsp;</td>
					</tr> 
					<tr>
						<td class="spacer" height="41" colspan="3" style="font-size: 1px;line-height: 1px;">&nbsp;</td>
					</tr>
				</table>
			</td>
			<!-- / .content -->
		</tr>
		<tr>
			<!-- <td class="footer"  bgcolor="#eee" >
				<table cellpadding="0" cellspacing="0" width="640" border="0" class="container" align="center">
					<tr>
						<td height="74" align="center" valign="middle" style="font-size: 14px;line-height: 25px;font-family: Helvetica, Arial, sans-serif;color: #333;">
							Don’t want to receive our newsletter?  <a href="#" style="text-decoration: underline;color: #2d87ba;">Unsubscribe</a>
						</td>
					</tr>
				</table>
			</td> -->
			<!-- / .footer -->
		</tr>
	</table>
</body>
</html>