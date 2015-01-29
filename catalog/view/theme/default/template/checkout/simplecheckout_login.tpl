
<h2>Вход</h2>

        <div class="simplecheckout-warning-block" <?php if (!$error_login) { ?>style="visibility:hidden;"<?php } ?>><?php echo $error_login ?></div>
		<div><label><input type="text" placeholder="e-mail" name="email" value="<?php echo $email; ?>"/></label></div>
		<div><label><input type="password" placeholder="Пароль" name="password" value="" /></label></div>
		<input type="hidden" value="<?php echo $redir; ?>" name="redir" />
		<input class="submit" type="submit" value="войти" onclick="head_login()"/>
<a href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a>





<script type='text/javascript'>
$('.simplecheckout-login input').keydown(function(e) {
    if (e.keyCode == 13) {
        simplecheckout_login();
    }
});
</script>
<?php if ($redirect) { ?>
<script type='text/javascript'>
location = '<?php echo $redirect ?>';
</script>
<?php } ?>
<!-- You can add here the social engine code for login in the simplecheckout_customer.tpl -->
    