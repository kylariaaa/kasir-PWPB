<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\user as ModelUser;

class User extends Component
{
    public $pilihanMenu = "lihat";
    public $nama;
    public $email;
    public $peran;
    public $password;

        public function simpan(){
            $this->validate([
                'nama' => 'required',
                'email' => ['required','email','unique:users,email'],
                'password' => 'required',
                'peran' => 'required'
            ],[
                'nama.required' => 'Nama Harus Diisi',
                'email.required' => 'Email Harus Diisi',
                'email.email' => 'Format mesti diisi',
                'email.unique' => 'Email sudah digunakan',
                'peran.required' => 'Peran Harus Diisi',
                'password.required' => 'Password Harus Diisi',
            ]);

            $simpan = new ModelUser();
            $simpan->name = $this->nama;
            $simpan->email = $this->email;
            $simpan->password = bcrypt($this->password);
            $simpan->peran = $this->peran;
            $simpan->save();

            $this->reset('nama', 'email', 'password', 'peran');
            $this->pilihanMenu = 'lihat';

        }
        public function pilihMenu($menu)
        {
            $this->pilihanMenu = $menu;
        }
    public function render()
    {
        return view('livewire.user')->with ([
            'semuaPengguna' => ModelUser::all()
        ]);
    }
}
