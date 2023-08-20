<!DOCTYPE html>
<html>

<head>
    <title>Lista de Personas</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            font-size: 12px;
            
        }
    </style>
</head>

<body>
    <h1 style="width: 100%;">Lista de Personas</h1>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Telefono</th>
                <th>DNI</th>
                <th>Identificación</th>
                <th>Email</th>
                <th>Cargo</th>
                <th>Alta</th>
                <th>Pais</th>
                <th>Baja</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($personas as $persona)
                <tr
                    @if ($persona->activo==1)
                        style="background-color:#E6B0AA"
                    @endif                
                >
                    <td>{{ $persona->name }}</td>
                    <td>{{ $persona->surname }}</td>
                    <td>{{ $persona->phone }}</td>
                    <td>{{ $persona->dni }}</td>
                    <td>{{ $persona->identification }}</td>
                    <td>{{ $persona->email }}</td>
                    <td>{{ $persona->rol }}</td>
                    <td>{{ $persona->created_at }}</td>
                    <td>{{ $persona->country }}</td>
                    <td>{{ $persona->activo }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
