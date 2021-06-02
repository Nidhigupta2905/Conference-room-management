<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <title>Document</title>

    <style>
        
        #header{
            padding-top: 10px !important;
            padding-bottom: 10px !important;
            background: gray !important;
            text-align: center !important;
            color: white;
        }

        #title, #para, #footer{
            padding-top: 10px !important;
            padding-bottom: 10px !important;
            text-align: center !important;
            margin-top: 20px;
        }

        
    </style>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-6 p-5" id="col">

                <h1 class="text-center text-success" id="header">{{ $meetingDetails['header'] }}</h3>
                <h3 class="font-weight-bold text-success text-center" id="title">{{ $meetingDetails['title'] }}</h3>
                <p class="" id="para">{{ $meetingDetails['body'] }}</p>
                <p class="" id="footer">{{ $meetingDetails['footer'] }}</p>

            </div>
        </div>
    </div>
</body>

</html>
