var appObj = {}

appObj.init = function() {
    /* Placeholder */
    $('input[placeholder], textarea[placeholder]').placeholder();

    /* Title line */
    $('.blockMainTitle').each(function() {
        var widthTitle = $(this).find('h2').width();
        $(this).find('.line').css('margin-left', widthTitle + 5 + 'px');
    });

    $('body').on('click', 'a[data-reveal-id]', function(e) {
        e.preventDefault();
        e.stopPropagation();
        //$('.close-reveal-modal').trigger('click');
        var modalLocation = $(this).attr('data-reveal-id');
        $('#'+modalLocation).reveal($(this).data());
        return false;
    });

    /* Accordion */
    $( ".accordion" ).accordion({
        collapsible: true,
        heightStyle: "content",
        icons: {
            header: "ui-icon-circle-arrow-e",
            activeHeader: "ui-icon-circle-arrow-s"
        }
    });
    $('body').on('click', '.accordionTitle', function() {
        $(this).toggleClass('closed').next('.accordionText').slideToggle();
    });

    /*Sidebar Catalog Menu*/
    $('body').on('click', '.itemCatalogTitle', function (){
        var _this = $(this);
        _this.next('.listSubCatalog').slideToggle(function() {
            if (_this.hasClass('active')) {
                _this.removeClass('active');
            } else {
                _this.addClass('active');
            }
        });
    });

    /*Order list*/
    $('body').on('click', '.ordersItemTitle', function (){
        var _this = $(this);
        _this.next('.ordersItemOptions').slideToggle(function() {
            if (_this.hasClass('active')) {
                _this.removeClass('active');
            } else {
                _this.addClass('active');
            }
        });
    });

    /*Select*/
    $('select').customStyle1();

    /*Slider*/
    $("#productPhotos").carouFredSel({
        direction: 'up',
        circular: true,
        items: {
            visible: 3,
            minimum: 3
        },
        scroll: {
            items: 1
        },
        auto: {
            delay: 10000,
            timeoutDuration: 5000
        },
        prev: {
            button: '.prevButton'
        },
        next: {
            button: '.nextButton'
        }
    });
    $("#productPhotosPopup").carouFredSel({
        direction: 'left',
        circular: true,
        items: {
            visible: 5,
            minimum: 5
        },
        scroll: {
            items: 1
        },
        prev: {
            button: '.prevButtonPopup'
        },
        next: {
            button: '.nextButtonPopup'
        },
        auto: {
            play: false
        }
    });

    /*Fancybox*/
    $('.fb').fancybox({
        'padding' : 10
    });

    /*SlideRunner*/
    $('.slideRunner').slideRunner();

}

appObj.selectSlider = function() {
    $('.productPhotosWrap').on('click', '.itemLink', function(event) {
        event.preventDefault();
        var srcMidImage = $(this).data('midimg');
        var srcBigImage = $(this).data('bigimg');
        var idBlockPhoto = $(this).closest('.productPhotosWrap').data('id');
        $(idBlockPhoto).attr('href', srcBigImage);
        $(idBlockPhoto).find('img').attr('src', srcMidImage);
    });
    $('body').on('click', '#blockBigPhoto', function(event) {
        event.preventDefault();
        var $self = $(this);
        var urlPic = $self.attr('href');
        $('#blockBigPhotoPopup').find('img').attr('src', urlPic);
    });
}

appObj.filter = function() {
    var minCost = 50000;
    var maxCost = 90000;
    $( "#sliderRange").slider({
        range: true,
        min: minCost,
        max: maxCost,
        values: [ minCost+10000, maxCost-10000 ],
        slide: function( event, ui ) {
            $('.amountMin').val(ui.values[ 0 ]);
            $('.amountMax').val( ui.values[ 1 ]);
        }
    });
    $('.amountMin').val($('#sliderRange').slider('values', 0 ));
    $('.amountMax').val( $('#sliderRange').slider('values', 1 ));
   //$('.valueMin').text(minCost);
   // $('.valueMax').text(maxCost);
}

appObj.switchTabs = function() {
    $('.compareTabs').on('click', '.compareTab', function() {
        var _this = $(this);
        var indx = _this.index();
        if (!_this.hasClass('active')) {
            _this.addClass('active').siblings().removeClass('active');
            $('.compareGroups').find('.listProducts').hide().eq(indx).show();
        }
    });
}

$(function($) {
    appObj.init();

    appObj.selectSlider();
    appObj.filter();
    appObj.switchTabs();

});