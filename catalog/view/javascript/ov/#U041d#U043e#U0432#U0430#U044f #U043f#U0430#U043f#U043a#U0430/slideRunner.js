// jQuery plugin SlideRunner 1.0

(function($) {
    $.fn.slideRunner = function(options) {

        var settings = $.extend({
            control: '.slideRunnerControl',
            list: '.slideRunnerList',
            item: '.itemProduct'
        }, options);

        return this.each(function() {
            var $self = $(this);

            if (!$self.hasClass('sr-slideRunner')) $self.addClass('sr-slideRunner');

            $self.find(settings.list).each(function() {
                var $this = $(this);
                var listWidth = 0;
                var arrWidthItems = $this.find(settings.item).map(function() {
                    return $(this).width();
                }).get();
                $.each(arrWidthItems, function(key, val) {
                    listWidth += val;
                });
                $this.width(listWidth).css({position: 'relative'});
            });

            var $listItems = $self.find(settings.list);
            var listItemWidth = $listItems.width();
            var widthWrapper = $listItems.wrap('<div class="sr-slideRunnerWrapList"></div>').parent('.sr-slideRunnerWrapList').width();

            if (listItemWidth == widthWrapper) return false;

            $self.find(settings.control).append('<div class="sr-slideRunnerLine"><div class="sr-slideRunnerPoint"></div></div>');

            $self.find(settings.control).on('onselectstart', '.sr-slideRunnerPoint', function(event) {
                return false;
            });
            $self.find(settings.control).on('mousedown', '.sr-slideRunnerPoint', function(event) {
                var $this = $(this);
                var pointOffset = $this.offset();
                var pointWidth = $this.width();

                var shiftX = event.pageX - pointOffset.left;
                var shiftY = event.pageY - pointOffset.top;

                var $line = $this.closest('.sr-slideRunnerLine');
                var lineOffset = $line.offset();
                var lineWidth = $line.width();

                var fullWidth = lineWidth - pointWidth;

                var mouseup = false;

                $(document).bind('mousemove', 'body', function(event) {
                    if (mouseup) return false;

                    var newLeft = event.pageX - shiftX - lineOffset.left;
                    if (newLeft < 0) {
                        newLeft = 0;
                    }
                    if (newLeft > fullWidth) {
                        newLeft = fullWidth;
                    }
                    $this.css({left: newLeft + 'px'});
                    var newListLeft = ((listItemWidth - widthWrapper) / fullWidth) * newLeft;
                    $listItems.css({left: '-' + newListLeft + 'px'});
                });

                $(document).bind('mouseup', 'body', function(event) {
                    mouseup = true;
                });

                return false;
            });

        });

    }
})(jQuery);
