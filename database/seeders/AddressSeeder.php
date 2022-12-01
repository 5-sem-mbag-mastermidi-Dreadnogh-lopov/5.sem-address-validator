<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddressSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('address')->insert([
            'id' => 1,
            'confidence' => 'sure',
            'address_formatted' => 'Fyrkildevej 104, 1. tv, 9220 Aalborg',
            'street_name' => 'Fyrkildevej',
            'street_number' => '104, 1. tv',
            'zip_code'=> '9220',
            'city' => 'Aalborg',
            'state' => '',
            'country_code' => 'DK',
            'country_name' => 'Denmark',
            'latitude' => '57.02798986',
            'longitude'=>'10.00766145',
            'mainland' => true,
            'response_json' => "{\"id\": \"0a3f50c9-fec1-32b8-e044-0003ba298018\", \"d\u00f8r\": \"tv\", \"href\": \"https:\/\/api.dataforsyningen.dk\/adresser\/0a3f50c9-fec1-32b8-e044-0003ba298018\", \"kvhx\": \"08512253_104__1__tv\", \"etage\": \"1\", \"status\": 1, \"historik\": {\"nedlagt\": null, \"\u00e6ndret\": \"2000-02-05T21:27:21.000\", \"oprettet\": \"2000-02-05T21:27:21.000\", \"ikrafttr\u00e6delse\": \"2000-02-05T21:27:21.000\"}, \"darstatus\": 3, \"adgangsadresse\": {\"id\": \"0a3f509c-3e93-32b8-e044-0003ba298018\", \"kvh\": \"08512253_104\", \"DDKN\": {\"km1\": \"1km_6320_561\", \"km10\": \"10km_632_56\", \"m100\": \"100m_63209_5611\"}, \"href\": \"https:\/\/api.dataforsyningen.dk\/adgangsadresser\/0a3f509c-3e93-32b8-e044-0003ba298018\", \"sogn\": {\"href\": \"https:\/\/api.dataforsyningen.dk\/sogne\/8371\", \"kode\": \"8371\", \"navn\": \"N\u00f8rre Tranders\"}, \"zone\": \"Byzone\", \"husnr\": \"104\", \"region\": {\"href\": \"https:\/\/api.dataforsyningen.dk\/regioner\/1081\", \"kode\": \"1081\", \"navn\": \"Region Nordjylland\"}, \"status\": 1, \"brofast\": true, \"ejerlav\": {\"kode\": 2005057, \"navn\": \"Nr. Tranders, Aalborg Jorder\"}, \"kommune\": {\"href\": \"https:\/\/api.dataforsyningen.dk\/kommuner\/0851\", \"kode\": \"0851\", \"navn\": \"Aalborg\"}, \"historik\": {\"nedlagt\": null, \"\u00e6ndret\": \"2018-11-14T13:01:39.204\", \"oprettet\": \"2000-02-05T21:27:21.000\", \"ikrafttr\u00e6delse\": \"2000-02-05T21:27:21.000\"}, \"landsdel\": {\"href\": \"https:\/\/api.dataforsyningen.dk\/landsdele\/DK050\", \"navn\": \"Nordjylland\", \"nuts3\": \"DK050\"}, \"vejpunkt\": {\"id\": \"1f3ece75-af45-11e7-847e-066cff24d637\", \"kilde\": \"Adressemyn\", \"\u00e6ndret\": \"2022-01-04T10:08:30.534848\", \"koordinater\": [10.00766145, 57.02798986], \"n\u00f8jagtighed\": \"A\", \"tekniskstandard\": \"V0\"}, \"darstatus\": 3, \"retskreds\": {\"href\": \"https:\/\/api.dataforsyningen.dk\/retskredse\/1178\", \"kode\": \"1178\", \"navn\": \"Retten i Aalborg\"}, \"storkreds\": {\"href\": \"https:\/\/api.dataforsyningen.dk\/storkredse\/10\", \"navn\": \"Nordjylland\", \"nummer\": \"10\"}, \"vejstykke\": {\"href\": \"https:\/\/api.dataforsyningen.dk\/vejstykker\/851\/2253\", \"kode\": \"2253\", \"navn\": \"Fyrkildevej\", \"adresseringsnavn\": \"Fyrkildevej\"}, \"jordstykke\": {\"href\": \"https:\/\/api.dataforsyningen.dk\/jordstykker\/2005057\/7i\", \"ejerlav\": {\"href\": \"https:\/\/api.dataforsyningen.dk\/ejerlav\/2005057\", \"kode\": 2005057, \"navn\": \"Nr. Tranders, Aalborg Jorder\"}, \"matrikelnr\": \"7i\", \"esrejendomsnr\": \"567836\"}, \"matrikelnr\": \"7i\", \"postnummer\": {\"nr\": \"9220\", \"href\": \"https:\/\/api.dataforsyningen.dk\/postnumre\/9220\", \"navn\": \"Aalborg \u00d8st\"}, \"bebyggelser\": [{\"id\": \"12337669-a10c-6b98-e053-d480220a5a3f\", \"href\": \"https:\/\/api.dataforsyningen.dk\/bebyggelser\/12337669-a10c-6b98-e053-d480220a5a3f\", \"kode\": null, \"navn\": \"N\u00f8rre Tranders\", \"type\": \"bydel\"}, {\"id\": \"12337669-a143-6b98-e053-d480220a5a3f\", \"href\": \"https:\/\/api.dataforsyningen.dk\/bebyggelser\/12337669-a143-6b98-e053-d480220a5a3f\", \"kode\": 10938, \"navn\": \"Aalborg\", \"type\": \"by\"}], \"politikreds\": {\"href\": \"https:\/\/api.dataforsyningen.dk\/politikredse\/1460\", \"kode\": \"1460\", \"navn\": \"Nordjyllands Politi\"}, \"adgangspunkt\": {\"id\": \"0a3f509c-3e93-32b8-e044-0003ba298018\", \"kilde\": 5, \"h\u00f8jde\": 6.7, \"\u00e6ndret\": \"2018-11-14T12:57:46.827\", \"koordinater\": [10.00767943, 57.02821846], \"n\u00f8jagtighed\": \"A\", \"tekstretning\": 200, \"tekniskstandard\": \"TN\"}, \"navngivenvej\": {\"id\": \"d0316ed9-8734-41a5-99a7-92b648fbfdcb\", \"href\": \"https:\/\/api.dataforsyningen.dk\/navngivneveje\/d0316ed9-8734-41a5-99a7-92b648fbfdcb\"}, \"valglandsdel\": {\"href\": \"https:\/\/api.dataforsyningen.dk\/valglandsdele\/C\", \"navn\": \"Midtjylland-Nordjylland\", \"bogstav\": \"C\"}, \"esrejendomsnr\": \"567836\", \"opstillingskreds\": {\"href\": \"https:\/\/api.dataforsyningen.dk\/opstillingskredse\/0090\", \"kode\": \"0090\", \"navn\": \"Aalborg \u00d8st\"}, \"adressebetegnelse\": \"Fyrkildevej 104, 9220 Aalborg \u00d8st\", \"supplerendebynavn\": null, \"afstemningsomr\u00e5de\": {\"href\": \"https:\/\/api.dataforsyningen.dk\/afstemningsomraader\/851\/40\", \"navn\": \"Tornh\u00f8jskolen, Hallen\", \"nummer\": \"40\"}, \"supplerendebynavn2\": null, \"stormodtagerpostnummer\": null}, \"adressebetegnelse\": \"Fyrkildevej 104, 1. tv, 9220 Aalborg \u00d8st\"}"
        ]);
    }
}