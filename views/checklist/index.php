<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="keywords" content=""/>
    <meta name="description" content=""/>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>Редактируемый список</title>
    <link href='http://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
    <!-- Bootstrap -->
    <link href="/template/css/bootstrap.min.css" rel="stylesheet">
    <link href="/template/css/checklist/index.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="/template/js/jquery-1.11.3.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/template/js/bootstrap.min.js"></script>
    <script src="/template/js/checklist/index.js"></script>
</head>
<body>
<div class="container">
    <div class="row text-center">
        <div class="col-md-12">
            <h1>Редактируемый список</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-1">
            <button type="button" class="btn btn-success" id="checklist-add">
                <span class="glyphicon glyphicon-plus"></span> Добавить новую строку
            </button>
        </div>
    </div>
    <hr>
    <div id="checklist-container">
    <?php
        $tmp = '';

        if ( count( $checklist ) === 0 )
        {
            $tmp =
                '<div class="row" id="message-empty">' .
                    '<div class="col-md-12">Ничего нет...</div>' .
                '</div>';
        }
        else
        {
            foreach ($checklist as $item)
            {
                $tmp .=
                    '<div class="row padbot10">'.
                        '<div class="col-md-12">'.
                            '<div class="input-group">'.
                                '<span class="input-group-btn">'.
                                    '<button type="button" class="btn btn-default btn-number checklist-remove" data-id="' . $item['id'] . '">'.
                                        '<span class="glyphicon glyphicon-minus"></span>'.
                                    '</button>'.
                                '</span>'.
                                '<input class="form-control input-number checklist-input-change" placeholder="Начните писать" value="' . $item['string'] . '">'.
                            '</div>'.
                        '</div>'.
                    '</div>';
            }
        }

        echo( $tmp );
    ?>
    </div>
</div>
</body>
</html>
