<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <title>Document</title>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h4 class="font-weight-bold text-success">{{ $meetingDetails['title'] }}</h4>
                <p>{{ $meetingDetails['body'] }}</p>

            </div>
        </div>
    </div>
</body>

</html>
