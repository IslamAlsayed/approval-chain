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
    <h2 style="text-align: center">i'm {{ $role }}</h2>

    <div style="width: 50%; margin: auto;">
        <ul>
            <li><a href="/approve/project/create">create project</a></li>
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

    <table style="width: 50%; margin: auto; border-collapse: collapse;">
        <thead>
            <tr>
                <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">ID</th>
                <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">Title</th>
                <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">Status</th>
                <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">Action</th>
            </tr>
        </thead>
        <tbody>
            @if ($approvals->count() > 0)
                @foreach ($approvals as $approval)
                    <tr>
                        <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{ $approval->project->id }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{ $approval->project->title }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{ $approval->project->status }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">
                            <form action="{{ route('approve.update', $approval->project->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" style="background-color: green; color: white; border: none; padding: 5px 10px; cursor: pointer;">Approve</button>
                            </form>
                            <form action="{{ route('approve.delete', $approval->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background-color: red; color: white; border: none; padding: 5px 10px; cursor: pointer;">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4" style="border: 1px solid #ddd; padding: 8px; text-align: center;">No approvals found</td>
                </tr>
            @endif
        </tbody>
    </table>

</body>

</html>
