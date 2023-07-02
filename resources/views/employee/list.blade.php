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

    <div class="container">
        <div class="d-flex justify-content-between py-3">
            <div class="h5">Employees</div>
            <div>
                <a href="{{route('employees.create')}}" class="btn btn-primary">Create</a>
            </div>
        </div>

        @if (Session::has('success'))
            <div class="alert alert-success">
                {{Session::get('success')}}
            </div>
        @endif

        <div class="card border-0 shadow-lg">
            <div class="card-body">
                <table class="table table-striped">
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Action</th>
                    </tr>
                @if ($employees->isNotEmpty())
                    @foreach ($employees as $employee)
                        
                    <tr>
                        <td>{{$employee->id}}</td>
                        <td>
                        @if ($employee->image != '' && file_exists(public_path().'/uploads/employees/'.$employee->image))
                            <img src="{{url('uploads/employees/'.$employee->image)}}" alt="" width="50" height="50" class="rounded-circle">
                        @else
                            <img src="{{url('assets/images/no-img.png')}}" alt="" width="50" height="50" class="rounded-circle">
                        @endif</td>
                        <td>{{$employee->name}}</td>
                        <td>{{$employee->email}}</td>
                        <td>{{$employee->address}}</td>
                        <td>
                            <a href="{{route('employees.edit',$employee->id)}}" class="btn btn-primary btn-sm">Edit</a>
                            <a href="#" onclick="deleteEmployee({{$employee->id}})" class="btn btn-danger btn-sm">Delete</a>

                            <form id="employee-id-action-{{$employee->id}}" action="{{route('employees.destroy',$employee->id)}}" method="post">
                                @csrf
                                @method('delete')
                            </form>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6">Record not found.</td>
                    </tr>
                @endif
                </table>
            </div>
        </div>

        <div class="mt-3">
            {{$employees->links()}}
        </div>

    </div>
    
</body>
</html>
<script>
    function deleteEmployee(id)
    {
        if(confirm("Are you sure you want to delete?"))
        {
            document.getElementById('employee-id-action-'+id).submit();
        }
    }
</script>