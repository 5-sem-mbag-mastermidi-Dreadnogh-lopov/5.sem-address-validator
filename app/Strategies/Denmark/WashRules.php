<?php

namespace App\Strategies\Denmark;

class WashRules
{

    public function __construct()
    {

    }

    public static function index(): array
    {
        return [
            'alle'           => 'allé',
            'allé'           => 'alle',
            'gammel'         => 'gl',
            'kgs'            => 'kongens',
            'kgs.'           => 'kongens',
            'sankt'          => 'skt',
            'christian'      => 'chr',
            'chr'            => 'chr.',
            'chr.'           => 'christian',
            'hc'             => 'h.c.',
            'ST'             => 'STORE',
            'AA'             => 'Å',
            'AVDE'           => 'AUDE',
            'BVD.'           => 'BOULEVARD',
            'BVD'            => 'BOULEVARD',
            'BOULEV.'        => 'BOULEVARD',
            'BOULEV'         => 'BOULEVARD',
            'ARN.'           => 'ARNOLD',
            'ARN'            => 'ARNOLD',
            'LL.'            => 'LILLE',
            'LL'             => 'LILLE',
            'ISL.'           => 'ISLANDS',
            'NDR.'           => 'NORDRE',
            'NDR'            => 'NORDRE',
            'NR'             => 'NØRRE',
            'NR.'            => 'NØRRE',
            'NORDER'         => 'NORDRE',
            'SDR.'           => 'SØNDER',
            'SDR'            => 'SØNDER',
            'SØNDRE'         => 'SØNDER',
            'VESTRE'         => 'VESTER',
            'ØSTRE'          => 'ØSTER',
            'LUDV.'          => 'LUDVIG',
            'LUDV'           => 'LUDVIG',
            'OVERG'          => 'OVERGADEN',
            'OVERG.'         => 'OVERGADEN',
            'BJÆRG'          => 'BJERG',
            'NIKOLAI'        => 'NIKOLAJ',
            'NICOLAI'        => 'NIKOLAJ',
            'NICOLAJ'        => 'NIKOLAJ',
            'KJÆR'           => 'KÆR',
            'BAUN'           => 'BAVN',
            'STR.'           => 'STRAND',
            'KR.'            => 'KRONPRINSESSE',
            'KR '            => 'KRONPRINSESSE',
            'KRONPRINS.'     => 'KRONPRINSESSE',
            'PR.'            => 'PRINSESSE',
            'PR '            => 'PRINSESSE',
            'KVT.'           => 'KVARTER',
            ' KVT'           => 'KVARTER',
            'Ö'              => 'Ø',
            'Ä'              => 'Æ',
            'Ü'              => 'Y',
            'É'              => 'E',
            'Æ'              => 'E',
            'CHR.'           => 'CHRISTIAN',
            'CHR'            => 'CHRISTIAN',
            'BORG.'          => 'BORGMESTER',
            'BORG'           => 'BORGMESTER',
            'BORGM.'         => 'BORGMESTER',
            'BORGM '         => 'BORGMESTER',
            'SCT.'           => 'SANKT',
            'SKT.'           => 'SANKT',
            'SCT '           => 'SANKT',
            'SKT '           => 'SANKT',
            'KGS.'           => 'KONGENS',
            'KGS '           => 'KONGENS',
            'DOKTOR'         => 'DR.',
            'DR.'            => 'DRONNING',
            'DR '            => 'DRONNING',
            'DRON.'          => 'DRONNING',
            'DRONNINGENS'    => 'DRONNING',
            'JOHS.'          => 'JOHANNES',
            'JOHS '          => 'JOHANNES',
            'MICH.'          => 'MICHAEL',
            'MICH '          => 'MICHAEL',
            'VEJEN'          => 'VEJ',
            'GADEN'          => 'GADE',
            'HOVEDE'         => 'HOVED',
            'HVF.'           => 'H/F',
            'HVF '           => 'H/F',
            'HF '            => 'H/F',
            'HF.'            => 'H/F',
            'HAVEFORENINGEN' => 'H/F',
            'HAVEFORENING'   => 'H/F',
            'HAVEFOREN.'     => 'H/F',
            'HAVEFOREN '     => 'H/F',
            'FR.BERG'        => 'FREDERIKSBERG',
            'FR BERG'        => 'FREDERIKSBERG',
            'VILH.'          => 'VILHELM',
            'VILH '          => 'VILHELM',
            '`'              => '',
            'ae'             => 'æ',
            'aa'             => 'å',
            'oe'             => "ø",
        ];
    }
}
