<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;700;800&display=swap" rel="stylesheet">
    <style>
        body{
            padding: 0px;
            margin: auto;
            font-family: 'Tajawal Medium', sans-serif;
            color: #74787E;
        }
        table{
            width: 100%;
        }
        .text-center{
            text-align: center;
        }
        .heading-1{
            font-size: 32px;
        }
        .btn{
            padding:15px 25px;
            margin: 10px 0;
            text-decoration: none;
            color: white;
            text-transform: uppercase;
            font-weight: bold;
        }
        .btn-primary{
            background-color: #0099FF;
        }
    </style>
</head>
<body>
<!-- body -->
<div style="background-color: #F3F5F9">
    <table>
        <tbody>
        <!-- /// -->
        <tr>
            <td>
                <div>
                    <!-- header -->
                    <table>
                        <tbody>
                        <tr>
                            <td>
                                <div class=" text-center" style="padding: 2em 0 1em 0">
                                    <img src="{{$domainLogoPath}}" style="height: 60px" alt="">
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <!-- header end-->
                </div>
            </td>
        </tr>
        <!-- /// -->
        <tr>
            <td>
                <div>
                    <!-- content -->
                    <table>
                        <tbody>
                        <tr>
                            <td>
                                <div style="padding: 0 2em">
                                    <div style="background-color: white; padding: 2em">
                                        <div style="text-align: center">
                                            <img src="{{$headerImage}}" width="200">
                                        </div>
                                        <p style="text-align: center; font-size: 32px; font-family: 'Tajawal Extra-bold', sans-serif;">Account Activation</p>
                                        <p>Dear <strong>{{$receiverData['receiver_name']}}</strong></p>
                                        <p>
                                            Thank you for joining {{$domain}}. <br>
                                            Only one more step to complete your registration, please click on the link below to complete your registration.
                                        </p>
                                        <br>
                                        <div style="text-align: center">
                                            <a href="{{$validationLink}}" class="btn btn-primary" >Verify my email</a>
                                        </div>
                                        <br>
                                        <br>
                                        <p>
                                            Regards <br>
                                            {{$domain}} team
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <!-- content end-->
                </div>
            </td>
        </tr>
        <!-- /// -->
        <tr>
            <td>
                <div>
                    <!-- footer -->
                    <table>
                        <tbody>
                        <tr>
                            <td>
                                <div class=" text-center" style="padding: 2em 0">
                                    2020 {{$domain}}. All rights reserved.
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <!-- footer end-->
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</div>
<!--end body -->
</body>
</html>