


<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Website</th>
            <th>Type</th>
            <th>Admin Name</th>
            <th>Admin Email</th>
            <th>Admin Name</th>
            <th>Admin Email</th>
        </tr>
    </thead>
    <tbody style="font-size: 12px;">
        @foreach($institutions as $institution)
        
            <tr>
                <td>
                    {{ $loop->index + 1 }}
                </td>
                <td>
                    {{ $institution->name }}
                </td>
                <td>
                    {{ $institution->type }}
                </td>
                <td>
                    {{ $institution->website }}
                </td>

                @if(count($institution["users"]) > 0)
                    
                    @if($institution["users"][0])
                        <td>
                            {{ $institution["users"][0]["name"] }}
                        </td>
                        <td>
                            {{ $institution["users"][0]["email"] }}
                        </td>
                    @endif
                    @if(count($institution["users"]) > 1)
                        <td>
                            {{ $institution["users"][1]["name"] }}
                        </td>
                        <td>
                            {{ $institution["users"][1]["email"] }}
                        </td>
                    @else
                        <td></td>
                    @endif
                @else
                    <td></td>
                    <td></td>
                @endif
                
                    
            </tr>
        @endforeach
    </tbody>
</table>