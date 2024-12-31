<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Approval chain</title>

    <style>
        ul {
            gap: 20px;
            display: flex;
            list-style: none;
            align-items: center;
        }
    </style>
</head>

<body>
    <h2 style="text-align: center">create project</h2>

    <div style="width: 50%; margin: auto;">
        <ul>
            <li><a href="/approve/role/admin1">admin1</a></li>
            <li><a href="/approve/role/admin2">admin2</a></li>
            <li><a href="/approve/role/admin3">admin3</a></li>
            <li><a href="/approve/completed">approved</a></li>
            <li><a href="/approve/trashed">trashed</a></li>
        </ul>
    </div>

    @if (session('success'))
        <div style="width: 50%; margin: auto; margin-bottom: 20px; padding: 10px; border: 1px solid #d4edda; background-color: #d4edda; color: #155724;">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div style="width: 50%; margin: auto; margin-bottom: 20px; padding: 10px; border: 1px solid #d4edda; background-color: #d4edda; color: #155724;">
            {{ session('error') }}
        </div>
    @endif

    <div style="width: 50%; margin: auto;">
        <form action="{{ route('approve.project.store') }}" method="POST" style="display: inline;">
            @csrf
            @method('POST')
            <input type="text" name="title" id="title" value="project" />
            <button type="submit" style="background-color: #0b2c88; color: white; border: none; padding: 5px 10px; cursor: pointer;">save</button>
        </form>
    </div>
</body>

</html>
