<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Report by Program</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>User Report by Program</h1>
    <table>
        <thead>
            <tr>
                <th>Program</th>
                <th>Total Users</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usersByProgram as $program)
                <tr>
                    <td>{{ $program->Program ?? 'Not Assigned' }}</td>
                    <td>{{ $program->total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
