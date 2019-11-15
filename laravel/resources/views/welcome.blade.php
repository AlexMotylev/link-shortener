<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
<div class="flex-center position-ref full-height">

    <div class="content">
        <div class="title m-b-md">
            Сократитель ссылок
        </div>
        <div class="content">
            <form id="linkForm" method="post" action="/api/link">
                Полная ссылка:
                <input type="text" name="url">
                <button type="submit">Сократить</button>
                <div class="errors"></div>
                <br>
                Короткая ссылка:
                <input type="text" name="short_url">

            </form>
        </div>

    </div>
</div>
<script>
    window.linkForm.addEventListener('submit', event => {
        event.preventDefault();
        fetch('/api/link', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json;charset=utf-8'
            },
            body: JSON.stringify({url: event.target.url.value})
        })
            .then(response => response.json())
            .then(response => {
                if(response.short_url){
                    event.target.short_url.value=response.short_url;
                    event.target.querySelector('.errors').innerHTML ='';
                }else{
                    event.target.querySelector('.errors').innerHTML = JSON.stringify(response);
                }
            });
    });
</script>
</body>
</html>
