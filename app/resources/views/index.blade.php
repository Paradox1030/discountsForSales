<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="/css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
          integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
            integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
            integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
            crossorigin="anonymous"></script>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>

<div class="container mt-4">

    <div class="row">
    <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#exampleModal">
        Добавить нового покупателя
    </button>
        <div class="col-6">
            <input type="text" name="dateSale" id="dateSale"> <button class="btn updateTable">Обновить таблицу</button>
        </div>
    </div>
    <table class="table table_sales">
        <thead>
        <tr>
            <th scope="col">№</th>
            <th scope="col">Имя</th>
            <th scope="col">Фамилия</th>
            <th scope="col">Отчество</th>
            <th scope="col">Скидка</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($buyers as $buyer)
            <tr>
                <th scope="row">{{ $buyer->id }}</th>
                <td>{{ $buyer->first_name }}</td>
                <td>{{ $buyer->second_name }}</td>
                <td>{{ $buyer->patronymic }}</td>
                <td>{{ $buyer->sale }}</td>
                <td><a href="/delete-buyer?id={{$buyer->id}}" class="badge badge-danger">Удалить</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <br>
    <br>
    <br>
    <hr>
    <br>
    <br>
    <br>

    <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#exampleModal2">
        Добавить новую продажу
    </button>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">№</th>
            <th scope="col">Покупатель</th>
            <th scope="col">Сумма продажи</th>
            <th scope="col">Дата продажи</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($sales as $sale)
            <tr>
                <th scope="row">{{ $sale->id }}</th>
                <td>{{ $sale->first_name }} {{ $sale->second_name }} {{ $sale->patronymic }}</td>
                <td>{{ $sale->sale_amount }}</td>
                <td>{{ $sale->created_at }}</td>
                <td><a href="/delete-sales?id={{ $sale->id }}" class="badge badge-danger">Удалить</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="modal" tabindex="-1" id="exampleModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Добавление нового покупателя</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="GET" action="/create-buyer">
                        @csrf
                        <div class="form-group">
                            <label for="first_name" class="col-form-label">Фамилия:</label>
                            <input type="text" class="form-control" name="first_name" id="first_name">
                        </div>

                        <div class="form-group">
                            <label for="second_name" class="col-form-label">Имя:</label>
                            <input type="text" class="form-control" name="second_name" id="second_name">
                        </div>

                        <div class="form-group">
                            <label for="patronymic" class="col-form-label">Отчество:</label>
                            <input type="text" class="form-control" name="patronymic" id="patronymic">
                        </div>

                        <button type="submit" class="btn btn-primary">Добавить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" id="exampleModal2" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Добавление новой продажи</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="GET" action="/create-sales">
                        @csrf
                        <div class="form-group">
                            <select name="buyer_id" id="buyer_id">
                                @foreach ($buyers as $buyer)
                                    <option
                                        value="{{$buyer->id}}">{{ $buyer->first_name }} {{ $buyer->second_name }} {{ $buyer->patronymic }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="date_sale" class="col-form-label">Дата продажи:</label>
                            <input type="date" class="form-control" name="date_sale" id="date_sale">
                        </div>

                        <div class="form-group">
                            <label for="sale_amount" class="col-form-label">Сумма продажи:</label>
                            <input type="text" class="form-control" name="sale_amount" id="sale_amount">
                        </div>

                        <button type="submit" class="btn btn-primary">Добавить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $( document ).ready(function() {
        $( "#dateSale" ).datepicker();

        $(".updateTable").on('click', (e) => {
            let date = $('#dateSale').val();
            $.ajax({
                url: '/getbuyers',
                data: {'date': date},
                method: 'GET',
                beforeSend: function() {
                    $('#loader').show();
                    $('body').css('overflow', 'hidden')
                },
            }).done(function (data) {
                $('#loader').hide();
              if(data.length > 0) {

                  $('.table_sales tbody').html('');
                  $('body').css('overflow', 'auto')
                  let res = JSON.parse(data);

                  res.forEach(item => {
                      let sale = item.sale != null ? item.sale : 0;
                      let tr = '<tr><td>'+item.id+'</td>'+'<td>' + item.first_name + '</td><td> '+ item.second_name + '</td> <td>' +item.patronymic + '</td>' +
                          '<td>'+sale + '</td>' +
                          '<td> <a href="/delete-buyer?id="' +  item.id +'" class="badge badge-danger">Удалить</a></td>'

                      $('.table_sales tbody').append(tr)
                  })
              }
            });
        })
    } );
</script>

<div id="loader"></div>
</body>
</html>
