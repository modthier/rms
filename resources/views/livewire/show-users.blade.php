<div>
    <table>
        <thead>
            <th>Username</th>
            <th>email</th>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                </tr>
            @endforeach
        </tbody>
        
    </table>
</div>
