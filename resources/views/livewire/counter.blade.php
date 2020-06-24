@if($view)
<div style="text-align: center">
    <form wire:submit.prevent="submit">
	    <input type="text" wire:model="name">
	    @error('name') <span class="error">{{ $message }}</span> @enderror

	    <input type="text" wire:model="email">
	    @error('email') <span class="error">{{ $message }}</span> @enderror

	    <button type="submit">Save Contact</button>
	</form>
	<div>
    
</div>
    <table class="table">
    	<thead>
    	<tr>
    		<th>id</th>
    		<th>name</th>
    		<th>email</th>
    		<th>action</th>
    	</tr>
    	</thead>
    	<tbody>
    	@forelse($users as $user)
    	<tr>
    		<td>{{$user->id}}</td>
    		<td>{{$user->name}}</td>
    		<td>{{$user->email}}</td>
    		<td><button wire:click="editUser({{$user->id}})" type="button" class="btn btn-primary" >
  edit
  </button>  |  <button type="button" class="btn btn-danger" onclick="delitem({{$user->id}})">
  delete
</button></td>
    	</tr>
    	@empty
      <td>no data</td>
    	@endforelse
    	</tbody>
    	{{$users->links()}}
    </table>
 <form wire:submit.prevent="save">
    <input type="file" wire:model="photos" multiple>

    @error('photo') <span class="error">{{ $message }}</span> @enderror

    <button type="submit">Save Photo</button>
</form>

@else
<div class="col-lg-8 ">
<form wire:submit.prevent="updateUser">
<input type="text" class="form-control" wire:model="idUser" value="{{$users->id}}"><br>
<input type="text" class="form-control" wire:model="name" value="{{$users->name}}"><br>
<input type="text" class="form-control" wire:model="email" value="{{$users->email}}"><br>
<input type="submit" class="btn btn-primary" value="update"><br>
</form>
</div>
@endif

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">

	function delitem(id){
    swal({
      title: "Are you sure?",
      text: "Once deleted, you will not be able to recover this imaginary file!",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        @this.call('deleteUser', id);
        swal("Poof! Your imaginary file has been deleted!", {
          icon: "success",
        });
      } else {
        swal("Your imaginary file is safe!");
      }
    });

  }

</script>