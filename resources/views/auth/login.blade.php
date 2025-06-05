<!-- resources/views/auth/login.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
       <meta charset="UTF-8">
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <title>Login - SB Admin 2</title>
       <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
       <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
       <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>

<body class="bg-gradient-primary">
       <div class="container">
              <div class="row justify-content-center">
                     <div class="col-xl-5 col-lg-12 col-md-9">
                            <div class="card o-hidden border-0 shadow-lg my-5">
                                   <div class="card-body p-0">
                                          <div class="p-5">
                                                 <div class="text-center">
                                                        <h1 class="h4 text-gray-900 mb-4">WarungCihuy</h1>
                                                 </div>
                                                 <form class="user" method="POST" action="{{ url('login') }}">
                                                        @csrf
                                                        <div class="form-group">
                                                               <input type="text" name="username" class="form-control form-control-user" placeholder="username" required>
                                                        </div>
                                                        <div class="form-group">
                                                               <input type="password" name="password" class="form-control form-control-user" placeholder="Password" required>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                                               Login
                                                        </button>
                                                 </form>
                                                 <!-- Di bawah form login -->
                                                 <hr>
                                          </div>
                                   </div>
                            </div>
                     </div>
              </div>
       </div>
</body>

</html>