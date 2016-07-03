function getNewString( info )
{
    return  '<div class="row padbot10">'+
                '<div class="col-md-12">'+
                    '<div class="input-group">'+
                        '<span class="input-group-btn">'+
                            '<button type="button" class="btn btn-default btn-number checklist-remove" data-id="' + info['id'] + '">'+
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
        id   = elem.data('id');

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

                if ( $('#checklist-container').children().length == 0 )
                {
                    $('#checklist-container').append(
                        '<div class="row" id="message-empty">' +
                            '<div class="col-md-12">Ничего нет...</div>' +
                        '</div>'
                    );
                }
            },
            'error'     : function( jqXHR  )
            {
                alert('Не удалось');
            }
        }
    );
};

$(document).ready(
    function()
    {
        setInterval(function()
        {
            console.log('update');
        }, 1000); // 1 second

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

                            $('#checklist-container').find('.checklist-remove[data-id="' + data['id'] + '"]').bind(
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

        // update string state
        $('.checklist-input-change').on(
            'keyup',
            function()
            {
                console.log('change');
            }
        );
    }
);