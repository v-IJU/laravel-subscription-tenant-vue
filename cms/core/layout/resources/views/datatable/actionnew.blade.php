<style>
    .actions{
        display: flex;
        align-items: center;
    }
  .actions button,
  .actions i,
  .actions a {
      font-size: 14px !important;
  }

  .delete-icon {
      width: 40px;
      height: 40px;
      display: inline-block;
      background-color: rgba(0, 0, 0, 0); /* Light white background */
      align-items: center;
      padding: 10px; /* Space around the icon */
      border-radius: 60%; /* Circular background */
      margin-right: 15px;
      border:0;
  }

  .delete-icon i {
      color: red; /* Red color for the trash icon */
      font-size: 20px; /* Adjust the size of the icon */
  }

  .edit-icon {
      width: 40px;
      height: 40px;
      display: flex; /* Use flexbox for centering */
      justify-content: center; /* Horizontally center the icon */
      align-items: center;
      background-color: rgba(0, 0, 0, 0); /* Light red background */
      padding: 10px; /* Space around the icon */
      border-radius: 60%; /* Circular background */
      margin-right: 15px;
      border:0;
  }

  .edit-icon i {
      color: blue; /* Red color for the trash icon */
      font-size: 25px; /* Adjust the size of the icon */
  }
  .view-icon {
      width: 40px;
      height: 40px;
      display: flex;
      background-color: rgba(0, 0, 0, 0); /* Light white background */
      justify-content: center; /* Horizontally center the icon */
      align-items: center;
      padding: 10px; /* Space around the icon */
      border-radius: 60%; /* Circular background */
      margin-right: 15px;
      border:0;
  }

  .view-icon i {
      color: green; /* Red color for the trash icon */
      font-size: 25px; /* Adjust the size of the icon */
  }


 </style>

<div class="actions">

    @if($showEdit)
      <!-- Edit button -->
      <a href="{{ route($editRoute,$id) }}" class="edit-icon" title="Edit"><i class="fas fa-pencil-alt"></i></a>
    @endif

    @if($showView)
      <!-- View button -->
      <a href="{{ route($viewRoute,$id) }}" class="view-icon" title="View"><i class="fa fa-eye"></i></a>
    @endif

    @if(isset($showClone))
      <!-- Clone button -->
      <a href="{{ route($cloneRoute,$id) }}" class="view-icon" title="Clone"><i class="fa fa-plus-square"></i></a>
    @endif

    @if($showDelete)
      <!-- Delete button -->
      <form action="{{ route($deleteRoute, $id) }}" method="POST" >
        @csrf
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        <button type="submit" id="delete" class="delete-icon delete" title="Delete"><i class="fa fa-trash"></i></button>
      </form>
    @endif

   </div>



