<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th style="width: 30px;">Name</th>
        </tr>
    </thead>
    <tbody style="font-size: 12px;">
        @foreach($categories as $category)
            <tr>
                <td>
                    {{ $loop->index + 1 }}
                </td>
                <td>
                    {{ $category->name }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>