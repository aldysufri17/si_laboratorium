<?php

namespace App\Http\Controllers;

use App\Models\PeminjamanBarang;
use Illuminate\Http\Request;

class PeminjamanBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $peminjaman = PeminjamanBarang::all();
        return view('backend.peminjaman.index', compact('peminjaman'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PeminjamanBarang  $peminjamanBarang
     * @return \Illuminate\Http\Response
     */
    public function show(PeminjamanBarang $peminjamanBarang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PeminjamanBarang  $peminjamanBarang
     * @return \Illuminate\Http\Response
     */
    public function edit(PeminjamanBarang $peminjamanBarang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PeminjamanBarang  $peminjamanBarang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PeminjamanBarang $peminjamanBarang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PeminjamanBarang  $peminjamanBarang
     * @return \Illuminate\Http\Response
     */
    public function destroy(PeminjamanBarang $peminjamanBarang)
    {
        //
    }
}
