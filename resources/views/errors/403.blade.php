<!DOCTYPE html>
<html lang="pt" dir="ltr">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <!-- Título -->
    <title>Desculpe, esta página não pode ser acedida</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"
        integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous" />
    <style>
        #footer {
            text-align: center;
            position: fixed;
            margin-left: 530px;
            bottom: 0px
        }
    </style>
</head>

<body class="bg-dark text-white py-5">
    <div class="container py-5">
        <div class="row">
            <div class="col-md-2 text-center">
                <p><i class="fa fa-exclamation-triangle fa-5x"></i><br />Error: 403</p>
            </div>
            <div class="col-md-10">
                <h3>Ups!!!! Desculpe...</h3>
                <p>Lamentamos, mas o seu acesso foi recusado por motivos de segurança. Fale com o adiministrador<br />
                Por favor, volte à página anterior para continuar a navegar.</p>
                <a class="btn btn-danger" href="{{ route('login') }}">Voltar atrás</a>
            </div>
        </div>
    </div>

    <div id="footer" class="text-center">
        Direitos {{ date('Y') }},
    </div>
</body>

</html>
