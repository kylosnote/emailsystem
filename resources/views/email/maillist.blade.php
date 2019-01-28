@extends('layout.app')

@section('content')
    <div class="container">
        <div class="col-md-12">
            <div class="row">
                <form method="POST" action="/maillist/update">
                    @csrf
                    <button type="submit" class="btn btn-primary" href="/dashboard">Update</button>
                </form>
                <form method="POST" action="">
                    @csrf
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#submitModal">Send</button>
                    <!-- Modal -->
                    <div class="modal fade" id="submitModal" tabindex="-1" role="dialog" aria-labelledby="Confirmation" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="">Confirmation</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to send email?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Back</button>
                                    <button type="submit" class="btn btn-primary" name="submit_button" id="submit_button">Yes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row">
                <table class="table table-striped table-responsive-md ">
                <thead>
                <th>Email</th>
                <th>Status</th>
                <th>Last Login</th>
                <th>Last Email</th>
                </thead>
                <tbody>
                @if(!empty($maillist))
                    @foreach($maillist as $mail)
                        <tr>
                            <td>{{$mail->email}}</td>
                            <td @if($mail->status=="Active")style="color: green"
                            @elseif($mail->status=='Inactive')style="color: red"
                                    @endif><i class="fa fa-user "></i> {{$mail->status}}</td>
                            <td>{{$mail->last_login}}</td>
                            <td>{{$mail->last_email_sent}}</td>
                        </tr>

                    @endforeach
                @endif
                </tbody>
            </table>
            </div>
            @if(!empty($maillist))
                {{ $maillist->appends(Request::except('page'))->links() }}
            @endif

        </div>
    </div>

@endsection