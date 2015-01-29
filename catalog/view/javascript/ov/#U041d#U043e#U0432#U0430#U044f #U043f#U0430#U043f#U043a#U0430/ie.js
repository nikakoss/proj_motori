$(function() {
    $('input[type="radio"] + .labelRadio').on('click', function() {
        $(this).siblings('input[type="radio"]').attr('checked', 'checked');
    });
    $('input[type="checkbox"] + .labelCheckbox').on('click', function() {
        if ($(this).prev('input[type="checkbox"]').attr('checked') !== 'checked') {
            $(this).prev('input[type="checkbox"]').attr('checked', 'checked');
        } else {
            $(this).prev('input[type="checkbox"]').removeAttr('checked');
        }
    });

    $('.table .tableItem:nth-child(2n)').css({'background' : '#f3f3f3'});
    $('.table .tableItem:nth-child(2n+1)').css({'background' : '#fff'});

    $('.tableProduct .tableItem:nth-child(2n)').css({'background' : '#f8f8f8'});
    $('.tableProduct .tableItem:nth-child(2n+1)').css({'background' : '#f3f3f3'});
});