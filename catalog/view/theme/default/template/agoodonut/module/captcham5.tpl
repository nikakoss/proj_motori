<!-- // for the lazy. no need to thanks. no offense, i wanted to help them :) -->
<?php if ($captcha_status) { ?>
<div class="height30" style="float:left">
<img class="captcha_update" src="index.php?route=record/record/captcham5&v=<?php echo rand(0,1000); ?>" alt="captcha" id="imgcaptcha" class="captcha_img" style="float:left;margin:0 20px 0 0" title="кликните по картинке что бы обновить">
<input type="text" name="captcha" value="" id="captcha_fun" class="captcha captchainput captcha_img" maxlength="5" size="5">

</div>
<script type="text/javascript">
$(document).ready(function(){

	$('.bkey').bind('click', subcaptcha);

	$('.captcha_update').click(function() {
	 captcha_fun();
	 return false;
	});

});
</script>


<?php } ?>