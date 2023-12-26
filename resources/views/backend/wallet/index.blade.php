@extends('backend.layouts.app')
@section('title', 'Users')
@section('wallet-active', 'mm-active')
@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-users icon-gradient bg-mean-fruit">
                </i>
            </div>
            <div>Wallet</div>
        </div>
    </div>
</div>



<div class="content py-3">
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered Datatable">
                <thead>
                    <tr class="bg-light">
                        <th>Account Number</th>
                        <th>Account Profile</th>
                        <th>Amount</th>
                        <th>Created at</th>
                        <th class="updated_at">Updated At</th>

                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        var table = $('.Datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "/admin/wallet/ssd",
            columns: [
                {
                    data: "account_number",
                    name: "account_number",
                },
                {
                    data: "account_profile",
                    name: "account_profile",
                },
                {
                    data: "amount",
                    name: "amount",
                },
                {
                    data: "created_at",
                    name: "created_at",
                },
              
                {
                    data: "updated_at",
                    name: "updated_at",
                },
                
            ],
            order: [[ 3, "desc" ]],

            columnDefs: [{

                targets: "no-sort",
                sortable: false,
                
            }]
        });

        $(document).on('click','.delete_btn',function(e){
            $id=$(this).data('id');
            e.preventDefault();
                Swal.fire({
                    title: "Are you sure?",
                    text: "You want be able to delete this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33 ",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete it!",
                    reverseButtons: true,

                    }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                                title: "Deleted!",
                                text: "Your file has been deleted.",
                                icon: "success"
                        }); 
                       $.ajax({
                            url:'/admin/user/'+$id,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            method:'DELETE',
                            success:function(){
                               
                                table.ajax.reload()
                            }
                        })
                    }
                });   
        });
    });

</script>
@endsection