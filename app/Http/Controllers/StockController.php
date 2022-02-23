<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stock = DB::table('stock')
            ->leftJoin("barang", "barang.id", "=", "stock.barang_id")
            ->orderBy('stock.created_at', 'desc')
            ->paginate(5);
        return view('backend.stock.index', ['stock' => $stock]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $barang = Barang::all();
        return view('backend.stock.add', compact('barang'));
        // dd($barang);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'barang' => 'required',
            'status' => 'required',
            'jumlah' => 'required',
        ]);

        $data = [
            'barang_id'     => $request->barang,
            'status'        => $request->status,
            'deskripsi'     => $request->deskripsi,
            'inventaris'    => 0,
            'masuk'         => 0,
            'keluar'        => 0,
            'total'         => 0,
        ];
        $random = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
        $sisa = Barang::where('id', $request->barang)->first();
        $total = $request->jumlah;
        if ($request->status == 1) {
            $data['inventaris'] = 'IN' . $random;
            $data['masuk'] = $total;
            $data['keluar'] = 0;
            $data['total'] = $sisa->stock + $total;
            Barang::whereid($request->barang)->update(['stock' => $sisa->stock + $total]);
        } else {
            $data['inventaris'] = 'OUT' . $random;
            $data['masuk'] = 0;
            $data['keluar'] = $total;
            if ($request->status == 2) {
                Barang::whereid($request->barang)->update(['rusak' => $sisa->rusak + $total]);
                $data['deskripsi'] = "Rusak" . " " . $request->deskripsi;
            }
            if ($sisa->stock - $total < 0) {
                return redirect()->route('stock.index')->with('warning', 'Stock Tidak Boleh Kurang dari 0');
            } else {
                $data['total'] = $sisa->stock - $total;
                Barang::whereid($request->barang)->update(['stock' => $sisa->stock - $total]);
            }
        }

        $stock = Stock::create($data);
        if ($stock) {
            return redirect()->route('stock.index')->with('success', 'Stock Berhasil diperbarui!.');
        } else {
            return redirect()->route('stock.index')->with('error', 'Stock Gagal diperbarui!.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function show(Stock $stock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function edit(Stock $stock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stock $stock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stock $stock)
    {
    }
}
