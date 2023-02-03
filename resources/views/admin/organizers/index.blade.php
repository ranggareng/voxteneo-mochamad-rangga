@extends('adminlte::page')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card mt-5">
            <div class="card-header">{{ __('Organizers') }}</div>

            <div class="card-body">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Organizer Name</th>
                            <th>Image Location</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($organizers as $key => $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->organizerName }}</td>
                                <td><img src="{{ $item->imageLocation }}" width=200></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $pagination->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
