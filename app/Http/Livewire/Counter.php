<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\User;


class Counter extends Component
{
	use WithPagination;
	use WithFileUploads;

    public $count = 0;
    public $idUser;
    public $email;
    public $name;

    public $view = true;
    

    public $photos = [];
    public $count_photo = 0;
    public function save()
    {
        $this->validate([
            'photos.*'  => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);
        foreach ($this->photos as $photo) {
        	$photo->store('photos');
        }

        $this->reset();

    }

    public function increment()
    {
        $this->count++;
    }

    public function decrement()
    {
        $this->count--;
    }
    public function updateUser()
    {
    	$user = User::where('id', $this->idUser)->firstorFail();
    	$user->name = $this->name;
    	$user->email = $this->email;
    	$user->save();
    	$this->view = true;
    	$this->reset();
    }
    public function deleteUser($id)
    {
    	User::where('id', $id)->delete();
    }
    public function editUser($id)
    {	
    	$this->view = false;

    	$user = User::where('id', $id)->firstorFail();
    	$this->idUser = $id;
    	$this->name = $user->name;
    	$this->email = $user->email;
    }

    public function submit()
    {
        $this->validate([
            'name' => 'required|min:6',
            'email' => 'required|email|unique:users',
        ]);

        // Execution doesn't reach here if validation fails.

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => '12345678',
        ]);

        $this->reset();
    }

    public function render()
    {
    	if($this->view == true){

        	return view('livewire.counter', ['users' => User::orderBy('created_at','desc')->paginate(5)]);
    	}
    	else{
    		return view('livewire.counter', ['users' => User::where('id', $this->idUser)->first() ]);
    	}
    }
}
