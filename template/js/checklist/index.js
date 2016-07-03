function getNewString( info )
{
    return  '<div class="row padbot10">'+
                '<div class="col-md-12">'+
                    '<div class="input-group" data-id="' + info['id'] + '">'+
                        '<span class="input-group-btn">'+
                            '<button type="button" class="btn btn-default btn-number checklist-remove">'+
                                '<span class="glyphicon glyphicon-minus"></span>'+
                            '</button>'+
                        '</span>'+
                        '<input class="form-control input-number checklist-input-change" placeholder="Начните писать" value="' + info['string'] + '">'+
                    '</div>'+
                '</div>'+
            '</div>';
}

var onRemoveFunction = function()
{
    var elem = $(this),
        id   = elem.closest('.input-group').data('id');

    // INSERT INTO DB
    $.ajax(
        {
            'dataType'  : 'json',
            'method'    : 'post',
            'data'      : {
                'id'    : id
            },
            'timeout'   : 60000,
            'url'       : '/ajax/remove',
            'success'   : function( data )
            {
                if ( data['result'] )
                {
                    // UPDATE HTML
                    elem.closest('.row.padbot10').remove();
                }

                checkForEmptiness();
            },
            'error'     : function( jqXHR  )
            {
                alert('Не удалось');
            }
        }
    );
};

function checkForEmptiness()
{
    if ( $('#checklist-container').children().length == 0 )
    {
        $('#checklist-container').append(
            '<div class="row" id="message-empty">' +
                '<div class="col-md-12">Ничего нет...</div>' +
            '</div>'
        );
    }
}

$(document).ready(
    function()
    {
        setInterval(function()
        {
            // INSERT INTO DB
            $.ajax(
                {
                    'dataType'  : 'json',
                    'method'    : 'post',
                    'data'      : {},
                    'timeout'   : 60000,
                    'url'       : '/ajax/check',
                    'success'   : function( result )
                    {
                        var focused_elem    = $(document.activeElement),
                            id              = false;

                        // whether focused elem is input
                        if ( focused_elem.is('input.checklist-input-change') )
                        {
                            id = $(focused_elem).closest('.input-group').data('id');

                            $(focused_elem).blur();
                        }

                        var data = result['result'];
                        var tmp = '';

                        for( var i = 0, n = data.length; i < n; ++i )
                        {
                            var elem = data[i];

                            // if some input is not focused just update
                            if ( !id )
                            {
                                tmp += getNewString( elem );
                            }
                            else
                            {
                                if ( elem['id'] == id )
                                {
                                    // message on current machine is more preferable than on others
                                    elem['string'] = $(focused_elem).val();
                                }

                                tmp += getNewString( elem );
                            }
                        }

                        $('#checklist-container').html( tmp );

                        // need to return focus
                        if ( id )
                        {
                            var input = $('#checklist-container').find('.input-group[data-id="' + id + '"]').first().find('.checklist-input-change').first(),
                                tmp_string = input.val();
                            input.focus();
                            input.val('');
                            input.val(tmp_string);
                        }

                        $('#checklist-container').find('.checklist-remove').each(function()
                        {
                            $(this).bind(
                                'click',
                                onRemoveFunction
                            );
                        });

                        checkForEmptiness();
                    },
                    'error'     : function( jqXHR  )
                    {
                        alert('Не удалось');
                    }
                }
            );
        }, 3000); // 1 second

        // add new string
        $('#checklist-add').on(
            'click',
            function()
            {
                // INSERT INTO DB
                $.ajax(
                    {
                        'dataType'  : 'json',
                        'method'    : 'post',
                        'data'      : {},
                        'timeout'   : 60000,
                        'url'       : '/ajax/add',
                        'success'   : function( data )
                        {
                            $('#message-empty').remove();

                            // UPDATE HTML
                            $('#checklist-container').append( getNewString(data) );

                            $('#checklist-container').find('.input-group[data-id="' + data['id'] + '"]').first().find('.checklist-remove').bind(
                                'click',
                                onRemoveFunction
                            );
                        },
                        'error'     : function( jqXHR  )
                        {
                            alert('Не удалось');
                        }
                    }
                );
            }
        );

        // remove string
        $('.checklist-remove').on(
            'click',
            onRemoveFunction
        );

        // update string state on focus out
        $('.checklist-input-change').on(
            'blur',
            function()
            {
                var id      = $(this).closest('.input-group').data('id'),
                    string  = $(this).val();

                // UPDATE DB
                $.ajax(
                    {
                        'dataType'  : 'json',
                        'method'    : 'post',
                        'data'      : {
                            'id'    : id,
                            'string': string
                        },
                        'timeout'   : 60000,
                        'url'       : '/ajax/change',
                        'success'   : function( data )
                        {
                            //TODO
                        },
                        'error'     : function( jqXHR  )
                        {
                            alert('Не удалось');
                        }
                    }
                );
            }
        );
    }
);