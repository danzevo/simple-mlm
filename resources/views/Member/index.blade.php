<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Forex IMX</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.5.0/sweetalert2.min.css" integrity="sha512-y6TjkITSFkRB9mZmDaJyDOsyHsYvOo3Np3iAKe02HgMDP4L4vbmbhlzNpbbIVC1x+GUUHvepTd1BKDe4kC6kNg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.5.0/sweetalert2.min.js" integrity="sha512-wM6MHfyY3vToxbuE7MSr9FBoFAo3+wzqynlL49URg4ZVf4SxYOr2+2g6j7h1h/YWt2d0R4Cb92jre62OJUm6mA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  </head>
  <body>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-2 offset-1">
                    <label>Perhitungan Bonus</label>
                    <select class="form-control select2" id="select_member_id" name="select_member_id" data-placeholder="Select member ID">
                        <option value=""></option>
                        @foreach($member as $row)
                            <option value="{{ $row->id }}">{{ $row->name . ' | ' . $row->member_id }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-2">
                    <label></label>
                    <select class="form-control select2" id="level" name="level" data-placeholder="Pilih level">
                        <option value=""></option>
                        <option value="all">All</option>
                        <option>2</option>
                        <option>3</option>
                    </select>
                </div>
                <div class="col-2">
                    <button class="btn btn-primary mt-4" onclick="calculateBonus()">Calculate = </button>
                </div>
                <div class="col-2">
                    <label></label>
                    <input type="text" id="bonus" name="bonus" class="form-control" placeholder="$$$">
                </div>
            </div>
            <div class="row">
                <div class="col-2 offset-1">
                    <label>Register ID Member baru</label>
                    <label></label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Inisial member baru" required>
                </div>
                <div class="col-2">
                    <label></label>
                    <select class="form-control select2" id="parent_id" name="parent_id" data-placeholder="Pilih Parent">
                        <option value=""></option>
                        @foreach($member as $row)
                            <option value="{{ $row->id }}">{{ $row->name . ' | ' . $row->member_id }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-2">
                    <button class="btn btn-primary mt-4" onclick="save(type)">Register </button>
                </div>
                <div class="col-2">
                    <label></label>
                    <input type="text" id="member_id" name="member_id" class="form-control" placeholder="Member ID">
                </div>
            </div>
            <div class="row">
                <div class="col-2 offset-1">
                    <label>Migrasi member</label>
                    <select class="form-control select2" id="migrasi_member_id" name="migrasi_member_id" data-placeholder="Select member ID">
                        <option value=""></option>
                        @foreach($member as $row)
                            <option value="{{ $row->id }}">{{ $row->name . ' | ' . $row->member_id }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-2">
                    <label></label>
                    <select class="form-control select2" id="select_parent_id" name="select_parent_id" data-placeholder="Pilih Parent">
                        <option value=""></option>
                        @foreach($member as $row)
                            <option value="{{ $row->id }}">{{ $row->name . ' | ' . $row->member_id }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-2">
                    <button class="btn btn-primary mt-4" onclick="migrate()">Migrate </button>
                </div>
                <div class="col-2">
                    <label></label>
                    <input type="text" id="new_member_id" name="new_member_id" class="form-control" placeholder="New Member ID">
                </div>
            </div>
            <div class="d-flex flex-row justify-content-center align-items-center">
                <div class="tree">
                    <ul>
                        <li>
                            <a href="#">Admin</a>
                            <ul id="content_result">
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(".select2").select2({
            allowClear:true
        });
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            featchData();
        //   location.reload();
        });

        function save()
        {
            let name = document.getElementById('name').value;
            let parent_id = document.getElementById('parent_id').value;

            var url = "{{ url('member') }}";

            var form_data = new FormData();
                form_data.append('name', name);
                form_data.append('parent_id', parent_id);

            ajax(url, form_data, 'POST');
        }

        function featchData() {
            var url = "{{ url('fetch-data') }}";

                $.ajax({
                    url: url,
                    type: "get", //send it through get method
                    data: {},
                    success: function(result) {
                        $('#content_result').html(result);
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: 'Error!',
                            icon: 'error',
                            html: xhr.responseJSON.message,
                        });
                    }
                });
        }

        function calculateBonus() {
            let member_id = document.getElementById('select_member_id').value;
            let level = document.getElementById('level').value;

            var url = "{{ url('member-bonus') }}";

                $.ajax({
                    url: url,
                    type: "get", //send it through get method
                    data: {
                        id: member_id,
                        level: level,
                    },
                    success: function(result) {
                        $('#bonus').val(result.total_bonus);
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: 'Error!',
                            icon: 'error',
                            html: xhr.responseJSON.message,
                        });
                    }
                });
        }

        function migrate() {
            let member_id = document.getElementById('migrasi_member_id').value;
            let parent_id = document.getElementById('select_parent_id').value;

            var url = "{{ url('member') }}/"+member_id;

            var form_data = new FormData();
                // form_data.append('name', name);
                form_data.append('parent_id', parent_id);
                form_data.append('_method', 'PUT');

            ajax(url, form_data, 'POST');
        }

        function ajax(url, form_data, method) {

            $.ajax({
                type: method,
                url: url,
                beforeSend: function (xhr) {
                    var token = $('meta[name="csrf_token"]').attr('content');

                    if (token) {
                        return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                    }
                },
                data: form_data,
                dataType: "json",
                contentType: false,
                cache : false,
                processData : false,
                success: function(result){
                    // document.getElementById("submitArticle").disabled = false;

                    // $('#InputModal').modal('hide');
                    Swal.fire("Success!", result.message, "success");
                    location.reload();
                } ,error: function(xhr, status, error) {
                    Swal.fire({
                    title: 'Error!',
                    icon: 'error',
                    html: xhr.responseJSON.message,
                    });
                    // document.getElementById("submitArticle").disabled = false;
                },

            });
        }
    </script>
  </body>
</html>
