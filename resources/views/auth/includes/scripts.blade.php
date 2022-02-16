<!-- App core JavaScript-->
<script src="{{asset('js/app.js')}}"></script>

<!-- Custom scripts for all pages-->
<script src="{{asset('admin/js/sb-admin-2.min.js')}}"></script>
<script type="text/javascript">
    let scanner = new Instascan.Scanner({
        video: document.getElementById("preview"),
    });

    scanner.addListener("scan", function (content) {
        const data = content;
        const lower = content.toLowerCase();
        // console.log(data.includes("hello"));
        if (lower.includes("s1-teknik komputer") === true) {
            window.location.href = "{{ route('cek')}}";
        } else {
            alert("Maaf anda bukan Mahasiswa Teknik Komputer")
        }
    });

    Instascan.Camera.getCameras()
        .then(function (cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                console.error("No cameras found.");
            }
        })
        .catch(function (e) {
            console.error(e);
        });

</script>