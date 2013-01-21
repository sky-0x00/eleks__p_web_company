<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Strict//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>Панель управления сайтом - {# $DomainInfo[0].name #}</title>
<link href="/admin/css/style.css" rel="stylesheet" type="text/css">
</head>
<script language="JavaScript" src="{# $PATH_SKIN_JS #}md5.js"></script>
<script language="JavaScript" src="{# $PATH_SKIN_JS #}function.js"></script>
<!--
	<table id="loginform" >
		<tr>
			<td style="text-align: center; width: 100%;">
		
			<div id="back">				
				
				<div id="form">				
				<form id="auth_form" action="{# $SESS_URL #}" method="post" name="auth_form">
					<table align="center"  style="text-align: center;">
						<tr><td>логин<td align="left"><input type="text" class="text" name="auth_login"></td></tr>
						<tr><td>пароль</td><td align="left"><input type="password" class="text" name="auth_password"></td></tr>
						<tr><td></td><td align="left">
							<div style="float: left;"><input type="checkbox" name="remember"></div>
							<div style="float: left; font-size: 11px;color: #58585a; margin-top:2px; font-weight: normal;">запомнить</div>
							<div style="text-align: right;"><button class="enter" onClick="return doChallengeResponse();"></button></div>
							</td></tr>
					</table>
				</div>						
			
			<input type="hidden" name="auth_challenge" value="{# $AUTH_CHALLENGE #}">        
			</form>
			</div>
			
			<div style="display:none;">
            <form action="{# $SESS_URL #}" method="post" name="auth_form_submit">
            <input type="hidden" name="auth_login" value="">
            <input type="hidden" name="auth_response"  value="">
            <input type="hidden" name="remember"  value="">
            </form>    
		</div>
			
			</td>
		</tr>
	</table>-->


<div id="auth-form">
	<div class="back">
	<div id="auth-form-field">				
		<form id="auth_form" action="{# $SESS_URL #}" method="post" name="auth_form">
		<table align="center"  style="text-align: center;">
			<tr><td>логин<td align="left"><input type="text" class="text" name="auth_login"></td></tr>
			<tr><td>пароль</td><td align="left"><input type="password" class="text" name="auth_password"></td></tr>
			<tr><td></td><td align="left">
			<div style="float: left;"><input type="checkbox" name="remember"></div>
			<div style="float: left; font-size: 11px;color: #58585a; margin-top:2px; font-weight: normal;">запомнить</div>
			<div style="text-align: right;"><button class="enter" onClick="return doChallengeResponse();"></button></div>
			</td></tr>
		</table>
	</div>
	<input type="hidden" name="auth_challenge" value="{# $AUTH_CHALLENGE #}">        
	</form>
	</div>
	
	<div style="display:none;">
		<form action="{# $SESS_URL #}" method="post" name="auth_form_submit">
		<input type="hidden" name="auth_login" value="">
		<input type="hidden" name="auth_response"  value="">
		<input type="hidden" name="remember"  value="">
		</form>
	</div>
</div>
