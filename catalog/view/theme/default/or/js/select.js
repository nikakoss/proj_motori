(function($){
 $.fn.extend({

 	customStyle1 : function(options) {
	  if(!$.browser.msie || ($.browser.msie&&$.browser.version>6)){
          return this.each(function() {

                var currentSelected = $(this).find(':selected');
                $(this).after('<span class="selectSpan"><span class="customStyleSelectBoxInner">'+currentSelected.text()+'</span></span>').css({position:'absolute', opacity:0,fontSize:$(this).next().css('font-size')});
                var selectBoxSpan = $(this).next();
                var selectBoxSpanInner = selectBoxSpan.find(':first-child');
                selectBoxSpan.css({display:'inline-block'});
                var selectBoxWidth = parseInt(selectBoxSpan.width());
                selectBoxSpanInner.css({width:selectBoxWidth, display:'inline-block', overflow:'hidden'});
                var selectBoxHeight = parseInt(selectBoxSpan.height()) + parseInt(selectBoxSpan.css('padding-top')) + parseInt(selectBoxSpan.css('padding-bottom'));
                $(this).height(selectBoxHeight).change(function(){
                    selectBoxSpanInner.text($('option:selected',this).text()).parent().addClass('changed');
                });

          });
	  }
	}
 });
})(jQuery);