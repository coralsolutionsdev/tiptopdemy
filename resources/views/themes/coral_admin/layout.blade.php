<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        :root{
            --theme-primary-color: {{getAdminColor()}};
        }
    </style>
    <!-- THEME CSS -->
    <link rel="stylesheet" href="{{url('themes/coral_admin/css/general.css')}}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">
    <!-- scripts -->
    <script src="https://kit.fontawesome.com/2f85794b10.js" crossorigin="anonymous"></script>
    <script src="{{ asset('/js/jquery-3.3.1.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script><!-- Uikit javascript-->
    <script src="https://cdn.tiny.cloud/1/0disoxw0ri417kacpbbaufwzt6temhwubr87eejae2tyvpjy/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="{{ asset('js/lightbox.js') }}"></script>
    <script src="{{ asset('js/parallax.js') }}"></script>
    <title>{{getSite()->name}} | @yield('title')</title>
    @yield('head')

</head>
<body>
<div id="admin_panel" class="display-table">
    <div class="display-table-row">
        <div class="display-table-cell sidebar">
            <nav class="navbar navbar-light bg-light">
                <a class="navbar-brand" href="#">
                    <span class="logo uk-text-primary">
                        <span class="uk-margin-small-right" uk-icon="uikit"></span>
                        </span><span class="title"> {{getSite()->name}}</span>
                </a>
            </nav>

            <div>
                @include('manage._sidebar')
            </div>
        </div>
        <div class="display-table-cell content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="#" style=""><i class="fas fa-search" style="font-size: 14px"></i></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="far fa-bell"></i><span class="notification-badge badge badge-pill badge-danger">3</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="far fa-envelope"></i></a>
                        </li>
                        <li class="nav-item dropdown" style="margin-left: 40px">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{Auth::user()->getProfilePicURL()}}" alt="image" class="profile-picture-w-35" width="40" style="position: absolute; left: -30px; top: -5px; margin-right: 60px; border-radius: 50%">
                                {{Auth::user()->name}}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right user-dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="#"><i class="far fa-user-circle"></i> My Profile</a>
                                <a class="dropdown-item" href="#"><i class="far fa-envelope"></i> Messages</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt"></i> Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>

            </nav>
            <div class="container-fluid">
                @include('layouts.partials._messages')
                @yield('content')
            </div>
        </div>
    </div>
</div>
<script>
    tinymce.init({
        selector: '.content-editor',
        branding: false,
        menubar: true,
        statusbar: false,
        toolbar_drawer: 'sliding',
        // theme: "modern",
        fontsize_formats: "8pt 9pt 10pt 11pt 12pt 26pt 36pt 48pt 72pt",
        plugins: [
            "advlist autolink link image lists charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
            "table contextmenu directionality emoticons paste textcolor code fullscreen",
        ],
        toolbar1: "undo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect link| image media | forecolor backcolor | link unlink anchor | fontsizeselect forecolor backcolor  | print preview code fullscreen",
        // image_advtab: true ,
    });
    // List item delete
    $('.btn-delete').click(function () {
        var item = $(this);
        if (!confirm('Are you sure you want to delete this item?')){
            return false;
        }
        var delete_form = item.parent().find('#delete-form');
        console.log(delete_form.attr('id'));
        delete_form.submit();
    });
</script>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
@yield('script')
</body>
</html>