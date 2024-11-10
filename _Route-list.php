<?php

#Отображение списка маршрутов на странице проекта в браузере по адресу /routes

#В файл app/Providers/RouteServiceProvider.php добавляем код в метод:
public function mapWebRoutes()
{
    Route::middleware('web')
        ->namespace($this->namespace)
        ->group(base_path('routes/web.php'));

    #Начало добавляемого кода
    if ($this->app->environment('local')) {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(function () {
                Route::get('/routes', function () {
                    $routes = collect(\Route::getRoutes())->map(function ($route) {
                        return [
                            'method' => implode('|', $route->methods()),
                            'uri' => $route->uri(),
                            'name' => $route->getName(),
                            'action' => ltrim($route->getActionName(), '\\'),
                        ];
                    })->all();

                    return view('routes', ['routes' => $routes]);
                });
            });
    }
    #Конец добавляемого кода
}

#Создаем представление routes.blade.php в папке resources/views
<html>
<head>
    <title>List of Routes</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>List of Routes</h1>

    <table>
        <thead>
            <tr>
                <th>Method</th>
                <th>URI</th>
                <th>Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($routes as $route)
                <tr>
                    <td>{{ $route['method'] }}</td>
                    <td>{{ $route['uri'] }}</td>
                    <td>{{ $route['name'] }}</td>
                    <td>{{ $route['action'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

