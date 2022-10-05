<?php

namespace Database\Seeders;

use App\Models\Services;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('services')->delete();
        $services = [
            [
                'invoice_number' => '51',
                'price' => '300',
                'quantity' => '1',
                'description' => 'ΚΑΤΑΣΚΕΥΗ FRONT-END EDITING SYSTEM'
            ],
            [
                'invoice_number' => '51',
                'price' => '600',
                'quantity' => '1',
                'description' => 'ΚΑΤΑΣΚΕΥΗ ΝΕΑΣ ΙΣΤΟΣΕΛΙΔΑΣ'
            ],
            [
                'invoice_number' => '52',
                'price' => '80',
                'quantity' => '1',
                'description' => 'ΑΝΑΝΕΩΣΗ ΤΗΣ ΕΤΗΣΙΑΣ ΦΙΛΟΞΕΝΙΑΣ ΤΗΣ ΙΣΤΟΣΕΛΙΔΑΣ INMARS.GR'
            ],
            [
                'invoice_number' => '53',
                'price' => '80',
                'quantity' => '1',
                'description' => 'ΑΝΑΝΕΩΣΗ ΤΗΣ ΕΤΗΣΙΑΣ ΦΙΛΟΞΕΝΙΑΣ ΤΗΣ ΙΣΤΟΣΕΛΙΔΑΣ PAPADOSXOLI.GR'
            ],
            [
                'invoice_number' => '54',
                'price' => '50',
                'quantity' => '1',
                'description' => 'ΓΡΑΦΙΣΤΙΚΟΣ ΣΧΕΔΙΑΣΜΟΣ ΕΤΑΙΡΙΚΗΣ ΕΠΑΓΓΕΛΜΑΤΙΚΗΣ ΚΑΡΤΑΣ'
            ],
            [
                'invoice_number' => '55',
                'price' => '80',
                'quantity' => '1',
                'description' => 'ΑΝΑΝΕΩΣΗ ΤΗΣ ΕΤΗΣΙΑΣ ΦΙΛΟΞΕΝΙΑΣ ΤΗΣ ΙΣΤΟΣΕΛΙΔΑΣ FOREVERMORE.GR'
            ],
            [
                'invoice_number' => '56',
                'price' => '560',
                'quantity' => '1',
                'description' => 'ΚΑΤΑΣΚΕΥΗ ΥΠΟΣΕΛΙΔΑΣ ΣΤΗΝ ΙΣΤΟΣΕΛΙΔΑ ENTERPRISEGREECE.GOV.GR ΓΙΑ ΤΗ ΔΡΑΣΗ SYNERGASSIA CYPRUS 2019'
            ],
            [
                'invoice_number' => '57',
                'price' => '800',
                'quantity' => '1',
                'description' => 'ΜΗΝΙΑΙΑ ΤΕΧΝΙΚΗ ΥΠΟΣΤΗΡΙΞΗ ΓΙΑ ΤΗΝ ΙΣΤΟΣΕΛΙΔΑ ENTERPRISEGREECE.GOV.GR ΓΙΑ ΤΟΝ ΜΗΝΑ ΙΑΝΟΥΑΡΙΟ 2019 ΒΑΣΕΙ ΣΥΜΒΑΣΗΣ'
            ],
            [
                'invoice_number' => '58',
                'price' => '80',
                'quantity' => '1',
                'description' => 'ΕΓΚΑΤΑΣΤΑΣΗ ΚΑΙ ΡΥΘΜΙΣΗ ΓΕΦΥΡΑΣ ΠΛΗΡΩΜΩΝ ΜΕ ΤΗΝ ΕΘΝΙΚΗ ΤΡΑΠΕΖΑ'
            ],
            [
                'invoice_number' => '59',
                'price' => '650',
                'quantity' => '1',
                'description' => 'ΚΑΤΑΣΚΕΥΗ ΜΙΝΙ ΙΣΤΟΣΕΛΙΔΑΣ ΓΙΑ ΤΗΝ ΕΚΘΕΣΗ GULFOOD 2019'
            ],
            [
                'invoice_number' => '60',
                'price' => '800',
                'quantity' => '1',
                'description' => 'ΣΧΕΔΙΑΣΜΟΣ BOOKLET ΕΞΗΝΤΑ (60) ΣΕΛΙΔΩΝ'
            ],
            [
                'invoice_number' => '61',
                'price' => '90',
                'quantity' => '1',
                'description' => 'ΕΤΗΣΙΑ ΦΙΛΟΞΕΝΙΑ ΤΗΣ ΙΣΤΟΣΕΛΙΔΑΣ MLIFT.GR ΓΙΑ ΤΟ ΕΤΟΣ 2019'
            ],
            [
                'invoice_number' => '62',
                'price' => '60',
                'quantity' => '1',
                'description' => 'ΠΡΟΣΑΡΜΟΓΗ WEB VIDEO, ΣΤΗΝ ΑΡΧΙΚΗ ΣΕΛΙΔΑ ΤΟΥ FUTURE.COM.GR'
            ],
            [
                'invoice_number' => '63',
                'price' => '1200',
                'quantity' => '1',
                'description' => 'ΚΑΤΑΣΚΕΥΗ ΙΣΤΟΣΕΛΙΔΑΣ GREEK-JEWELS.GR'
            ],
            [
                'invoice_number' => '64',
                'price' => '800',
                'quantity' => '1',
                'description' => 'ΜΗΝΙΑΙΑ ΤΕΧΝΙΚΗ ΥΠΟΣΤΗΡΙΞΗ ΓΙΑ ΤΗΝ ΙΣΤΟΣΕΛΙΔΑ ENTERPRISEGREECE.GOV.GR ΓΙΑ ΤΟΝ ΜΗΝΑ ΦΕΒΡΟΥΑΡΙΟ 2019 ΒΑΣΕΙ ΣΥΜΒΑΣΗΣ'
            ],
            [
                'invoice_number' => '65',
                'price' => '400',
                'quantity' => '1',
                'description' => 'ΚΑΤΑΣΚΕΥΗ ΜΙΝΙ ΙΣΤΟΣΕΛΙΔΑΣ GIOCHI PREZIOSI  L.O.L. SURPRISE - ΛΑΜΠΑΔΑ ΜΥΣΤΙΚΟ ΜΑΞΙΛΑΡΙ'
            ],
            [
                'invoice_number' => '66',
                'price' => '650',
                'quantity' => '1',
                'description' => 'ΚΑΤΑΣΚΕΥΗ ΜΙΝΙ ΙΣΤΟΣΕΛΙΔΑΣ ΓΙΑ ΤΗΝ ΕΚΘΕΣΗ PROWEIN 2019'
            ],
            [
                'invoice_number' => '67',
                'price' => '800',
                'quantity' => '1',
                'description' => 'ΜΗΝΙΑΙΑ ΤΕΧΝΙΚΗ ΥΠΟΣΤΗΡΙΞΗ ΓΙΑ ΤΗΝ ΙΣΤΟΣΕΛΙΔΑ ENTERPRISEGREECE.GOV.GR ΓΙΑ ΤΟΝ ΜΗΝΑ ΜΑΡΤΙΟ 2019 ΒΑΣΕΙ ΣΥΜΒΑΣΗΣ'
            ],
            [
                'invoice_number' => '68',
                'price' => '30',
                'quantity' => '1',
                'description' => 'ΠΡΟΘΗΚΗ ΑΡΧΕΙΩΝ PDF ΓΙΑ IPIDS'
            ],
            [
                'invoice_number' => '68',
                'price' => '30',
                'quantity' => '1',
                'description' => 'ΑΝΑΡΤΗΣΗ ΑΝΑΚΟΙΝΩΣΗΣ'
            ],
            [
                'invoice_number' => '68',
                'price' => '60',
                'quantity' => '1',
                'description' => 'ΠΡΟΘΗΚΗ ΑΡΧΕΙΩΝ PDF ΓΙΑ IPIDS'
            ],
            [
                'invoice_number' => '68',
                'price' => '80',
                'quantity' => '1',
                'description' => 'ΚΑΤΑΣΚΕΥΗ ΑΡΘΡΟΥ ΣΥΜΦΩΝΑ ΜΕ ΣΧΕΔΙΑΣΜΟ'
            ],
            [
                'invoice_number' => '69',
                'price' => '90',
                'quantity' => '1',
                'description' => 'ΑΝΑΝΕΩΣΗ ΕΤΗΣΙΑΣ ΦΙΛΟΞΕΝΙΑΣ ΙΣΤΟΣΕΛΙΔΑΣ CUTTINGPOWER.GR'
            ],
            [
                'invoice_number' => '70',
                'price' => '80',
                'quantity' => '1',
                'description' => 'ΜΗΝΙΑΙΑ ΤΕΧΝΙΚΗ ΥΠΟΣΤΗΡΙΞΗ ΓΙΑ ΤΗΝ ΙΣΤΟΣΕΛΙΔΑ ENTERPRISEGREECE.GOV.GR ΓΙΑ ΤΟΝ ΜΗΝΑ ΑΠΡΙΛΙΟ 2019 ΒΑΣΕΙ ΣΥΜΒΑΣΗΣ'
            ],
            [
                'invoice_number' => '71',
                'price' => '560',
                'quantity' => '1',
                'description' => 'ΚΑΤΑΣΚΕΥΗ ΥΠΟΣΕΛΙΔΑΣ ΣΤΗΝ ΙΣΤΟΣΕΛΙΔΑ ENTERPRISEGREECE.GOV.GR ΓΙΑ ΤΗ ΔΡΑΣΗ SYNERGASSIA LACONIA 2019'
            ],
            [
                'invoice_number' => '72',
                'price' => '800',
                'quantity' => '1',
                'description' => 'ΜΗΝΙΑΙΑ ΤΕΧΝΙΚΗ ΥΠΟΣΤΗΡΙΞΗ ΓΙΑ ΤΗΝ ΙΣΤΟΣΕΛΙΔΑ ENTERPRISEGREECE.GOV.GR ΓΙΑ ΤΟΝ ΜΗΝΑ ΜΑΪΟ 2019 ΒΑΣΕΙ ΣΥΜΒΑΣΗΣ'
            ],
            [
                'invoice_number' => '73',
                'price' => '250',
                'quantity' => '1',
                'description' => 'ΕΙΚΑΣΤΙΚΕΣ ΑΛΛΑΓΕΣ, ΠΡΟΣΑΡΜΟΓΗ VIDEO ΚΑΙ ΑΝΑΠΡΟΣΑΡΜΟΓΗ ΠΕΡΙΕΧΟΜΕΝΟΥ ΣΤΗΝ ΙΣΤΟΣΕΛΙΔΑ AEGEANINSURANCE.GR'
            ],
            [
                'invoice_number' => '74',
                'price' => '80',
                'quantity' => '1',
                'description' => 'ΑΝΑΝΕΩΣΗ ΕΤΗΣΙΑΣ ΦΙΛΟΞΕΝΕΙΑΣ (HOSTING) ΓΙΑ ΤΗΝ ΙΣΤΟΣΕΛΙΔΑ YACHTINGCAPITAL.GR'
            ],
            [
                'invoice_number' => '75',
                'price' => '800',
                'quantity' => '1',
                'description' => 'ΜΗΝΙΑΙΑ ΤΕΧΝΙΚΗ ΥΠΟΣΤΗΡΙΞΗ ΓΙΑ ΤΗΝ ΙΣΤΟΣΕΛΙΔΑ ENTERPRISEGREECE.GOV.GR ΓΙΑ ΤΟΝ ΜΗΝΑ ΙΟΥΛΙΟ 2019 ΒΑΣΕΙ ΣΥΜΒΑΣΗΣ'
            ],
            [
                'invoice_number' => '76',
                'price' => '50',
                'quantity' => '1',
                'description' => 'ΜΕΤΑΦΟΡΑ DOMAIN NAME (HELLENICWAVE.COM) ΣΕ ΑΛΛΟ ΠΑΡΟΧΟ ΚΑΙ ΣΥΝΔΕΣΗ ΜΕ SQUARESPACE ACCOUNT'
            ],
            [
                'invoice_number' => '77',
                'price' => '800',
                'quantity' => '1',
                'description' => 'ΜΗΝΙΑΙΑ ΤΕΧΝΙΚΗ ΥΠΟΣΤΗΡΙΞΗ ΓΙΑ ΤΗΝ ΙΣΤΟΣΕΛΙΔΑ ENTERPRISEGREECE.GOV.GR ΓΙΑ ΤΟΝ ΜΗΝΑ ΑΥΓΟΥΣΤΟ 2019 ΒΑΣΕΙ ΣΥΜΒΑΣΗΣ'
            ],
            [
                'invoice_number' => '78',
                'price' => '120',
                'quantity' => '1',
                'description' => 'ΚΑΤΑΣΚΕΥΗ WEB ΕΦΑΡΜΟΓΗΣ ΓΙΑ ΣΥΛΛΟΓΗ ΑΠΑΝΤΗΣΕΩΝ ΑΠΟ NEWSLETTER ΣΧΕΤΙΚΑ ΜΕ ΤΗ 84η ΔΕΘ'
            ],
            [
                'invoice_number' => '78',
                'price' => '20',
                'quantity' => '1',
                'description' => 'ΑΓΟΡΑ DOMAIN ELTA-EVENTS.GR'
            ],
            [
                'invoice_number' => '78',
                'price' => '90',
                'quantity' => '1',
                'description' => 'ΦΙΛΟΞΕΝΕΙΑ ΓΙΑ ΕΝΑ ΕΤΟΣ'
            ],
            [
                'invoice_number' => '78',
                'price' => '55',
                'quantity' => '1',
                'description' => 'ΑΠΟΣΤΟΛΗ NEWSLETTERS'
            ],
            [
                'invoice_number' => '79',
                'price' => '400',
                'quantity' => '1',
                'description' => 'ΚΑΤΑΣΚΕΥΗ ΙΣΤΟΣΕΛΙΔΑΣ ONETEAM.GR ΜΕ ΣΥΣΤΗΜΑ FRONT-END EDITING'
            ],
            [
                'invoice_number' => '80',
                'price' => '650',
                'quantity' => '1',
                'description' => 'ΚΑΤΑΣΚΕΥΗ ΜΙΝΙ ΙΣΤΟΣΕΛΙΔΑΣ ΓΙΑ ΤΗΝ ΕΚΘΕΣΗ SUMMER FANCY FOOD SHOW 2019'
            ],
            [
                'invoice_number' => '81',
                'price' => '650',
                'quantity' => '1',
                'description' => 'ΚΑΤΑΣΚΕΥΗ ΜΙΝΙ ΙΣΤΟΣΕΛΙΔΑΣ ΓΙΑ ΤΗΝ ΕΚΘΕΣΗ ANUGA 2019'
            ],
            [
                'invoice_number' => '82',
                'price' => '450',
                'quantity' => '1',
                'description' => 'ΔΙΑΧΕΙΡΙΣΗ ΚΑΙ ΕΙΣΑΓΩΓΗ ΠΕΡΙΕΧΟΜΕΝΟΥ ΣΤΗΝ ΙΣΤΟΣΕΛΙΔΑ GREEKJEWELLS.GR'
            ],
            [
                'invoice_number' => '83',
                'price' => '50',
                'quantity' => '1',
                'description' => 'ΤΕΧΝΙΚΗ ΥΠΟΣΤΗΡΙΞΗ ΓΙΑ ΤΗΝ ΙΣΤΟΣΕΛΙΔΑ TRIATHLONCOACH.GR ΓΙΑ ΤΟ ΜΗΝΑ ΣΕΠΤΕΜΒΡΙΟ'
            ],
            [
                'invoice_number' => '83',
                'price' => '50',
                'quantity' => '1',
                'description' => 'ΤΕΧΝΙΚΗ ΥΠΟΣΤΗΡΙΞΗ ΓΙΑ ΤΗΝ ΙΣΤΟΣΕΛΙΔΑ TRIATHLONCOACH.GR ΓΙΑ ΤΟ ΜΗΝΑ ΟΚΤΩΒΡΙΟ'
            ],
            [
                'invoice_number' => '84',
                'price' => '90',
                'quantity' => '1',
                'description' => 'ΑΝΑΝΕΩΣΗ ΧΩΡΟΥ ΦΙΛΟΞΕΝΙΑΣ ΓΙΑ ΤΗΝ ΙΣΤΟΣΕΛΙΔΑ DENTAL4ALL.COM.GR'
            ],
            [
                'invoice_number' => '84',
                'price' => '20',
                'quantity' => '1',
                'description' => 'ΑΝΑΝΕΩΣΗ ΟΝΟΜΑΤΟΣ ΧΩΡΟΥ (DOMAIN) ΓΙΑ 2 ΕΤΗ'
            ],
            [
                'invoice_number' => '85',
                'price' => '800',
                'quantity' => '1',
                'description' => 'ΜΗΝΙΑΙΑ ΤΕΧΝΙΚΗ ΥΠΟΣΤΗΡΙΞΗ ΓΙΑ ΤΗΝ ΙΣΤΟΣΕΛΙΔΑ ENTERPRISEGREECE.GOV.GR ΓΙΑ ΤΟΝ ΜΗΝΑ ΣΕΠΤΕΜΒΡΙΟ 2019 ΒΑΣΕΙ ΣΥΜΒΑΣΗΣ'
            ],
            [
                'invoice_number' => '86',
                'price' => '800',
                'quantity' => '1',
                'description' => 'ΜΗΝΙΑΙΑ ΤΕΧΝΙΚΗ ΥΠΟΣΤΗΡΙΞΗ ΓΙΑ ΤΗΝ ΙΣΤΟΣΕΛΙΔΑ ENTERPRISEGREECE.GOV.GR ΓΙΑ ΤΟΝ ΜΗΝΑ ΟΚΤΩΒΡΙΟ 2019 ΒΑΣΕΙ ΣΥΜΒΑΣΗΣ'
            ],
            [
                'invoice_number' => '87',
                'price' => '800',
                'quantity' => '1',
                'description' => 'ΜΗΝΙΑΙΑ ΤΕΧΝΙΚΗ ΥΠΟΣΤΗΡΙΞΗ ΓΙΑ ΤΗΝ ΙΣΤΟΣΕΛΙΔΑ ENTERPRISEGREECE.GOV.GR ΓΙΑ ΤΟΝ ΜΗΝΑ ΝΟΕΜΒΡΙΟ 2019 ΒΑΣΕΙ ΣΥΜΒΑΣΗΣ'
            ],
            [
                'invoice_number' => '88',
                'price' => '850',
                'quantity' => '1',
                'description' => 'ΚΑΤΑΣΚΕΥΗ ΙΣΤΟΣΕΛΙΔΑΣ TROULISLAW.COM ΜΕ ΣΥΣΤΗΜΑ FRONT-END EDITING'
            ],
            [
                'invoice_number' => '89',
                'price' => '120',
                'quantity' => '1',
                'description' => 'ΕΤΗΣΙΑ ΦΙΛΟΞΕΝΙΑ TROULISLAW.COM'
            ],
            [
                'invoice_number' => '90',
                'price' => '50',
                'quantity' => '1',
                'description' => 'ΤΕΧΝΙΚΗ ΥΠΟΣΤΗΡΙΞΗ ΓΙΑ ΤΗΝ ΙΣΤΟΣΕΛΙΔΑ TRIATHLONCOACH.GR ΓΙΑ ΤΟ ΜΗΝΑ ΝΟΕΜΒΡΙΟ 2019'
            ],
            [
                'invoice_number' => '90',
                'price' => '50',
                'quantity' => '1',
                'description' => 'ΤΕΧΝΙΚΗ ΥΠΟΣΤΗΡΙΞΗ ΓΙΑ ΤΗΝ ΙΣΤΟΣΕΛΙΔΑ TRIATHLONCOACH.GR ΓΙΑ ΤΟ ΜΗΝΑ ΔΕΚΕΜΒΡΙΟ 2019'
            ],
            [
                'invoice_number' => '91',
                'price' => '800',
                'quantity' => '1',
                'description' => 'ΜΗΝΙΑΙΑ ΤΕΧΝΙΚΗ ΥΠΟΣΤΗΡΙΞΗ ΓΙΑ ΤΗΝ ΙΣΤΟΣΕΛΙΔΑ ENTERPRISEGREECE.GOV.GR ΓΙΑ ΤΟΝ ΜΗΝΑ ΔΕΚΕΜΒΡΙΟ 2019 ΒΑΣΕΙ ΣΥΜΒΑΣΗΣ'
            ],
            [
                'invoice_number' => '92',
                'price' => '90',
                'quantity' => '1',
                'description' => 'ΕΤΗΣΙΑ ΦΙΛΟΞΕΝΙΑ (HOSTING) ΓΙΑ ΤΗΝ ΙΣΤΟΣΕΛΙΔΑ PAPADOSXOLI.GR'
            ],
            [
                'invoice_number' => '93',
                'price' => '800',
                'quantity' => '1',
                'description' => 'ΜΗΝΙΑΙΑ ΤΕΧΝΙΚΗ ΥΠΟΣΤΗΡΙΞΗ ΓΙΑ ΤΗΝ ΙΣΤΟΣΕΛΙΔΑ ENTERPRISEGREECE.GOV.GR ΓΙΑ ΤΟΝ ΜΗΝΑ ΙΑΝΟΥΑΡΙΟ 2020 ΒΑΣΕΙ ΣΥΜΒΑΣΗΣ'
            ],
            [
                'invoice_number' => '94',
                'price' => '300',
                'quantity' => '1',
                'description' => 'ΚΑΤΑΣΚΕΥΗ ΣΥΣΤΗΜΑΤΟΣ E-PAYMENT ΣΤΗΝ ΙΣΤΟΣΕΛΙΔΑ AEGEANINSURANCE.GR'
            ],
            [
                'invoice_number' => '95',
                'price' => '250',
                'quantity' => '1',
                'description' => 'ΑΝΑΠΡΟΣΑΡΜΟΓΗ ΕΙΚΑΣΤΙΚΟΥ ΣΧΕΔΙΑΣΜΟΥ ΣΤΟΝ ΤΟΜΕΑ B2B TOY DIMITRIOS-EXCLUSIVE.GR'
            ],
            [
                'invoice_number' => '95',
                'price' => '300',
                'quantity' => '1',
                'description' => 'ΔΙΑΦΟΡΟΠΟΙΗΣΗ ΤΙΜΩΝ ΤΩΝ ΠΡΟΪΟΝΤΩΝ ΜΕ ΚΡΙΤΗΡΙΟ ΤΗΝ ΧΩΡΑ ΤΟΥ ΠΕΛΑΤΗ'
            ],
            [
                'invoice_number' => '96',
                'price' => '300',
                'quantity' => '1',
                'description' => 'ΑΝΑΝΕΩΣΗ ΕΤΗΣΙΑΣ ΦΙΛΟΞΕΝΙΑΣ ΓΙΑ ΤΗΝ ΙΣΤΟΣΕΛΙΔΑ MLIFT.GR'
            ],
            [
                'invoice_number' => '96',
                'price' => '300',
                'quantity' => '1',
                'description' => 'ΑΝΑΝΕΩΣΗ ΟΝΟΜΑΤΟΣ DOMAIN MLIFT.GR ΓΙΑ ΔΥΟ ΕΤΗ'
            ],
            [
                'invoice_number' => '97',
                'price' => '800',
                'quantity' => '1',
                'description' => 'ΜΗΝΙΑΙΑ ΤΕΧΝΙΚΗ ΥΠΟΣΤΗΡΙΞΗ ΓΙΑ ΤΗΝ ΙΣΤΟΣΕΛΙΔΑ ENTERPRISEGREECE.GOV.GR ΓΙΑ ΤΟΝ ΜΗΝΑ ΦΕΒΡΟΥΑΡΙΟ 2020 ΒΑΣΕΙ ΣΥΜΒΑΣΗΣ'
            ],
            [
                'invoice_number' => '98',
                'price' => '800',
                'quantity' => '1',
                'description' => 'ΜΗΝΙΑΙΑ ΤΕΧΝΙΚΗ ΥΠΟΣΤΗΡΙΞΗ ΓΙΑ ΤΗΝ ΙΣΤΟΣΕΛΙΔΑ ENTERPRISEGREECE.GOV.GR ΓΙΑ ΤΟΝ ΜΗΝΑ ΜΑΡΤΙΟ 2020 ΒΑΣΕΙ ΣΥΜΒΑΣΗΣ'
            ],
            [
                'invoice_number' => '99',
                'price' => '400',
                'quantity' => '1',
                'description' => 'ΕΠΑΝΑΣΧΕΔΙΑΣΜΟΣ ΤΗΣ ΑΡΧΙΚΗΣ ΣΕΛΙΔΑΣ ΤΟΥ ENTERPRISEGREECE.GOV.GR'
            ],
            [
                'invoice_number' => '99',
                'price' => '800',
                'quantity' => '1',
                'description' => 'ΥΛΟΠΟΙΗΣΗ ΕΠΑΝΑΣΧΕΔΙΑΣΜΟΥ ΤΗΣ ΑΡΧΙΚΗΣ ΣΕΛΙΔΑΣ ΤΟΥ ENTERPRISEGREECE.GOV.GR'
            ],
            [
                'invoice_number' => '100',
                'price' => '700',
                'quantity' => '1',
                'description' => 'ΚΑΤΑΣΚΕΥΗ ΕΝΗΜΕΡΩΤΙΚΗΣ ΣΕΛΙΔΑΣ ΣΧΕΤΙΚΑ ΜΕ ΤΟΝ COVID-19'
            ],
            [
                'invoice_number' => '101',
                'price' => '800',
                'quantity' => '1',
                'description' => 'ΜΗΝΙΑΙΑ ΤΕΧΝΙΚΗ ΥΠΟΣΤΗΡΙΞΗ ΓΙΑ ΤΗΝ ΙΣΤΟΣΕΛΙΔΑ ENTERPRISEGREECE.GOV.GR ΓΙΑ ΤΟΝ ΜΗΝΑ ΑΠΡΙΛΙΟ 2020 ΒΑΣΕΙ ΣΥΜΒΑΣΗΣ'
            ],
            [
                'invoice_number' => '102',
                'price' => '800',
                'quantity' => '1',
                'description' => 'ΜΗΝΙΑΙΑ ΤΕΧΝΙΚΗ ΥΠΟΣΤΗΡΙΞΗ ΓΙΑ ΤΗΝ ΙΣΤΟΣΕΛΙΔΑ ENTERPRISEGREECE.GOV.GR ΓΙΑ ΤΟΝ ΜΗΝΑ ΜΑΪΟ 2020 ΒΑΣΕΙ ΣΥΜΒΑΣΗΣ'
            ],
            [
                'invoice_number' => '103',
                'price' => '800',
                'quantity' => '1',
                'description' => 'ΜΗΝΙΑΙΑ ΤΕΧΝΙΚΗ ΥΠΟΣΤΗΡΙΞΗ ΓΙΑ ΤΗΝ ΙΣΤΟΣΕΛΙΔΑ ENTERPRISEGREECE.GOV.GR ΓΙΑ ΤΟΝ ΜΗΝΑ ΙΟΥΝΙΟ 2020 ΒΑΣΕΙ ΣΥΜΒΑΣΗΣ'
            ],
            [
                'invoice_number' => '104',
                'price' => '1630',
                'quantity' => '1',
                'description' => 'ΚΑΤΑΣΚΕΥΗ ΗΛΕΚΤΡΟΝΙΚΟΥ ΚΑΤΑΣΤΗΜΑΤΟΣ SANUSVITA.GR'
            ],
            [
                'invoice_number' => '105',
                'price' => '800',
                'quantity' => '1',
                'description' => 'ΜΗΝΙΑΙΑ ΤΕΧΝΙΚΗ ΥΠΟΣΤΗΡΙΞΗ ΓΙΑ ΤΗΝ ΙΣΤΟΣΕΛΙΔΑ ENTERPRISEGREECE.GOV.GR ΓΙΑ ΤΟΝ ΜΗΝΑ ΙΟΥΛΙΟ 2020 ΒΑΣΕΙ ΣΥΜΒΑΣΗΣ'
            ],
            [
                'invoice_number' => '106',
                'price' => '800',
                'quantity' => '1',
                'description' => 'ΜΗΝΙΑΙΑ ΤΕΧΝΙΚΗ ΥΠΟΣΤΗΡΙΞΗ ΓΙΑ ΤΗΝ ΙΣΤΟΣΕΛΙΔΑ ENTERPRISEGREECE.GOV.GR ΓΙΑ ΤΟΝ ΜΗΝΑ ΑΥΓΟΥΣΤΟ 2020 ΒΑΣΕΙ ΣΥΜΒΑΣΗΣ'
            ],
            [
                'invoice_number' => '107',
                'price' => '6000',
                'quantity' => '1',
                'description' => 'ΚΑΤΑΣΚΕΥΗ ΣΥΣΤΗΜΑΤΟΣ ΔΗΜΟΣΙΑΣ ΔΙΑΒΟΥΛΕΥΣΗΣ ΣΤΗΝ ΙΣΤΟΣΕΛΙΔΑ ENTERPRISEGREECE.GOV.GR'
            ],
            [
                'invoice_number' => '108',
                'price' => '600',
                'quantity' => '1',
                'description' => 'ΚΑΤΑΣΚΕΥΗ ΙΣΤΟΣΕΛΙΔΑΣ M2.GR'
            ],
            [
                'invoice_number' => '109',
                'price' => '800',
                'quantity' => '1',
                'description' => 'ΜΗΝΙΑΙΑ ΤΕΧΝΙΚΗ ΥΠΟΣΤΗΡΙΞΗ ΓΙΑ ΤΗΝ ΙΣΤΟΣΕΛΙΔΑ ENTERPRISEGREECE.GOV.GR ΓΙΑ ΤΟΝ ΜΗΝΑ ΣΕΠΤΕΜΒΡΙΟ 2020 ΒΑΣΕΙ ΣΥΜΒΑΣΗΣ'
            ],
            [
                'invoice_number' => '110',
                'price' => '800',
                'quantity' => '1',
                'description' => 'ΜΗΝΙΑΙΑ ΤΕΧΝΙΚΗ ΥΠΟΣΤΗΡΙΞΗ ΓΙΑ ΤΗΝ ΙΣΤΟΣΕΛΙΔΑ ENTERPRISEGREECE.GOV.GR ΓΙΑ ΤΟΝ ΜΗΝΑ ΟΚΤΩΒΡΙΟ 2020 ΒΑΣΕΙ ΣΥΜΒΑΣΗΣ'
            ],
            [
                'invoice_number' => '111',
                'price' => '158',
                'quantity' => '1',
                'description' => 'ΜΟΡΦΟΠΟΙΗΣΗ EMAIL ΠΑΡΑΓΓΕΛΙΑΣ ΓΙΑ E-SHOP'
            ],
            [
                'invoice_number' => '112',
                'price' => '400',
                'quantity' => '1',
                'description' => 'ΕΠΙΚΑΙΡΟΠΟΙΗΣΗ ΕΡΓΑΛΕΙΩΝ ΣΤΗΝ ΙΣΤΟΣΕΛΙΔΑ ΤΗΣ ΕΛΙΞ'
            ],
            [
                'invoice_number' => '113',
                'price' => '60',
                'quantity' => '4',
                'description' => 'ΠΑΡΟΧΗ ΥΠΟΣΤΗΡΙΞΗΣ ΣΕ WEBINAR - DOING BUSINESS IN GERMANY'
            ],
            [
                'invoice_number' => '113',
                'price' => '60',
                'quantity' => '3',
                'description' => 'ΠΑΡΟΧΗ ΥΠΟΣΤΗΡΙΞΗΣ ΣΕ WEBINAR - DOING BUSINESS IN SOUTH KOREA'
            ],
            [
                'invoice_number' => '114',
                'price' => '60',
                'quantity' => '3',
                'description' => 'ΠΑΡΟΧΗ ΥΠΟΣΤΗΡΙΞΗΣ ΣΕ WEBINAR - TECH TUESDAYS 03/11'
            ],
            [
                'invoice_number' => '114',
                'price' => '60',
                'quantity' => '4',
                'description' => 'ΠΑΡΟΧΗ ΥΠΟΣΤΗΡΙΞΗΣ ΣΕ WEBINAR - TECH TUESDAYS 10/11'
            ],
            [
                'invoice_number' => '114',
                'price' => '60',
                'quantity' => '3',
                'description' => 'ΠΑΡΟΧΗ ΥΠΟΣΤΗΡΙΞΗΣ ΣΕ WEBINAR - TECH TUESDAYS 19/11'
            ],
            [
                'invoice_number' => '114',
                'price' => '60',
                'quantity' => '2',
                'description' => 'ΠΑΡΟΧΗ ΥΠΟΣΤΗΡΙΞΗΣ ΣΕ WEBINAR - TECH TUESDAYS 24/11'
            ],
            [
                'invoice_number' => '115',
                'price' => '800',
                'quantity' => '1',
                'description' => 'ΜΗΝΙΑΙΑ ΤΕΧΝΙΚΗ ΥΠΟΣΤΗΡΙΞΗ ΓΙΑ ΤΗΝ ΙΣΤΟΣΕΛΙΔΑ ENTERPRISEGREECE.GOV.GR ΓΙΑ ΤΟΝ ΜΗΝΑ ΝΟΕΜΒΡΙΟ 2020 ΒΑΣΕΙ ΣΥΜΒΑΣΗΣ'
            ],
            [
                'invoice_number' => '116',
                'price' => '2000',
                'quantity' => '1',
                'description' => 'ΚΑΤΑΣΚΕΥΗ ΕΝΟΤΗΤΑΣ SYNERGASSIA REGIONAL COMPASS ΣΤΗΝ ΙΣΤΟΣΕΛΙΔΑ ENTERPRISEGREECE.GOV.GR'
            ],
            [
                'invoice_number' => '117',
                'price' => '800',
                'quantity' => '1',
                'description' => 'ΜΗΝΙΑΙΑ ΤΕΧΝΙΚΗ ΥΠΟΣΤΗΡΙΞΗ ΓΙΑ ΤΗΝ ΙΣΤΟΣΕΛΙΔΑ ENTERPRISEGREECE.GOV.GR ΓΙΑ ΤΟΝ ΜΗΝΑ ΔΕΚΕΜΒΡΙΟ 2020 ΒΑΣΕΙ ΣΥΜΒΑΣΗΣ'
            ],
            [
                'invoice_number' => '118',
                'price' => '2000',
                'quantity' => '1',
                'description' => 'ΚΑΤΑΣΚΕΥΗ ΔΥΝΑΜΙΚΗΣ ΙΣΤΟΣΕΛΙΔΑΣ ΠΟΛΛΑΠΛΟΥ ΣΚΟΠΟΥ (THEME)'
            ],
            [
                'invoice_number' => '119',
                'price' => '800',
                'quantity' => '1',
                'description' => 'ΜΗΝΙΑΙΑ ΤΕΧΝΙΚΗ ΥΠΟΣΤΗΡΙΞΗ ΓΙΑ ΤΗΝ ΙΣΤΟΣΕΛΙΔΑ ENTERPRISEGREECE.GOV.GR ΓΙΑ ΤΟΝ ΜΗΝΑ ΙΑΝΟΥΑΡΙΟ 2021 ΒΑΣΕΙ ΣΥΜΒΑΣΗΣ'
            ],
            [
                'invoice_number' => '120',
                'price' => '60',
                'quantity' => '3',
                'description' => 'ΠΑΡΟΧΗ ΥΠΟΣΤΗΡΙΞΗΣ ΣΕ WEBINAR - TECH TUESDAYS 01/12'
            ],
            [
                'invoice_number' => '120',
                'price' => '60',
                'quantity' => '3',
                'description' => 'ΠΑΡΟΧΗ ΥΠΟΣΤΗΡΙΞΗΣ ΣΕ WEBINAR - TECH TUESDAYS 01/12'
            ],
            [
                'invoice_number' => '120',
                'price' => '60',
                'quantity' => '3',
                'description' => 'ΠΑΡΟΧΗ ΥΠΟΣΤΗΡΙΞΗΣ ΣΕ WEBINAR - TECH TUESDAYS 08/12'
            ],
            [
                'invoice_number' => '120',
                'price' => '60',
                'quantity' => '3',
                'description' => 'ΠΑΡΟΧΗ ΥΠΟΣΤΗΡΙΞΗΣ ΣΕ WEBINAR - TECH TUESDAYS 15/12'
            ],
            [
                'invoice_number' => '121',
                'price' => '60',
                'quantity' => '4',
                'description' => 'ΠΑΡΟΧΗ ΥΠΟΣΤΗΡΙΞΗΣ ΣΕ WEBINAR - TECH TUESDAYS 12/01'
            ],
            [
                'invoice_number' => '121',
                'price' => '60',
                'quantity' => '3',
                'description' => 'ΠΑΡΟΧΗ ΥΠΟΣΤΗΡΙΞΗΣ ΣΕ WEBINAR - TECH TUESDAYS 19/01'
            ],
            [
                'invoice_number' => '121',
                'price' => '60',
                'quantity' => '3',
                'description' => 'ΠΑΡΟΧΗ ΥΠΟΣΤΗΡΙΞΗΣ ΣΕ WEBINAR - TECH TUESDAYS 26/01'
            ],
            [
                'invoice_number' => '121',
                'price' => '60',
                'quantity' => '2',
                'description' => 'ΠΑΡΟΧΗ ΥΠΟΣΤΗΡΙΞΗΣ ΣΕ WEBINAR - TECH TUESDAYS 02/02'
            ],
            [
                'invoice_number' => '122',
                'price' => '60',
                'quantity' => '3',
                'description' => 'ΠΑΡΟΧΗ ΤΕΧΝΙΚΗΣ ΥΠΟΣΤΗΡΙΞΗΣ WEBINAR THRIVING IN THE STORM'
            ],
            [
                'invoice_number' => '122',
                'price' => '60',
                'quantity' => '2',
                'description' => 'ΠΑΡΟΧΗ ΤΕΧΝΙΚΗΣ ΥΠΟΣΤΗΡΙΞΗΣ WEBINAR DOING BUSINESS IN ISRAEL'
            ],
            [
                'invoice_number' => '122',
                'price' => '60',
                'quantity' => '3',
                'description' => 'ΠΑΡΟΧΗ ΤΕΧΝΙΚΗΣ ΥΠΟΣΤΗΡΙΞΗΣ WEBINAR DOING BUSINESS IN JAPAN'
            ],
            [
                'invoice_number' => '122',
                'price' => '60',
                'quantity' => '2',
                'description' => 'ΠΑΡΟΧΗ ΤΕΧΝΙΚΗΣ ΥΠΟΣΤΗΡΙΞΗΣ WEBINAR DOING BUSINESS IN SAUDI ARABIA'
            ],
            [
                'invoice_number' => '122',
                'price' => '60',
                'quantity' => '3',
                'description' => 'ΠΑΡΟΧΗ ΤΕΧΝΙΚΗΣ ΥΠΟΣΤΗΡΙΞΗΣ WEBINAR DOING BUSINESS IN BRAZIL'
            ],
            [
                'invoice_number' => '123',
                'price' => '1500',
                'quantity' => '1',
                'description' => 'ΑΜΟΙΒΗ ΜΗΝΟΣ ΦΕΒΡΟΥΑΡΙΟΥ 2021, ΒΑΣΕΙ ΣΥΜΒΑΣΗΣ (015/2021-487), ΓΙΑ ΤΟ ΕΡΓΟ Ανάπτυξη Διδικτυακής εφαρμογής για την υποστήριξη της γραμματείας του Διοικητικού Συμβουλίου του ΕΚΕΦΕ Δ. και Υποστήριξη του ιστοτόπου του Ινστιτούτου Πηρινικών και Ραδιολογικών Επιστημών και Τεχνολογίας, Ενέργειας και Ασφάλειας (ΙΠΡΕΤΕΑ).'
            ],
            [
                'invoice_number' => '124',
                'price' => '800',
                'quantity' => '1',
                'description' => 'ΜΗΝΙΑΙΑ ΤΕΧΝΙΚΗ ΥΠΟΣΤΗΡΙΞΗ ΓΙΑ ΤΗΝ ΙΣΤΟΣΕΛΙΔΑ ENTERPRISEGREECE.GOV.GR ΓΙΑ ΤΟΝ ΜΗΝΑ ΦΕΒΡΟΥΑΡΙΟ 2021 ΒΑΣΕΙ ΣΥΜΒΑΣΗΣ'
            ],
            [
                'invoice_number' => '125',
                'price' => '1500',
                'quantity' => '1',
                'description' => 'ΑΜΟΙΒΗ ΜΗΝΟΣ ΜΑΡΤΙΟΥ 2021, ΒΑΣΕΙ ΣΥΜΒΑΣΗΣ (015/2021-487), ΓΙΑ ΤΟ ΕΡΓΟ Ανάπτυξη Διδικτυακής εφαρμογής για την υποστήριξη της γραμματείας του Διοικητικού Συμβουλίου του ΕΚΕΦΕ Δ. και Υποστήριξη του ιστοτόπου του Ινστιτούτου Πηρινικών και Ραδιολογικών Επιστημών και Τεχνολογίας, Ενέργειας και Ασφάλειας (ΙΠΡΕΤΕΑ).'
            ],
            [
                'invoice_number' => '126',
                'price' => '600',
                'quantity' => '1',
                'description' => 'ΚΑΤΑΣΚΕΥΗ ΕΝΟΤΗΤΑΣ E-EXPORTS ACADEMY ΣΤΗΝ ΙΣΤΟΣΕΛΙΔΑ ENTERPRISEGREECE.GOV.GR'
            ],
            [
                'invoice_number' => '127',
                'price' => '800',
                'quantity' => '1',
                'description' => 'ΜΗΝΙΑΙΑ ΤΕΧΝΙΚΗ ΥΠΟΣΤΗΡΙΞΗ ΓΙΑ ΤΗΝ ΙΣΤΟΣΕΛΙΔΑ ENTERPRISEGREECE.GOV.GR ΓΙΑ ΤΟΝ ΜΗΝΑ ΜΑΡΤΙΟ 2021 ΒΑΣΕΙ ΣΥΜΒΑΣΗΣ'
            ],
            [
                'invoice_number' => '128',
                'price' => '2000',
                'quantity' => '1',
                'description' => 'ΑΝΑΚΑΤΑΣΚΕΥΗ ΤΩΝ ΣΕΛΙΔΩΝ ΤΗΣ ΕΝΟΤΗΤΑΣ ΠΡΟΩΘΗΣΗΣ ΕΞΑΓΩΓΩΝ ΤΗΣ ΙΣΤΟΣΕΛΙΔΑΣ ENTERPRISEGREECE.GOV.GR'
            ],
            [
                'invoice_number' => '129',
                'price' => '1500',
                'quantity' => '1',
                'description' => 'ΑΜΟΙΒΗ ΜΗΝΟΣ ΑΠΡΙΛΙΟΥ 2021, ΒΑΣΕΙ ΣΥΜΒΑΣΗΣ (015/2021-487), ΓΙΑ ΤΟ ΕΡΓΟ Ανάπτυξη Διδικτυακής εφαρμογής για την υποστήριξη της γραμματείας του Διοικητικού Συμβουλίου του ΕΚΕΦΕ Δ. και Υποστήριξη του ιστοτόπου του Ινστιτούτου Πηρινικών και Ραδιολογικών Επιστημών και Τεχνολογίας, Ενέργειας και Ασφάλειας (ΙΠΡΕΤΕΑ).'
            ],
            [
                'invoice_number' => '130',
                'price' => '800',
                'quantity' => '1',
                'description' => 'ΜΗΝΙΑΙΑ ΤΕΧΝΙΚΗ ΥΠΟΣΤΗΡΙΞΗ ΓΙΑ ΤΗΝ ΙΣΤΟΣΕΛΙΔΑ ENTERPRISEGREECE.GOV.GR ΓΙΑ ΤΟΝ ΜΗΝΑ ΑΠΡιΛΙΟ 2021 ΒΑΣΕΙ ΣΥΜΒΑΣΗΣ'
            ],
            [
                'invoice_number' => '131',
                'price' => '1500',
                'quantity' => '1',
                'description' => 'ΑΜΟΙΒΗ ΜΗΝΟΣ ΜΑΪΟΥ 2021, ΒΑΣΕΙ ΣΥΜΒΑΣΗΣ (015/2021-487), ΓΙΑ ΤΟ ΕΡΓΟ Ανάπτυξη Διδικτυακής εφαρμογής για την υποστήριξη της γραμματείας του Διοικητικού Συμβουλίου του ΕΚΕΦΕ Δ. και Υποστήριξη του ιστοτόπου του Ινστιτούτου Πηρινικών και Ραδιολογικών Επιστημών και Τεχνολογίας, Ενέργειας και Ασφάλειας (ΙΠΡΕΤΕΑ).'
            ],
            [
                'invoice_number' => '132',
                'price' => '1500',
                'quantity' => '1',
                'description' => 'ΑΜΟΙΒΗ ΜΗΝΟΣ ΙΟΥΝΙΟΥ 2021, ΒΑΣΕΙ ΣΥΜΒΑΣΗΣ (015/2021-487), ΓΙΑ ΤΟ ΕΡΓΟ Ανάπτυξη Διδικτυακής εφαρμογής για την υποστήριξη της γραμματείας του Διοικητικού Συμβουλίου του ΕΚΕΦΕ Δ. και Υποστήριξη του ιστοτόπου του Ινστιτούτου Πηρινικών και Ραδιολογικών Επιστημών και Τεχνολογίας, Ενέργειας και Ασφάλειας (ΙΠΡΕΤΕΑ).'
            ],
            [
                'invoice_number' => '133',
                'price' => '800',
                'quantity' => '1',
                'description' => 'ΜΗΝΙΑΙΑ ΤΕΧΝΙΚΗ ΥΠΟΣΤΗΡΙΞΗ ΓΙΑ ΤΗΝ ΙΣΤΟΣΕΛΙΔΑ ENTERPRISEGREECE.GOV.GR ΓΙΑ ΤΟΝ ΜΗΝΑ ΜΑΪΟ 2021 ΒΑΣΕΙ ΣΥΜΒΑΣΗΣ'
            ],
            [
                'invoice_number' => '134',
                'price' => '800',
                'quantity' => '1',
                'description' => 'ΜΗΝΙΑΙΑ ΤΕΧΝΙΚΗ ΥΠΟΣΤΗΡΙΞΗ ΓΙΑ ΤΗΝ ΙΣΤΟΣΕΛΙΔΑ ENTERPRISEGREECE.GOV.GR ΓΙΑ ΤΟΝ ΜΗΝΑ ΙΟΥΝΙΟ 2021 ΒΑΣΕΙ ΣΥΜΒΑΣΗΣ'
            ],
            [
                'invoice_number' => '135',
                'price' => '600',
                'quantity' => '1',
                'description' => 'ΚΑΤΑΣΚΕΥΗ ΙΣΤΟΣΕΛΙΔΑΣ ΤΟΥ ΟΡΓΑΝΙΣΜΟΥ ENTERPRISEGREECE.GOV.GR ΣΤΑ ΑΡΑΒΙΚΑ'
            ],
            [
                'invoice_number' => '136',
                'price' => '600',
                'quantity' => '1',
                'description' => 'ΚΑΤΑΣΚΕΥΗ ΣΥΣΤΗΜΑΤΟΣ NEWSLETTER'
            ],
            [
                'invoice_number' => '137',
                'price' => '1500',
                'quantity' => '1',
                'description' => 'ΑΜΟΙΒΗ ΜΗΝΟΣ ΙΟΥλΙΟΥ 2021, ΒΑΣΕΙ ΣΥΜΒΑΣΗΣ (015/2021-487), ΓΙΑ ΤΟ ΕΡΓΟ Ανάπτυξη Διδικτυακής εφαρμογής για την υποστήριξη της γραμματείας του Διοικητικού Συμβουλίου του ΕΚΕΦΕ Δ. και Υποστήριξη του ιστοτόπου του Ινστιτούτου Πηρινικών και Ραδιολογικών Επιστημών και Τεχνολογίας, Ενέργειας και Ασφάλειας (ΙΠΡΕΤΕΑ).'
            ],
            [
                'invoice_number' => '138',
                'price' => '19',
                'quantity' => '1',
                'description' => 'ΑΝΑΝΕΩΣΗ ΟΝΟΜΑΤΟΣ ΧΩΡΟΥ MTBCONTROLS.GR'
            ],
            [
                'invoice_number' => '139',
                'price' => '19',
                'quantity' => '1',
                'description' => 'ΑΝΑΝΕΩΣΗ ΟΝΟΜΑΤΟΣ ΧΩΡΟΥ PAPADOSXOLI.GR'
            ],
            [
                'invoice_number' => '140',
                'price' => '800',
                'quantity' => '1',
                'description' => 'ΜΗΝΙΑΙΑ ΤΕΧΝΙΚΗ ΥΠΟΣΤΗΡΙΞΗ ΓΙΑ ΤΗΝ ΙΣΤΟΣΕΛΙΔΑ ENTERPRISEGREECE.GOV.GR ΓΙΑ ΤΟΝ ΜΗΝΑ ΙΟΥΛΙΟ 2021 ΒΑΣΕΙ ΣΥΜΒΑΣΗΣ'
            ],
            [
                'invoice_number' => '141',
                'price' => '1500',
                'quantity' => '1',
                'description' => 'ΑΜΟΙΒΗ ΜΗΝΟΣ ΑΥΓΟΥΣΤΟΥ 2021, ΒΑΣΕΙ ΣΥΜΒΑΣΗΣ (015/2021-487), ΓΙΑ ΤΟ ΕΡΓΟ Ανάπτυξη Διδικτυακής εφαρμογής για την υποστήριξη της γραμματείας του Διοικητικού Συμβουλίου του ΕΚΕΦΕ Δ. και Υποστήριξη του ιστοτόπου του Ινστιτούτου Πηρινικών και Ραδιολογικών Επιστημών και Τεχνολογίας, Ενέργειας και Ασφάλειας (ΙΠΡΕΤΕΑ).'
            ],
            [
                'invoice_number' => '142',
                'price' => '260',
                'quantity' => '1',
                'description' => 'ΑΝΑΚΑΤΑΣΚΕΥΗ ΤΗΣ ΣΕΛΙΔΑΣ FUTURE.COM.GR'
            ],
            [
                'invoice_number' => '143',
                'price' => '800',
                'quantity' => '1',
                'description' => 'ΜΗΝΙΑΙΑ ΤΕΧΝΙΚΗ ΥΠΟΣΤΗΡΙΞΗ ΓΙΑ ΤΗΝ ΙΣΤΟΣΕΛΙΔΑ ENTERPRISEGREECE.GOV.GR ΓΙΑ ΤΟΝ ΜΗΝΑ ΑΥΓΟΥΣΤΟ 2021 ΒΑΣΕΙ ΣΥΜΒΑΣΗΣ'
            ],
            [
                'invoice_number' => '144',
                'price' => '1500',
                'quantity' => '1',
                'description' => 'ΑΜΟΙΒΗ ΜΗΝΟΣ ΣΕΠΤΕΜΒΡΙΟΥ 2021, ΒΑΣΕΙ ΣΥΜΒΑΣΗΣ (015/2021-487), ΓΙΑ ΤΟ ΕΡΓΟ Ανάπτυξη Διδικτυακής εφαρμογής για την υποστήριξη της γραμματείας του Διοικητικού Συμβουλίου του ΕΚΕΦΕ Δ. και Υποστήριξη του ιστοτόπου του Ινστιτούτου Πηρινικών και Ραδιολογικών Επιστημών και Τεχνολογίας, Ενέργειας και Ασφάλειας (ΙΠΡΕΤΕΑ).'
            ],
            [
                'invoice_number' => '145',
                'price' => '800',
                'quantity' => '1',
                'description' => 'ΜΗΝΙΑΙΑ ΤΕΧΝΙΚΗ ΥΠΟΣΤΗΡΙΞΗ ΓΙΑ ΤΗΝ ΙΣΤΟΣΕΛΙΔΑ ENTERPRISEGREECE.GOV.GR ΓΙΑ ΤΟΝ ΜΗΝΑ ΣΕΠΤΕΜΒΡΙΟ 2021 ΒΑΣΕΙ ΣΥΜΒΑΣΗΣ'
            ],
            [
                'invoice_number' => '146',
                'price' => '400',
                'quantity' => '1',
                'description' => 'ΚΑΤΑΣΚΕΥΗ MINI SITE ΓΙΑ ΤΗΝ ΕΚΘΕΣΗ BIG5 2021 ΕΝΤΟΣ ΤΗΣ ΙΣΤΟΣΕΛΙΔΑΣ ΤΗΣ ENTERPRISE GREECE'
            ],
            [
                'invoice_number' => '147',
                'price' => '400',
                'quantity' => '1',
                'description' => 'ΚΑΤΑΣΚΕΥΗ MINI SITE ΓΙΑ ΤΗΝ ΕΚΘΕΣΗ ANUGA 2021 ΕΝΤΟΣ ΤΗΣ ΙΣΤΟΣΕΛΙΔΑΣ ΤΗΣ ENTERPRISE GREECE'
            ],
            [
                'invoice_number' => '148',
                'price' => '1200',
                'quantity' => '1',
                'description' => 'ΑΜΟΙΒΗ ΜΗΝΟΣ ΣΕΠΤΕΜΒΡΙΟΥ 2021, ΒΑΣΕΙ ΣΥΜΒΑΣΗΣ (015/2021-487), ΓΙΑ ΤΟ ΕΡΓΟ Ανάπτυξη Διδικτυακής εφαρμογής για την υποστήριξη της γραμματείας του Διοικητικού Συμβουλίου του ΕΚΕΦΕ Δ. και Υποστήριξη του ιστοτόπου του Ινστιτούτου Πηρινικών και Ραδιολογικών Επιστημών και Τεχνολογίας, Ενέργειας και Ασφάλειας (ΙΠΡΕΤΕΑ).'
            ],
            [
                'invoice_number' => '149',
                'price' => '800',
                'quantity' => '1',
                'description' => 'ΜΗΝΙΑΙΑ ΤΕΧΝΙΚΗ ΥΠΟΣΤΗΡΙΞΗ ΓΙΑ ΤΗΝ ΙΣΤΟΣΕΛΙΔΑ ENTERPRISEGREECE.GOV.GR ΓΙΑ ΤΟΝ ΜΗΝΑ ΟΚΤΩΒΡΙΟ 2021 ΒΑΣΕΙ ΣΥΜΒΑΣΗΣ'
            ],
            [
                'invoice_number' => '150',
                'price' => '1800',
                'quantity' => '1',
                'description' => 'ΑΜΟΙΒΗ ΜΗΝΟΣ ΝΟΕΜΒΡΙΟΥ 2021, ΒΑΣΕΙ ΣΥΜΒΑΣΗΣ (015/2021-487), ΓΙΑ ΤΟ ΕΡΓΟ Ανάπτυξη Διδικτυακής εφαρμογής για την υποστήριξη της γραμματείας του Διοικητικού Συμβουλίου του ΕΚΕΦΕ Δ. και Υποστήριξη του ιστοτόπου του Ινστιτούτου Πηρινικών και Ραδιολογικών Επιστημών και Τεχνολογίας, Ενέργειας και Ασφάλειας (ΙΠΡΕΤΕΑ).'
            ],
            [
                'invoice_number' => '151',
                'price' => '800',
                'quantity' => '1',
                'description' => 'ΜΗΝΙΑΙΑ ΤΕΧΝΙΚΗ ΥΠΟΣΤΗΡΙΞΗ ΓΙΑ ΤΗΝ ΙΣΤΟΣΕΛΙΔΑ ENTERPRISEGREECE.GOV.GR ΓΙΑ ΤΟΝ ΜΗΝΑ ΝΟΕΜΒΡΙΟ 2021 ΒΑΣΕΙ ΣΥΜΒΑΣΗΣ'
            ],
            [
                'invoice_number' => '152',
                'price' => '300',
                'quantity' => '1',
                'description' => 'Μετατροπή του site ergoprolipsis.gr ώστε να είναι συμβατό με το διεθνές πρότυπο WCAG, έκδοση 2.0, σε επίπεδο ΑΑ'
            ],
            [
                'invoice_number' => '153',
                'price' => '1500',
                'quantity' => '1',
                'description' => 'ΑΜΟΙΒΗ ΜΗΝΟΣ ΔΕΚΕΜΒΡΙΟΥ 2021, ΒΑΣΕΙ ΣΥΜΒΑΣΗΣ (015/2021-487), ΓΙΑ ΤΟ ΕΡΓΟ Ανάπτυξη Διδικτυακής εφαρμογής για την υποστήριξη της γραμματείας του Διοικητικού Συμβουλίου του ΕΚΕΦΕ Δ. και Υποστήριξη του ιστοτόπου του Ινστιτούτου Πηρινικών και Ραδιολογικών Επιστημών και Τεχνολογίας, Ενέργειας και Ασφάλειας (ΙΠΡΕΤΕΑ).'
            ],
            [
                'invoice_number' => '154',
                'price' => '2400',
                'quantity' => '1',
                'description' => 'ΑΝΤΙΚΑΤΑΣΤΑΣΗ ΤΙΤΛΩΝ ΚΑΙ META ΠΕΡΙΓΡΑΦΩΝ ΤΗΣ ΙΣΤΟΣΕΛΙΔΑΣ ENTERPRISEGREECE.GOV.GR'
            ],
            [
                'invoice_number' => '155',
                'price' => '800',
                'quantity' => '1',
                'description' => 'ΜΗΝΙΑΙΑ ΤΕΧΝΙΚΗ ΥΠΟΣΤΗΡΙΞΗ ΓΙΑ ΤΗΝ ΙΣΤΟΣΕΛΙΔΑ ENTERPRISEGREECE.GOV.GR ΓΙΑ ΤΟΝ ΜΗΝΑ ΔΕΚΕΜΒΡΙΟ 2021 ΒΑΣΕΙ ΣΥΜΒΑΣΗΣ'
            ],
            [
                'invoice_number' => '156',
                'price' => '1500',
                'quantity' => '1',
                'description' => 'ΑΜΟΙΒΗ ΜΗΝΟΣ ΔΕΚΕΜΒΡΙΟΥ 2021, ΒΑΣΕΙ ΣΥΜΒΑΣΗΣ (015/2022-80), ΓΙΑ ΤΟ ΕΡΓΟ Ανάπτυξη Διδικτυακής εφαρμογής για την υποστήριξη της γραμματείας του Διοικητικού Συμβουλίου του ΕΚΕΦΕ Δ. και Υποστήριξη του ιστοτόπου του Ινστιτούτου Πηρινικών και Ραδιολογικών Επιστημών και Τεχνολογίας, Ενέργειας και Ασφάλειας (ΙΠΡΕΤΕΑ).'
            ],
            [
                'invoice_number' => '157',
                'price' => '800',
                'quantity' => '1',
                'description' => 'ΜΗΝΙΑΙΑ ΤΕΧΝΙΚΗ ΥΠΟΣΤΗΡΙΞΗ ΓΙΑ ΤΗΝ ΙΣΤΟΣΕΛΙΔΑ ENTERPRISEGREECE.GOV.GR ΓΙΑ ΤΟΝ ΜΗΝΑ ΙΑΝΟΥΑΡΙΟ 2021 ΒΑΣΕΙ ΣΥΜΒΑΣΗΣ'
            ],
            [
                'invoice_number' => '158',
                'price' => '1500',
                'quantity' => '1',
                'description' => 'ΑΜΟΙΒΗ ΜΗΝΟΣ ΙΑΝΟΥΑΡΙΟΥ 2021, ΒΑΣΕΙ ΣΥΜΒΑΣΗΣ (015/2022-80), ΓΙΑ ΤΟ ΕΡΓΟ Ανάπτυξη Διδικτυακής εφαρμογής για την υποστήριξη της γραμματείας του Διοικητικού Συμβουλίου του ΕΚΕΦΕ Δ. και Υποστήριξη του ιστοτόπου του Ινστιτούτου Πηρινικών και Ραδιολογικών Επιστημών και Τεχνολογίας, Ενέργειας και Ασφάλειας (ΙΠΡΕΤΕΑ).'
            ]
        ];
        Services::insert($services);
    }
}
