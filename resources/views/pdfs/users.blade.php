


<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Institution</th>
            <th>Role</th>
        </tr>
    </thead>
    <tbody style="font-size: 12px;">
        @foreach($users as $user)
        
            <tr>
                <td>
                    {{ $loop->index + 1 }}
                </td>
                <td>
                    {{ $user->name }}
                </td>
                <td>
                    {{ $user->email }}
                </td>
                <td>
                    @if($user->institution)
                        {{ $user->institution->name }}
                    @else
                        {{ $user->pending_institution }}
                    @endif
                    
                </td>
                <td>
                    @if($user->role_id == 2)
                        Teacher
                    @elseif($user->role_id == 3)
                        Institution admin
                    @endif
                </td>

                
                    
            </tr>
        @endforeach
    </tbody>
</table>