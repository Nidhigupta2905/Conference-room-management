<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
</head>
<style>
    .main {
        display: flex;
        align-items: center;
        height: 100vh;
    }

    .container {
        /* background-color: aquamarine; */
    }

    img {
        width: 100vmax;
    }

</style>

<body style="background-color: #F0F3F8">
    <div class="main">
        <div class="container">
            <div class="row">
                <div class="
              col-md-5
              offset-md-1
              mt-md-5
              col-sm-5
              offset-sm-1
              mt-sm-1
              col-12
            ">
                    <p for="" class="font-weight-bold" style="text-align: center; font-size: 20px">CR MANAGEMENT SYSTEM
                    </p>

                    <a href="{{ route('auth.google.login') }}" class="btn btn-success btn-block">EMPLOYEE
                        LOGIN</a><br />
                </div>
                <div class="col-md-1 col-sm-1 col-xs-1"></div>
                <div class="col-md-5 col-sm-5 col-12">
                    <img src="{{ asset('admin/dist/images/doonoffice_3.png') }}" alt="" class="img-fluid d-block"
                        style="margin-right: 0px" />
                </div>
            </div>
        </div>
    </div>
</body>

</html>
