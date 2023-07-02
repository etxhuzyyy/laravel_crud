<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Simple CRUD Operations | Laravel</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
</head>
<body>

    <div class="bg-dark py-3">
        <div class="container">
            <div class="h4 text-white">LARAVEL CRUD</div>
        </div>
    </div>

    <div class="container py-3">
        <div class="d-flex justify-content-between">
            <div class="h5">Edit Employees</div>
            <div>
                <a href="{{route('employees.index')}}" class="btn btn-primary">Back</a>
            </div>
        </div>

        <form action="{{route('employees.update',$employee->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card border-0 shadow-lg mt-3">
                <div class="card-body">

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" id="name" placeholder="Enter your name" class="form-control @error('name') is-invalid @enderror" value="{{old('name',$employee->name)}}">
                        @error('name')
                            <p class="invalid-feedback">{{$message}}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" placeholder="Enter your email" class="form-control @error('email') is-invalid @enderror" value="{{old('email',$employee->email)}}">
                        @error('email')
                            <p class="invalid-feedback">{{$message}}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea name="address" id="address" cols="30" rows="10" class="form-control">{{old('address',$employee->address)}}</textarea>
                    </div>

                    <div class="mb-3">
                        <input type="file" name="image" class="@error('image') is-invalid @enderror">
                        @error('image')
                            <p class="invalid-feedback">{{$message}}</p>
                        @enderror
                        <div class="pt-3">
                            @if ($employee->image != '' && file_exists(public_path().'/uploads/employees/'.$employee->image))
                            <img src="{{url('uploads/employees/'.$employee->image)}}" alt="" width="80" height="80">
                        @endif
                        </div>
                    </div>

                </div>
            </div>

            <button class="btn btn-primary my-3">Update</button>
        </form>

    </div>
    
</body>
</html>