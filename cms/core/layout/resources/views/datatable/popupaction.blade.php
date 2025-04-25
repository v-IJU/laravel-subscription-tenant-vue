 <style>
     .actions {
         display: flex;
         align-items: center;
         gap: 10px
     }
 </style>



 <div class="actions">

     <a class="btn btn-outline-secondary btn-sm edit popup-edit-btn" title="Edit" data-toggle="modal"
         data-id={{ $data->id }} href="javascript:void(0);">
         <i class="fas fa-pencil-alt"></i>
     </a>
     @if (@$route != 'coupon')
         <form method="post" action="{{ route($route . '.destroy', $data->id) }}">
             <!-- here the '1' is the id of the post which you want to delete -->

             {{ csrf_field() }}
             {{ method_field('DELETE') }}

             <button class="btn btn-outline-danger btn-sm deleteTableItem" type="button"><i class="fa fa-trash"
                     title="delete"></i></button>
         </form>
     @endif


 </div>
