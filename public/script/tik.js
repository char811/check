$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function parse_hash()
{
    if (window.location.hash)
    {
        var matcheorders = /^\#order\_by\=(-*)(.+)/.exec(window.location.hash);
        return {direction: matcheorders[1]?1:0, field: matcheorders[2]};
    }
    return false;
}

function setCookie(name, value, options)
{
    options = options || {};

    var expires = options.expires;

    if (typeof expires == "number" && expires)
    {
        var d = new Date();
        d.setTime(d.getTime() + expires*1000);
        expires = options.expires = d;
    }
    if (expires && expires.toUTCString)
    {
        options.expires = expires.toUTCString();
    }

    value = encodeURIComponent(value);

    var updatedCookie = name + "=" + value;

    for(var propName in options)
    {
        updatedCookie += "; " + propName;
        var propValue = options[propName];
        if (propValue !== true)
        {
            updatedCookie += "=" + propValue;
        }
    }

    document.cookie = updatedCookie;
}

function getCookie(name)
{
    var matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}

$('document').ready(function(){
    if (1 === parseInt(getCookie('flash')))
    {
        //setCookie('flash', 0);
        document.cookie = 'flash' + "=" + "; expires=Thu, 01 Jan 1970 00:00:01 GMT";
        deleteOrderMsg();
    }
    if (1 === parseInt(getCookie('dash')))
    {
       // setCookie('dash', 0);
        document.cookie = 'dash' + "=" + "; expires=Thu, 01 Jan 1970 00:00:01 GMT";
        function deleteManagerMsg(){
            $.growl.notice({message: "Менеджер удален !" });
        }
    }
    if (1 === parseInt(getCookie('managerDelete'))) {
        //setCookie('managerDelete', 0);
        document.cookie = 'managerDelete' + "=" + "; expires=Thu, 01 Jan 1970 00:00:01 GMT";
        deleteManagerMsg();
    }


    $('#modal').modal();
    $(".popconfirm").popConfirm({
            title: "Удалить ?",
            content: "Я предупреждаю тебя !",
            placement: "left", // (top, right, bottom, left)
            yesBtn:   'Да',
            noBtn:    'Нет'
    });
    $(".shadow").popConfirm({
        title: "Тень ?",
        content: "Я предупреждаю тебя !",
        placement: "left", // (top, right, bottom, left)
        yesBtn:   'Да',
        noBtn:    'Нет'
    });
    /*
    delete client button
     */
    $('.ajaxForm').on('submit', function(e)
    {
   return function(e){
        e.preventDefault();
        var url = $(this).attr('action');
        $.ajax({
            url:url,
            success:function()
            {
                setCookie('dash',1);
                window.location.reload();
            }
        });
return false;
}
    });


    function deleteClientMsg()
    {
    $.growl.notice({message: "Клиент удален, как и все его заказы!" });
    }
    
    /*
     delete manager button
     */
    $('.managerDelete').on('submit', function(e)
    {
      return function(e){
        e.preventDefault();
        var url = $(this).attr('action');
        $.ajax({
            url:url,
            success:function()
            {
                setCookie('managerDelete',1);
                window.location.reload();
            }
        });
        return false;
       }
    });

    /*
    Ajax search request clients and orders on email  uses function autocomplete
     */
    if ($.fn.autocomplete && $('#email').length)
    {
        $('#email').autocomplete({
            source: window.location.origin+"/search",
            focus: function( event, ui ) {
                $( "#email" ).val( ui.item.value );
                return false;
            },
            select: function( event, ui ) {
                $( "#email" ).val( ui.item.value );
                $('#email').parents('form').submit();
                return false;
            }
        })
            .data( "autocomplete" )._renderItem = function( ul, item ) {
            return $( "<li>" )
                .append( "<a>" + item.label + "</a>" )
                .appendTo( ul );
        };
    }

    if ($.fn.autocomplete && $('#emailManager').length)
    {
        $('#emailManager').autocomplete({
            source: window.location.origin+"/searchManager",
            focus: function( event, ui ) {
                $( "#emailManager" ).val( ui.item.value );
                return false;
            },
            select: function( event, ui ) {
                $( "#emailManager" ).val( ui.item.value );
                $('#emailManager').parents('form').submit();
                return false;
            }
        })
            .data( "autocomplete" )._renderItem = function( ul, item ) {
            return $( "<li>" )
                .append( "<a>" + item.label + "</a>" )
                .appendTo( ul );
        };
    }



    if ($('.orderTable').length)
    {
        $("#example").tablesorter({
            headers: { 3: { sorter: 'digit'}, 5: { sorter: false} },
            usNumberFormat: true,
            numberSorter: function (a, b, direction) {
                // console.log(a, b);
                if (a >= 0 && b >= 0)
                {
                    return direction ? a - b : b - a;
                }
                if (a >= 0)
                {
                    return -1;
                }
                if (b >= 0)
                {
                    return 1;
                }
                return direction ? b - a : a - b;
            }
        });

        var headers = [
            'email',
            'service',
            'process',
            'price',
            'created_at'
        ];
    }

    if ($('.clientTable').length)
    {
        $("#example").tablesorter({
            headers: { 6: { sorter: false} }
        });

        var headers = [
            'username',
            'first_name',
            'last_name',
            'email',
            'mobile',
            'created_at'
        ];
    }

    if ($('.managerTable').length)
    {
        $("#example").tablesorter({
            headers: { 3: { sorter: false} }
        });

        var headers = [
            'username',
            'email',
            'city'
        ];
    }


    /*
     page navigation after tablesorter function
     */
    if ($.fn.tablesorterPager)
    {
        $("#example").tablesorterPager({container: $("#pager")});
    }


    (function () {
        var parsed_sort_data = parse_hash();
        if (parsed_sort_data.field)
        {
            var field = headers.indexOf(parsed_sort_data.field);
            var sorting = [
                [field, parsed_sort_data.direction]
            ];
            // сортируем по первой колонке
            $("#example").trigger("sorton", [sorting]);
            setTimeout(function ()
            {
                $("#example").find('.sortable.tablesorter-headerAsc, .sortable.tablesorter-headerDesc').trigger('click');
            }, 300);
        }
    })();


    $("#example").find('.sortable').on('click', function (e) {
        setTimeout((function (self) {
            return function (e) {
                var column = $(self);
                var direction = column.hasClass('tablesorter-headerAsc') ? '' : '-';
                var arrow_class = column.hasClass('tablesorter-headerAsc') ? 'glyphicon-arrow-up' : 'glyphicon-arrow-down';
                $('.sortable').find('i').removeClass('glyphicon-arrow-up');
                $('.sortable').find('i').removeClass('glyphicon-arrow-down');
                if (arrow_class == 'glyphicon-arrow-up') {
                    column.find('i').removeClass('glyphicon-arrow-down');
                } else {
                    column.find('i').removeClass('glyphicon-arrow-up');
                }
                window.location.hash = '#order_by=' + direction + headers[column.data('column')];
                column.find('i').addClass(arrow_class);
            }
        })(this), 50);
    });
});


/*
modal window in tablesorter
 */
function closeModal(modal_id) {
    $('#basicModal' + modal_id).modal('hide');
    return false;
}


/*
delete order button
 */
function confirma (id) {
    var c = $('.confirm');
    c.show();
    $('.no').click(function () {
        $('.confirm').hide();
        return false;
    });
    $('.yes').on('click', (function (id) {
        return function(e){
            e.preventDefault();
            var form = $('.confirm form');
            form.find('[name="id"]').val(id);
            $.get(form.attr('action') + '?' + 'id=' + id, function(){
               setCookie('flash', 1);
               window.location.reload();
            });
            $('.confirm').hide();
           return false;
        }
    })(id));
    return false;

}

function deleteOrderMsg(){
    $.growl.notice({message: "Заказ успешно удален !" });
}

$(document).mouseup(function (e) {
    var container = $("#non");
    if (container.has(e.target).length === 0){
        container.hide();
    }
});

