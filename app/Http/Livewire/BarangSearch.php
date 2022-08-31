<?php

namespace App\Http\Livewire;

use App\Models\Barang;
use App\Models\Keranjang;
use App\Models\Laboratorium;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class BarangSearch extends Component
{
    use WithPagination;

    public $search = "";
    public $labId = 0;
    public $name;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        if (Auth::check()) {
            // $data = Peminjaman::where('user_id', Auth::user()->id)->pluck('barang_id');
            $barang = Barang::where('show', 1)
                ->where('pengadaan_id', '!=', 4)
                ->where('stock', '!=', 0)
                ->where('nama', 'like', '%' . $this->search . '%')
                ->where('laboratorium_id', $this->labId)
                // ->whereNotIn('id', $data)
                ->paginate(7);
        } else {
            $barang = Barang::where('show', 1)
                ->where('pengadaan_id', '!=', 4)
                ->where('stock', '!=', 0)
                ->where('nama', 'like', '%' . $this->search . '%')
                ->where('laboratorium_id', $this->labId)
                ->paginate(7);
        }
        $laboratorium = Laboratorium::all();
        $this->name = Laboratorium::whereId($this->labId)->value('nama');
        return view('livewire.barang-search', [
            'barang' => $barang,
            'laboratorium' => $laboratorium
        ]);
    }
}
