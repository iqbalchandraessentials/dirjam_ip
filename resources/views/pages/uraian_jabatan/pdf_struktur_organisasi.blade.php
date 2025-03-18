<style>
    * {
        font-family: sans-serif;
        font-size: 10;
        letter-spacing: 0px;
    }

    body>* {
        font-size: 85%;
        line-height: 1.3em;
    }

    .mini {
            font-size: 10px;
            font-style: italic;
            display: block;
            font-weight: normal;
            text-align: justify;
        }

        @media print {
            .perkecil {
                width: 300px Imp !important;
            }
    }

    ul li {
        list-style-type: none;
    }

    ul li:before {
        content: "-";
        position: relative;
        left: -10px;
    }

    ul li {
        text-indent: -5px;
    }
    .struktur-organisasi-container {
    display: flex;
    justify-content: center;
    padding: 40px;
    }

    .struktur-organisasi-content {
        display: block;
        margin-bottom: 90px;
    }
</style>

<h3>11. STRUKTUR ORGANISASI</h3>
<small class="mini">
    Memberikan gambaran posisi jabatan tersebut di dalam organisasi, yang memperlihatkan posisi jabatan atasan
    langsung, bawahan langsung serta rekan kerja (peers).
</small>
<br>
<br>
<div class="struktur-organisasi-container">
    <div class="struktur-organisasi-content">
        {!! $data['struktur_organisasi'] !!}
    </div>
</div>
