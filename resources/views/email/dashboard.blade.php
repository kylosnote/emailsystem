@extends('layout.app')

@section('content')
    <div class="container">
        <div class="col-md-12">
            <div class="row">
                <table class="table table-striped table-responsive-md">
                    <thead>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Time Sent</th>
                    </thead>
                    <tbody>
                    @if(!empty($records))
                        @foreach($records as $record)
                            <tr>
                                <td>{{$record->subject}}</td>
                                <td>{{$record->message}}</td>
                                <td>{{$record->from}}</td>
                                <td>{{$record->to}}</td>
                                <td>{{$record->time_sent}}</td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
            <div class="row">
                @if(!empty($records))
                    {{ $records->appends(Request::except('page'))->links() }}
                @endif
            </div>
        </div>
    </div>
@endsection