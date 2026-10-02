{{-- Jump straight to a page, for long histories. --}}
<x-widget.table caption="Login history" :columns="['When', 'Device', 'Location']" :rows="$logins" pagination="jump">
    @foreach ($logins as $login)
        <x-widget.table.row>
            <td>{{ $login->when }}</td>
            <td>{{ $login->device }}</td>
            <td>{{ $login->location }}</td>
        </x-widget.table.row>
    @endforeach
</x-widget.table>
