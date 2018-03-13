<table class="table table-striped table-hover">
    <thead class="">
    <tr>
        <th scope="col">{{ __('Name') }}</th>
        <th scope="col">{{ __('Roles') }}</th>
    </tr>
    </thead>
    <tbody>
        @foreach($resources as $r)
            <tr>
                <td>{{$r->name}}</td>
                <td>{{implode(",", $r->getRoleNames()->toArray())}}</td>
            </tr>
        @endforeach
    </tbody>
</table>