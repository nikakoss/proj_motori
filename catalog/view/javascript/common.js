$(document).ready(function() {
    /* Search */
    $('#searchForm p').bind('click', function() {
        url = $('base').attr('href') + 'index.php?route=product/search';

        var search = $('input[name=\'search\']').attr('value');

        if (search) {
            url += '&search=' + encodeURIComponent(search);
        }

        location = url;
    });

    $('.otzivclick').bind('click', function() {
        $('html, body').animate({ scrollTop: $('.otzivi').offset().top }, 'slow');
        if(!$('#otzivvisibl').is(":visible")){
            $('.accordionTitle.otzivi').trigger('click');
        }
        return false; 
    });

    $('span.error').live('mouseover', function() {
        $(this).hide("slow");
    });
    $('span.errorcontact').live('mouseover', function() {
        $(this).hide("slow");
    });

    $('input[name=\'search\']').bind('keydown', function(e) {
        if (e.keyCode == 13) {
            url = $('base').attr('href') + 'index.php?route=product/search';

            var search = $('input[name=\'search\']').attr('value');

            if (search) {
                url += '&search=' + encodeURIComponent(search);
            }

            location = url;
        }
    });

    /* Ajax Cart */
    $('#cart > .heading a').live('click', function() {
        $('#cart').addClass('active');

        $('#cart').load('index.php?route=module/cart #cart > *');

        $('#cart').live('mouseleave', function() {
            $(this).removeClass('active');
        });
    });

    /* Mega Menu */
    $('#menu ul > li > a + div').each(function(index, element) {
        // IE6 & IE7 Fixes
        if ($.browser.msie && ($.browser.version == 7 || $.browser.version == 6)) {
            var category = $(element).find('a');
            var columns = $(element).find('ul').length;

            $(element).css('width', (columns * 143) + 'px');
            $(element).find('ul').css('float', 'left');
        }        

        var menu = $('#menu').offset();
        var dropdown = $(this).parent().offset();

        i = (dropdown.left + $(this).outerWidth()) - (menu.left + $('#menu').outerWidth());

        if (i > 0) {
            $(this).css('margin-left', '-' + (i + 5) + 'px');
        }
    });

    // IE6 & IE7 Fixes
    if ($.browser.msie) {
        if ($.browser.version <= 6) {
            $('#column-left + #column-right + #content, #column-left + #content').css('margin-left', '195px');

            $('#column-right + #content').css('margin-right', '195px');

            $('.box-category ul li a.active + ul').css('display', 'block');    
        }

        if ($.browser.version <= 7) {
            $('#menu > ul > li').bind('mouseover', function() {
                $(this).addClass('active');
            });

            $('#menu > ul > li').bind('mouseout', function() {
                $(this).removeClass('active');
            });    
        }
    }

    $('.success img, .warning img, .attention img, .information img').live('click', function() {
        $(this).parent().fadeOut('slow', function() {
            $(this).remove();
        });
    });    
    $('#backcall').bind('click', function() {


        bcvalidph=false;    
        bcvalidfio=false;    
        $('#bphone').css('border','none');
        $('#fio').css('border','none');
        var bphone = $('#bphone').val();
        if(bphone=='') {
            $('#bphone').focus();
            $('#bphone').css('border','1px solid red')

        }
        else {   
            bcvalidph=true;  
        } 
        var fio = $('#fio').val();
        if(fio=='') {
            $('#fio').focus();
            $('#fio').css('border','1px solid red')
        } 
        else  {   
            bcvalidfio=true;   
        }

        if(bcvalidph && bcvalidfio ){
            $.ajax({
                url: 'index.php?route=information/backcall',
                type: 'post',
                data: $('#backcallform input[type=\'text\']'), 
                dataType: 'html',
                success: function(html) {
                    $('#OrderCallModal .backcallsucces').hide();
                    $('#OrderCallModal .backcallfin').html(html);
                    $('#OrderCallModal .backcallfin').show();
                }
            });
        }
        return false;
    });        







    $('#askquest').bind('click', function() {


        faname=false;    
        famail=false;    
        famess=false;
        $('#faname').css('border','none');
        $('#famail').css('border','none');
        $('#famess').css('border','none');

        var famess = $('#famess').val();
        if(famess=='') {
            $('#famess').focus();
            $('#famess').css('border','1px solid red')
        } 
        else  {   
            famess=true;   
        }

        var famail = $('#famail').val();
        if(famail=='') {
            $('#famail').focus();
            $('#famail').css('border','1px solid red')
        } 
        else  {   famail=true;   }



        var faname = $('#faname').val();
        if(faname=='') {
            $('#faname').focus();
            $('#faname').css('border','1px solid red')

        }
        else {    faname=true;  } 



        if(faname && famail && famess  ){
            $.ajax({
                url: 'index.php?route=information/backcall',
                type: 'post',
                data: $('#AskQuestionModal input[type=\'text\']'), 
                dataType: 'html',
                success: function(html) {
                    $('#AskQuestionModal #faqsuccess').html(html);
                }
            });
        }
        return false;
    });    























});




function getURLVar(key) {
    var value = [];

    var query = String(document.location).split('?');

    if (query[1]) {
        var part = query[1].split('&');

        for (i = 0; i < part.length; i++) {
            var data = part[i].split('=');

            if (data[0] && data[1]) {
                value[data[0]] = data[1];
            }
        }

        if (value[key]) {
            return value[key];
        } else {
            return '';
        }
    }
} 

function addToCart(product_id, quantity,ofs) {
    quantity = typeof(quantity) != 'undefined' ? quantity : 1;

    $.ajax({
        url: 'index.php?route=checkout/cart/add',
        type: 'post',
        data: 'product_id=' + product_id + '&quantity=' + quantity,
        dataType: 'json',
        success: function(json) {
            $('.success, .warning, .attention, .information, .error').remove();

            if (json['redirect']) {
                location = json['redirect'];
            }

            if (json['success']) {
                $('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');

                $('.success').fadeIn('slow');
                $('#cart-total').html(json['total']);

                $('html, body').animate({ scrollTop: 0 }, 'slow'); 
            }    
        }
    });
}
function addToWishList(product_id) {
    $.ajax({
        url: 'index.php?route=account/wishlist/add',
        type: 'post',
        data: 'product_id=' + product_id,
        dataType: 'json',
        success: function(json) {
            $('.success, .warning, .attention, .information').remove();

            if (json['success']) {
                $('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');

                $('.success').fadeIn('slow');

                $('#wishlist-total').html(json['total']);

                $('html, body').animate({ scrollTop: 0 }, 'slow');
            }    
        }
    });
}

function addToCompare(product_id, btn) {
 

    $.ajax({
        url: 'index.php?route=product/compare/add',
        type: 'post',
        data: 'product_id=' + product_id,
        dataType: 'json',
        success: function(json) {
            $('.success, .warning, .attention, .information').remove();

            if (json['success']) {
                $('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');

                $('.success').fadeIn('slow');

                $('#compareq').html(json['total']);

                btn.html('Добавлено к сравнению');
                $('html, body').animate({ scrollTop: 0 }, 'slow'); 
            }    
        }
    });
}




function head_login() {
    jQuery.ajax({
        url: 'index.php?route=checkout/simplecheckout_customer/login',
        data: jQuery('#h_login input'),
        type: 'POST',
        dataType: 'text',
        success: function(data) {
            jQuery('#h_login').html(data);
        }
    });
}




