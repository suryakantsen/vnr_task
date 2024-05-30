<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href="http://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.11.0/sweetalert2.css" integrity="sha512-n1PBkhxQLVIma0hnm731gu/40gByOeBjlm5Z/PgwNxhJnyW1wYG8v7gPJDT6jpk0cMHfL8vUGUVjz3t4gXyZYQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Scripts -->
    {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>
                            </li>
                            {{-- <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li> --}}
                            <li class="nav-item mt-1">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                            <li class="nav-item mt-1">
                                <button type="button" class="btn btn-sm btn-danger ml-1 delete_acount">Delete</button>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.2/js/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

    new DataTable('#myTable');

    $('#blogPostModal').on('hidden.bs.modal', function (e) {
      $('#title').val('');
      $('#body').val('');
      $('#post_id').val('');
      $('.modal-title').html('Add Modal Post');
      $('.footer_div').hasClass('d-none') ? $('.footer_div').removeClass('d-none') : '';
      enable_disable(false);
    })

    $(document).on('click', '.save_btn', function(){
              var formData = new FormData($('#post_blog_form')[0]);
              $.ajax({
              type: 'POST',
              url: "{{route('create')}}",
              data: formData,
              dataType: 'json',
              contentType: false,
              cache: false,
              processData: false,
              beforeSend: function() {
                $('.save_btn').prop('disabled', true);
              },
              success: function(data) {
                    if (data.status)
                    {
                      toastr.success(data.message, '', {
                          closeButton: !0,
                          tapToDismiss: !1,
                          progressBar: true,
                          timeOut: 2000
                      });
                      $('.save_btn').prop('disabled', false);
                      $('#blogPostModal').modal('hide');
                      window.location.reload();
                    }
                    else
                    {
                      toastr.error(data.message, '', {
                          closeButton: !0,
                          tapToDismiss: !1,
                          progressBar: true,
                          timeOut: 2000
                      });
                      $('.save_btn').prop('disabled', false);
                    }
                  }
              });
        });

    $(document).on('click', '.delete_acount', function(){
        Swal.fire({
          title: "Are you sure you want to delete your account?",
          text: "You won't be able to revert this!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!"
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              type: 'GET',
              url: "{{route('delete_account')}}",
              success: function(data) {
                    if (data.status)
                    {
                        toastr.success(data.message, '', {
                          closeButton: !0,
                          tapToDismiss: !1,
                          progressBar: true,
                          timeOut: 2000
                        });
                        window.location.href = "{{url('').'/login'}}";
                    }
                    else
                    {
                      toastr.error(data.message, '', {
                          closeButton: !0,
                          tapToDismiss: !1,
                          progressBar: true,
                          timeOut: 2000
                      });
                    }
                  }
            });
          }
        });
    });

    $(document).on('click', '.delete_btn', function(){
        let id = $(this).data('value');
        Swal.fire({
          title: "Are you sure?",
          text: "You won't be able to revert this!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!"
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              type: 'GET',
              url: "{{route('delete')}}",
              data: {'id':id},
              success: function(data) {
                    if (data.status)
                    {
                        toastr.success(data.message, '', {
                          closeButton: !0,
                          tapToDismiss: !1,
                          progressBar: true,
                          timeOut: 2000
                        });
                        window.location.reload();
                    }
                    else
                    {
                      toastr.error(data.message, '', {
                          closeButton: !0,
                          tapToDismiss: !1,
                          progressBar: true,
                          timeOut: 2000
                      });
                    }
                  }
            });
          }
        });
    });

    $(document).on('click', '.edit_btn, .view_btn', function(){
          $('#blogPostModal').modal();
          let id = $(this).data('value');
          let action = $(this).data('action');
          $.ajax({
          type: 'GET',
          url: "{{route('get_data')}}",
          data: {'id':id},
          success: function(data) {
                if (data.status)
                {
                    let status = (action == 'edit') ? false : true;
                    enable_disable(status);
                    if(status)
                    {
                        $('.modal-title').html('View Modal Post');
                        $('.footer_div').hasClass('d-none') ? '' : $('.footer_div').addClass('d-none');
                    }
                    else
                    {
                        $('.modal-title').html('Edit Modal Post');
                        $('.footer_div').hasClass('d-none') ? $('.footer_div').removeClass('d-none') : '';
                    }
                    let value = data.data; 
                    $('#post_id').val(id);
                    $('#title').val(value.title);
                    $('#body').val(value.body);
                }
              }
          });
    });

    function enable_disable(status)
    {
        $('#title').attr('disabled', status);
        $('#body').attr('disabled', status);
    }
</script>

    </div>
</body>
</html>
