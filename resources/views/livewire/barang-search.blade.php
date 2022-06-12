<div>
    <div class="container">
        <div class="input-group mb-5">
            <div class="input-group-prepend">
                <select class="form-select" wire:model="lab" aria-label="Default select example">
                    <option value="1">Sistem Tertanam dan
                        Robotika</option>
                    <option value="2">Rekayasa Perangkat
                        Lunak</option>
                    <option value="3">Jaringan dan
                        Keamanan Komputer</option>
                    <option value="4">Multimedia</option>
                </select>
            </div>
            <input type="text" class="form-control" wire:model="search" placeholder="Search...">
        </div>
        @if ($barang->isNotEmpty())
        @foreach ($barang as $data)
        <a href="{{route('detail.barang', encrypt($data->id))}}">
            <div class="card items shadow-sm p-4 mb-4 bg-white rounded">
                <div class="card-block">
                    <h4 class="card-title text-dark">{{$data->nama}} - {{$data->tipe}}</h4>
                    <h6 class="card-subtitle mb-2 text-muted">Stock : {{$data->stock}}
                        {{$data->satuan->nama_satuan}}</h6>
                    @if($data->kategori_id != 0)
                    <span class="badge badge-secondary">{{$data->kategori->nama_kategori}}</span>
                    @endif
                    <span class="badge badge-success">Baik</span>
                    <span class="badge badge-primary">{{$data->lokasi}}</span>
                </div>
            </div>
        </a>
        @endforeach
        {{ $barang->links() }}
        @else
        <div class="card shadow-sm p-3 mb-4 bg-white rounded" style="border-left: solid 4px rgb(0, 54, 233);">
            <div class="card-block">
                <span class="">Oops!</span><br>
                <p><i class="fa-solid fa-circle-info text-primary"></i> Barang Tidak Ditemukan</p>
            </div>
        </div>
        @endif
    </div>
</div>
