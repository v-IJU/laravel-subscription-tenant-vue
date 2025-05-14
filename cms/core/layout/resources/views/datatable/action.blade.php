 <style>
     .actions {
         display: flex;
         align-items: center;
         gap: 10px
     }
 </style>



 <div class="actions">
     @if(@$route == 'institute')
        @if($data->onboard_status == 1)
         <a class="btn btn-outline-secondary btn-sm web" title="Edit" data="{{ $data->id }}"
            href="http://{{ $domain }}:8000/" target="_blank">
                <i class='bx bx-globe'></i> Link
        </a>

        @else
            <form method="post" action="{{ route('institute_onboard_from_admin', $data->id) }}">


                {{ csrf_field() }}


                <button class="editbutton btn btn-primary onboard" type="submit">Onboard</button>
            </form>
        @endif
     @endif
     <a class="btn btn-outline-secondary btn-sm edit" title="Edit" data-toggle="modal" data={{ $data->id }}
         href="{{ route($route . '.edit', $data->id) }}">
         <i class="fas fa-pencil-alt"></i>
     </a>



     <a class="btn btn-outline-secondary btn-sm edit " data-toggle="modal" data={{ $data->id }}
         href="{{ route($route . '.show', $data->id) }}" title="view"><i class="fa fa-eye"></i></a>




     <form method="post" action="{{ route($route . '.destroy', $data->id) }}">
         <!-- here the '1' is the id of the post which you want to delete -->

         {{ csrf_field() }}
         {{ method_field('DELETE') }}

         <button class="btn btn-outline-danger btn-sm deleteTableItem" type="button"><i class="fa fa-trash"
                 title="delete"></i></button>
     </form>

 </div>
