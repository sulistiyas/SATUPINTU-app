@foreach ($data_users as $item_users)
    <div class="row">
        <div class="col-md-12">
            <!-- Profile Image -->
            <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                <img class="profile-user-img img-fluid img-circle"
                    src="{{ asset('assets/dist/img/user.png') }}"
                    alt="User profile picture">
                </div>

                <h3 class="profile-username text-center">{{ $item_users->name }}</h3>

                <p class="text-muted text-center">{{ $item_users->emp_position }} | {{ $item_users->emp_division }}</p>

                <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                    <b>Work e-Mail</b> <a class="float-right">{{ $item_users->email }}</a>
                </li>
                <li class="list-group-item">
                    <b>Personal e-Mail</b> <a class="float-right">{{ $item_users->personal_email }}</a>
                </li>
                <li class="list-group-item">
                    <b>Phone Number</b> <a class="float-right">{{ $item_users->emp_phone }}</a>
                </li>
                </ul>

                {{-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> --}}
            </div>
            <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">About Me</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                {{-- <strong><i class="fas fa-book mr-1"></i> Education</strong>

                <p class="text-muted">
                B.S. in Computer Science from the University of Tennessee at Knoxville
                </p> --}}

                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                <p class="text-muted">{{ $item_users->emp_address }}</p>

                <hr>

                <strong><i class="fas fa-pencil-alt mr-1"></i> Place & Date of Birth</strong>

                <p class="text-muted">{{ $item_users->place_birth }}, {{ $item_users->birth_date }}</p>

                <hr>

                <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>

                <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
            </div>
            <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
<!-- /.row -->
@endforeach

