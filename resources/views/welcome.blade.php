<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script>
            window.Laravel = { csrfToken: '{{ csrf_token() }}' }
        </script>
        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.1/css/bulma.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Yellowtail" rel="stylesheet">

    </head>
    <style>
        @import url('https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');

        .button.is-primary {
            background-color: #62ad65 !important;
            border-color: #62ad65 !important;
        }

        a {
            color: inherit;
            text-decoration: none
        }

        a:hover {
            color: inherit;
        }

        .fade-enter-active, .fade-leave-active {
        transition-property: opacity;
        transition-duration: .25s;
        }

        .fade-enter-active {
        transition-delay: .25s;
        }

        .fade-enter, .fade-leave-active {
        opacity: 0
        }
        nav .buttons a {
            margin-right: 1rem
        }

        .logo {
            font-family: 'Yellowtail', cursive;
            font-size: 3em;
        }
    </style>
    <body>
        <div id="app">
        </div>
        <script src="../js/app.js"></script>
        <script>
              let last_drop_open = undefined;
        document.addEventListener('click', function (el) {
            let target = el.target;
            // console.log(target.closest('input'));
            if (target.closest('input')){
                return;
            }
            if (target.closest('.dropdown-trigger')) {
                last_drop_open = target.closest('.dropdown');
                last_drop_open.classList.toggle('is-active');
            } else if (last_drop_open) {
                last_drop_open.classList.remove('is-active');
            }
        })
        </script>
    </body>
</html>
