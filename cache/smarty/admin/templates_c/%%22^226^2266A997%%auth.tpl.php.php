<?php /* Smarty version 2.6.18, created on 2012-12-02 12:16:51
         compiled from C:/Users/sky-0x00/Documents/Visual+Studio+2008/Projects/p_web_company/admin/modules/auth/templates/auth.tpl.php */ ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Strict//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>������ ���������� ������ - <?php echo $this->_tpl_vars['DomainInfo'][0]['name']; ?>
</title>
<link href="/admin/css/style.css" rel="stylesheet" type="text/css">
</head>
<script language="JavaScript" src="<?php echo $this->_tpl_vars['PATH_SKIN_JS']; ?>
md5.js"></script>
<script language="JavaScript" src="<?php echo $this->_tpl_vars['PATH_SKIN_JS']; ?>
function.js"></script>
<!--
	<table id="loginform" >
		<tr>
			<td style="text-align: center; width: 100%;">
		
			<div id="back">				
				
				<div id="form">				
				<form id="auth_form" action="<?php echo $this->_tpl_vars['SESS_URL']; ?>
" method="post" name="auth_form">
					<table align="center"  style="text-align: center;">
						<tr><td>�����<td align="left"><input type="text" class="text" name="auth_login"></td></tr>
						<tr><td>������</td><td align="left"><input type="password" class="text" name="auth_password"></td></tr>
						<tr><td></td><td align="left">
							<div style="float: left;"><input type="checkbox" name="remember"></div>
							<div style="float: left; font-size: 11px;color: #58585a; margin-top:2px; font-weight: normal;">���������</div>
							<div style="text-align: right;"><button class="enter" onClick="return doChallengeResponse();"></button></div>
							</td></tr>
					</table>
				</div>						
			
			<input type="hidden" name="auth_challenge" value="<?php echo $this->_tpl_vars['AUTH_CHALLENGE']; ?>
">        
			</form>
			</div>
			
			<div style="display:none;">
            <form action="<?php echo $this->_tpl_vars['SESS_URL']; ?>
" method="post" name="auth_form_submit">
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
		<form id="auth_form" action="<?php echo $this->_tpl_vars['SESS_URL']; ?>
" method="post" name="auth_form">
		<table align="center"  style="text-align: center;">
			<tr><td>�����<td align="left"><input type="text" class="text" name="auth_login"></td></tr>
			<tr><td>������</td><td align="left"><input type="password" class="text" name="auth_password"></td></tr>
			<tr><td></td><td align="left">
			<div style="float: left;"><input type="checkbox" name="remember"></div>
			<div style="float: left; font-size: 11px;color: #58585a; margin-top:2px; font-weight: normal;">���������</div>
			<div style="text-align: right;"><button class="enter" onClick="return doChallengeResponse();"></button></div>
			</td></tr>
		</table>
	</div>
	<input type="hidden" name="auth_challenge" value="<?php echo $this->_tpl_vars['AUTH_CHALLENGE']; ?>
">        
	</form>
	</div>
	
	<div style="display:none;">
		<form action="<?php echo $this->_tpl_vars['SESS_URL']; ?>
" method="post" name="auth_form_submit">
		<input type="hidden" name="auth_login" value="">
		<input type="hidden" name="auth_response"  value="">
		<input type="hidden" name="remember"  value="">
		</form>
	</div>
</div>