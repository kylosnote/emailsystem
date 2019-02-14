<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link href="{{ asset('css/main.css') }}" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">


    </head>
    <body>
        <div id="app">
            <main>
                <div class="container">
                    <div class="col-md-12">
                        <h2>List</h2>
                        <table class="table table-striped table-responsive-md">
                            <thead>
                                <th>ID</th>
                                <th>List Name</th>
                                <th>Company Name</th>
                                <th>Member Count</th>
                            </thead>
                            @if(!empty($resp_array))
                                @foreach($resp_array["lists"] as $index => $list)
                                    <tr>
                                        <td>{{$list['id']}}</td>
                                        <td>{{$list['name']}}</td>
                                        <td>{{$list['contact']['company']}}</td>
                                        <td>{{$list['stats']['member_count']}}</td>

                                    </tr>
                                @endforeach
                            @endif
                        </table>
                        <hr/>
                        <h2> Create List</h2>
                            <div class="card">
                                <div class="card-body">
                                    <form method="POST" action="/create/list">
                                        @csrf
                                        <div class="form-group row">
                                            <label for="InputName">Name</label>
                                            <input name='name' type="name" class="form-control" id="InputName" aria-describedby="nameHelp" placeholder="Enter Name" required>
                                            <small id="emailHelp" class="form-text text-muted">List name.</small>
                                        </div>

                                        <div class="form-group row">
                                            <label for="InputCompanyName">Company Name</label>
                                            <input name="company_name" type="company_name" class="form-control" id="InputCompanyName" aria-describedby="companyNameHelp" placeholder="Enter Company Name" required>
                                        </div>

                                        <div class="form-group row">
                                            <label for="InputAddress1">Address1</label>
                                            <input name="address1" type="address" class="form-control" id="InputAddress1" aria-describedby="address1Help" placeholder="Enter address1" required>
                                        </div>

                                        <div class="form-group row">
                                            <label for="InputCity">City</label>
                                            <input name="city" type="city" class="form-control" id="InputCity" aria-describedby="cityHelp" placeholder="Enter city" required>
                                        </div>

                                        <div class="form-group row">
                                            <label for="InputState">State</label>
                                            <input name="state" type="state" class="form-control" id="InputState" aria-describedby="stateHelp" placeholder="Enter State" required>
                                        </div>

                                        <div class="form-group row">
                                            <label for="InputZip">Zip</label>
                                            <input name="zip" type="zip" class="form-control" id="InputZip" aria-describedby="zipHelp" placeholder="Enter zip code" required>
                                        </div>
                                        <div class="form-group row">
                                            <div class="text-right">
                                                <button type="submit" class="btn btn-primary" name="submit" value="list">Submit</button>
                                            </div>
                                        </div>                                    </form>
                                </div>
                            </div>

                        <hr/>
                        <h2>Email</h2>
                           <div class="card">
                               <div class="card-body">
                                   <form method="POST" action="/add/member">
                                       @csrf
                                       <div class="form-group row">
                                           <label for="InputList">List</label>
                                           <select name="list" class="form-control" id="SelectList" required>
                                               @foreach($resp_array["lists"] as $key=>$value)
                                                   <option value="{{$value['id']}}">{{$value['name']}}</option>
                                               @endforeach
                                           </select>
                                       </div>
                                       <div class="form-group row">
                                           <label for="InputEmail">Email</label>
                                           <input name='email' type="email" class="form-control" id="InputEmail" aria-describedby="emailHelp" placeholder="Enter email address" required>
                                           <small id="emailHelp" class="form-text text-muted">Enter email address.</small>
                                       </div>
                                       <div class="form-group row">
                                           <div class="text-right">
                                               <button type="submit" class="btn btn-primary" name="submit" value="email">Add Email</button>
                                           </div>
                                       </div>
                                   </form>
                               </div>
                           </div>
                        <hr/>
                        <h2>Campaign</h2>
                        <table class="table table-striped table-responsive-md">
                            <thead>
                            <th>ID</th>
                            <th>List Name</th>
                            <th>Recipient Count</th>
                            <th>Status</th>
                            <th>Email Sent</th>
                            <th>Create Time</th>
                            <th>Send Time</th>
                            <th>Action</th>
                            </thead>
                            @if(!empty($campaign_array))
                                @foreach($campaign_array["campaigns"] as $index => $campaign)
                                    <tr>
                                        <td>{{$campaign['id']}}</td>
                                        <td>{{$campaign['recipients']['list_name']}}</td>
                                        <td>{{$campaign['recipients']['recipient_count']}}</td>
                                        <td>{{$campaign['status']}}</td>
                                        <td>{{$campaign['emails_sent']}}</td>
                                        <td>{{$campaign['create_time']}}</td>
                                        <td>{{$campaign['send_time']}}</td>
                                        <td><a class="btn btn-primary" href="/launch/campaign/{{$campaign['id']}}" role="button">Launch</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </table>
                        <hr/>
                        <h2>Create Campaign</h2>
                        <div class="card">
                            <div class="card-body">
                                <form method="POST" action="/create/campaign">
                                    @csrf
                                    <div class="form-group row">
                                        <label for="InputList" class="col-md-2 col-form-label">List</label>
                                        <select name="list" class="col-md-4 form-control" id="SelectList" required>
                                            @foreach($resp_array["lists"] as $key=>$value)
                                                <option value="{{$value['id']}}">{{$value['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-2 col-form-label">Subject Line</label>
                                        <input type="text" name="subject_line" id="subject_line" class="col-md-4 form-control" required>

                                        <label class="col-md-2">Preview Text</label>
                                        <input type="text" name="preview_text" id="preview_text" class="col-md-4 form-control" required>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-2 col-form-label">Title</label>
                                        <input type="text" name="title" id="title" class="col-md-4 form-control" required>

                                        <label class="col-md-2">From Name</label>
                                        <input type="text" name="from_name" id="from_name" class="col-md-4 form-control" required>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-2 col-form-label">Plain Text</label>
                                        <textarea class="col-md-10 form-control" id="plain_text" name='plain_text' rows="3" placeholder="Write email content here..."></textarea>
                                    </div>

                                    <div class="form-group row">
                                        <div class="text-right">
                                            <button type="submit" class="btn btn-primary" name="submit" value="campaign">Create Campaign</button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </main>
        </div>
    </body>
</html>