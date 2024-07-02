@include('includes.header')
<!-- Page content-->
<div class="container">
    <div class="mt-5">
        @if(!empty($code) && $code === 200)
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{ !empty($code) && $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @elseif(!empty($code) && $code === 404)
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> {{ !empty($code) && $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="d-flex justify-content-between">
            <div>
                <h1>Webhook List</h1>
            </div>
            <div>
                <a class="btn btn-primary" href="{{ route('add-webhook') }}">Create Webhook</a>
            </div>
        </div>
        <table class="table table-bordered mt-5">
            <thead>
            <tr>
                <th scope="col" width="10%" style="background: #333; color: white">No</th>
                <th scope="col" width="30%" style="background: #333; color: white; text-align: center">Title</th>
                <th scope="col" width="40%" style="background: #333; color: white; text-align: center">Description</th>
                <th scope="col" width="20%" style="background: #333; color: white; text-align: center">Action</th>
            </tr>
            </thead>
            <tbody>
            @if(!empty($data))
                @foreach($data as $data)
                    <tr>
                        <td width="10%">{{ $loop->iteration }}</td>
                        <td width="30%">{{ $data->title }}</td>
                        <td width="40%">
                            <div class="d-flex justify-content-between">
                                <div href="javasscript:void(0)">{{ $data->description }}</div>
                                <button type="button" onclick="copyToClipboard('{{ route('webhook', ['id' => $data->unique_id]) }}')" class="btn btn-dark copylink" data-toggle="tooltip" data-placement="top" title="{{ route('webhook', ['id' => $data->unique_id]) }}">Copy Webhook Link</button>

                            </div>
                        </td>
                        <td width="20%" class="text-center">
                            <a class="btn btn-primary" href="{{ route('add-new-url',['id' => $data->id]) }}">Edit
                                </a>
                            <button type="button" class="btn btn-danger" onclick="deleteWebhook({{$data->id}})">Delete</button>
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="successPopup" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Process Initialized!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                We have started processing the records to Salesforce, We will notify once all records will be processed.<br/><br/>
                Thanks,<br/>
                Sterling Team
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@include('includes.footer')
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

    function copyToClipboard(text) {
        var $temp = $("<input>");
         $("body").append($temp);
        $temp.val(text).select();
        document.execCommand("copy");
        $temp.remove();
    }



    function deleteWebhook(id)
    {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        Swal.fire({
            title: "Are you sure want to Delete?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: base_url + '/remove-webhook/' +id,
                    type: "Delete",
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken // Include CSRF token in headers
                    },
                    success: function (response) {
                        if (response.success === true) {
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 2000
                            });
                            window.location.reload();
                        }
                        if (response.success === false) {
                            if (response.modal == 'createJOB') {
                                Swal.fire({
                                    title: 'Error!',
                                    text: response.message,
                                    icon: 'error',
                                    confirmButtonText: 'OK',
                                    timer: 4000
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: response.message,
                                    icon: 'error',
                                    confirmButtonText: 'OK',
                                });
                            }
                        }
                    },
                    error: function () {
                        Swal.fire({
                            title: 'Error!',
                            text: 'SOMETHING WENT WRONG!',
                            icon: 'error',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                });
            }
        });
    }
</script>

