<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StoJobcodeExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data =  $data =  DB::select('SELECT * FROM INTTALENT.sto_jobcode');

        // Convert array of stdClass to array of associative arrays
        return collect($data)->map(function ($item) {
            return (array) $item;
        });
    }

    public function headings(): array
    {
        return [
            "KODE_JABATAN",
            "JOB_ROLE",
            "LEVELING",
            "STRUCTURE",
            "PERSON_ID_PARENT",
            "NAMA_PARENT",
            "NIPEG_PARENT",
            "EMAIL_PARENT",
            "PATH",
            "PARENT_PATH",
            "STATUS",
            "ID",
            "VALID_FROM",
            "VALID_TO",
            "PARENT_NAME",
            "PARENT_POSITION_ID",
            "CHILD_POSITION_ID",
            "CHILD_NAME",
            "PERSON_ID_BAWAHAN",
            "NAMA_BAWAHAN",
            "NIPEG_BAWAHAN",
            "EMAIL_BAWAHAN",
            "MASTER_JABATAN",
            "ORGANIZATION_ID",
            "ORGANIZATION_DESC",
            "MAX_PERSONS",
            "FTE",
            "JOB_ID",
            "JENIS_JABATAN",
            "JEN_P21B",
            "JENJANG",
            "SUBORDINATE_POSITION_ID",
            "FLAG_DEFINITIF",
            "DIREKTORAT",
            "DIVISI",
            "LOCATION_CODE",
            "TOWN_OR_CITY",
            "P22A",
            "POHON_BISNIS",
            "POHON_PROFESI",
            "DAHAN_PROFESI",
            "KODE_NAMA_PROFESI",
            "NAMA_PROFESI",
            "nama_profesi2",
            "POG_MIN",
            "POG_MAX",
            "SINGKATAN_JABATAN",
            "JENIS_PEMBANGKIT",
            "SINGKATAN_JABATAN_CLEAN",
            "UNIT_KD",
            "UNIT_KD_REV",
            "UNIT_NAMA",
            "RE",
            "PEOPLE_GROUP_ID",
            "ORG_ID",
        ];
    }
}
