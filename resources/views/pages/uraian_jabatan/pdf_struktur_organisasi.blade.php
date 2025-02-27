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
</style>

<h3>11. STRUKTUR ORGANISASI</h3>
<small class="mini">
    Memberikan gambaran posisi jabatan tersebut di dalam organisasi, yang memperlihatkan posisi jabatan atasan
    langsung, bawahan langsung serta rekan kerja (peers).
</small>
<br>
<br>
<div style="width: 100%; height: auto;">
    <div style="transform: scale(0.7); transform-origin: top center">
        {!! $data['struktur_organisasi'] !!}
</div>
</div>
