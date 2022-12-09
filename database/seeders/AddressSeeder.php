<?php

namespace Database\Seeders;

use App\Models\AddressResponse;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        AddressResponse::insert($this->createAddressSeed());
    }

    public function createAddressSeed(): array
    {
        return [
            [
                'id'                => 1,
                'confidence'        => 'sure',
                'address_formatted' => 'Fyrkildevej 104, 1. tv, 9220 Aalborg, Danmark',
                'street_name'       => 'Fyrkildevej',
                'street_number'     => '104, 1. tv',
                'zip_code'          => '9220',
                'city'              => 'Aalborg',
                'state'             => '',
                'country_code'      => 'DK',
                'country_name'      => 'Denmark',
                'latitude'          => 57.02798986,
                'longitude'         => 10.00766145,
                'mainland'          => true,
                'response_json'     => "{\"id\": \"0a3f50c9-fec1-32b8-e044-0003ba298018\", \"d\u00f8r\": \"tv\", \"href\": \"https:\/\/api.dataforsyningen.dk\/adresser\/0a3f50c9-fec1-32b8-e044-0003ba298018\", \"kvhx\": \"08512253_104__1__tv\", \"etage\": \"1\", \"status\": 1, \"historik\": {\"nedlagt\": null, \"\u00e6ndret\": \"2000-02-05T21:27:21.000\", \"oprettet\": \"2000-02-05T21:27:21.000\", \"ikrafttr\u00e6delse\": \"2000-02-05T21:27:21.000\"}, \"darstatus\": 3, \"adgangsadresse\": {\"id\": \"0a3f509c-3e93-32b8-e044-0003ba298018\", \"kvh\": \"08512253_104\", \"DDKN\": {\"km1\": \"1km_6320_561\", \"km10\": \"10km_632_56\", \"m100\": \"100m_63209_5611\"}, \"href\": \"https:\/\/api.dataforsyningen.dk\/adgangsadresser\/0a3f509c-3e93-32b8-e044-0003ba298018\", \"sogn\": {\"href\": \"https:\/\/api.dataforsyningen.dk\/sogne\/8371\", \"kode\": \"8371\", \"navn\": \"N\u00f8rre Tranders\"}, \"zone\": \"Byzone\", \"husnr\": \"104\", \"region\": {\"href\": \"https:\/\/api.dataforsyningen.dk\/regioner\/1081\", \"kode\": \"1081\", \"navn\": \"Region Nordjylland\"}, \"status\": 1, \"brofast\": true, \"ejerlav\": {\"kode\": 2005057, \"navn\": \"Nr. Tranders, Aalborg Jorder\"}, \"kommune\": {\"href\": \"https:\/\/api.dataforsyningen.dk\/kommuner\/0851\", \"kode\": \"0851\", \"navn\": \"Aalborg\"}, \"historik\": {\"nedlagt\": null, \"\u00e6ndret\": \"2018-11-14T13:01:39.204\", \"oprettet\": \"2000-02-05T21:27:21.000\", \"ikrafttr\u00e6delse\": \"2000-02-05T21:27:21.000\"}, \"landsdel\": {\"href\": \"https:\/\/api.dataforsyningen.dk\/landsdele\/DK050\", \"navn\": \"Nordjylland\", \"nuts3\": \"DK050\"}, \"vejpunkt\": {\"id\": \"1f3ece75-af45-11e7-847e-066cff24d637\", \"kilde\": \"Adressemyn\", \"\u00e6ndret\": \"2022-01-04T10:08:30.534848\", \"koordinater\": [10.00766145, 57.02798986], \"n\u00f8jagtighed\": \"A\", \"tekniskstandard\": \"V0\"}, \"darstatus\": 3, \"retskreds\": {\"href\": \"https:\/\/api.dataforsyningen.dk\/retskredse\/1178\", \"kode\": \"1178\", \"navn\": \"Retten i Aalborg\"}, \"storkreds\": {\"href\": \"https:\/\/api.dataforsyningen.dk\/storkredse\/10\", \"navn\": \"Nordjylland\", \"nummer\": \"10\"}, \"vejstykke\": {\"href\": \"https:\/\/api.dataforsyningen.dk\/vejstykker\/851\/2253\", \"kode\": \"2253\", \"navn\": \"Fyrkildevej\", \"adresseringsnavn\": \"Fyrkildevej\"}, \"jordstykke\": {\"href\": \"https:\/\/api.dataforsyningen.dk\/jordstykker\/2005057\/7i\", \"ejerlav\": {\"href\": \"https:\/\/api.dataforsyningen.dk\/ejerlav\/2005057\", \"kode\": 2005057, \"navn\": \"Nr. Tranders, Aalborg Jorder\"}, \"matrikelnr\": \"7i\", \"esrejendomsnr\": \"567836\"}, \"matrikelnr\": \"7i\", \"postnummer\": {\"nr\": \"9220\", \"href\": \"https:\/\/api.dataforsyningen.dk\/postnumre\/9220\", \"navn\": \"Aalborg \u00d8st\"}, \"bebyggelser\": [{\"id\": \"12337669-a10c-6b98-e053-d480220a5a3f\", \"href\": \"https:\/\/api.dataforsyningen.dk\/bebyggelser\/12337669-a10c-6b98-e053-d480220a5a3f\", \"kode\": null, \"navn\": \"N\u00f8rre Tranders\", \"type\": \"bydel\"}, {\"id\": \"12337669-a143-6b98-e053-d480220a5a3f\", \"href\": \"https:\/\/api.dataforsyningen.dk\/bebyggelser\/12337669-a143-6b98-e053-d480220a5a3f\", \"kode\": 10938, \"navn\": \"Aalborg\", \"type\": \"by\"}], \"politikreds\": {\"href\": \"https:\/\/api.dataforsyningen.dk\/politikredse\/1460\", \"kode\": \"1460\", \"navn\": \"Nordjyllands Politi\"}, \"adgangspunkt\": {\"id\": \"0a3f509c-3e93-32b8-e044-0003ba298018\", \"kilde\": 5, \"h\u00f8jde\": 6.7, \"\u00e6ndret\": \"2018-11-14T12:57:46.827\", \"koordinater\": [10.00767943, 57.02821846], \"n\u00f8jagtighed\": \"A\", \"tekstretning\": 200, \"tekniskstandard\": \"TN\"}, \"navngivenvej\": {\"id\": \"d0316ed9-8734-41a5-99a7-92b648fbfdcb\", \"href\": \"https:\/\/api.dataforsyningen.dk\/navngivneveje\/d0316ed9-8734-41a5-99a7-92b648fbfdcb\"}, \"valglandsdel\": {\"href\": \"https:\/\/api.dataforsyningen.dk\/valglandsdele\/C\", \"navn\": \"Midtjylland-Nordjylland\", \"bogstav\": \"C\"}, \"esrejendomsnr\": \"567836\", \"opstillingskreds\": {\"href\": \"https:\/\/api.dataforsyningen.dk\/opstillingskredse\/0090\", \"kode\": \"0090\", \"navn\": \"Aalborg \u00d8st\"}, \"adressebetegnelse\": \"Fyrkildevej 104, 9220 Aalborg \u00d8st\", \"supplerendebynavn\": null, \"afstemningsomr\u00e5de\": {\"href\": \"https:\/\/api.dataforsyningen.dk\/afstemningsomraader\/851\/40\", \"navn\": \"Tornh\u00f8jskolen, Hallen\", \"nummer\": \"40\"}, \"supplerendebynavn2\": null, \"stormodtagerpostnummer\": null}, \"adressebetegnelse\": \"Fyrkildevej 104, 1. tv, 9220 Aalborg \u00d8st\"}"
            ],
            [
                'id'                => 2,
                'confidence'        => 'sure',
                'address_formatted' => 'Pilestræde 1, 1112 København K, Danmark',
                'street_name'       => 'Pilestræde',
                'street_number'     => '1',
                'zip_code'          => '1112',
                'city'              => 'København K',
                'state'             => '',
                'country_code'      => 'DK',
                'country_name'      => 'Denmark',
                'latitude'          => 55.6794797,
                'longitude'         => 12.58115016,
                'mainland'          => true,
                'response_json'     => '{"id": "7ad711d2-e81e-4d0f-aba8-9dc3fdfb8315", "dør": null, "href": "https://api.dataforsyningen.dk/adresser/7ad711d2-e81e-4d0f-aba8-9dc3fdfb8315", "kvhx": "01015520___1_______", "etage": null, "status": 1, "historik": {"nedlagt": null, "ændret": "2014-05-05T19:07:48.577", "oprettet": "2014-05-05T19:07:48.577", "ikrafttrædelse": "2014-05-05T19:07:48.577"}, "darstatus": 3, "adgangsadresse": {"id": "0a3f507a-da60-32b8-e044-0003ba298018", "kvh": "01015520___1", "DDKN": {"km1": "1km_6176_725", "km10": "10km_617_72", "m100": "100m_61762_7251"}, "href": "https://api.dataforsyningen.dk/adgangsadresser/0a3f507a-da60-32b8-e044-0003ba298018", "sogn": {"href": "https://api.dataforsyningen.dk/sogne/7002", "kode": "7002", "navn": "Helligånds"}, "zone": "Byzone", "husnr": "1", "region": {"href": "https://api.dataforsyningen.dk/regioner/1084", "kode": "1084", "navn": "Region Hovedstaden"}, "status": 1, "brofast": true, "ejerlav": {"kode": 2000162, "navn": "Købmager Kvarter, København"}, "kommune": {"href": "https://api.dataforsyningen.dk/kommuner/0101", "kode": "0101", "navn": "København"}, "historik": {"nedlagt": null, "ændret": "2018-07-04T18:00:00.000", "oprettet": "2009-11-25T01:07:37.000", "ikrafttrædelse": "2009-11-25T01:07:37.000"}, "landsdel": {"href": "https://api.dataforsyningen.dk/landsdele/DK011", "navn": "Byen København", "nuts3": "DK011"}, "vejpunkt": {"id": "11edb063-af45-11e7-847e-066cff24d637", "kilde": "Ekstern", "ændret": "2018-05-03T14:08:02.125", "koordinater": [12.58115016, 55.6794797], "nøjagtighed": "B", "tekniskstandard": "V0"}, "darstatus": 3, "retskreds": {"href": "https://api.dataforsyningen.dk/retskredse/1101", "kode": "1101", "navn": "Københavns Byret"}, "storkreds": {"href": "https://api.dataforsyningen.dk/storkredse/1", "navn": "København", "nummer": "1"}, "vejstykke": {"href": "https://api.dataforsyningen.dk/vejstykker/101/5520", "kode": "5520", "navn": "Pilestræde", "adresseringsnavn": "Pilestræde"}, "jordstykke": {"href": "https://api.dataforsyningen.dk/jordstykker/2000162/53", "ejerlav": {"href": "https://api.dataforsyningen.dk/ejerlav/2000162", "kode": 2000162, "navn": "Købmager Kvarter, København"}, "matrikelnr": "53", "esrejendomsnr": "543617"}, "matrikelnr": "53", "postnummer": {"nr": "1112", "href": "https://api.dataforsyningen.dk/postnumre/1112", "navn": "København K"}, "bebyggelser": [{"id": "12337669-d99e-6b98-e053-d480220a5a3f", "href": "https://api.dataforsyningen.dk/bebyggelser/12337669-d99e-6b98-e053-d480220a5a3f", "kode": null, "navn": "Indre By", "type": "bydel"}, {"id": "290f85b8-8c7a-6fd1-e053-d480220af996", "href": "https://api.dataforsyningen.dk/bebyggelser/290f85b8-8c7a-6fd1-e053-d480220af996", "kode": 18368, "navn": "København", "type": "by"}], "politikreds": {"href": "https://api.dataforsyningen.dk/politikredse/1470", "kode": "1470", "navn": "Københavns Politi"}, "adgangspunkt": {"id": "0a3f507a-da60-32b8-e044-0003ba298018", "kilde": 5, "højde": 3.7, "ændret": "2002-04-05T00:00:00.000", "koordinater": [12.58104424, 55.67946202], "nøjagtighed": "A", "tekstretning": 200, "tekniskstandard": "TD"}, "navngivenvej": {"id": "64662afe-f8a3-4546-949c-25c8f8c9ec90", "href": "https://api.dataforsyningen.dk/navngivneveje/64662afe-f8a3-4546-949c-25c8f8c9ec90"}, "valglandsdel": {"href": "https://api.dataforsyningen.dk/valglandsdele/A", "navn": "Hovedstaden", "bogstav": "A"}, "esrejendomsnr": "543617", "opstillingskreds": {"href": "https://api.dataforsyningen.dk/opstillingskredse/0003", "kode": "0003", "navn": "Indre By"}, "adressebetegnelse": "Pilestræde 1, 1112 København K", "supplerendebynavn": null, "afstemningsområde": {"href": "https://api.dataforsyningen.dk/afstemningsomraader/101/11", "navn": "3. Indre By", "nummer": "11"}, "supplerendebynavn2": null, "stormodtagerpostnummer": null}, "adressebetegnelse": "Pilestræde 1, 1112 København K"}'
            ]
        ];
    }
}
