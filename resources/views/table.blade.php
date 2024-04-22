<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Table View</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container my-3">
        <table class="table table-bordered">
            <thead>
                <tr>
                    @foreach (array_keys($items[0] ?? []) as $key)
                    <th scope="col">{{ $key }}</th>
                    @endforeach
                </tr>
            </thead>

            <tbody>
                @foreach ($items as $item)
                <tr>
                    @foreach ($item as $value)
                    <td>{{ $value }}</td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
