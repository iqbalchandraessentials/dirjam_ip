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
        $data = DB::select('SELECT SINGKATAN_JABATAN,
        JENIS_PEMBANGKIT,
        SINGKATAN_JABATAN_CLEAN,
        KODE_JABATAN,
        PEOPLE_GROUP_ID,
        ORG_ID,
        LEVELING,
        STRUCTURE,
        PERSON_ID_PARENT,
        NAMA_PARENT,
        NIPEG_PARENT,
        EMAIL_PARENT,
        PATH,
        PARENT_PATH,
        STATUS,
        ID,
        VALID_FROM,
        VALID_TO,
        PARENT_NAME,
        PARENT_POSITION_ID,
        CHILD_POSITION_ID,
        CHILD_NAME,
        PERSON_ID_BAWAHAN,
        NAMA_BAWAHAN,
        NIPEG_BAWAHAN,
        EMAIL_BAWAHAN,
        MASTER_JABATAN,
        ORGANIZATION_ID,
        ORGANIZATION_DESC,
        MAX_PERSONS,
        FTE,
        JOB_ID,
        JENIS_JABATAN,
        JEN_P21B,
        JENJANG,
        SUBORDINATE_POSITION_ID,
        FLAG_DEFINITIF,
        DIREKTORAT,
        DIVISI,
        LOCATION_CODE,
        TOWN_OR_CITY,
        P22A,
        POG_MIN,
        POG_MAX,
        UNIT_KD,
        UNIT_KD_REV,
        UNIT_NAMA,
        RE FROM INTTALENT.sto_jobcode');

        // Convert array of stdClass to array of associative arrays
        return collect($data)->map(function ($item) {
            return (array) $item;
        });
    }

    public function headings(): array
    {
        return [
            "singkatan_jabatan",
            "jenis_pembangkit",
            "singkatan_jabatan_clean",
            "kode_jabatan",
            "people_group_id",
            "org_id",
            "leveling",
            "structure",
            "person_id_parent",
            "nama_parent",
            "nipeg_parent",
            "email_parent",
            "path",
            "parent_path",
            "status",
            "id",
            "valid_from",
            "valid_to",
            "parent_name",
            "parent_position_id",
            "child_position_id",
            "child_name",
            "person_id_bawahan",
            "nama_bawahan",
            "nipeg_bawahan",
            "email_bawahan",
            "master_jabatan",
            "organization_id",
            "organization_desc",
            "max_persons",
            "fte",
            "job_id",
            "jenis_jabatan",
            "jen_p21b",
            "jenjang",
            "subordinate_position_id",
            "flag_definitif",
            "direktorat",
            "divisi",
            "location_code",
            "town_or_city",
            "p22a",
            "pog_min",
            "pog_max",
            "unit_kd",
            "unit_kd_rev",
            "unit_nama",
            "re"
        ];
    }
}
