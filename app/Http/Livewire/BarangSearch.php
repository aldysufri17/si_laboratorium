<?php

namespace App\Http\Livewire;

use App\Models\Barang;
use App\Models\Keranjang;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class BarangSearch extends Component
{
    use WithPagination;

    public $search = "";
    public $lab = 1;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        if (Auth::check()) {
            $data = Keranjang::where('user_id', Auth::user()->id)->pluck('barang_id');
            $barang = Barang::where('show', 1)
                ->where('nama', 'like', '%' . $this->search . '%')
                ->where('kategori_lab', $this->lab)
                ->whereNotIn('id', $data)
                ->paginate(7);
        } else {
            $barang = Barang::where('show', 1)
                ->where('nama', 'like', '%' . $this->search . '%')
                ->where('kategori_lab', $this->lab)
                ->paginate(7);
        }

        return view('livewire.barang-search', [
            'barang' => $barang
        ]);
    }
}
