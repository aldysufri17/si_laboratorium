<div>
    <div class="container">
        <div class="input-group mb-5">
            <div class="input-group-prepend">
                <select class="form-select" wire:model="labId" aria-label="Default select example">
                    <option value="0" disabled selected>Pilih Kategori laboratorium</option>
                    @foreach ($laboratorium as $lab)
                    <option value="{{$lab->id}}">{{$lab->nama}}</option>
                    @endforeach
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
            @if ($labId == 0)
            <div class="card shadow-sm p-3 mb-4 bg-white rounded" style="border-left: solid 4px rgb(19, 233, 0);">
                <div class="card-block">
                    <span class=""><b>Hello..</b></span><br>
                    <p><i class="fa-solid fa-circle-info text-success"></i><b> Pilih Barang Berdasarkan Kategori Laboratorium</b></p>
                </div>
            </div>
            @else
            <div class="card shadow-sm p-3 mb-4 bg-white rounded" style="border-left: solid 4px rgb(0, 54, 233);">
                <div class="card-block">
                    <span class=""><b>Oops!</b></span><br>
                    <p><i class="fa-solid fa-circle-info text-primary"></i><b> Barang {{$name}} Tidak Ditemukan</b></p>
                </div>
            </div>
            @endif
        @endif
    </div>
</div>
